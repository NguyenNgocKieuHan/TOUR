<?php
session_start();
include('includes/db.php'); // Bao gồm tệp kết nối cơ sở dữ liệu

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['userid'])) {
    die("Bạn phải đăng nhập để gửi đánh giá.");
}

// Lấy dữ liệu từ form
$userid = $_SESSION['userid'];
$tourid = $_POST['tourid'];
$startdate = $_POST['startdate']; // Nhận startdate từ form
$rating = $_POST['rating'];
$comment = $_POST['comment'];

// Validate rating (giá trị từ 1 đến 5)
if ($rating < 1 || $rating > 5) {
    die("Giá trị đánh giá không hợp lệ.");
}

// Kiểm tra xem người dùng đã đánh giá tour này chưa
$reviewCheck = $conn->prepare("SELECT * FROM reviews WHERE userid = ? AND TOURID = ?");
$reviewCheck->bind_param("ii", $userid, $tourid);
$reviewCheck->execute();
$reviewResult = $reviewCheck->get_result();

if ($reviewResult->num_rows > 0) {
    die("Bạn đã đánh giá tour này trước đó.");
}

// Xử lý tải lên hình ảnh nếu có
$imagePath = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $imageName = $_FILES['image']['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageSize = $_FILES['image']['size'];
    $imageError = $_FILES['image']['error'];
    $imageType = $_FILES['image']['type'];

    // Trích xuất phần mở rộng
    $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    // Định nghĩa các loại tệp được phép
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($imageExt, $allowed)) {
        if ($imageSize < 5000000) { // Giới hạn 5MB
            // Tạo tên duy nhất cho hình ảnh
            $newImageName = uniqid('', true) . '.' . $imageExt;
            $imageDestination = 'uploads/review_images/' . $newImageName;

            // Di chuyển tệp đã tải lên đến đích
            if (move_uploaded_file($imageTmpName, $imageDestination)) {
                $imagePath = $imageDestination;
            } else {
                die("Lỗi khi tải lên hình ảnh.");
            }
        } else {
            die("Kích thước hình ảnh quá lớn.");
        }
    } else {
        die("Định dạng hình ảnh không hợp lệ.");
    }
}

// Chèn đánh giá vào cơ sở dữ liệu
if ($imagePath) {
    // Nếu có hình ảnh, thêm vào cột REVIEWIMAGE
    $reviewInsert = $conn->prepare("INSERT INTO reviews (userid, TOURID, STARTDATE, RATING, COMMENT, POSTDATE, REVIEWIMAGE) VALUES (?, ?, ?, ?, ?, NOW(), ?)");
    $reviewInsert->bind_param("iisiss", $userid, $tourid, $startdate, $rating, $comment, $imagePath);
} else {
    // Nếu không có hình ảnh, không bao gồm REVIEWIMAGE
    $reviewInsert = $conn->prepare("INSERT INTO reviews (userid, TOURID, STARTDATE, RATING, COMMENT, POSTDATE) VALUES (?, ?, ?, ?, ?, NOW())");
    $reviewInsert->bind_param("iiiss", $userid, $tourid, $startdate, $rating, $comment);
}

if ($reviewInsert->execute()) {
    echo "<script>alert('Đánh giá của bạn đã được gửi thành công!'); window.location.href='tour_detail.php?tourid=$tourid';</script>";
} else {
    echo "Lỗi khi gửi đánh giá: " . $conn->error;
}

// Giải phóng kết quả và đóng kết nối
$reviewCheck->free_result();
$reviewCheck->close();
$conn->close();
