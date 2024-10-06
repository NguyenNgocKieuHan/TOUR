<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Bạn chưa đăng nhập!'); window.location.href='login.php';</script>";
    exit();
}

include('includes/db.php');

// Kiểm tra xem form đã được gửi chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $userid = $_SESSION['userid']; // Người dùng đã đăng nhập
    $tourid = $_POST['tourid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $startdate = $_POST['startdate'];
    $people_count = $_POST['people_count'];
    $price = str_replace('.', '', $_POST['price']);
    $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); // Loại bỏ các ký tự không phải số
    if (!is_numeric($price)) {
        echo "<script>alert('Giá không hợp lệ!'); window.location.href='bookingg.php';</script>";
        exit();
    }

    // Tính tổng tiền
    $total_price = $price * $people_count;

    // Kiểm tra các trường bắt buộc
    if (empty($tourid) || empty($startdate) || empty($people_count)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!'); window.location.href='booking.php';</script>";
        exit();
    }

    // Chuẩn bị truy vấn để thêm đặt chỗ
    $sql = "INSERT INTO bookings (TOURID, USERID, BOOKINGDATE, NUMOFPEOPLE, TOTALPRICE, STATUS, STARTDATE) 
            VALUES (?, ?, NOW(), ?, ?, '2', ?)";

    // Sử dụng Prepared Statement để tránh SQL Injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiids", $tourid, $userid, $people_count, $total_price, $startdate);

    if ($stmt->execute()) {
        echo "<script>alert('Đặt tour thành công! Chúng tôi sẽ liên hệ với bạn để xác nhận.'); window.location.href='booking_success.php';</script>";
    } else {
        echo "<script>alert('Đặt tour thất bại. Vui lòng thử lại.'); window.location.href='booking.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Yêu cầu không hợp lệ!'); window.location.href='booking.php';</script>";
    exit();
}
