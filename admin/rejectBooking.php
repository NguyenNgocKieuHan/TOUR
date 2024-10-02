<?php
session_start();
include('includes/db.php');

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['USERID'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra xem TOURID có được truyền vào không
if (isset($_GET['tourid']) && isset($_SESSION['USERID'])) {
    $tourId = intval($_GET['tourid']);
    $userId = $_SESSION['USERID'];

    // Nếu phương thức là POST, xử lý từ chối booking
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lấy lý do từ biểu mẫu
        $rejectionReason = trim($_POST['rejectionReason']);

        // Cập nhật trạng thái booking thành "Đã từ chối" và lưu lý do
        $sql = "UPDATE bookings SET STATUS = 0, REJECTION_REASON = ? WHERE TOURID = ? AND USERID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $rejectionReason, $tourId, $userId);

        if ($stmt->execute()) {
            // Chuyển hướng về trang quản lý booking với thông báo thành công
            header("Location: bookingManagement.php?status=success");
            exit();
        } else {
            echo "Lỗi khi từ chối booking: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    echo "<script>alert('Thông tin đặt tour không được cung cấp!'); window.location.href='bookingManagement.php';</script>";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Từ Chối Đặt Tour</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css"> <!-- Thay đổi đường dẫn theo thực tế -->
</head>

<body>
    <div class="main-container">
        <div class="pd-20 xs-pd-20-10">
            <div class="card-box pd-20 mb-30">
                <h4 class="text-blue h4">Từ Chối Đặt Tour</h4>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="rejectionReason">Lý do từ chối</label>
                        <select id="rejectionReason" name="rejectionReason" class="form-control" required>
                            <option value="" disabled selected>Chọn lý do từ chối</option>
                            <option value="Tour đã đầy">Tour đã đầy</option>
                            <option value="Không đủ số lượng người">Không đủ số lượng người</option>
                            <option value="Yêu cầu đặc biệt không thể đáp ứng">Yêu cầu đặc biệt không thể đáp ứng</option>
                            <option value="Khách hàng không tuân thủ quy định">Khách hàng không tuân thủ quy định</option>
                            <option value="Lý do khác">Lý do khác</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger">Từ chối</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>