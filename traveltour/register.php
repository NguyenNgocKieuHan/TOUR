<?php
include('includes/header.php');
include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $confirm_password = $_POST['confirm_password'];

    if (password_verify($confirm_password, $password)) {

        // Tìm ID người dùng lớn nhất hiện tại
        $result = mysqli_query($conn, "SELECT MAX(USERID) AS max_id FROM users");
        $row = mysqli_fetch_assoc($result);
        $next_user_id = $row['max_id'] + 1;

        // Chuẩn bị và bind dữ liệu
        $stmt = $conn->prepare("INSERT INTO users (USERID, USNAME, USEMAIL, USSDT, USPASSWORD) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $next_user_id, $name, $email, $sdt, $password);

        // Thực thi truy vấn
        if ($stmt->execute()) {
            echo "<script>alert('Đăng ký thành công! Hãy đăng nhập để có nhiều trải nghiệm hơn!'); window.location.href='login.php';</script>";
        } else {
            echo "Lỗi: " . $stmt->error;
        }

        // Đóng kết nối
        $stmt->close();
    } else {
        echo "<script>alert('Mật khẩu xác nhận không khớp!');</script>";
    }
    $conn->close();
}
?>

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4">Đăng ký</h3>
    </div>
</div>
<!-- Header End -->

<div class="container-fluid contact bg-light py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">Đăng ký</h5>
            <h1 class="mb-0">Trở thành một thành viên của chúng tôi để có những trải nghiệm tốt hơn.</h1>
        </div>
        <div class="row g-5 align-items-center">
            <div class="col-lg-8 mx-auto">
                <h3 class="mb-2">Hãy điền thông tin tại đây</h3>
                <form action="" method="POST">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control border-0" id="name" name="name" placeholder="Your Name" required>
                                <label for="name">Họ và tên</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="email" class="form-control border-0" id="email" name="email" placeholder="Your Email" required>
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control border-0" id="sdt" name="sdt" placeholder="Phone" required>
                                <label for="sdt">Số điện thoại</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="password" class="form-control border-0" id="password" name="password" placeholder="Password" required>
                                <label for="password">Mật khẩu</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="password" class="form-control border-0" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                                <label for="confirm_password">Xác nhận mật khẩu</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3" type="submit">Đăng ký</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>