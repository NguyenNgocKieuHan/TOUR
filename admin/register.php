<?php
// Kết nối cơ sở dữ liệu
$host = 'localhost'; // Địa chỉ của server MySQL
$dbname = 'tour'; // Tên cơ sở dữ liệu
$username = 'root'; // Tài khoản MySQL
$password = ''; // Mật khẩu MySQL

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
	// Thiết lập chế độ lỗi của PDO là Exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	die("Connection failed: " . $e->getMessage());
}

// Kiểm tra nếu form được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Lấy dữ liệu từ form
	$name = $_POST['name'];
	$email = $_POST['email'];
	$sdt = $_POST['sdt'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];

	// Kiểm tra các trường không để trống
	if (empty($name) || empty($email) || empty($sdt) || empty($password) || empty($confirm_password)) {
		echo "Vui lòng điền đầy đủ thông tin.";
	} elseif ($password !== $confirm_password) {
		echo "Mật khẩu xác nhận không khớp.";
	} else {
		// Kiểm tra email có tồn tại không
		$stmt = $conn->prepare("SELECT * FROM ADMIN WHERE ADEMAIL = :email");
		$stmt->bindParam(':email', $email);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			echo "Email đã tồn tại.";
		} else {
			// Mã hóa mật khẩu
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);

			// Tìm ID người dùng lớn nhất hiện tại
			$stmt = $conn->query("SELECT MAX(ADID) AS max_id FROM ADMIN");
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$next_user_id = $row['max_id'] + 1;


			// Thêm quản trị viên mới vào cơ sở dữ liệu
			$sql = "INSERT INTO ADMIN (ADNAME, ADEMAIL, ADSDT, ADPASSWORD) VALUES (:name, :email, :sdt, :password)";
			$stmt = $conn->prepare($sql);

			// Liên kết tham số với giá trị
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':sdt', $sdt);
			$stmt->bindParam(':password', $hashed_password);

			// Thực thi truy vấn
			if ($stmt->execute()) {
				echo "<script>alert('Đăng ký thành công với tư cách Quản trị viên. Bạn có muốn đăng nhập không?'); window.location.href='login.php';</script>";
				exit();
			} else {
				echo "Đã xảy ra lỗi. Vui lòng thử lại.";
			}
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>TravelTour - Đăng ký</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/style.css">
	<!-- Thêm liên kết đến FontAwesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
					<li><a href="login.php">Đăng nhập</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
					<img src="vendors/images/register-page-img.png" alt="">
				</div>
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">Đăng ký tài khoản</h2>
						</div>
						<form method="POST" action="">
							<div class="input-group custom">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<input type="text" name="name" class="form-control form-control-lg" placeholder="Họ và tên" required>
							</div>
							<div class="input-group custom">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-envelope"></i></span>
								</div>
								<input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required>
							</div>
							<div class="input-group custom">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-phone"></i></span>
								</div>
								<input type="text" name="sdt" class="form-control form-control-lg" placeholder="Số điện thoại" required>
							</div>
							<div class="input-group custom">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-lock"></i></span>
								</div>
								<input type="password" name="password" class="form-control form-control-lg" placeholder="Mật khẩu" required>
							</div>
							<div class="input-group custom">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-lock"></i></span>
								</div>
								<input type="password" name="confirm_password" class="form-control form-control-lg" placeholder="Xác nhận mật khẩu" required>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										<button class="btn btn-primary btn-lg btn-block" type="submit">Đăng ký</button>
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