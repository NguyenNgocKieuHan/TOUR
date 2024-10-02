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

// Truy xuất dữ liệu người dùng
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Lỗi truy xuất dữ liệu: " . mysqli_error($conn));
}
?>
<div class="mobile-menu-overlay"></div>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Quản lý Người dùng</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Quản lý Người dùng</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- Export Datatable start -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Danh sách Người dùng</h4>
                </div>
                <div class="pb-20">
                    <table class="table hover multiple-select-row data-table-export nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">STT</th>
                                <th class="table-plus datatable-nosort">Họ và tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <!-- <th>Chức vụ</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stt = 1; // Khởi tạo biến số thứ tự
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td class="table-plus"><?php echo $stt++; ?></td> <!-- Hiển thị số thứ tự -->
                                    <td><?php echo htmlspecialchars($row['USNAME']); ?></td>
                                    <td><?php echo htmlspecialchars($row['USEMAIL']); ?></td>
                                    <td><?php echo htmlspecialchars($row['USSDT']); ?></td>
                                    <!-- <td><?php echo htmlspecialchars($row['USERTYPE']); ?></td> -->
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Export Datatable End -->
        </div>
        <?php
        mysqli_close($conn); // Đóng kết nối
        ?>
    </div>
</div>
<!-- js -->
<script src="vendors/scripts/core.js"></script>
<script src="vendors/scripts/script.min.js"></script>
<script src="vendors/scripts/process.js"></script>
<script src="vendors/scripts/layout-settings.js"></script>
<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<!-- buttons for Export datatable -->
<script src="src/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script src="src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
<script src="src/plugins/datatables/js/buttons.print.min.js"></script>
<script src="src/plugins/datatables/js/buttons.html5.min.js"></script>
<script src="src/plugins/datatables/js/buttons.flash.min.js"></script>
<script src="src/plugins/datatables/js/pdfmake.min.js"></script>
<script src="src/plugins/datatables/js/vfs_fonts.js"></script>
<!-- Datatable Setting js -->
<script src="vendors/scripts/datatable-setting.js"></script>
</body>

</html>