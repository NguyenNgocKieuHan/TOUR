<?php
include('includes/db.php'); // Kết nối cơ sở dữ liệu

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $tour_id = mysqli_real_escape_string($conn, $_POST['tour_id']);
    $destination_name = mysqli_real_escape_string($conn, $_POST['destination_name']);
    $district_id = mysqli_real_escape_string($conn, $_POST['district_id']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Xử lý tải ảnh
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra xem file có phải là ảnh không
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "File không phải là ảnh.";
        $uploadOk = 0;
    }

    // Kiểm tra kích thước file
    if ($_FILES["image"]["size"] > 5000000) {
        echo "Kích thước ảnh quá lớn.";
        $uploadOk = 0;
    }

    // Kiểm tra định dạng file
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Chỉ các định dạng JPG, JPEG, PNG & GIF được cho phép.";
        $uploadOk = 0;
    }

    // Nếu tất cả kiểm tra đều ok
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Lưu đường dẫn ảnh vào cơ sở dữ liệu
            $image_path = $target_file;

            // Tìm ID DESTINATION lớn nhất hiện tại và tạo ID mới
            $result = mysqli_query($conn, "SELECT MAX(DESTINATIONID) AS max_id FROM destination");
            $row = mysqli_fetch_assoc($result);
            $next_id = $row['max_id'] + 1; // ID kế tiếp

            // Chèn dữ liệu vào cơ sở dữ liệu
            $sql = "INSERT INTO destination (DESTINATIONID, DISTRICTID, TOURID, DENAME, DEDESCRIPTION, IMAGE) 
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'iiisss', $next_id, $district_id, $tour_id, $destination_name, $description, $image_path);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Thêm địa điểm thành công!'); window.location.href='destinationManagement.php';</script>";
            } else {
                echo "Lỗi: " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Có lỗi xảy ra khi tải ảnh lên.";
        }
    }
}

mysqli_close($conn); // Đóng kết nối
