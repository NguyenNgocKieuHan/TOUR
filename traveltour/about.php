<?php
session_start();

$activate = "about";
include('includes/header.php');
include('includes/db.php');
?>

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4">Về chúng tôi</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#">Trang</a></li>
                <li class="breadcrumb-item active text-white">Về chúng tôi</li>
            </ol>
    </div>
</div>
<!-- Header End -->

<!-- About Start -->
<div class="container-fluid about py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <div class="h-100" style="border: 50px solid; border-color: transparent #13357B transparent #13357B;">
                    <img src="img/about-img.jpg" class="img-fluid w-100 h-100" alt="">
                </div>
            </div>
            <div class="col-lg-7" style="background: linear-gradient(rgba(255, 255, 255, .8), rgba(255, 255, 255, .8)), url(img/about-img-1.png);">
                <h1 class="mb-4">Chào mừng đến với <span class="text-primary">TravelTour</span></h1>
                <p>TravelTour là nền tảng hàng đầu cung cấp dịch vụ tour du lịch toàn diện. Chúng tôi cam kết mang đến cho bạn những trải nghiệm du lịch tốt nhất với các dịch vụ chất lượng cao và sự chăm sóc tận tâm.</p>
                <h2 class="mb-4">Về Chúng Tôi</h2>
                <p>Chúng tôi là một đội ngũ chuyên nghiệp với nhiều năm kinh nghiệm trong ngành du lịch. Với sứ mệnh mang đến cho khách hàng những chuyến đi đáng nhớ và tiện lợi, chúng tôi cung cấp các gói tour đa dạng từ các chuyến đi trong nước đến quốc tế.</p>

            </div>
        </div>
    </div>
</div>
<!-- About End -->

<!-- About End -->
<div class="container-fluid testimonial py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h2 class="section-title px-3">Giá Trị Cốt Lõi của Chúng Tôi</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-5">
                        <div class="card-body">
                            <h5 class="card-title">Khách hàng là trung tâm</h5>
                            <p class="card-text">Chúng tôi luôn đặt nhu cầu và sự hài lòng của khách hàng lên hàng đầu.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-5">
                        <div class="card-body">
                            <h5 class="card-title">Chất lượng dịch vụ</h5>
                            <p class="card-text"> Chúng tôi cam kết cung cấp dịch vụ chất lượng cao với sự chăm sóc tận tâm.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-5">
                        <div class="card-body">
                            <h5 class="card-title">Đổi mới và sáng tạo</h5>
                            <p class="card-text"> Chúng tôi không ngừng cải tiến và sáng tạo để mang đến những trải nghiệm du lịch mới mẻ.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<!-- Testimonial Start -->

<div class="container-fluid testimonial py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">Liên Hệ Với Chúng Tôi</h5>

            <p>Nếu bạn có bất kỳ câu hỏi nào hoặc cần hỗ trợ thêm thông tin, đừng ngần ngại liên hệ với chúng tôi qua:</p>
            <p>Email: <a href="mailto:support@traveltour.com">support@traveltour.com</a></p>
            <p>Điện thoại: +84 123 456 789</p>
            <p>Địa chỉ: 123 Đường Du Lịch, Thành phố Cần Thơ, Việt Nam</p>
        </div>

    </div>
</div>
<!-- Travel Guide Start -->
<!-- <div class="container-fluid guide py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">Travel Guide</h5>
            <h1 class="mb-0">Meet Our Guide</h1>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="guide-item">
                    <div class="guide-img">
                        <div class="guide-img-efects">
                            <img src="img/guide-1.jpg" class="img-fluid w-100 rounded-top" alt="Image">
                        </div>
                        <div class="guide-icon rounded-pill p-2">
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="guide-title text-center rounded-bottom p-4">
                        <div class="guide-title-inner">
                            <h4 class="mt-3">Full Name</h4>
                            <p class="mb-0">Designation</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="guide-item">
                    <div class="guide-img">
                        <div class="guide-img-efects">
                            <img src="img/guide-2.jpg" class="img-fluid w-100 rounded-top" alt="Image">
                        </div>
                        <div class="guide-icon rounded-pill p-2">
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="guide-title text-center rounded-bottom p-4">
                        <div class="guide-title-inner">
                            <h4 class="mt-3">Full Name</h4>
                            <p class="mb-0">Designation</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="guide-item">
                    <div class="guide-img">
                        <div class="guide-img-efects">
                            <img src="img/guide-3.jpg" class="img-fluid w-100 rounded-top" alt="Image">
                        </div>
                        <div class="guide-icon rounded-pill p-2">
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="guide-title text-center rounded-bottom p-4">
                        <div class="guide-title-inner">
                            <h4 class="mt-3">Full Name</h4>
                            <p class="mb-0">Designation</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="guide-item">
                    <div class="guide-img">
                        <div class="guide-img-efects">
                            <img src="img/guide-4.jpg" class="img-fluid w-100 rounded-top" alt="Image">
                        </div>
                        <div class="guide-icon rounded-pill p-2">
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="guide-title text-center rounded-bottom p-4">
                        <div class="guide-title-inner">
                            <h4 class="mt-3">Full Name</h4>
                            <p class="mb-0">Designation</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- Travel Guide End -->

<!-- Subscribe Start -->
<!-- <div class="container-fluid subscribe py-5">
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
</div> -->
<!-- Subscribe End -->

<!-- Footer Start -->
<?php
include 'includes/footer.php';
?>
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