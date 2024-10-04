<?php
session_start();
include('includes/header.php');
include('includes/db.php');

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['ADID'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra xem TOURID và USERID có được truyền vào không
if (isset($_GET['tourid']) && isset($_SESSION['ADID'])) {
    $tourId = intval($_GET['tourid']);
    $userId = $_SESSION['ADID'];

    // In ra giá trị để kiểm tra
    echo "Tour ID: $tourId<br>";
    echo "User ID: $userId<br>";

    // Truy vấn để lấy thông tin booking
    $sql = "SELECT b.BOOKINGDATE, b.NUMOFPEOPLE, b.TOTALPRICE, b.STATUS, b.REJECTION_REASON, t.TOURNAME, u.USNAME, u.USEMAIL,b.TOURID,b.USERID
            FROM bookings b
            JOIN tour t ON b.TOURID = t.TOURID
            JOIN users u ON b.USERID = u.USERID
            WHERE b.TOURID = ? AND b.USERID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $tourId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $statusText = ($row['STATUS'] == 1) ? 'Đã xác nhận' : ($row['STATUS'] == 0 ? 'Đã từ chối' : 'Chưa xác nhận');
        $rejectionReason = $row['REJECTION_REASON'] ? htmlspecialchars($row['REJECTION_REASON']) : 'N/A';
    } else {
        echo "Không tìm thấy thông tin booking cho TOURID: $tourId và USERID: $userId";
        exit();
    }
    $stmt->close();
} else {
    echo "Thông tin đặt tour không được cung cấp.";
    exit();
}

$conn->close();
?>

<div class="mobile-menu-overlay"></div>

<div class="main-container">
    <div class="pd-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix mb-20">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Chi Tiết Đặt Tour</h4>
                    </div>
                    <div class="pull-right">
                        <a href="bookingManagement.php" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Trở về</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Tên Tour:</strong> <?php echo htmlspecialchars($row['TOURNAME']); ?></p>
                        <p><strong>Ngày Đặt:</strong> <?php echo htmlspecialchars($row['BOOKINGDATE']); ?></p>
                        <p><strong>Số Người:</strong> <?php echo htmlspecialchars($row['NUMOFPEOPLE']); ?></p>
                        <p><strong>Tổng Giá:</strong> <?php echo number_format($row['TOTALPRICE'], 0, ',', '.') . " VNĐ"; ?></p>
                        <p><strong>Trạng Thái:</strong> <?php echo htmlspecialchars($statusText); ?></p>
                        <?php if ($row['STATUS'] == 0) { // Chỉ hiển thị lý do từ chối nếu trạng thái là 'Đã từ chối' 
                        ?>
                            <p><strong>Lý do từ chối:</strong> <?php echo $rejectionReason; ?></p>
                        <?php } ?>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tên Người Đặt:</strong> <?php echo htmlspecialchars($row['USNAME']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($row['USEMAIL']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- js -->
<script src="vendors/scripts/core.js"></script>
<script src="vendors/scripts/script.min.js"></script>
<script src="vendors/scripts/process.js"></script>
<script src="vendors/scripts/layout-settings.js"></script>
</body>

</html>