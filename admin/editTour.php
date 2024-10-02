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

// Lấy mã ID của tour từ URL
$tour_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Truy xuất thông tin của tour từ cơ sở dữ liệu
$sql_tour = "SELECT * FROM tour WHERE TOURID = ?";
$stmt = $conn->prepare($sql_tour);
$stmt->bind_param("i", $tour_id);
$stmt->execute();
$result_tour = $stmt->get_result();

// Kiểm tra lỗi truy vấn tour
if (!$result_tour) {
    die("Lỗi truy vấn tour: " . mysqli_error($conn));
}

$tour = $result_tour->fetch_assoc();

// Kiểm tra nếu không có dữ liệu từ truy vấn tour
if ($tour === null) {
    echo "Không tìm thấy tour với ID = $tour_id";
    exit; // Dừng việc xử lý trang nếu không tìm thấy dữ liệu
}

// Truy xuất danh sách loại tour từ bảng `tourtype`
$sql_type = "SELECT TOURTYPEID, TOURTYPENAME FROM tourtype";
$result_type = mysqli_query($conn, $sql_type);

// Kiểm tra lỗi truy vấn loại tour
if (!$result_type) {
    die("Lỗi truy vấn loại tour: " . mysqli_error($conn));
}
?>

<div class="mobile-menu-overlay"></div>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Sửa tour</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Sửa tour</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="pd-20 card-box mb-30">
                <form action="suaTour.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($tour['TOURID']); ?>">

                    <div class="form-group">
                        <label>Tên tour</label>
                        <input class="form-control" type="text" name="tour_name" value="<?php echo htmlspecialchars($tour['TOURNAME']); ?>" required>
                    </div>

                    <!-- Dropdown cho loại tour -->
                    <div class="form-group">
                        <label>Loại tour</label>
                        <select class="form-control" name="tour_type_id" required>
                            <option value="">Loại tour</option>
                            <?php while ($row = mysqli_fetch_assoc($result_type)) { ?>
                                <option value="<?php echo htmlspecialchars($row['TOURTYPEID']); ?>" <?php echo ($row['TOURTYPEID'] == $tour['TOURTYPEID']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row['TOURTYPENAME']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Thêm trường ngày -->
                    <div class="form-group">
                        <label>Ngày</label>
                        <input class="form-control" type="text" name="start_date" value="<?php echo htmlspecialchars($tour['TIMETOUR']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Giá tour</label>
                        <input class="form-control" type="text" name="price" value="<?php echo htmlspecialchars($tour['PRICE']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Lịch trình</label>
                        <textarea class="form-control" name="description" required><?php echo htmlspecialchars($tour['DESCRIPTION']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Ảnh hiện tại</label>
                        <div id="image_preview">
                            <?php
                            // Nếu ảnh được lưu dưới dạng BLOB
                            if (!empty($tour['IMAGE'])) {
                                // Hiển thị ảnh từ BLOB
                                $imageData = base64_encode($tour['IMAGE']);
                                $src = 'data:image/jpeg;base64,' . $imageData; // Đảm bảo định dạng chính xác
                                echo "<img src='$src' width='150' height='150' alt='Current Image' id='current_image'>";
                            } else {
                                echo "Không có ảnh hiện tại.";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image">Chọn ảnh:</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    </div>
                    <!-- Nút Chỉnh sửa tour -->
                    <button type="submit" class="btn btn-primary">Sửa tour</button>
                </form>
            </div>
        </div>
        <?php
        mysqli_close($conn); // Đóng kết nối
        ?>
    </div>
</div>

<!-- js -->
<script src="vendors/scripts/core.js"></script>
<script src="vendors/scripts/script.min.js"></script>
<script src="vendors/scripts/process.js"></script>
<script src="vendors/scripts/layout-settings.js"></script>
<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imagePreview = document.getElementById('image_preview');
                imagePreview.innerHTML = `<img src="${e.target.result}" alt="Image Preview" style="max-width: 100%; height: auto;">`;
            }
            reader.readAsDataURL(file);
        }
    });
</script>

</body>

</html>