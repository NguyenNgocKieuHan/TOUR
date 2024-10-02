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
            <div class="page-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="title">
                            <h4>Quản lý đánh giá</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Quản lý đánh giá</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="mb-30">
                <div class="pb-20">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="sitemap">
                                <h5 class="h5">Danh sách đánh giá</h5>
                                <ul>
                                    <?php
                                    $query = "SELECT u.USNAME as USERNAME, t.TOURNAME, r.RATING, r.COMMENT, r.POSTDATE
                                                FROM reviews r
                                                JOIN users u ON r.USERID = u.USERID
                                                JOIN tour t ON r.TOURID = t.TOURID
                                                ORDER BY r.POSTDATE DESC";

                                    $result = mysqli_query($conn, $query);

                                    // Xử lý dữ liệu và hiển thị cấu trúc phân cấp
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<li>";
                                        echo "<strong>Người dùng:</strong> " . htmlspecialchars($row['USERNAME']) . "<br>";
                                        echo "<strong>Tour:</strong> " . htmlspecialchars($row['TOURNAME']) . "<br>";
                                        echo "<strong>Đánh giá:</strong> " . htmlspecialchars($row['RATING']) . "<br>";
                                        echo "<strong>Nhận xét:</strong> " . htmlspecialchars($row['COMMENT']) . "<br>";
                                        echo "<strong>Ngày đăng:</strong> " . date('d/m/Y H:i:s', strtotime($row['POSTDATE'])) . "<br>";
                                        echo "</li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
    </div>
</div>
<!-- js -->
<script src="vendors/scripts/core.js"></script>
<script src="vendors/scripts/script.min.js"></script>
<script src="vendors/scripts/process.js"></script>
<script src="vendors/scripts/layout-settings.js"></script>
</body>

</html>