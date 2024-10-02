<?php
session_start();
include('includes/db.php');

// Kiểm tra nếu form được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['NAME']);
    $email = mysqli_real_escape_string($conn, $_POST['EMAIL']);
    $message = mysqli_real_escape_string($conn, $_POST['MESSAGE']);
    $userid = isset($_SESSION['USERID']) ? $_SESSION['USERID'] : null;

    // Kiểm tra nếu người dùng đã đăng nhập
    if ($userid) {
        $query = "INSERT INTO contact (USERID, MESSAGE, CONTACTDATE) VALUES ('$userid', '$message', NOW())";
    } else {
        // Trường hợp khách gửi liên hệ không đăng nhập
        $query = "INSERT INTO contact (USERID, MESSAGE, CONTACTDATE) VALUES (NULL, '$message', NOW())";
    }

    if (mysqli_query($conn, $query)) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
