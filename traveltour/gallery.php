<?php
session_start();
$activate = "gallery_activate";

include('includes/header.php');
include('includes/db.php');

// Khởi tạo mảng để lưu ảnh
$images = [];
$reviewImages = []; // Khởi tạo mảng cho ảnh review

// Lấy ảnh từ bảng tour
$tourStmt = $conn->prepare("SELECT IMAGE FROM tour");
$tourStmt->execute();
$tourStmt->bind_result($tourImage);
while ($tourStmt->fetch()) {
    $images[] = $tourImage; // Lưu ảnh từ tour vào mảng $images
}
$tourStmt->close();

// Lấy ảnh từ bảng reviews
$reviewStmt = $conn->prepare("SELECT REVIEWIMAGE FROM reviews");
$reviewStmt->execute();
$reviewStmt->bind_result($reviewImage);
while ($reviewStmt->fetch()) {
    $reviewImages[] = $reviewImage; // Lưu ảnh từ reviews vào mảng $reviewImages
}
$reviewStmt->close();

// Lấy ảnh từ bảng destination
$destinationStmt = $conn->prepare("SELECT IMAGE FROM destination");
$destinationStmt->execute();
$destinationStmt->bind_result($destinationImage);
while ($destinationStmt->fetch()) {
    $images[] = $destinationImage; // Lưu ảnh từ destination vào mảng $images
}
$destinationStmt->close();

$conn->close();
?>

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4">Thư viện ảnh của chúng tôi</h3>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="#">Trang</a></li>
            <li class="breadcrumb-item active text-white">Thư viện ảnh</li>
        </ol>
    </div>
</div>
<!-- Header End -->

<!-- Gallery Start -->
<div class="container-fluid gallery py-5 my-5">
    <div class="mx-auto text-center mb-5" style="max-width: 900px;">
        <h5 class="section-title px-3">Thư viện ảnh của chúng tôi</h5>
        <h1 class="mb-4">Thư viện ảnh Du lịch & Lữ hành.</h1>
        <!-- <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum tempore nam, architecto doloremque velit explicabo? Voluptate sunt eveniet fuga eligendi! Expedita laudantium fugiat corrupti eum cum repellat a laborum quasi. -->
        </p>
    </div>
    <div class="tab-class text-center">
        <ul class="nav nav-pills d-inline-flex justify-content-center mb-5">
            <li class="nav-item">
                <a class="d-flex mx-3 py-2 border border-primary bg-light rounded-pill active" data-bs-toggle="pill" href="#GalleryTab-1">
                    <span class="text-dark" style="width: 150px;">Tất cả</span>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="d-flex py-2 mx-3 border border-primary bg-light rounded-pill" data-bs-toggle="pill" href="#GalleryTab-2">
                    <span class="text-dark" style="width: 150px;">Ảnh bên TravelTour</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="d-flex mx-3 py-2 border border-primary bg-light rounded-pill" data-bs-toggle="pill" href="#GalleryTab-3">
                    <span class="text-dark" style="width: 150px;">Ảnh của khách hàng</span>
                </a>
            </li> -->
        </ul>
        <div class="tab-content">
            <!-- Tab Tất cả -->
            <div class="container py-5 tab-pane fade show active" id="GalleryTab-1">
                <div class="row g-2">
                    <?php foreach ($images as $image): ?>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="gallery-item h-100">
                                <img src="data:image/jpeg;base64,<?= base64_encode($image); ?>" class="img-fluid w-100 h-100 rounded" alt="Image">
                                <div class="gallery-plus-icon">
                                    <a href="data:image/jpeg;base64,<?= base64_encode($image); ?>" data-lightbox="gallery" class="my-auto"><i class="fas fa-plus fa-2x text-white"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Tab Ảnh bên TravelTour -->
            <div id="GalleryTab-2" class="tab-pane fade show p-0">
                <div class="row g-2">
                    <?php foreach ($images as $image): // Chỉ hiển thị ảnh từ bảng tour 
                    ?>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="gallery-item h-100">
                                <img src="data:image/jpeg;base64,<?= base64_encode($image); ?>" class="img-fluid w-100 h-100 rounded" alt="Image">
                                <div class="gallery-content">
                                    <div class="gallery-info">
                                        <h5 class="text-white text-uppercase mb-2">Ảnh bên TravelTour</h5>
                                        <a href="#" class="btn-hover text-white">View All Place <i class="fa fa-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                                <div class="gallery-plus-icon">
                                    <a href="data:image/jpeg;base64,<?= base64_encode($image); ?>" data-lightbox="gallery" class="my-auto"><i class="fas fa-plus fa-2x text-white"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Tab Ảnh của khách hàng -->
            <div id="GalleryTab-3" class="tab-pane fade show p-0">
                <div class="row g-2">
                    <?php foreach ($reviewImages as $image): // Hiển thị ảnh từ bảng reviews 
                    ?>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="gallery-item h-100">
                                <img src="data:image/jpeg;base64,<?= base64_encode($image); ?>" class="img-fluid w-100 h-100 rounded" alt="Image">
                                <div class="gallery-content">
                                    <div class="gallery-info">
                                        <h5 class="text-white text-uppercase mb-2">Ảnh của khách hàng</h5>
                                        <a href="#" class="btn-hover text-white">View All Place <i class="fa fa-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                                <div class="gallery-plus-icon">
                                    <a href="data:image/jpeg;base64,<?= base64_encode($image); ?>" data-lightbox="gallery" class="my-auto"><i class="fas fa-plus fa-2x text-white"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Gallery End -->


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
<?php include('includes/footer.php'); ?>