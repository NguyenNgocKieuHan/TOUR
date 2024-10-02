<?php
session_start(); // Bắt đầu phiên làm việc

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
	<div class="pd-ltr-20 xs-pd-20-10">
		<div class="min-height-200px">
			<div class="pd-20 card-box mb-30">
				<div class="clearfix mb-20">
					<div class="pull-left">
						<h4 class="text-blue h4">Quản lý Hóa Đơn</h4>
					</div>
					<div class="pull-right">
						<!-- <a href="addInvoice.php" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Thêm Hóa Đơn</a> -->
					</div>
				</div>
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">Stt</th>
							<th scope="col">Tour</th>
							<th scope="col">Ngày Lập Hóa Đơn</th>
							<th scope="col">Ngày Bắt Đầu</th>
							<th scope="col">Số Lượng</th>
							<th scope="col">Số Tiền</th>
							<th scope="col">Hành động</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// Truy vấn cơ sở dữ liệu
						$query = "SELECT i.INVOICEDID, t.TOURNAME, i.INVOICEDATE, i.STARTDATE, i.QUANTITY, i.AMOUNT
                                  FROM invoice i
                                  JOIN tour t ON i.TOURID = t.TOURID";
						$result = mysqli_query($conn, $query);
						$counter = 1;

						// Xử lý dữ liệu và hiển thị bảng
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<tr>";
							echo "<th scope='row'>" . $counter . "</th>";
							echo "<td>" . $row['TOURNAME'] . "</td>";
							echo "<td>" . date('d/m/Y H:i:s', strtotime($row['INVOICEDATE'])) . "</td>";
							echo "<td>" . date('d/m/Y', strtotime($row['STARTDATE'])) . "</td>";
							echo "<td>" . $row['QUANTITY'] . "</td>";
							echo "<td>" . number_format($row['AMOUNT'], 2) . "</td>"; // Định dạng số tiền
							echo "<td>
                                    <a href='editInvoice.php?id=" . $row['INVOICEDID'] . "' class='btn btn-info btn-sm'><i class='fa fa-edit'></i> Sửa</a>
                                    <a href='deleteInvoice.php?id=" . $row['INVOICEDID'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa không?\");'><i class='fa fa-trash'></i> Xóa</a>
                                  </td>";
							echo "</tr>";
							$counter++;
						}
						?>
					</tbody>
				</table>
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