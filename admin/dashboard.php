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
							<div class="weight-600 font-14">Tổng số lượt đặt tour</div>
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
	<div class="card-box mb-30">
		<h2 class="h4 pd-20">Tours bán chạy nhất</h2>
		<table class="table table-striped">
			<thead>
				<tr>
					<th scope="col">Quản trị viên đã thêm tour</th>
					<th scope="col">Tên Tour</th>
					<th scope="col">Loại Tour</th>
					<th scope="col">Giá</th>
					<th scope="col">Thời Gian</th>
					<th scope="col">Ảnh</th>
					<th scope="col">Hành động</th>
				</tr>
			</thead>
			<tbody>
				<?php
				// Truy vấn thông tin tour và loại tour với số lượng đặt từ 2 trở lên
				$query = "SELECT t.TOURID, t.TOURNAME, tt.TOURTYPENAME, t.PRICE, t.TIMETOUR, t.IMAGE, a.ADNAME, COUNT(b.USERID) AS booking_count
                                  FROM TOUR t
                                  JOIN TOURTYPE tt ON t.TOURTYPEID = tt.TOURTYPEID
                                  JOIN ADMIN a ON t.ADID = a.ADID
                                  LEFT JOIN bookings b ON t.TOURID = b.TOURID
                                  GROUP BY t.TOURID
                                  HAVING booking_count >= 2";

				$result = mysqli_query($conn, $query);

				// Kiểm tra có bản ghi nào không
				if (mysqli_num_rows($result) > 0) {
					// Lặp qua các bản ghi và hiển thị
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<tr>";
						echo "<th>" . htmlspecialchars($row['ADNAME']) .  "</th>";
						echo "<td>" . htmlspecialchars($row['TOURNAME']) .  "</td>";
						echo "<td>" . htmlspecialchars($row['TOURTYPENAME']) . "</td>";
						echo "<td>" . htmlspecialchars($row['PRICE']) . "</td>";
						echo "<td>" . htmlspecialchars($row['TIMETOUR']) . " " . "Ngày" . "</td>";

						// Hiển thị ảnh tour
						echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['IMAGE']) . "' alt='Ảnh' style='width: 100px;'></td>";

						echo "<td>
                                        <a href='editTour.php?id=" . $row['TOURID'] . "' class='btn btn-info btn-sm'><i class='fa fa-edit'></i> Sửa</a>
                                        <a href='deleteTour.php?id=" . $row['TOURID'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa không?\");'><i class='fa fa-trash'></i> Xóa</a>
                                      </td>";
						echo "</tr>";
					}
				} else {
					echo "<tr><td colspan='7' class='text-center'>Không có tour nào để hiển thị.</td></tr>";
				}
				?>
			</tbody>
		</table>
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