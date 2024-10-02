<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tour";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối cơ sở dữ liệu
if ($conn->connect_error) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
}
