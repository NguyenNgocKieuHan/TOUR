<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    echo "<script>
    alert('Bạn chưa đăng nhập!');
    window.location.href = 'login.php';
</script>";
    exit();
}

$activate = "booking";

include('includes/header.php');
include('includes/db.php');

// Get the tour details from the URL
if (isset($_GET['tourid'])) {
    $tourId = intval($_GET['tourid']);

    // Fetch tour details from database
    $queryTour = "SELECT TOURNAME, PRICE FROM tour WHERE TOURID = ?";
    $stmtTour = $conn->prepare($queryTour);
    $stmtTour->bind_param("i", $tourId);
    $stmtTour->execute();
    $resultTour = $stmtTour->get_result();
    $tourData = $resultTour->fetch_assoc();

    if (!$tourData) {
        echo "<p>Không tìm thấy thông tin tour!</p>";
        exit;
    }

    $tourName = htmlspecialchars($tourData['TOURNAME']);
    $price = htmlspecialchars($tourData['PRICE']);
} else {
    echo "<p>Không tìm thấy thông tin tour !!</p>";
    exit;
}

// Fetch user details based on USERID
$userid = $_SESSION['userid'];
$query = "SELECT USNAME, USEMAIL FROM users WHERE USERID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if (!$userData) {
    echo "<p>Không tìm thấy thông tin người dùng!</p>";
    exit;
}

$fullName = $userData['USNAME'];
$email = $userData['USEMAIL'];
?>
<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4">Đặt tour trực tuyến</h3>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="#">Trang</a></li>
            <li class="breadcrumb-item active text-white">Đặt tour trực tuyến</li>
        </ol>
    </div>
</div>
<!-- Header End -->

<!-- Tour Booking Start -->
<div class="container-fluid booking py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <h5 class="section-booking-title pe-3">Đặt tour</h5>
                <h1 class="text-white mb-4">Đặt tour trực tuyến </h1>
                <p class="text-white mb-4">Đặt tour trực tuyến dễ dàng và nhanh chóng. Hãy chọn tour mà bạn muốn tham gia và cung cấp thông tin cần thiết để hoàn tất đặt chỗ.</p>
                <p class="text-white mb-4">Hãy chọn tour mà bạn muốn tham gia từ danh sách các tour hiện có. Chúng tôi cung cấp nhiều lựa chọn tour phong phú với điểm đến đa dạng. Mỗi tour đều có chương trình đặc biệt dành riêng cho du khách, bao gồm lịch trình chi tiết, dịch vụ chất lượng và giá cả hợp lý.</p>
            </div>
            <div class="col-lg-6">
                <h1 class="text-white mb-3">Đặt tour du lịch</h1>
                <form action="process_booking.php" method="post">
                    <div class="row g-3">
                        <input type="hidden" name="tourid" value="<?php echo $tourId; ?>">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-white border-0" id="name" name="name" value="<?php echo $fullName; ?>" readonly>
                                <label for="name">Họ và tên</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control bg-white border-0" id="email" name="email" value="<?php echo $email; ?>" readonly>
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating date" id="date3" data-target-input="nearest">
                                <input type="date" class="form-control bg-white border-0" name="startdate" id="datetime" placeholder="Chọn Ngày" data-target="#date3" data-toggle="datetimepicker" min="<?php echo date('Y-m-d'); ?>" />
                                <label for="datetime">Ngày khởi hành</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-white border-0" id="tourname" name="tourname" value="<?php echo $tourName; ?>" placeholder="Tên Tour" readonly>
                                <label for="tourname">Tên Tour</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control bg-white border-0" id="people_count" name="people_count" min="1" max="30" placeholder="Số lượng người" required>
                                <label for="people_count">Số người</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="price" placeholder="Giá vé" name="price" value="<?php echo number_format($price, 0, ',', '.') . ' VND'; ?>" readonly>
                                <label for="CategoriesSelect">Giá vé cho 1 người</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary text-white w-100 py-3" type="submit">Đặt ngay</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Tour Booking End -->

