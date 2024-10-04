<?php
session_start();

include('includes/db.php'); // Bao gồm tệp kết nối cơ sở dữ liệu

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    die("Bạn phải đăng nhập để gửi đánh giá.");
}

// Get the form data
$userid = $_SESSION['userid']; // Lấy USERID từ session
$tourid = $_POST['tourid'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

// Validate rating (between 1 and 5)
if ($rating < 1 || $rating > 5) {
    die("Giá trị đánh giá không hợp lệ.");
}

// Handle image upload if provided
$imagePath = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $imageName = $_FILES['image']['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageSize = $_FILES['image']['size'];
    $imageError = $_FILES['image']['error'];
    $imageType = $_FILES['image']['type'];

    // Extract the extension
    $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    // Define allowed file types
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($imageExt, $allowed)) {
        if ($imageSize < 5000000) { // 5MB limit
            // Generate a unique name for the image
            $newImageName = uniqid('', true) . '.' . $imageExt;
            $imageDestination = 'uploads/review_images/' . $newImageName;

            // Move the uploaded file to the destination
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

// Insert review into the database
if ($imagePath) {
    // Nếu có hình ảnh, thêm vào cột REVIEWIMAGE
    $reviewInsert = $conn->prepare("INSERT INTO reviews (userid, TOURID, RATING, COMMENT, POSTDATE, REVIEWIMAGE) VALUES (?, ?, ?, ?, NOW(), ?)");
    $reviewInsert->bind_param("iiiss", $userid, $tourid, $rating, $comment, $imagePath);
} else {
    // Nếu không có hình ảnh, không bao gồm REVIEWIMAGE
    $reviewInsert = $conn->prepare("INSERT INTO reviews (userid, TOURID, RATING, COMMENT, POSTDATE) VALUES (?, ?, ?, ?, NOW())");
    $reviewInsert->bind_param("iiis", $userid, $tourid, $rating, $comment);
}

if ($reviewInsert->execute()) {
    echo "<script>alert('Đánh giá của bạn đã được gửi thành công!'); window.location.href='tour_detail.php';</script>";
} else {
    echo "Lỗi khi gửi đánh giá: " . $conn->error;
}

// Close the connection
$conn->close();
