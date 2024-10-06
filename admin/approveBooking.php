<?php
session_start();
include('includes/db.php');

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['ADID'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra nếu có TOURID, USERID và STARTDATE trong URL
if (isset($_GET['TOURID']) && isset($_GET['userid']) && isset($_GET['startdate'])) {
    $tour_id = mysqli_real_escape_string($conn, $_GET['TOURID']);
    $user_id = mysqli_real_escape_string($conn, $_GET['userid']);
    $start_date = mysqli_real_escape_string($conn, $_GET['startdate']);

    // Truy vấn để lấy thông tin booking và số lượng chỗ tối đa
    $sql = "SELECT b.STARTDATE, b.NUMOFPEOPLE, t.MAXSLOTS 
            FROM bookings b
            JOIN tour t ON b.TOURID = t.TOURID 
            WHERE b.TOURID = ? AND b.USERID = ? AND b.STARTDATE = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iis', $tour_id, $user_id, $start_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $startDate = $row['STARTDATE'];
        $numOfPeople = $row['NUMOFPEOPLE'];
        $maxSlots = $row['MAXSLOTS'];

        // Kiểm tra ngày hiện tại và số lượng chỗ tối đa
        if (strtotime($startDate) > time() && ($maxSlots - $numOfPeople) >= 0) {
            // Cập nhật trạng thái đơn đặt tour thành đã xác nhận (trạng thái 1)
            $updateSql = "UPDATE bookings SET STATUS = 1 WHERE TOURID = ? AND USERID = ? AND STARTDATE = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param('iis', $tour_id, $user_id, $start_date);

            if ($updateStmt->execute()) {
                echo "<script>alert('Duyệt đơn đặt tour thành công!'); window.location.href='bookingManagement.php';</script>";
            } else {
                echo "Lỗi: " . mysqli_error($conn);
            }

            $updateStmt->close();
        } else {
            echo "<script>alert('Không thể duyệt đơn đặt tour. Vui lòng kiểm tra ngày bắt đầu hoặc số lượng chỗ trống.'); window.location.href='bookingManagement.php';</script>";
        }
    } else {
        echo "<script>alert('Thông tin không hợp lệ.'); window.location.href='bookingManagement.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Thông tin không hợp lệ.'); window.location.href='bookingManagement.php';</script>";
}

$conn->close(); // Đóng kết nối
