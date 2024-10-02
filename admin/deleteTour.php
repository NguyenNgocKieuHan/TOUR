<?php
include('includes/db.php'); // Kết nối tới database

// Lấy mã ID của tour từ URL
$tour_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Kiểm tra mã ID hợp lệ
if ($tour_id <= 0) {
    echo "ID tour không hợp lệ.";
    exit;
}

// Kiểm tra xem tour này có đặt chỗ nào không
$sql_check_booking = "SELECT COUNT(*) AS booking_count FROM bookings WHERE TOURID = $tour_id";
$result_check = mysqli_query($conn, $sql_check_booking);
$row = mysqli_fetch_assoc($result_check);

if ($row['booking_count'] > 0) {
    echo "<script>alert('Không thể xóa tour này vì đã có đặt chỗ.'); window.location.href='tourManagement.php();</script>";
    exit;
}

// Xóa tour từ cơ sở dữ liệu
$sql_delete = "DELETE FROM tour WHERE TOURID = $tour_id";
if (mysqli_query($conn, $sql_delete)) {
    // Xóa thành công, chuyển hướng về trang danh sách tour
    header("Location: tourManagement.php");
    exit;
} else {
    // Xóa không thành công, hiển thị lỗi
    echo "Lỗi khi xóa tour: " . mysqli_error($conn);
}

// Đóng kết nối
mysqli_close($conn);
