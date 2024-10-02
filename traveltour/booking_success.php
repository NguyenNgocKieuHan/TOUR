<?php
session_start();

include('includes/header.php');
include('includes/db.php');

// Gửi email xác nhận
$email_to = "user@example.com"; // Địa chỉ email của người đặt tour
$subject = "Xác nhận đặt tour thành công";
$message = "
    Chào bạn,\n\n
    Chúng tôi vui mừng thông báo rằng bạn đã đặt tour thành công. Thông tin chi tiết về tour sẽ được gửi đến bạn trong thời gian sớm nhất.\n\n
    Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi.\n\n
    Trân trọng,\n
    Đội ngũ Tour Management
";
// Xóa trạng thái đặt tour sau khi hiển thị trang thành công
unset($_SESSION['booking_success']);

// include('includes/header.php');
?>

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4">Đặt tour thành công</h3>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white">Xác nhận đặt tour</li>
        </ol>
    </div>
</div>
<!-- Header End -->

<!-- Success Message Start -->
<div class="container-fluid py-5">
    <div class="container py-5 text-center">
        <h1 class="display-4 text-success mb-4">Chúc mừng!</h1>
        <p class="fs-5 text-muted">Bạn đã đặt tour thành công. Chúng tôi sẽ sớm liên lạc để xác nhận và cung cấp thông tin chi tiết.</p>
        <a href="index.php" class="btn btn-primary text-white mt-3">Quay lại Trang chủ</a>
    </div>
</div>
<!-- Success Message End -->

<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->

<!-- Back to Top -->
<a href="#" class="btn btn-primary btn-primary-outline-0 btn-md-square back-to-top"><i class="fa fa-arrow-up"></i></a>

<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>
</body>

</html>