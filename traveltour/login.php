<?php
session_start();

include('includes/header.php');

// Kết nối cơ sở dữ liệu
$host = 'localhost';
$dbname = 'tour';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Thiết lập chế độ lỗi của PDO là Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


// Xử lý khi form được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kiểm tra xem email có tồn tại trong cơ sở dữ liệu không
    $stmt = $conn->prepare("SELECT * FROM users WHERE USEMAIL = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Nếu người dùng tồn tại
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra mật khẩu đã được băm bằng password_hash
        if (password_verify($password, $user['USPASSWORD'])) {
            // Lưu thông tin vào session
            $_SESSION['USERID'] = $user['USERID'];
            $_SESSION['USNAME'] = $user['USNAME'];

            header("Location: index.php");
            exit();
        } else {
            echo "Sai mật khẩu. Vui lòng thử lại!";
        }
    }
}
?>
<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4">Đăng nhập</h3>
    </div>
</div>
<!-- Header End -->

<div class="container-fluid contact bg-light py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">Đăng nhập</h5>
            <h1 class="mb-0">Hãy đăng nhập để trải nghiệm nhiều hơn.</h1>
        </div>
        <div class="row g-5 align-items-center">
            <div class="col-lg-8 mx-auto">
                <h3 class="mb-2">Điền thông tin đăng nhập của bạn</h3>
                <?php
                if (isset($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <form action="" method="POST">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="email" class="form-control border-0" id="email" name="email" placeholder="Your Email" required>
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="password" class="form-control border-0" id="password" name="password" placeholder="Password" required>
                                <label for="password">Mật khẩu</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3" type="submit">Đăng nhập</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>