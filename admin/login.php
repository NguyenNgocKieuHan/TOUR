<?php

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

// Bắt đầu phiên làm việc (session)
session_start();

// Xử lý khi form được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Lấy dữ liệu từ form
	$email = $_POST['email'];
	$password = $_POST['password'];

	// Kiểm tra xem email có tồn tại trong cơ sở dữ liệu không
	$stmt = $conn->prepare("SELECT * FROM admin WHERE ADEMAIL = :email");
	$stmt->bindParam(':email', $email);
	$stmt->execute();

	// Nếu người dùng tồn tại
	if ($stmt->rowCount() > 0) {
		$admin = $stmt->fetch(PDO::FETCH_ASSOC);

		// Kiểm tra mật khẩu
		if (password_verify($password, $admin['ADPASSWORD'])) {
			// Lưu thông tin vào session
			$_SESSION['ADID'] = $admin['ADID'];
			$_SESSION['ADNAME'] = $admin['ADNAME'];

			// Chuyển hướng tới trang quản trị
			header("Location: dashboard.php");
			exit();
		} else {
			echo "Sai mật khẩu. Vui lòng thử lại!";
		}
	} else {
		echo "Email không tồn tại!";
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>TravelTour</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/style.css">
</head>

<body class="login-page">
	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="login.php">
					<img src="vendors/images/deskapp-logo.svg" alt="">
				</a>
			</div>
			<div class="login-menu">
				<ul>
					<li><a href="register.php">Đăng ký</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
					<img src="vendors/images/login-page-img.png" alt="">
				</div>
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">Đăng nhập vào TravelTour</h2>
						</div>
						<form method="POST" action="login.php">
							<div class="input-group custom">
								<input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required>
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
								</div>
							</div>
							<div class="input-group custom">
								<input type="password" name="password" class="form-control form-control-lg" placeholder="**********" required>
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>
							<div class="row pb-30">
								<div class="col-6">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck1">
										<label class="custom-control-label" for="customCheck1">Nhớ</label>
									</div>
								</div>
								<div class="col-6">
									<div class="forgot-password"><a href="forgot-password.php">Quên mật khẩu</a></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										<button class="btn btn-primary btn-lg btn-block" type="submit">Đăng nhập</button>
									</div>
									<div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">hoặc</div>
									<div class="input-group mb-0">
										<a class="btn btn-outline-primary btn-lg btn-block" href="register.php">Đăng ký để tạo tài khoản</a>
									</div>
								</div>
							</div>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
</body>

</html>