<?php
session_start();

// Hủy tất cả các session
session_unset();

// Hủy session hiện tại
session_destroy();

// Chuyển hướng về trang đăng nhập với thông báo
echo "<script>alert('Đăng xuất thành công!'); window.location.href='index.php';</script>";

// header("Location: index.php?message=Bạn đã đăng xuất thành công.");
exit();
