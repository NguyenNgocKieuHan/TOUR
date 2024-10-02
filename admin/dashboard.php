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
				<div class="card-box height-100-p widget-style1">
					<div class="d-flex flex-wrap align-items-center">
						<div class="progress-data">
							<div id="chart4"></div>
						</div>
						<div class="widget-data">
							<div class="h4 mb-0">$6060</div>
							<div class="weight-600 font-14">Worth</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
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
		</div>
		<div class="card-box mb-30">
			<h2 class="h4 pd-20">Tours bán chạy nhất</h2>
			<table class="data-table table nowrap">
				<thead>
					<tr>
						<th class="table-plus datatable-nosort">Tour</th>
						<th>Tên tour</th>
						<th>Giá</th>
						<!-- <th>Mô tả</th> -->
						<th>Ngày bắt đầu</th>
						<th>Số lượng</th>
						<th class="datatable-nosort">Hoạt động</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="table-plus">
							<img src="vendors/images/product-1.jpg" width="70" height="70" alt="">
						</td>
						<td>
							<h5 class="font-16">Shirt</h5>
							by John Doe
						</td>
						<td>Black</td>
						<td>M</td>
						<td>$1000</td>
						<td>1</td>
						<td>
							<div class="dropdown">
								<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
									<i class="dw dw-more"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
									<a class="dropdown-item" href="#"><i class="dw dw-eye"></i> Xem chi tiết</a>
									<a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Sửa</a>
									<a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Xóa</a>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="table-plus">
							<img src="vendors/images/product-2.jpg" width="70" height="70" alt="">
						</td>
						<td>
							<h5 class="font-16">Boots</h5>
							by Lea R. Frith
						</td>
						<td>brown</td>
						<td>9UK</td>
						<td>$900</td>
						<td>1</td>
						<td>
							<div class="dropdown">
								<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
									<i class="dw dw-more"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
									<a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a>
									<a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
									<a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="table-plus">
							<img src="vendors/images/product-3.jpg" width="70" height="70" alt="">
						</td>
						<td>
							<h5 class="font-16">Hat</h5>
							by Erik L. Richards
						</td>
						<td>Orange</td>
						<td>M</td>
						<td>$100</td>
						<td>4</td>
						<td>
							<div class="dropdown">
								<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
									<i class="dw dw-more"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
									<a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a>
									<a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
									<a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="table-plus">
							<img src="vendors/images/product-4.jpg" width="70" height="70" alt="">
						</td>
						<td>
							<h5 class="font-16">Long Dress</h5>
							by Renee I. Hansen
						</td>
						<td>Gray</td>
						<td>L</td>
						<td>$1000</td>
						<td>1</td>
						<td>
							<div class="dropdown">
								<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
									<i class="dw dw-more"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
									<a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a>
									<a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
									<a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="table-plus">
							<img src="vendors/images/product-5.jpg" width="70" height="70" alt="">
						</td>
						<td>
							<h5 class="font-16">Blazer</h5>
							by Vicki M. Coleman
						</td>
						<td>Blue</td>
						<td>M</td>
						<td>$1000</td>
						<td>1</td>
						<td>
							<div class="dropdown">
								<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
									<i class="dw dw-more"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
									<a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a>
									<a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
									<a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Footer -->
<?php
?>
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