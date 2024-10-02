<?php
session_start();
$activate = "destination";

include('includes/header.php');
include('includes/db.php');

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

<!-- Destination Start -->
<div class="container-fluid destination py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">Điểm đến</h5>
            <h1 class="mb-0">Điểm đến phổ biến</h1>
        </div>
        <div class="tab-class text-center">
            <ul class="nav nav-pills d-inline-flex justify-content-center mb-5">
                <li class="nav-item">
                    <a class="d-flex mx-3 py-2 border border-primary bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-all">
                        <span class="text-dark" style="width: 150px;">Tất cả</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="d-flex mx-3 py-2 border border-primary bg-light rounded-pill" data-bs-toggle="pill" href="#tab-cairang">
                        <span class="text-dark" style="width: 150px;">Cái Răng</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="d-flex mx-3 py-2 border border-primary bg-light rounded-pill" data-bs-toggle="pill" href="#tab-ninhkieu">
                        <span class="text-dark" style="width: 150px;">Ninh Kiều</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="d-flex mx-3 py-2 border border-primary bg-light rounded-pill" data-bs-toggle="pill" href="#tab-phongdien">
                        <span class="text-dark" style="width: 150px;">Phong Điền</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="d-flex mx-3 py-2 border border-primary bg-light rounded-pill" data-bs-toggle="pill" href="#tab-thotnot">
                        <span class="text-dark" style="width: 150px;">Thốt Nốt</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="d-flex mx-3 py-2 border border-primary bg-light rounded-pill" data-bs-toggle="pill" href="#tab-binhthuy">
                        <span class="text-dark" style="width: 150px;">Bình Thủy</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- Tab Tất cả -->
                <div id="tab-all" class="tab-pane fade show active">
                    <div class="row g-4">
                        <?php
                        // Truy vấn tất cả địa điểm
                        $query = "SELECT DESTINATIONID, DESTINATIONNAME, IMAGE FROM destination";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Hiển thị tất cả các điểm đến
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-xl-4">';
                            echo '<div class="destination-img h-100">';
                            echo '<img class="img-fluid rounded w-100 h-100" style="object-fit: cover; min-height: 300px;" src="data:image/jpeg;base64,' . base64_encode($row['IMAGE']) . '" alt="Image">';
                            echo '<div class="destination-overlay p-4">';
                            echo '<h4 class="text-white mb-2 mt-3">' . htmlspecialchars($row['DESTINATIONNAME']) . '</h4>';
                            echo '<a href="#" class="btn-hover text-white">View All Place <i class="fa fa-arrow-right ms-2"></i></a>';
                            echo '</div>';
                            echo '<div class="search-icon">';
                            echo '<a href="data:image/jpeg;base64,' . base64_encode($row['IMAGE']) . '" data-lightbox="destination-' . htmlspecialchars($row['DESTINATIONID']) . '">';
                            echo '<i class="fa fa-plus-square fa-1x btn btn-light btn-lg-square text-primary"></i>';
                            echo '</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>


                <!-- Tab Cái Răng -->
                <div id="tab-cairang" class="tab-pane fade">
                    <div class="row g-4">
                        <?php
                        // Truy vấn các địa điểm Cái Răng dựa trên DISTRICTID
                        $query = "SELECT DESTINATIONID, DESTINATIONNAME, IMAGE FROM destination WHERE DISTRICTID = ?";
                        $stmt = $conn->prepare($query);
                        $districtId = 1; // DISTRICTID của Cái Răng
                        $stmt->bind_param("i", $districtId);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-xl-4">';
                            echo '<div class="destination-img h-100">';
                            echo '<img class="img-fluid rounded w-100 h-100" style="object-fit: cover; min-height: 300px;" src="data:image/jpeg;base64,' . base64_encode($row['IMAGE']) . '" alt="Image">';
                            echo '<div class="destination-overlay p-4">';
                            echo '<h4 class="text-white mb-2 mt-3">' . htmlspecialchars($row['DESTINATIONNAME']) . '</h4>';
                            echo '<a href="#" class="btn-hover text-white">View All Place <i class="fa fa-arrow-right ms-2"></i></a>';
                            echo '</div>';
                            echo '<div class="search-icon">';
                            echo '<a href="data:image/jpeg;base64,' . base64_encode($row['IMAGE']) . '" data-lightbox="destination-' . htmlspecialchars($row['DESTINATIONID']) . '">';
                            echo '<i class="fa fa-plus-square fa-1x btn btn-light btn-lg-square text-primary"></i>';
                            echo '</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Tab Ninh Kiều -->
                <div id="tab-ninhkieu" class="tab-pane fade">
                    <div class="row g-4">
                        <?php
                        // Truy vấn các địa điểm Ninh Kiều dựa trên DISTRICTID
                        $query = "SELECT DESTINATIONID, DESTINATIONNAME, IMAGE FROM destination WHERE DISTRICTID = ?";
                        $stmt = $conn->prepare($query);
                        $districtId = 2; // DISTRICTID của Ninh Kiều
                        $stmt->bind_param("i", $districtId);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-xl-4">';
                            echo '<div class="destination-img h-100">';
                            echo '<img class="img-fluid rounded w-100 h-100" style="object-fit: cover; min-height: 300px;" src="data:image/jpeg;base64,' . base64_encode($row['IMAGE']) . '" alt="Image">';
                            echo '<div class="destination-overlay p-4">';
                            echo '<h4 class="text-white mb-2 mt-3">' . htmlspecialchars($row['DESTINATIONNAME']) . '</h4>';
                            echo '<a href="#" class="btn-hover text-white">View All Place <i class="fa fa-arrow-right ms-2"></i></a>';
                            echo '</div>';
                            echo '<div class="search-icon">';
                            echo '<a href="data:image/jpeg;base64,' . base64_encode($row['IMAGE']) . '" data-lightbox="destination-' . htmlspecialchars($row['DESTINATIONID']) . '">';
                            echo '<i class="fa fa-plus-square fa-1x btn btn-light btn-lg-square text-primary"></i>';
                            echo '</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
                <!-- Tab Phong Điền -->
                <div id="tab-phongdien" class="tab-pane fade">
                    <div class="row g-4">
                        <?php
                        // Truy vấn các địa điểm Phong Điền dựa trên DISTRICTID
                        $query = "SELECT DESTINATIONID, DESTINATIONNAME, IMAGE FROM destination WHERE DISTRICTID = ?";
                        $stmt = $conn->prepare($query);
                        $districtId = 3; // DISTRICTID của Phong Điền
                        $stmt->bind_param("i", $districtId);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-xl-4">';
                            echo '<div class="destination-img h-100">';
                            echo '<img class="img-fluid rounded w-100 h-100" style="object-fit: cover; min-height: 300px;" src="data:image/jpeg;base64,' . base64_encode($row['IMAGE']) . '" alt="Image">';
                            echo '<div class="destination-overlay p-4">';
                            echo '<h4 class="text-white mb-2 mt-3">' . htmlspecialchars($row['DESTINATIONNAME']) . '</h4>';
                            echo '<a href="#" class="btn-hover text-white">View All Place <i class="fa fa-arrow-right ms-2"></i></a>';
                            echo '</div>';
                            echo '<div class="search-icon">';
                            echo '<a href="data:image/jpeg;base64,' . base64_encode($row['IMAGE']) . '" data-lightbox="destination-' . htmlspecialchars($row['DESTINATIONID']) . '">';
                            echo '<i class="fa fa-plus-square fa-1x btn btn-light btn-lg-square text-primary"></i>';
                            echo '</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Tab Thốt Nốt -->
                <div id="tab-thotnot" class="tab-pane fade">
                    <div class="row g-4">
                        <?php
                        // Truy vấn các địa điểm Thốt Nốt dựa trên DISTRICTID
                        $query = "SELECT DESTINATIONID, DESTINATIONNAME, IMAGE FROM destination WHERE DISTRICTID = ?";
                        $stmt = $conn->prepare($query);
                        $districtId = 4; // DISTRICTID của Thốt Nốt
                        $stmt->bind_param("i", $districtId);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-xl-4">';
                            echo '<div class="destination-img h-100">';
                            echo '<img class="img-fluid rounded w-100 h-100" style="object-fit: cover; min-height: 300px;" src="data:image/jpeg;base64,' . base64_encode($row['IMAGE']) . '" alt="Image">';
                            echo '<div class="destination-overlay p-4">';
                            echo '<h4 class="text-white mb-2 mt-3">' . htmlspecialchars($row['DESTINATIONNAME']) . '</h4>';
                            echo '<a href="#" class="btn-hover text-white">View All Place <i class="fa fa-arrow-right ms-2"></i></a>';
                            echo '</div>';
                            echo '<div class="search-icon">';
                            echo '<a href="data:image/jpeg;base64,' . base64_encode($row['IMAGE']) . '" data-lightbox="destination-' . htmlspecialchars($row['DESTINATIONID']) . '">';
                            echo '<i class="fa fa-plus-square fa-1x btn btn-light btn-lg-square text-primary"></i>';
                            echo '</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Tab Bình Thủy -->
                <div id="tab-binhthuy" class="tab-pane fade">
                    <div class="row g-4">
                        <?php
                        // Truy vấn các địa điểm Bình Thủy dựa trên DISTRICTID
                        $query = "SELECT DESTINATIONID, DESTINATIONNAME, IMAGE FROM destination WHERE DISTRICTID = ?";
                        $stmt = $conn->prepare($query);
                        $districtId = 5; // DISTRICTID của Bình Thủy
                        $stmt->bind_param("i", $districtId);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-xl-4">';
                            echo '<div class="destination-img h-100">';
                            echo '<img class="img-fluid rounded w-100 h-100" style="object-fit: cover; min-height: 300px;" src="data:image/jpeg;base64,' . base64_encode($row['IMAGE']) . '" alt="Image">';
                            echo '<div class="destination-overlay p-4">';
                            echo '<h4 class="text-white mb-2 mt-3">' . htmlspecialchars($row['DESTINATIONNAME']) . '</h4>';
                            echo '<a href="#" class="btn-hover text-white">View All Place <i class="fa fa-arrow-right ms-2"></i></a>';
                            echo '</div>';
                            echo '<div class="search-icon">';
                            echo '<a href="data:image/jpeg;base64,' . base64_encode($row['IMAGE']) . '" data-lightbox="destination-' . htmlspecialchars($row['DESTINATIONID']) . '">';
                            echo '<i class="fa fa-plus-square fa-1x btn btn-light btn-lg-square text-primary"></i>';
                            echo '</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }

                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Destination End -->

<!-- Subscribe Start -->
<!-- <div class="container-fluid subscribe py-5">
    <div class="container text-center py-5">
        <div class="mx-auto text-center" style="max-width: 900px;">
            <h5 class="subscribe-title px-3">Subscribe</h5>
            <h1 class="text-white mb-4">Our Newsletter</h1>
            <p class="text-white mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum tempore nam, architecto doloremque velit explicabo? Voluptate sunt eveniet fuga eligendi! Expedita laudantium fugiat corrupti eum cum repellat a laborum quasi.</p>
            <div class="position-relative mx-auto">
                <input class="form-control border-primary rounded-pill w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                <button type="button" class="btn btn-primary rounded-pill position-absolute top-0 end-0 py-2 px-4 mt-2 me-2">Subscribe</button>
            </div>
        </div>
    </div>
</div> -->
<!-- Subscribe End -->

<!-- Footer Start -->
<?php include 'includes/footer.php'; ?>

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