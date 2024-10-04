<?php
session_start();
include('includes/header.php');
include('includes/db.php');

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['ADID'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra xem TOURID và userid có được truyền vào không
if (isset($_GET['TOURID']) && isset($_GET['userid'])) {
    $tourId = isset($_GET['TOURID']) ? intval($_GET['TOURID']) : 0;
    $userId = isset($_GET['userid']) ? intval($_GET['userid']) : 0;

    // Kiểm tra nếu TOURID và userid hợp lệ
    if ($tourId > 0 && $userId > 0) {
        // Truy vấn để lấy thông tin ngày khởi hành (STARTDATE) từ bảng bookings
        $bookingQuery = "SELECT STARTDATE FROM bookings WHERE TOURID = ? AND USERID = ?";
        $stmtBooking = $conn->prepare($bookingQuery);
        $stmtBooking->bind_param("ii", $tourId, $userId);
        $stmtBooking->execute();
        $resultBooking = $stmtBooking->get_result();

        if ($resultBooking->num_rows > 0) {
            $rowBooking = $resultBooking->fetch_assoc();
            $startDate = $rowBooking['STARTDATE'];

            // Kiểm tra nếu ngày hiện tại trước ngày khởi hành
            $currentDate = date('Y-m-d'); // Ngày hiện tại

            if ($currentDate < $startDate) {
                // Truy vấn để lấy thông tin booking
                $sql = "SELECT * FROM bookings WHERE TOURID = ? AND USERID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $tourId, $userId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Cập nhật trạng thái booking thành 'Đã xác nhận' (STATUS = 1)
                    $updateQuery = "UPDATE bookings SET STATUS = 1, CANCELLED_BY = NULL, REJECTION_REASON = NULL WHERE TOURID = ? AND USERID = ?";
                    $stmtUpdate = $conn->prepare($updateQuery);
                    $stmtUpdate->bind_param("ii", $tourId, $userId);

                    if ($stmtUpdate->execute()) {
                        echo "<script>alert('Đơn đặt tour đã được phê duyệt thành công.'); window.location.href='bookingManagement.php';</script>";
                    } else {
                        echo "<script>alert('Có lỗi xảy ra khi phê duyệt đơn đặt tour.'); window.location.href='bookingManagement.php';</script>";
                    }
                } else {
                    echo "<script>alert('Không tìm thấy thông tin booking.'); window.location.href='bookingManagement.php';</script>";
                }

                $stmt->close();
            } else {
                // Thông báo nếu ngày hiện tại đã qua ngày khởi hành
                echo "<script>alert('Tour này không được duyệt do quá hạn ngày khởi hành.Bạn hãy hủy ngay để tránh nhầm lẫn'); window.location.href='rejectBooking.php';</script>";
            }
        } else {
            echo "<script>alert('Không tìm thấy thông tin booking.'); window.location.href='bookingManagement.php';</script>";
        }

        $stmtBooking->close();
    } else {
        echo "<script>alert('Thông tin đặt tour không hợp lệ.'); window.location.href='bookingManagement.php';</script>";
    }
} else {
    echo "<script>alert('Thông tin đặt tour không được cung cấp.'); window.location.href='bookingManagement.php';</script>";
}

$conn->close();
