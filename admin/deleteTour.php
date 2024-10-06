<?php
session_start();
include('includes/db.php');

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['ADID'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

// Lấy TOURID từ URL
if (isset($_GET['id'])) {
    $tourId = intval($_GET['id']);

    // Kiểm tra xem tour đã có khách hàng đặt chưa
    $bookingCheckQuery = "SELECT * FROM bookings WHERE TOURID = ?";
    $stmt = $conn->prepare($bookingCheckQuery);
    $stmt->bind_param("i", $tourId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Nếu đã có khách hàng đặt tour
    if ($result->num_rows > 0) {
        echo "<script>alert('Không thể xóa tour này vì đã có khách hàng đặt!'); window.location.href='tourManagement.php';</script>";
        exit();
    } else {
        // Nếu chưa có khách hàng đặt, tiến hành xóa tour
        $deleteQuery = "DELETE FROM tour WHERE TOURID = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $tourId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Xóa tour thành công!'); window.location.href='tourManagement.php';</script>";
        } else {
            echo "<script>alert('Đã xảy ra lỗi khi xóa tour!'); window.location.href='tourManagement.php';</script>";
        }
        exit();
    }
} else {
    echo "<script>alert('Không tìm thấy tour để xóa!'); window.location.href='tourManagement.php';</script>";
    exit();
}
