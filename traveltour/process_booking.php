<?php
session_start();
include('includes/db.php');

// Kiểm tra người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Bạn chưa đăng nhập!'); window.location.href='login.php';</script>";
    exit();
}

// Lấy dữ liệu từ form đặt tour
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tourID = $_POST['tourid'];
    $userID = $_SESSION['userid']; // Đảm bảo tên biến đúng là 'userid'
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
    $sqlTotalPeople = "SELECT COALESCE(SUM(NUMOFPEOPLE), 0) AS totalPeople FROM bookings WHERE TOURID = ? AND STATUS = 'Approved'";
    $stmt = $conn->prepare($sqlTotalPeople);
    $stmt->bind_param("i", $tourID);
    $stmt->execute();
    $stmt->bind_result($totalPeople);
    $stmt->fetch();
    $stmt->close();

    // Kiểm tra nếu còn đủ slot
    if (($totalPeople + $numOfPeople) <= $maxSlots) {
        // Truy vấn kiểm tra xem có booking nào đã tồn tại vào cùng một ngày khởi hành
        $sqlCheckDuplicate = "SELECT * FROM bookings WHERE TOURID = ? AND STARTDATE = ?";
        $stmt = $conn->prepare($sqlCheckDuplicate);
        $stmt->bind_param("is", $tourID, $startDate);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Nếu có bản ghi trùng lặp cho tour vào cùng một ngày khởi hành
            echo "<script>alert('Tour này đã được đặt vào ngày đó. Vui lòng kiểm tra thông tin đặt tour của bạn.'); window.location.href='list_tours.php';</script>";
            exit(); // Ngăn không cho tiếp tục thực hiện truy vấn thêm
        } else {
            // Nếu không có trùng lặp, thực hiện việc đặt tour
            $bookingDate = date("Y-m-d"); // Ngày đặt tour hiện tại
            $totalPrice = $numOfPeople * $tourPrice; // Tính tổng giá tiền dựa trên số người đặt
            $status = '2'; // Trạng thái ban đầu là 'Chờ xác nhận'

            // Chuẩn bị truy vấn để thêm thông tin đặt tour vào bảng bookings
            $sqlInsertBooking = "INSERT INTO bookings (TOURID, USERID, BOOKINGDATE, NUMOFPEOPLE, TOTALPRICE, STATUS, STARTDATE)
                                 VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sqlInsertBooking);
            $stmt->bind_param("iissdss", $tourID, $userID, $bookingDate, $numOfPeople, $totalPrice, $status, $startDate);

            // Thực thi truy vấn
            if ($stmt->execute()) {
                echo "<script>alert('Đặt tour thành công! Vui lòng chờ xác nhận từ quản lý.'); window.location.href='booking_success.php';</script>";
            } else {
                echo "<script>alert('Lỗi: Không thể đặt tour. Vui lòng thử lại sau.');</script>";
            }
            $stmt->close();
        }
    } else {
        // Thông báo hết chỗ và đưa ra 2 lựa chọn cho người dùng
        echo "<script>
                alert('Xin lỗi, tour này đã hết chỗ!');
                window.location.href='list_tours.php';
                </script>";
    }
}
