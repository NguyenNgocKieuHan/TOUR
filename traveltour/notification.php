<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

include('includes/header.php');
include('includes/db.php');

// Lấy thông tin booking của người dùng
$userId = $_SESSION['userid'];
$notificationsQuery = "SELECT b.TOURID, b.STATUS, b.CANCELLED_BY, t.TOURNAME, b.BOOKINGDATE
                        FROM bookings b
                        LEFT JOIN TOUR t ON b.TOURID = t.TOURID
                        WHERE b.userid = ?";
$stmt = $conn->prepare($notificationsQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$notificationsResult = $stmt->get_result();
?>
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4">Thông báo</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#">Trang</a></li>
                <li class="breadcrumb-item active text-white">Thông báo</li>
            </ol>
    </div>
</div>
<div class="main-container">
    <div class="pd-ltr-20">
        <div class="container">
            <h6 class="font-20 weight-500 mb-10 text-capitalize">Thông báo trạng thái tour của bạn</h6>

            <?php if ($notificationsResult->num_rows > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tên Tour</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                            <!-- <th>Người hủy</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $notificationsResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['TOURNAME']); ?></td>
                                <td>
                                    <?php
                                    switch ($row['STATUS']) {
                                        case 1:
                                            echo 'Đã được duyệt';
                                            break;
                                        case 2:
                                            echo 'Chờ xác nhận';
                                            break;
                                        case 3:
                                            echo 'Đã bị hủy';
                                            break;
                                        default:
                                            echo 'Không rõ';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($row['BOOKINGDATE'])); ?></td>
                                <!-- <td><?php echo $row['CANCELLED_BY'] ? htmlspecialchars($row['CANCELLED_BY']) : 'Không có'; ?></td> -->
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">Bạn chưa có thông báo nào.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="path/to/jquery.js"></script>
<script src="path/to/bootstrap.bundle.js"></script>
</body>

</html>
<?php
$stmt->close();
$conn->close();
?>