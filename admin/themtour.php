<?php
include('includes/db.php'); // Kết nối cơ sở dữ liệu
session_start(); // Bắt đầu session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $tour_name = mysqli_real_escape_string($conn, $_POST['tour_name']);
    $tour_type_id = mysqli_real_escape_string($conn, $_POST['tour_type_id']);
    $time = mysqli_real_escape_string($conn, $_POST['time']); // Thay đổi thành 'time'
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Lấy ADID của admin từ session
    $adid = $_SESSION['ADID'];
    // Xử lý tải ảnh
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Kiểm tra và di chuyển ảnh
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_path = $target_file;
    } else {
        echo "Có lỗi xảy ra khi tải ảnh lên.";
        exit();
    }

    // Tìm ID TOUR lớn nhất hiện tại
    $result = mysqli_query($conn, "SELECT MAX(TOURID) AS max_id FROM tour");
    $row = mysqli_fetch_assoc($result);
    $next_id = $row['max_id'] + 1; // ID kế tiếp

    // Đọc nội dung ảnh vào biến
    $image_data = file_get_contents($target_file);

    // Chèn dữ liệu vào cơ sở dữ liệu
    $sql = "INSERT INTO tour (TOURID, TOURNAME, TOURTYPEID, ADID, TIMETOUR, PRICE, DESCRIPTION, IMAGE) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'issidiss', $next_id, $tour_name, $tour_type_id, $adid, $time, $price, $description, $image_data);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Thêm tour thành công!'); window.location.href='tourManagement.php';</script>";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }

    mysqli_close($conn); // Đóng kết nối
}
