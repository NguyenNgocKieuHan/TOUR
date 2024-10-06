<?php
session_start();
$activate = "tour";

include('includes/header.php');
include('includes/db.php');

// Truy vấn tour và loại tour
$sql = "SELECT tour.*, tourtype.TOURTYPENAME 
        FROM tour 
        INNER JOIN tourtype ON tour.TOURTYPEID = tourtype.TOURTYPEID";
$result = $conn->query($sql);

// Hàm rút gọn mô tả
function truncateDescription($description, $length = 100)
{
    if (strlen($description) > $length) {
        $description = substr($description, 0, $length) . '...';
    }
    return $description;
}

// Hàm tính số sao trung bình từ bảng reviews
function getAverageRating($conn, $tourId)
{
    $sql = "SELECT AVG(RATING) AS averageRating FROM reviews WHERE TOURID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $tourId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return round($row['averageRating'], 1); // Làm tròn đến 1 chữ số thập phân
}

?>

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4">Khám phá Tour</h3>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="#">Trang</a></li>
            <li class="breadcrumb-item active text-white">Khám phá</li>
        </ol>
    </div>
</div>

<div class="container-fluid packages py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">Khám phá Tour</h5>
            <h1 class="mb-0">Cần Thơ</h1>
        </div>
        <div class="packages-carousel owl-carousel">
            <?php
            if ($result->num_rows > 0) {
                // Fetch dữ liệu từng tour
                while ($row = $result->fetch_assoc()) {
                    $tourId = $row['TOURID'];
                    $tourName = $row['TOURNAME'];
                    $tourTypeName = $row['TOURTYPENAME'];
                    $time = $row['TIMETOUR'];
                    $price = $row['PRICE'];
                    $shortDescription = truncateDescription($row['DESCRIPTION']);

                    // Lấy đánh giá trung bình
                    $averageRating = getAverageRating($conn, $tourId);

                    // Convert hình ảnh (BLOB) thành base64
                    $imageData = base64_encode($row['IMAGE']);
                    $imageSrc = 'data:image/jpeg;base64,' . $imageData;

            ?>
                    <div class="packages-item">
                        <div class="packages-img">
                            <img src="<?php echo $imageSrc; ?>" class="img-fluid w-100 rounded-top" alt="Image">
                            <div class="packages-info d-flex border border-start-0 border-end-0 position-absolute" style="width: 100%; bottom: 0; left: 0; z-index: 5;">
                                <small class="flex-fill text-center border-end py-2">
                                    <i class="fa fa-map-marker-alt me-2"></i><?php echo $tourTypeName; ?>
                                </small>
                                <small class="flex-fill text-center border-end py-2">
                                    <i class="fa fa-calendar-alt me-2"></i><?php echo $time . ' Ngày'; ?>
                                </small>
                            </div>
                            <div class="packages-price py-2 px-4"><?php echo number_format($price, 0, ',', '.'); ?> VNĐ</div>
                        </div>
                        <div class="packages-content bg-light">
                            <div class="p-4 pb-0">
                                <h5 class="mb-0"><?php echo $tourName; ?></h5>
                                <div class="mb-3">
                                    <?php
                                    // Hiển thị số sao dựa trên đánh giá trung bình
                                    $fullStars = floor($averageRating); // Số sao đầy đủ
                                    $halfStar = ($averageRating - $fullStars) >= 0.5 ? true : false; // Nửa sao

                                    for ($i = 0; $i < 5; $i++) {
                                        if ($i < $fullStars) {
                                            echo '<small class="fa fa-star text-primary"></small>';
                                        } elseif ($halfStar && $i == $fullStars) {
                                            echo '<small class="fa fa-star-half-alt text-primary"></small>';
                                            $halfStar = false;
                                        } else {
                                            echo '<small class="fa fa-star-o text-primary"></small>';
                                        }
                                    }
                                    ?>
                                </div>
                                <p class="mb-4"><?php echo $shortDescription; ?></p>
                            </div>
                            <div class="row bg-primary rounded-bottom mx-0">
                                <div class="col-6 text-start px-0">
                                    <a href="tour_detail.php?tourid=<?php echo $tourId; ?>" class="my-autobtn-hover btn text-white py-2 px-4">Xem thêm</a>
                                </div>
                                <div class="col-6 text-end px-0">
                                    <?php if (isset($_SESSION['userid'])): ?>
                                        <a href="booking.php?tourid=<?php echo $tourId; ?>&tourname=<?php echo urlencode($tourName); ?>&price=<?php echo $price; ?>" class="btn-hover btn text-white py-2 px-4">Đặt ngay</a>
                                    <?php else: ?>
                                        <a href="login.php?redirect=<?php echo urlencode('booking.php?tourid=' . $tourId . '&tourname=' . urlencode($tourName) . '&price=' . $price); ?>" class="btn-hover btn text-white py-2 px-4">Đặt ngay</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No tours available.</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
</div>
<?php
include('includes/footer.php');
?>

<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>