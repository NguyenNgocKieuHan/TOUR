<?php
session_start();
include('includes/db.php');

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['ADID'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra nếu có TOURID, USERID và STARTDATE trong URL
if (isset($_GET['TOURID']) && isset($_GET['userid']) && isset($_GET['startdate'])) {
    $tour_id = mysqli_real_escape_string($conn, $_GET['TOURID']);
    $user_id = mysqli_real_escape_string($conn, $_GET['userid']);
    $start_date = mysqli_real_escape_string($conn, $_GET['startdate']);

    // Truy vấn để kiểm tra thông tin booking và số lượng chỗ tối đa
    $sql = "SELECT b.NUMOFPEOPLE, t.MAXSLOTS 
            FROM bookings b
            JOIN tour t ON b.TOURID = t.TOURID 
            WHERE b.TOURID = ? AND b.USERID = ? AND b.STARTDATE = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iis', $tour_id, $user_id, $start_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $numOfPeople = $row['NUMOFPEOPLE'];
        $maxSlots = $row['MAXSLOTS'];

        // Kiểm tra lý do từ chối
        if (strtotime($start_date) < time()) {
            // Ngày xuất phát đã qua
            $rejectionReason = "Đơn đặt tour đã bị từ chối vì ngày xuất phát đã qua.";
            $updateSql = "UPDATE bookings SET STATUS = 0, REJECTION_REASON = ? WHERE TOURID = ? AND USERID = ? AND STARTDATE = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param('siis', $rejectionReason, $tour_id, $user_id, $start_date);

            if ($updateStmt->execute()) {
                echo "<script>alert('$rejectionReason'); window.location.href='bookingManagement.php';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra trong hệ thống. Vui lòng thử lại sau.'); window.location.href='bookingManagement.php';</script>";
            }

            $updateStmt->close();
        } elseif ($numOfPeople > $maxSlots) {
            // Hết chỗ
            $rejectionReason = "Đơn đặt tour đã bị từ chối vì đã hết chỗ.";
            $updateSql = "UPDATE bookings SET STATUS = 0, REJECTION_REASON = ? WHERE TOURID = ? AND USERID = ? AND STARTDATE = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param('siis', $rejectionReason, $tour_id, $user_id, $start_date);

            if ($updateStmt->execute()) {
                echo "<script>alert('$rejectionReason'); window.location.href='bookingManagement.php';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra trong hệ thống. Vui lòng thử lại sau.'); window.location.href='bookingManagement.php';</script>";
            }

            $updateStmt->close();
        } else {
            // Lỗi khác
            $rejectionReason = "Đơn đặt tour đã bị từ chối vì có lỗi xảy ra trong hệ thống.";
            $updateSql = "UPDATE bookings SET STATUS = 0, REJECTION_REASON = ? WHERE TOURID = ? AND USERID = ? AND STARTDATE = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param('siis', $rejectionReason, $tour_id, $user_id, $start_date);

            if ($updateStmt->execute()) {
                echo "<script>alert('$rejectionReason'); window.location.href='bookingManagement.php';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra trong hệ thống. Vui lòng thử lại sau.'); window.location.href='bookingManagement.php';</script>";
            }

            $updateStmt->close();
        }
    } else {
        echo "<script>alert('Thông tin không hợp lệ.'); window.location.href='bookingManagement.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Thông tin không hợp lệ.'); window.location.href='bookingManagement.php';</script>";
}

$conn->close(); // Đóng kết nối
