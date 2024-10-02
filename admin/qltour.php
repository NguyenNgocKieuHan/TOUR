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
                                    // Truy vấn dữ liệu tour và quản trị viên
                                    $query = "SELECT t.TOURNAME, a.ADNAME
                                              FROM TOUR t
                                              JOIN admin a ON t.ADID = a.ADID
                                              ORDER BY a.ADNAME, t.TOURNAME";
                                    $result = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        $previous_admin = ''; // Biến lưu tên quản trị viên trước đó
                                        echo '<ul id="tree">'; // Bắt đầu danh sách cây
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            // Nếu quản trị viên mới khác quản trị viên trước đó, hiển thị tên quản trị viên mới
                                            if ($row['ADNAME'] != $previous_admin) {
                                                if ($previous_admin != '') {
                                                    echo "</ul></li>"; // Đóng nút cây trước đó
                                                }
                                                echo "<li><span class='caret'>" . htmlspecialchars($row['ADNAME']) . "</span>"; // Tên quản trị viên
                                                echo "<ul class='nested'>"; // Bắt đầu danh sách con cho tour
                                                $previous_admin = $row['ADNAME']; // Cập nhật quản trị viên hiện tại
                                            }
                                            echo "<li>- " . htmlspecialchars($row['TOURNAME']) . "</li>"; // Tour của quản trị viên
                                        }
                                        echo "</ul></li>"; // Đóng nút cây cuối cùng
                                        echo '</ul>'; // Đóng danh sách cây
                                    } else {
                                        echo "<p>Không có tour nào để hiển thị.</p>";
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
<script>
    // JavaScript để xử lý sơ đồ cây
    document.querySelectorAll('.caret').forEach(function(caret) {
        caret.addEventListener('click', function() {
            this.parentElement.querySelector('.nested').classList.toggle('active');
            this.classList.toggle('caret-down');
        });
    });
</script>
</body>

</html>