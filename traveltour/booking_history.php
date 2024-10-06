<?php
session_start();

// Kiểm tra người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Bạn chưa đăng nhập!'); window.location.href='login.php';</script>";
    exit();
}

$userid = $_SESSION['userid']; // Lấy USERID từ session
$activate = "booking_history";

include('includes/header.php');
include('includes/db.php');

// Truy vấn để lấy thông tin người dùng
$userQuery = "SELECT USNAME, USEMAIL, USSDT FROM USERS WHERE userid = ?";
$stmtUser = $conn->prepare($userQuery);
$stmtUser->bind_param("i", $userid);
$stmtUser->execute();
$userResult = $stmtUser->get_result();
$user = $userResult->fetch_assoc();

// Truy vấn để lấy lịch sử đặt tour
$historyQuery = "SELECT b.TOURID, t.TOURNAME, b.BOOKINGDATE, b.NUMOFPEOPLE, b.TOTALPRICE, b.STATUS, b.STARTDATE, b.CANCELLED_BY, b.REJECTION_REASON
                 FROM bookings b
                 JOIN tour t ON b.TOURID = t.TOURID
                 WHERE b.USERID = ? 
                 ORDER BY b.BOOKINGDATE DESC"; // Sắp xếp theo ngày đặt tour từ mới nhất đến cũ nhất
$stmtHistory = $conn->prepare($historyQuery);
$stmtHistory->bind_param("i", $userid);
$stmtHistory->execute();
$historyResult = $stmtHistory->get_result();
?>

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4">Lịch sử đặt tour</h3>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white">Lịch sử đặt tour</li>
        </ol>
    </div>
</div>
<!-- Header End -->

<!-- Booking History Start -->
<div class="container py-5">
    <h3 class="mb-4">Lịch sử đặt tour của bạn</h3>

    <?php if ($user) { ?>
        <div class="mb-4">
            <h4>Thông tin khách hàng</h4>
            <p>Tên: <?php echo htmlspecialchars($user['USNAME']); ?></p>
            <p>Email: <?php echo htmlspecialchars($user['USEMAIL']); ?></p>
            <p>Số điện thoại: <?php echo htmlspecialchars($user['USSDT']); ?></p>
        </div>
    <?php } ?>

    <?php if ($historyResult->num_rows > 0) { ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tên Tour</th>
                    <th>Ngày Đặt</th>
                    <th>Ngày Khởi Hành</th>
                    <th>Số Người</th>
                    <th>Tổng Giá</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $historyResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['TOURNAME']); ?></td>
                        <td><?php echo htmlspecialchars($row['BOOKINGDATE']); ?></td>
                        <td><?php echo htmlspecialchars($row['STARTDATE']); ?></td>
                        <td><?php echo $row['NUMOFPEOPLE']; ?></td>
                        <td><?php echo number_format($row['TOTALPRICE'], 0, ',', '.') . ' VND'; ?></td>
                        <td>
                            <?php
                            // Hiển thị trạng thái đơn đặt tour
                            switch ($row['STATUS']) {
                                case 0:
                                    if ($row['CANCELLED_BY'] == 2) {
                                        echo 'Khách hàng đã hủy tour';
                                    } else {
                                        echo 'Đã từ chối'; // Trạng thái từ chối
                                        if (!empty($row['REJECTION_REASON'])) {
                                            echo '<br>Lý do: ' . htmlspecialchars($row['REJECTION_REASON']);
                                        }
                                    }
                                    break;
                                case 1:
                                    echo 'Đã xác nhận';
                                    break;
                                case 2:
                                    echo 'Chờ xác nhận';
                                    break;
                                default:
                                    echo 'Không xác định';
                                    break;
                            }
                            ?>
                        </td>
                        <td>
                            <?php if ($row['STATUS'] == 2) { // Chỉ hiển thị nút hủy nếu trạng thái là 'Chờ xác nhận' 
                            ?>
                                <form action="cancel_booking.php" method="POST">
                                    <input type="hidden" name="tourid" value="<?php echo $row['TOURID']; ?>">
                                    <button type="submit" class="btn btn-danger">Hủy</button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>Bạn chưa đặt tour nào.</p>
    <?php } ?>
</div>
<!-- Booking History End -->

<?php include('includes/footer.php'); ?>