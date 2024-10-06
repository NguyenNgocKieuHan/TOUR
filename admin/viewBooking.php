<?php
session_start();
include('includes/header.php');
include('includes/db.php');

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['ADID'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra xem TOURID và STARTDATE có được truyền vào không
if (isset($_GET['tourid'], $_GET['startdate']) && isset($_SESSION['ADID'])) {
    $tourId = intval($_GET['tourid']);
    $userId = $_SESSION['ADID'];
    $startDate = $_GET['startdate']; // Lấy giá trị STARTDATE từ GET

    // Truy vấn để lấy thông tin booking dựa trên TOURID, USERID và STARTDATE
    $sql = "SELECT b.BOOKINGDATE, b.NUMOFPEOPLE, b.STARTDATE, b.TOTALPRICE, b.STATUS, b.REJECTION_REASON, 
                   t.TOURNAME, u.USNAME, u.USEMAIL
            FROM bookings b
            JOIN tour t ON b.TOURID = t.TOURID
            JOIN users u ON b.USERID = u.USERID
            WHERE b.TOURID = ? AND b.USERID = ? AND b.STARTDATE = ? LIMIT 1"; // Giới hạn kết quả về 1 bản ghi

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $tourId, $userId, $startDate); // Bind với STARTDATE
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Chỉ lấy 1 bản ghi
    } else {
        echo "Không tìm thấy thông tin booking cho TOURID: $tourId, USERID: $userId và STARTDATE: $startDate";
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
                        <p><strong>Trạng Thái:</strong> <?php echo htmlspecialchars($row['STATUS'] == 1 ? 'Đã xác nhận' : ($row['STATUS'] == 0 ? 'Đã từ chối' : 'Chưa xác nhận')); ?></p>
                        <p><strong>Ngày Xuất Phát:</strong> <?php echo htmlspecialchars($row['STARTDATE']); ?></p>
                        <?php if ($row['STATUS'] == 0) : ?>
                            <p><strong>Lý do từ chối:</strong> <?php echo htmlspecialchars($row['REJECTION_REASON'] ? $row['REJECTION_REASON'] : 'N/A'); ?></p>
                        <?php endif; ?>
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