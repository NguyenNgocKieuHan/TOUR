<?php
session_start();
include 'includes/header.php';
// Kết nối cơ sở dữ liệu
include 'includes/db.php'; // Giả sử bạn đã có file kết nối cơ sở dữ liệu

// Truy vấn các tour có ít nhất 2 lượt đặt
$query = "SELECT t.TOURID, t.TOURNAME, t.PRICE, t.TIMETOUR as TIMETOUR, t.IMAGE, COUNT(b.USERID) AS booking_count
          FROM TOUR t
          LEFT JOIN bookings b ON t.TOURID = b.TOURID
          GROUP BY t.TOURID
          HAVING booking_count >= 2
          ORDER BY booking_count DESC"; // Sắp xếp theo số lượng đặt giảm dần

$result = mysqli_query($conn, $query);

// Hiển thị giao diện HTML
?>
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix mb-20">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Xem chi tiết Tour</h4>
                    </div>
                </div>

                <div class="row">
                    <?php
                    // Kiểm tra có bản ghi nào không
                    if (mysqli_num_rows($result) > 0) {
                        // Lặp qua các bản ghi và hiển thị
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<div class='col-md-4 mb-4'>";
                            echo "<div class='card'>";
                            // Hiển thị ảnh tour
                            echo "<img class='card-img-top' src='data:image/jpeg;base64," . base64_encode($row['IMAGE']) . "' alt='Ảnh tour'>";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>" . htmlspecialchars($row['TOURNAME']) . "</h5>";
                            echo "<p class='card-text'>Giá: " . htmlspecialchars($row['PRICE']) . " VND</p>";
                            echo "<p class='card-text'>Thời gian: " . htmlspecialchars($row['TIMETOUR']) . " ngày</p>";
                            echo "<p class='card-text'>Số lượt đặt: " . htmlspecialchars($row['booking_count']) . " lượt</p>";
                            echo "</div>"; // Đóng card-body
                            echo "<div class='card-footer text-center'>";
                            echo "<a href='tourDetail.php?id=" . $row['TOURID'] . "' class='btn btn-primary'>Xem chi tiết</a>";
                            echo "</div>"; // Đóng card-footer
                            echo "</div>"; // Đóng card
                            echo "</div>"; // Đóng col-md-4
                        }
                    } else {
                        // Nếu không có tour bán chạy
                        echo "<p class='text-center'>Không có tour nào bán chạy.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>