<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Bạn chưa đăng nhập!'); window.location.href='login.php';</script>";
    exit();
}

include('includes/header.php');
include('includes/db.php');

// Lấy trạng thái booking
$sql = "SELECT b.BOOKINGID, t.TOURNAME, b.STATUS FROM bookings b JOIN tour t ON b.TOURID = t.TOURID WHERE b.USERID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Trạng thái đơn đặt tour của bạn</h2>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>Tour: " . $row['TOURNAME'] . " - Trạng thái: " . $row['STATUS'] . "</p>";
    }
} else {
    echo "<p>Bạn chưa đặt tour nào.</p>";
}
?>
<div>
    <!-- <a href="logout.php" class="btn btn-danger">Đăng xuất</a> -->
</div>