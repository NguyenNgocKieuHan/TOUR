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
    $tourId = intval($_GET['TOURID']);
    $userId = intval($_GET['userid']);

    // Kiểm tra nếu TOURID và userid hợp lệ
    if ($tourId > 0 && $userId > 0) {
        // Truy vấn để lấy thông tin booking
        $bookingQuery = "SELECT STARTDATE FROM bookings WHERE TOURID = ? AND USERID = ?";
        $stmtBooking = $conn->prepare($bookingQuery);
        $stmtBooking->bind_param("ii", $tourId, $userId);
        $stmtBooking->execute();
        $resultBooking = $stmtBooking->get_result();

        if ($resultBooking->num_rows > 0) {
            $rowBooking = $resultBooking->fetch_assoc();
            $startDate = $rowBooking['STARTDATE'];

            // Truy vấn số lượng người đã đặt cho tour
            $slotsQuery = "SELECT MAXSLOTS, (SELECT COUNT(*) FROM bookings WHERE TOURID = ?) AS bookedSlots FROM tour WHERE TOURID = ?";
            $stmtSlots = $conn->prepare($slotsQuery);
            $stmtSlots->bind_param("ii", $tourId, $tourId);
            $stmtSlots->execute();
            $resultSlots = $stmtSlots->get_result();

            if ($resultSlots->num_rows > 0) {
                $rowSlots = $resultSlots->fetch_assoc();
                $maxSlots = $rowSlots['MAXSLOTS'];
                $bookedSlots = $rowSlots['bookedSlots'];

                // Kiểm tra nếu không còn chỗ
                if ($bookedSlots >= $maxSlots) {
                    // Thêm lý do từ chối vào biến
                    $rejectionReason = "Tour đã đầy. Bạn có thể thay đổi ngày xuất phát.";

                    // Cập nhật trạng thái booking thành 'Đã từ chối' (STATUS = 0)
                    $updateQuery = "UPDATE bookings SET STATUS = 0, CANCELLED_BY = ?, REJECTION_REASON = ? WHERE TOURID = ? AND USERID = ?";
                    $stmtUpdate = $conn->prepare($updateQuery);
                    $stmtUpdate->bind_param("isii", $_SESSION['ADID'], $rejectionReason, $tourId, $userId);

                    if ($stmtUpdate->execute()) {
                        echo "<script>alert('Đơn đặt tour đã bị từ chối: $rejectionReason'); window.location.href='bookingManagement.php';</script>";
                    } else {
                        echo "<script>alert('Có lỗi xảy ra khi từ chối đơn đặt tour.'); window.location.href='bookingManagement.php';</script>";
                    }
                } else {
                    // Nếu còn chỗ, cho phép từ chối như đã định
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rejectionReason'])) {
                        $rejectionReason = mysqli_real_escape_string($conn, $_POST['rejectionReason']); // Lấy lý do từ form

                        // Cập nhật trạng thái booking thành 'Đã từ chối' (STATUS = 0)
                        $updateQuery = "UPDATE bookings SET STATUS = 0, CANCELLED_BY = ?, REJECTION_REASON = ? WHERE TOURID = ? AND USERID = ?";
                        $stmtUpdate = $conn->prepare($updateQuery);
                        $stmtUpdate->bind_param("isii", $_SESSION['ADID'], $rejectionReason, $tourId, $userId);

                        if ($stmtUpdate->execute()) {
                            echo "<script>alert('Đơn đặt tour đã bị từ chối thành công.'); window.location.href='bookingManagement.php';</script>";
                        } else {
                            echo "<script>alert('Có lỗi xảy ra khi từ chối đơn đặt tour.'); window.location.href='bookingManagement.php';</script>";
                        }
                    } else {
                        // Hiển thị form nhập lý do từ chối
?>
                        <div class="main-container">
                            <div class="pd-ltr-20 xs-pd-20-10">
                                <div class="min-height-200px">
                                    <div class="pd-20 card-box mb-30">
                                        <div class="clearfix mb-20">
                                            <div class="pull-left">
                                                <h4 class="text-blue h4">Quản lý Hủy tour</h4>
                                            </div>
                                        </div>
                                        <div class="container">
                                            <h2>Lý do từ chối đơn đặt tour</h2>
                                            <form action="rejectBooking.php?TOURID=<?php echo $tourId; ?>&userid=<?php echo $userId; ?>" method="POST">
                                                <div class="form-group">
                                                    <label for="rejectionReason">Lý do từ chối:</label>
                                                    <select id="rejectionReason" name="rejectionReason" class="form-control" required>
                                                        <option value="" disabled selected>Chọn lý do</option>
                                                        <option value="Tour đã đầy">Hủy tour theo yêu cầu của khách</option>
                                                        <option value="Ngày khởi hành không còn chỗ">Sự cố từ nhà cung cấp dịch vụ</option>
                                                        <?php if ($currentDate <= $oneDayBeforeStart): ?>
                                                            <option value="Lý do khác">Thời tiết không thuận lợi</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-danger">Từ chối</button>
                                                <a href="bookingManagement.php" class="btn btn-secondary">Hủy</a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<?php
                    }
                }
            } else {
                echo "<script>alert('Không tìm thấy thông tin tour.'); window.location.href='bookingManagement.php';</script>";
            }
            $stmtSlots->close();
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
?>