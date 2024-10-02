<?php
include('includes/db.php');

// Lấy dữ liệu từ form đặt tour
if (
    $_SERVER['REQUEST_METHOD'] == 'POST'
) {

    $tourID = $_POST['tourid'];
    $userID = $_SESSION['USERID'];
    $numOfPeople = $_POST['people_count'];
    $startDate = $_POST['startdate']; // Ngày khởi hành được người dùng chọn

    // Truy vấn để lấy giá tour và số slot tối đa của tour
    $sqlMaxSlots = "SELECT MAXSLOTS, PRICE FROM tour WHERE TOURID = ?";
    $stmt = $conn->prepare($sqlMaxSlots);
    $stmt->bind_param("i", $tourID);
    $stmt->execute();
    $stmt->bind_result($maxSlots, $tourPrice);
    $stmt->fetch();
    $stmt->close();

    // Truy vấn để tính tổng số người đã đặt chỗ cho tour đó (chỉ tính những booking đã được duyệt)
    $sqlTotalPeople = "SELECT SUM(NUMOFPEOPLE) AS totalPeople FROM bookings WHERE TOURID = ? AND STATUS = 'Approved'";
    $stmt = $conn->prepare($sqlTotalPeople);
    $stmt->bind_param("i", $tourID);
    $stmt->execute();
    $stmt->bind_result($totalPeople);
    $stmt->fetch();
    $stmt->close();

    // Kiểm tra nếu còn đủ slot
    if (($totalPeople + $numOfPeople) <= $maxSlots) {
        // Truy vấn kiểm tra xem người dùng đã đặt tour này vào cùng một ngày khởi hành chưa
        $sqlCheckDuplicate = "SELECT * FROM bookings WHERE TOURID = ? AND USERID = ? AND STARTDATE = ?";
        $stmt = $conn->prepare($sqlCheckDuplicate);
        $stmt->bind_param("iis", $tourID, $userID, $startDate);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Nếu có bản ghi trùng lặp, thông báo cho người dùng
            echo "Bạn đã đặt tour này vào ngày đó. Vui lòng kiểm tra thông tin đặt tour của bạn.";
        } else {
            // Nếu không có trùng lặp, thực hiện việc đặt tour
            $bookingDate = date("Y-m-d"); // Ngày đặt tour hiện tại
            $totalPrice = $numOfPeople * $tourPrice; // Tính tổng giá tiền dựa trên số người đặt
            $status = 'Chờ xác nhận'; // Trạng thái ban đầu là 'Chờ xác nhận'

            // Chuẩn bị truy vấn để thêm thông tin đặt tour vào bảng bookings
            $sqlInsertBooking = "INSERT INTO bookings (TOURID, USERID, BOOKINGDATE, NUMOFPEOPLE, TOTALPRICE, STATUS, STARTDATE)
    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sqlInsertBooking);
            $stmt->bind_param("iisidss", $tourID, $userID, $bookingDate, $numOfPeople, $totalPrice, $status, $startDate);

            // Thực thi truy vấn
            if ($stmt->execute()) {
                echo "Đặt tour thành công! Vui lòng chờ xác nhận từ quản lý.";
            } else {
                echo "Lỗi: Không thể đặt tour. Vui lòng thử lại sau.";
            }
        }
        $stmt->close();
    } else {
        // Thông báo hết chỗ và đưa ra 2 lựa chọn cho người dùng
        echo "Xin lỗi, tour này đã hết chỗ!";
        echo "<br>Bạn có thể:";
        echo "<ul>
        <li><a href='list_tours.php'>Đổi sang tour khác</a></li>
        <li><a href='reschedule_tour.php?tourID=$tourID'>Dời sang ngày khác</a></li>
    </ul>";
    }
}
