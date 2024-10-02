<?php
include('includes/db.php');

// Check if an ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID không hợp lệ!</div>";
    exit;
}

$destinationID = mysqli_real_escape_string($conn, $_GET['id']);

// Delete the destination from the database
$query = "DELETE FROM DESTINATION WHERE DESTINATIONID = $destinationID";

if (mysqli_query($conn, $query)) {
    echo "<div class='alert alert-success'>Địa điểm đã được xóa thành công!</div>";
} else {
    echo "<div class='alert alert-danger'>Lỗi: " . mysqli_error($conn) . "</div>";
}

// Redirect back to the destination management page
header("Location: destinationManagement.php"); // Update this with the correct page name if different
exit;
