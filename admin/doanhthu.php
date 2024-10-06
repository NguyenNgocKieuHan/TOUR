<?php
session_start();

if (!isset($_SESSION['ADID'])) {
    header("Location: login.php");
    exit();
}
include('includes/header.php');
include('includes/db.php');

// Lấy tổng số tour
$totalToursQuery = "SELECT COUNT(*) as totalTours FROM TOUR";
$totalToursResult = $conn->query($totalToursQuery);
if (!$totalToursResult) {
    die("Lỗi truy vấn: " . $conn->error);
}
$totalTours = $totalToursResult->fetch_assoc()['totalTours'];

// Lấy tổng số booking
$totalBookingsQuery = "SELECT COUNT(*) as totalBookings FROM bookings";
$totalBookingsResult = $conn->query($totalBookingsQuery);
if (!$totalBookingsResult) {
    die("Lỗi truy vấn: " . $conn->error);
}
$totalBookings = $totalBookingsResult->fetch_assoc()['totalBookings'];

// Lấy số lượng booking theo từng tour
$bookingsByTourQuery = "SELECT t.TOURNAME, COUNT(b.USERID) AS booking_count
                         FROM TOUR t
                         LEFT JOIN bookings b ON t.TOURID = b.TOURID
                         GROUP BY t.TOURID";
$bookingsByTourResult = $conn->query($bookingsByTourQuery);
if (!$bookingsByTourResult) {
    die("Lỗi truy vấn: " . $conn->error);
}

// Tính tổng doanh thu
$totalRevenueQuery = "SELECT SUM(TOTALPRICE) as totalRevenue FROM bookings";
$totalRevenueResult = $conn->query($totalRevenueQuery);
if (!$totalRevenueResult) {
    die("Lỗi truy vấn: " . $conn->error);
}
$totalRevenue = $totalRevenueResult->fetch_assoc()['totalRevenue'];
$totalRevenue = $totalRevenue ? $totalRevenue : 0; // Đặt doanh thu bằng 0 nếu NULL
?>

<div class="main-container">
    <div class="pd-ltr-20">
        <div class="container">
            <div class="col-md-8">
                <h6 class="font-20 weight-500 mb-10 text-capitalize">
                    Thống kê hệ thống bán tour tại Cần Thơ </h6>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Tổng số tour</h5>
                            <p class="card-text"><?php echo $totalTours; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Tổng số booking</h5>
                            <p class="card-text"><?php echo $totalBookings; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Doanh thu tổng</h5>
                            <p class="card-text"><?php echo number_format($totalRevenue, 0, ',', '.') . ' VNĐ'; ?></p>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Biểu đồ -->
            <h4>Biểu đồ thống kê</h4>
            <canvas id="myChart" style="max-width: 600px; margin: auto;"></canvas>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('myChart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'bar', // Loại biểu đồ: bar, line, pie, v.v.
                    data: {
                        labels: ['Tổng số tour', 'Tổng số booking', 'Doanh thu tổng'],
                        datasets: [{
                            label: 'Số liệu thống kê',
                            data: [<?php echo $totalTours; ?>, <?php echo $totalBookings; ?>, <?php echo $totalRevenue; ?>],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(75, 192, 192, 0.2)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>

            <h4>Thống kê số lượng booking theo từng tour</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tên Tour</th>
                        <th>Số lượng booking</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($bookingsByTourResult->num_rows > 0): ?>
                        <?php while ($row = $bookingsByTourResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['TOURNAME']); ?></td>
                                <td><?php echo $row['booking_count']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center">Không có dữ liệu để hiển thị.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="path/to/jquery.js"></script>
<script src="path/to/bootstrap.bundle.js"></script>
</body>

</html>
<?php
$conn->close();
?>