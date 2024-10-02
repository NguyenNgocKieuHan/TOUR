<?php
session_start();

// Check if user is logged in
// if (!isset($_SESSION['USERID'])) {
//     echo "<script>alert('Bạn chưa đăng nhập!'); window.location.href='login.php';</script>";
//     exit();
// }

$activate = "booking";

include('includes/header.php');
include('includes/db.php');

// Lấy danh sách các tour từ cơ sở dữ liệu
$sql = "SELECT TOURID, TOURNAME, PRICE FROM tour";
$result = $conn->query($sql);

$tours = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tours[] = $row;
    }
}

$conn->close();
?>
<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4">Đặt tour trực tuyến</h1>
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
                <h5 class="section-booking-title pe-3">Đặt Tour</h5>
                <h1 class="text-white mb-4">Đặt tour trực tuyến</h1>
                <p class="text-white mb-4">Đặt tour trực tuyến dễ dàng và nhanh chóng. Hãy chọn tour mà bạn muốn tham gia và cung cấp thông tin cần thiết để hoàn tất đặt chỗ.</p>
                <p class="text-white mb-4">Hãy chọn tour từ danh sách các tour hiện có. Mỗi tour có chương trình đặc biệt dành riêng cho du khách, bao gồm lịch trình chi tiết, dịch vụ chất lượng và giá cả hợp lý.</p>
            </div>

            <div class="col-lg-6">
                <h1 class="text-white mb-3">Đặt tour du lịch</h1>
                <form action="process_booking.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-white border-0" id="name" name="name" placeholder="Họ và tên" required>
                                <label for="name">Họ và tên</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control bg-white border-0" id="email" name="email" placeholder="Email" required>
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control bg-white border-0" name="startdate" id="startdate" placeholder="Chọn Ngày">
                                <label for="startdate">Ngày khởi hành</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select id="tourDropdown" class="form-select bg-white border-0" name="tourid">
                                    <option value="">Chọn tour</option>
                                    <?php foreach ($tours as $tour) { ?>
                                        <option value="<?php echo $tour['TOURID']; ?>" data-price="<?php echo $tour['PRICE']; ?>">
                                            <?php echo htmlspecialchars($tour['TOURNAME']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <label for="tourDropdown">Tên Tour</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control bg-white border-0" id="people_count" name="people_count" min="1" placeholder="Số lượng người" required>
                                <label for="people_count">Số người</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="price" name="price" placeholder="Giá vé cho 1 người" readonly>
                                <label for="price">Giá vé cho 1 người</label>
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

<?php include('includes/footer.php'); ?>

<script>
    // Cập nhật giá khi chọn tour
    document.getElementById('tourDropdown').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var price = selectedOption.getAttribute('data-price');
        document.getElementById('price').value = price ? price : '';
    });
</script>

<script>
    $('#datetime').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar-alt',
            up: 'fas fa-chevron-up',
            down: 'fas fa-chevron-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'far fa-calendar-check',
            clear: 'far fa-trash-alt',
            close: 'far fa-times-circle'
        }
    });
</script>