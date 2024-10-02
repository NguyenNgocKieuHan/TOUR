<?php
session_start();

include('includes/header.php');
include('includes/db.php');

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['USERID'])) {
    header("Location: login.php?message=Vui lòng đăng nhập để xem trang này.");
    exit();
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$userid = $_SESSION['USERID'];
$stmt = $conn->prepare("SELECT USNAME, USEMAIL, USSDT FROM users WHERE USERID = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$stmt->bind_result($name, $email, $sdt);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4">Thông tin cá nhân</h3>
    </div>
</div>
<!-- Header End -->

<div class="container-fluid contact bg-light py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h1 class="mb-0">Hồ sơ cá nhân của bạn</h1>
        </div>
        <div class="row g-5 align-items-center">
            <div class="col-lg-8 mx-auto">
                <h3 class="mb-4">Thông tin chi tiết</h3>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Họ và tên: </strong><?php echo htmlspecialchars($name); ?></li>
                    <li class="list-group-item"><strong>Email: </strong><?php echo htmlspecialchars($email); ?></li>
                    <li class="list-group-item"><strong>Số điện thoại: </strong><?php echo htmlspecialchars($sdt); ?></li>
                </ul>
                <!-- <a href="logout.php" class="btn btn-danger mt-4">Đăng xuất</a> -->
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>