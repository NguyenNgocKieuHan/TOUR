<?php
session_start();

if (!isset($_SESSION['USERID'])) {
    echo "<script>alert('Bạn chưa đăng nhập!'); window.location.href='login.php';</script>";
    exit();
}

$userid = $_SESSION['USERID']; // Lấy USERID từ session

// Kiểm tra xem có nhận được TOURID từ form hay không
if (!isset($_POST['tourid'])) {
    echo "<script>alert('Dữ liệu không hợp lệ!'); window.location.href='booking_history.php';</script>";
    exit();
}

$tourid = $_POST['tourid']; // Lấy TOURID từ form

include('includes/db.php');

// Kiểm tra xem đơn đặt tour có thuộc về người dùng hiện tại hay không
$query = "SELECT * FROM bookings WHERE TOURID = ? AND USERID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $tourid, $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Bạn không có quyền hủy đơn này!'); window.location.href='booking_history.php';</script>";
    exit();
}

// Cập nhật trạng thái đơn đặt tour thành 'Đã từ chối' (STATUS = 0) và ghi nhận người hủy là khách hàng
$updateQuery = "UPDATE bookings SET STATUS = 0, CANCELLED_BY = 2 WHERE TOURID = ? AND USERID = ?";
$stmtUpdate = $conn->prepare($updateQuery);
$stmtUpdate->bind_param("ii", $tourid, $userid);

if ($stmtUpdate->execute()) {
    echo "<script>alert('Đơn đặt tour đã được hủy thành công.'); window.location.href='booking_history.php';</script>";
} else {
    echo "<script>alert('Có lỗi xảy ra khi hủy đơn đặt tour.'); window.location.href='booking_history.php';</script>";
}
