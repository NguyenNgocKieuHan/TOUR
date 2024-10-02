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

?>

<div class="mobile-menu-overlay"></div>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="pd-20 card-box mb-30">
                <h4 class="text-blue h4">Thêm Tour</h4>
                <form action="themtour.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="tour_type_id">Loại Tour:</label>
                        <select name="tour_type_id" id="tour_type_id" class="form-control" required>
                            <?php
                            $tourTypeQuery = "SELECT TOURTYPEID, TOURTYPENAME FROM TOURTYPE";
                            $tourTypeResult = mysqli_query($conn, $tourTypeQuery);

                            while ($tourType = mysqli_fetch_assoc($tourTypeResult)) {
                                echo "<option value='" . $tourType['TOURTYPEID'] . "'>" . $tourType['TOURTYPENAME'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tour_name">Tên Tour:</label>
                        <input type="text" name="tour_name" id="tour_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Giá:</label>
                        <input type="text" name="price" id="price" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="time">Thời Gian:</label>
                        <input type="text" name="time" id="time" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Mô Tả:</label>
                        <textarea name="description" id="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Chọn ảnh:</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        <div id="image_preview" class="mt-3"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm Tour</button>
                </form>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
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