<?php
session_start();
include('includes/header.php');
include('includes/db.php');

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['ADID'])) {
	// Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
	header("Location: login.php");
	exit();
}
?>
<div class="mobile-menu-overlay"></div>

<div class="main-container">
	<div class="pd-ltr-20">
		<div class="card-box pd-20 height-100-p mb-30">
			<div class="row align-items-center">
				<div class="col-md-4">
					<img src="vendors/images/banner-img.png" alt="">
				</div>
				<div class="col-md-8">
					<h4 class="font-20 weight-500 mb-10 text-capitalize">
						Chào mừng đã trở lại <div class="weight-600 font-30 text-blue">TRAVELTOUR!</div>
					</h4>
					<p class="font-18 max-width-600">Chào mừng bạn đến với hệ thống quản lý tour dành cho quản trị viên. Giao diện thân thiện và trực quan. Hãy bắt đầu quản lý hiệu quả các tour của bạn ngay bây giờ để mang đến những trải nghiệm tuyệt vời nhất cho khách hàng.</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-3 mb-30">
				<div class="card-box height-100-p widget-style1">
					<div class="d-flex flex-wrap align-items-center">
						<div class="progress-data">
							<div id="chart"></div>
						</div>
						<div class="widget-data">
							<div class="h4 mb-0">
								<?php

								// Truy vấn đếm số lượng liên hệ
								$query = "SELECT COUNT(*) AS total_contacts FROM CONTACT";
								$result = mysqli_query($conn, $query);

								// Lấy kết quả
								if ($result) {
									$row = mysqli_fetch_assoc($result);
									echo $row['total_contacts']; // Hiển thị tổng số liên hệ
								} else {
									echo "0"; // Nếu không có liên hệ
								}
								?>
							</div>
							<div class="weight-600 font-14">Liên hệ</div>
						</div>

					</div>
				</div>
			</div>
			<div class="col-xl-3 mb-30">
				<div class="card-box height-100-p widget-style1">
					<div class="d-flex flex-wrap align-items-center">
						<div class="progress-data">
							<div id="chart2"></div>
						</div>
						<div class="widget-data">
							<div class="h4 mb-0">
								<?php

								// Truy vấn đếm số lượng tour
								$query = "SELECT COUNT(*) AS total_tours FROM TOUR";
								$result = mysqli_query($conn, $query);

								// Lấy kết quả
								if ($result) {
									$row = mysqli_fetch_assoc($result);
									echo $row['total_tours']; // Hiển thị tổng số tour
								} else {
									echo "0"; // Nếu không có tour
								}
								?>
							</div>
							<div class="weight-600 font-14">Số tour</div>
						</div>

					</div>
				</div>
			</div>
			<div class="col-xl-3 mb-30">
				<div class="card-box height-100-p widget-style1">
					<div class="d-flex flex-wrap align-items-center">
						<div class="progress-data">
							<div id="chart3"></div>
						</div>
						<div class="widget-data">
							<div class="h4 mb-0">
								<?php

								// Truy vấn đếm số lượng tour
								$query = "SELECT COUNT(*) AS total_destinations FROM DESTINATION";
								$result = mysqli_query($conn, $query);

								// Lấy kết quả
								if ($result) {
									$row = mysqli_fetch_assoc($result);
									echo $row['total_destinations']; // Hiển thị tổng số tour
								} else {
									echo "0"; // Nếu không có tour
								}
								?>
							</div>
							<div class="weight-600 font-14">Điểm đến</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 mb-30">
				<?php

				// Truy vấn để lấy tổng số lượt đặt tour
				$totalBookingsQuery = "SELECT COUNT(*) AS total_bookings FROM bookings";
				$stmtTotalBookings = $conn->prepare($totalBookingsQuery);
				$stmtTotalBookings->execute();
				$totalBookingsResult = $stmtTotalBookings->get_result();
				$totalBookings = $totalBookingsResult->fetch_assoc()['total_bookings'];
				?>

				<div class="card-box height-100-p widget-style1">
					<div class="d-flex flex-wrap align-items-center">
						<div class="progress-data">
							<div id="chart4"></div>
						</div>
						<div class="widget-data">
							<div class="h4 mb-0"><?php echo number_format($totalBookings, 0, ',', '.'); ?></div>
							<div class="weight-600 font-14">Lượt đặt tour</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- <div class="row">
			<div class="col-xl-8 mb-30">
				<div class="card-box height-100-p pd-20">
					<h2 class="h4 mb-20">Hoạt động</h2>
					<div id="chart5"></div>
				</div>
			</div>
			<div class="col-xl-4 mb-30">
				<div class="card-box height-100-p pd-20">
					<h2 class="h4 mb-20">Mục tiêu dẫn đầu</h2>
					<div id="chart6"></div>
				</div>
			</div>
		</div> -->
	</div>
	<div class="pd-ltr-20 xs-pd-20-10">
		<div class="min-height-200px">
			<div class="pd-20 card-box mb-30">
				<div class="clearfix mb-20">
					<div class="pull-left">
						<h4 class="text-blue h4">Các tour được đặt nhiều nhất</h4>
					</div>
				</div>

				<div class="row">
					<?php
					// Truy vấn các tour có ít nhất 2 lượt đặt
					$query = "SELECT t.TOURID, t.TOURNAME, t.PRICE, t.TIMETOUR as TIMETOUR, t.IMAGE, COUNT(b.USERID) AS booking_count
							FROM TOUR t
							LEFT JOIN bookings b ON t.TOURID = b.TOURID
							GROUP BY t.TOURID
							HAVING booking_count >= 2
							ORDER BY booking_count DESC"; // Sắp xếp theo số lượng đặt giảm dần

					$result = mysqli_query($conn, $query);

					// Hiển thị giao diện HTML
					// Kiểm tra có bản ghi nào không
					if (mysqli_num_rows($result) > 0) {
						// Lặp qua các bản ghi và hiển thị
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<div class='col-md-4 mb-4'>";
							echo "<div class='card'>";
							// Hiển thị ảnh tour
							echo "<img class='card-img-top' src='data:image/jpeg;base64," . base64_encode($row['IMAGE']) . "' alt='Ảnh tour'>";
							echo "<div class='card-body'>";
							echo "<h5 class='card-title'>" . htmlspecialchars($row['TOURNAME']) . "</h5>";
							echo "<p class='card-text'>Giá: " . htmlspecialchars($row['PRICE']) . " VND</p>";
							echo "<p class='card-text'>Thời gian: " . htmlspecialchars($row['TIMETOUR']) . " ngày</p>";
							echo "<p class='card-text'>Số lượt đặt: " . htmlspecialchars($row['booking_count']) . " lượt</p>";
							echo "</div>"; // Đóng card-body
							echo "<div class='card-footer text-center'>";
							echo "<a href='tourDetail.php?id=" . $row['TOURID'] . "' class='btn btn-primary'>Xem chi tiết</a>";
							echo "</div>"; // Đóng card-footer
							echo "</div>"; // Đóng card
							echo "</div>"; // Đóng col-md-4
						}
					} else {
						// Nếu không có tour bán chạy
						echo "<p class='text-center'>Không có tour nào bán chạy.</p>";
					}
					?>
				</div>
			</div>
		</div>
	</div>


	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
	<script src="src/plugins/apexcharts/apexcharts.min.js"></script>
	<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
	<script src="vendors/scripts/dashboard.js"></script>
	</body>

	</html>