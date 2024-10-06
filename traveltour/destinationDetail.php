<?php
session_start(); // Bắt đầu phiên làm việc
include('includes/header.php');
include('includes/db.php');

// Kiểm tra nếu có ID trong URL
if (isset($_GET['id'])) {
    $destination_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Truy vấn thông tin chi tiết của địa điểm
    $query = "SELECT d.DENAME, d.DEDESCRIPTION, d.IMAGE, c.CITYNAME, q.DISTRICTNAME
              FROM destination d
              JOIN district q ON d.DISTRICTID = q.DISTRICTID
              JOIN city c ON q.CITYID = c.CITYID
              WHERE d.DESTINATIONID = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $destination_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra có địa điểm không
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p>Không tìm thấy địa điểm nào.</p>";
        exit;
    }
} else {
    echo "<p>ID địa điểm không hợp lệ.</p>";
    exit;
}
?>
<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4">Điểm đến du lịch</h3>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="#">Trang</a></li>
            <li class="breadcrumb-item active text-white">Điểm đến</li>
        </ol>
    </div>
</div>
<!-- Header End -->

<div class="container py-5">
    <div class="row">
        <div class="col-lg-6">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['IMAGE']); ?>" class="img-fluid w-100 rounded mb-4">
            <h6 class="text-blue h4"><?php echo htmlspecialchars($row['DENAME']); ?></h6>
        </div>
        <div class="col-lg-6">
            <h7 class="mt-4"><strong>Thông Tin Chi Tiết:</strong></h7>
            <p><?php echo nl2br(htmlspecialchars($row['DEDESCRIPTION'])); ?></p>
            <h8><strong>Thành phố:</strong> <?php echo htmlspecialchars($row['CITYNAME']); ?></h8><br>
            <h8><strong>Quận huyện:</strong> <?php echo htmlspecialchars($row['DISTRICTNAME']); ?></h8>

            <div class="mt-4">
                <a href="destination.php" class="btn btn-primary">Quay lại danh sách</a>
            </div>
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