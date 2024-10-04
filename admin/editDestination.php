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


// Lấy ID địa điểm từ URL
if (isset($_GET['id'])) {
    $destinationID = intval($_GET['id']);

    // Lấy dữ liệu của địa điểm từ cơ sở dữ liệu
    $query = "SELECT * FROM destination WHERE DESTINATIONID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $destinationID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $destination = mysqli_fetch_assoc($result);
    } else {
        echo "<div class='alert alert-danger'>Địa điểm không tồn tại.</div>";
        exit();
    }
}
?>
<div class="mobile-menu-overlay"></div>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="pd-20 card-box mb-30">
                <h4 class="text-blue h4">Sửa Địa Điểm</h4>
                <form action="suaDestination.php?id=<?php echo $destinationID; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="district_id">Quận huyện:</label>
                        <select name="district_id" id="district_id" class="form-control" required>
                            <?php
                            // Fetch districts from the database
                            $districtQuery = "SELECT DISTRICTID, DISTRICTNAME FROM DISTRICT";
                            $districtResult = mysqli_query($conn, $districtQuery);

                            while ($district = mysqli_fetch_assoc($districtResult)) {
                                $selected = ($district['DISTRICTID'] == $destination['DISTRICTID']) ? 'selected' : '';
                                echo "<option value='" . $district['DISTRICTID'] . "' $selected>" . $district['DISTRICTNAME'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="destination_name">Tên địa điểm:</label>
                        <input type="text" name="destination_name" id="destination_name" class="form-control" value="<?php echo htmlspecialchars($destination['DENAME']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả:</label>
                        <textarea name="description" id="description" class="form-control" required><?php echo htmlspecialchars($destination['DEDESCRIPTION']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tour_id">Có trong Tour:</label>
                        <select name="tour_id" id="tour_id" class="form-control" required>
                            <?php
                            // Fetch tours from the database
                            $tourQuery = "SELECT TOURID, TOURNAME FROM tour";
                            $tourResult = mysqli_query($conn, $tourQuery);

                            while ($tour = mysqli_fetch_assoc($tourResult)) {
                                $selected = ($tour['TOURID'] == $destination['TOURID']) ? 'selected' : '';
                                echo "<option value='" . $tour['TOURID'] . "' $selected>" . $tour['TOURNAME'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image">Chọn ảnh:</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        <div id="image_preview" class="mt-3">
                            <?php if (!empty($destination['IMAGE'])): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($destination['IMAGE']); ?>" alt="Image Preview" style="max-width: 100%; height: auto;">
                            <?php endif; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập Nhật Địa Điểm</button>
                </form>
            </div>
        </div>
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