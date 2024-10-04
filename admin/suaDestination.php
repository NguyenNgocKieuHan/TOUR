<?php
session_start(); // Bắt đầu phiên làm việc

include('includes/db.php');

// Lấy ID địa điểm từ URL
if (isset($_GET['id'])) {
    $destinationID = intval($_GET['id']);

    // Lấy dữ liệu của địa điểm từ cơ sở dữ liệu
    $query = "SELECT * FROM destination WHERE DESTINATIONID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $destinationID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $destination = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Địa điểm không tồn tại.'); window.location.href='destinationManagement.php';</script>";
        exit();
    }

    // Xử lý khi form được gửi
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy dữ liệu từ form
        $districtID = mysqli_real_escape_string($conn, $_POST['district_id']);
        $destinationName = mysqli_real_escape_string($conn, $_POST['destination_name']);
        $tourID = mysqli_real_escape_string($conn, $_POST['tour_id']);
        $imageData = null;

        // Xử lý tải ảnh
        if (!empty($_FILES['image']['tmp_name'])) {
            $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

            $check = getimagesize($_FILES['image']['tmp_name']);
            if ($check === false) {
                echo "<script>alert('File không phải là ảnh.');</script>";
            } elseif ($_FILES['image']['size'] > 5000000) {
                echo "<script>alert('Kích thước ảnh quá lớn.');</script>";
            } elseif (!in_array($imageFileType, $allowedTypes)) {
                echo "<script>alert('Chỉ cho phép các định dạng JPG, JPEG, PNG & GIF.');</script>";
            } else {
                $imageData = file_get_contents($_FILES['image']['tmp_name']);
            }
        } else {
            // Nếu không có ảnh mới, giữ ảnh cũ
            $imageData = $destination['IMAGE'];
        }

        if ($imageData !== null) {
            // Cập nhật dữ liệu vào cơ sở dữ liệu
            $query = "UPDATE destination SET DISTRICTID = ?, TOURID = ?, DENAME = ?, IMAGE = ? WHERE DESTINATIONID = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'iissi', $districtID, $tourID, $destinationName, $imageData, $destinationID);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Địa điểm đã được cập nhật thành công!'); window.location.href='destinationManagement.php';</script>";
                exit();
            } else {
                echo "<script>alert('Lỗi: " . mysqli_error($conn) . "');</script>";
            }
        }
    }
} else {
    echo "<script>alert('ID địa điểm không hợp lệ.'); window.location.href='destinationManagement.php';</script>";
    exit();
}

mysqli_close($conn); // Đóng kết nối
