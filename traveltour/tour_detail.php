<?php
session_start();

include('includes/header.php');
include('includes/db.php');

// Get the TOURID from the URL
if (isset($_GET['tourid'])) {
    $tourId = intval($_GET['tourid']);

    // SQL query to fetch the tour details based on TOURID
    $sql = "SELECT * FROM tour WHERE TOURID = $tourId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch tour data
        $tour = $result->fetch_assoc();
        $imageData = base64_encode($tour['IMAGE']);
        $tourName = htmlspecialchars($tour['TOURNAME']);
        $description = htmlspecialchars($tour['DESCRIPTION']);
        $price = htmlspecialchars($tour['PRICE']);
        $time = htmlspecialchars($tour['TIMETOUR']);
    } else {
        echo "<p>No tour found.</p>";
        exit;
    }
} else {
    echo "<p>No tour selected.</p>";
    exit;
}
?>

<!-- Tour Detail Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4"><?php echo $tourName; ?></h3>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="explore_tours.php">Tour</a></li>
            <li class="breadcrumb-item active text-white"><?php echo $tourName; ?></li>
        </ol>
    </div>
</div>
<!-- Tour Detail Header End -->

<!-- Tour Detail Content Start -->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-6">
            <img src="data:image/jpeg;base64,<?php echo $imageData; ?>" class="img-fluid w-100 rounded mb-4" alt="<?php echo $tourName; ?>">

            <div class="packages-price py-2 px-4">
                <h4><i class="fa fa-map-marker me-2"></i>
                    Giá cho 1 tour:
                    <?php echo number_format($price, 0, ',', '.'); ?> VNĐ</h4>
            </div>


            <div class="packages-price py-2 px-4">
                <h4><i class="fa fa-calendar-alt me-2"></i>Tour diễn ra trong: <?php echo $time . ' Ngày'; ?></h4>
            </div>

            <div class="packages-price py-2 px-4">
                <?php
                // Truy vấn để lấy các đánh giá từ bảng reviews
                $reviewSql = "SELECT r.RATING, r.COMMENT, r.POSTDATE, u.USNAME, r.REVIEWIMAGE
              FROM reviews r 
              JOIN users u ON r.USERID = u.USERID 
              WHERE r.TOURID = ? ORDER BY r.POSTDATE DESC";
                $stmt = $conn->prepare($reviewSql);
                $stmt->bind_param("i", $tourId);
                $stmt->execute();
                $reviewResult = $stmt->get_result();

                if ($reviewResult->num_rows > 0) {
                    echo "<h3>Đánh giá từ người dùng</h3>";
                    while ($review = $reviewResult->fetch_assoc()) {
                        $rating = htmlspecialchars($review['RATING']);
                        $comment = htmlspecialchars($review['COMMENT']);
                        $fullname = htmlspecialchars($review['NAME']);
                        $postdate = htmlspecialchars($review['POSTDATE']);
                        $imagereview = $review['REVIEWIMAGE'];  // Đảm bảo cột chứa đúng dữ liệu hình ảnh

                        echo "<div class='review'>";
                        echo "<p><strong>$fullname</strong> (Đánh giá: $rating/5) <strong class='fa fa-star'></strong></p>";
                        echo "<p class='comment' >$comment</p>";
                        // echo "<p><img src='$imagereview' alt='Review Image' class='avatar'></p>";
                        echo "<p><img src='$imagereview' alt='Review Image' class='avatar' width='300' height='200'></p>";

                        echo "<p><small>Ngày đăng: $postdate</small></p>";
                        echo "</div><hr>";
                    }
                } else {
                    echo "<p>Chưa có đánh giá nào cho tour này.</p>";
                }
                ?>


            </div>
            <div class="packages-price py-2 px-4">

                <?php
                if (isset($_SESSION['USERID'])) {
                    $userid = $_SESSION['USERID'];
                    $tourId = $_GET['tourid'];

                    $bookingCheck = $conn->prepare("SELECT * FROM BOOKINGS WHERE USERID = ? AND TOURID = ?");
                    $bookingCheck->bind_param("ii", $userid, $tourId);
                    $bookingCheck->execute();
                    $bookingResult = $bookingCheck->get_result();

                    if ($bookingResult->num_rows > 0) {
                        $bookingData = $bookingResult->fetch_assoc();
                        $startDate = $bookingData['STARTDATE'];
                        $currentDate = date('d-m-Y');

                        if ($currentDate > $startDate) {
                            $reviewCheck = $conn->prepare("SELECT * FROM REVIEWS WHERE USERID = ? AND TOURID = ?");
                            $reviewCheck->bind_param("ii", $userid, $tourId);
                            $reviewCheck->execute();
                            $reviewResult = $reviewCheck->get_result();

                            if ($reviewResult->num_rows == 0) {
                ?>
                                <div class="container py-5">
                                    <h3>Đánh giá tour</h3>
                                    <form action="submit_review.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="tourid" value="<?php echo $tourId; ?>">
                                        <input type="hidden" name="userid" value="<?php echo $_SESSION['USERID']; ?>">
                                        <div class="form-group">
                                            <label for="rating">Đánh giá (1-5):</label>
                                            <input type="number" name="rating" min="1" max="5" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="comment">Nhận xét:</label>
                                            <textarea name="comment" class="form-control" rows="4" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Chèn ảnh (tùy chọn):</label>
                                            <input type="file" name="image" class="form-control" accept="image/*">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Gửi đánh giá</button>

                                        </div>
                                    </form>
                                </div>
                <?php
                            } else {
                                echo "<p>Bạn đã đánh giá tour này.</p>";
                            }
                        } else {
                            echo "<p>Bạn chưa đủ điều kiện để đánh giá tour này!.</p>";
                        }
                    } else {
                        echo "<p>Bạn chưa đặt tour này. Đặt ngay nào!.</p>";
                    }
                } else {
                    echo "<p>Bạn cần <a href='login.php'>đăng nhập</a> để đánh giá tour.</p>";
                }
                ?>
            </div>


        </div>
        <div class="col-lg-6">
            <h2><?php echo $tourName; ?></h2>
            <p style="white-space: pre-wrap;"><?php echo htmlspecialchars($description); ?></p>

            <a href="booking.php?tourid=<?php echo $tourId; ?>&tourname=<?php echo urlencode($tourName); ?>&price=<?php echo $price; ?>" class="btn btn-primary">Book Now</a>
        </div>
    </div>
</div>
<!-- Tour Detail Content End -->


<?php
include('includes/footer.php');
$conn->close();
?>