<!-- Subscribe Start -->
<div class="container-fluid subscribe py-5">
    <div class="container text-center py-5">
        <div class="mx-auto text-center" style="max-width: 900px;">
            <h5 class="subscribe-title px-3">Subscribe</h5>
            <h1 class="text-white mb-4">Our Newsletter</h1>
            <p class="text-white mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum tempore nam, architecto doloremque velit explicabo? Voluptate sunt eveniet fuga eligendi! Expedita laudantium fugiat corrupti eum cum repellat a laborum quasi.
            </p>
            <div class="position-relative mx-auto">
                <input class="form-control border-primary rounded-pill w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                <button type="button" class="btn btn-primary rounded-pill position-absolute top-0 end-0 py-2 px-4 mt-2 me-2">Subscribe</button>
            </div>
        </div>
    </div>
</div>
<!-- Subscribe End -->

<!-- Footer Start -->
<div class="container-fluid footer py-5">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Get In Touch</h4>
                    <a href=""><i class="fas fa-home me-2"></i> 123 Street, New York, USA</a>
                    <a href=""><i class="fas fa-envelope me-2"></i> info@example.com</a>
                    <a href=""><i class="fas fa-phone me-2"></i> +012 345 67890</a>
                    <a href="" class="mb-3"><i class="fas fa-print me-2"></i> +012 345 67890</a>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-share fa-2x text-white me-2"></i>
                        <a class="btn-square btn btn-primary rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn-square btn btn-primary rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn-square btn btn-primary rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn-square btn btn-primary rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Company</h4>
                    <a href=""><i class="fas fa-angle-right me-2"></i> About</a>
                    <a href=""><i class="fas fa-angle-right me-2"></i> Careers</a>
                    <a href=""><i class="fas fa-angle-right me-2"></i> Blog</a>
                    <a href=""><i class="fas fa-angle-right me-2"></i> Press</a>
                    <a href=""><i class="fas fa-angle-right me-2"></i> Gift Cards</a>
                    <a href=""><i class="fas fa-angle-right me-2"></i> Magazine</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Support</h4>
                    <a href=""><i class="fas fa-angle-right me-2"></i> Contact</a>
                    <a href=""><i class="fas fa-angle-right me-2"></i> Legal Notice</a>
                    <a href=""><i class="fas fa-angle-right me-2"></i> Privacy Policy</a>
                    <a href=""><i class="fas fa-angle-right me-2"></i> Terms and Conditions</a>
                    <a href=""><i class="fas fa-angle-right me-2"></i> Sitemap</a>
                    <a href=""><i class="fas fa-angle-right me-2"></i> Cookie policy</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item">
                    <div class="row gy-3 gx-2 mb-4">
                        <div class="col-xl-6">
                            <form>
                                <div class="form-floating">
                                    <select class="form-select bg-dark border" id="select1">
                                        <option value="1">Arabic</option>
                                        <option value="2">German</option>
                                        <option value="3">Greek</option>
                                        <option value="3">New York</option>
                                    </select>
                                    <label for="select1">English</label>
                                </div>
                            </form>
                        </div>
                        <div class="col-xl-6">
                            <form>
                                <div class="form-floating">
                                    <select class="form-select bg-dark border" id="select1">
                                        <option value="1">USD</option>
                                        <option value="2">EUR</option>
                                        <option value="3">INR</option>
                                        <option value="3">GBP</option>
                                    </select>
                                    <label for="select1">$</label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <h4 class="text-white mb-3">Payments</h4>
                    <div class="footer-bank-card">
                        <a href="#" class="text-white me-2"><i class="fab fa-cc-amex fa-2x"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-cc-visa fa-2x"></i></a>
                        <a href="#" class="text-white me-2"><i class="fas fa-credit-card fa-2x"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-cc-mastercard fa-2x"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-cc-paypal fa-2x"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-cc-discover fa-2x"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright text-body py-4">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-md-6 text-center text-md-end mb-md-0">
                <i class="fas fa-copyright me-2"></i><a class="text-white" href="#">Your Site Name</a>, All right reserved.
            </div>
            <div class="col-md-6 text-center text-md-start">
                <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                Designed By <a class="text-white" href="https://htmlcodex.com">HTML Codex</a>
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->

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