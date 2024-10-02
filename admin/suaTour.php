<?php
session_start(); // Bắt đầu phiên làm việc

include('includes/db.php'); // Kết nối tới cơ sở dữ liệu

// Kiểm tra nếu người dùng đã đăng nhập
// if (!isset($_SESSION['AIID'])) {
//     // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
//     header("Location: login.php");
//     exit();
// }

// Lấy mã ID của tour từ biểu mẫu
if (isset($_POST['tour_id'])) {
    $tour_id = intval($_POST['tour_id']);
} else {
    die("Không tìm thấy tour_id.");
}

// Kiểm tra kết nối với cơ sở dữ liệu
if (!$conn) {
    die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}

// Các thông tin khác từ biểu mẫu và bảo vệ đầu vào
$tour_name = mysqli_real_escape_string($conn, $_POST['tour_name']);
$tour_type_id = intval($_POST['tour_type_id']);
$time = mysqli_real_escape_string($conn, $_POST['start_date']);
$price = mysqli_real_escape_string($conn, $_POST['price']);
$description = mysqli_real_escape_string($conn, $_POST['description']);

// Xử lý ảnh
$image_data = null; // Biến để lưu trữ dữ liệu nhị phân của ảnh
$image_path = null; // Biến để lưu đường dẫn ảnh

if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    $temp_name = $_FILES['image']['tmp_name'];
    $image_path = basename($_FILES['image']['name']);
    $upload_file = $upload_dir . $image_path;

    if (move_uploaded_file($temp_name, $upload_file)) {
        // Đọc dữ liệu của ảnh từ tệp được tải lên
        $image_data = file_get_contents($upload_file);
    } else {
        echo "Lỗi khi tải ảnh lên.";
        exit;
    }
} else {
    // Nếu không có ảnh mới, giữ nguyên ảnh cũ
    $sql_tour = "SELECT IMAGE FROM tour WHERE TOURID = $tour_id";
    $result_tour = mysqli_query($conn, $sql_tour);
    $tour = mysqli_fetch_assoc($result_tour);
    $image_data = $tour['IMAGE']; // Lấy dữ liệu ảnh cũ từ database
}

// Cập nhật thông tin tour
$sql_update = "UPDATE tour SET 
    TOURNAME = ?, 
    TOURTYPEID = ?, 
    TIMETOUR= ?, 
    PRICE = ?, 
    DESCRIPTION = ?, 
    IMAGE = ? 
    WHERE TOURID = ?";

$stmt = $conn->prepare($sql_update);

// Liên kết các tham số vào câu truy vấn
$stmt->bind_param("sissssi", $tour_name, $tour_type_id, $time, $price, $description, $image_data, $tour_id);

// Thực thi câu lệnh
if ($stmt->execute()) {
    echo "<script>alert('Cập nhật tour thành công'); window.location.href='tourManagement.php';</script>";
} else {
    echo "Lỗi khi cập nhật thông tin tour: " . $stmt->error;
}

// Đóng kết nối
mysqli_close($conn);
