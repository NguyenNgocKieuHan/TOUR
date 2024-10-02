<?php
session_start();
include('includes/header.php');
include('includes/db.php');

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['ADID'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra xem TOURID có được truyền vào không
if (isset($_GET['TOURID']) && isset($_SESSION['USERID'])) {
    $tourId = intval($_GET['TOURID']);
    $userId = $_SESSION['USERID'];

    // Truy vấn để lấy thông tin booking
    $sql = "SELECT * FROM bookings WHERE TOURID = ? AND USERID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $tourId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Cập nhật trạng thái booking thành 'Đã xác nhận' (STATUS = 1)
        $updateQuery = "UPDATE bookings SET STATUS = 1, CANCELLED_BY = NULL WHERE TOURID = ? AND USERID = ?";
        $stmtUpdate = $conn->prepare($updateQuery);
        $stmtUpdate->bind_param("ii", $tourId, $userId);

        if ($stmtUpdate->execute()) {
            echo "<script>alert('Đơn đặt tour đã được phê duyệt thành công.'); window.location.href='bookingManagement.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra khi phê duyệt đơn đặt tour.'); window.location.href='bookingManagement.php';</script>";
        }
    } else {
        echo "<script>alert('Không tìm thấy thông tin booking.'); window.location.href='bookingManagement.php';</script>";
        exit();
    }
    $stmt->close();
} else {
    echo "<script>alert('Thông tin đặt tour không được cung cấp.'); window.location.href='bookingManagement.php';</script>";
    exit();
}

$conn->close();
?>

<!-- Footer -->
<?php include('includes/footer.php'); ?>