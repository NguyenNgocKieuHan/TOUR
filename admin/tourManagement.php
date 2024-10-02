<?php
session_start(); // Bắt đầu phiên làm việc

include('includes/header.php');
include('includes/db.php');

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['ADID'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

// Kiểm tra kết nối cơ sở dữ liệu
if (!$conn) {
    die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}
?>
<div class="mobile-menu-overlay"></div>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix mb-20">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Quản lý Tour</h4>
                    </div>
                    <div class="pull-right">
                        <a href="addTour.php" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Thêm Tour</a>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Quản trị viên đã thêm tour</th>
                            <th scope="col">Tên Tour</th>
                            <th scope="col">Loại Tour</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Thời Gian</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Truy vấn thông tin tour và loại tour
                        $query = "SELECT t.TOURID, t.TOURNAME, tt.TOURTYPENAME, t.PRICE, t.TIMETOUR, t.IMAGE, a.ADNAME
                            FROM TOUR t
                            JOIN TOURTYPE tt ON t.TOURTYPEID = tt.TOURTYPEID
                            JOIN ADMIN a ON t.ADID = a.ADID";

                        $result = mysqli_query($conn, $query);
                        $counter = 1;

                        // Kiểm tra có bản ghi nào không
                        if (mysqli_num_rows($result) > 0) {
                            // Lặp qua các bản ghi và hiển thị
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<th>" . htmlspecialchars($row['ADNAME']) .  "</th>";
                                echo "<td>" . htmlspecialchars($row['TOURNAME']) .  "</td>";
                                echo "<td>" . htmlspecialchars($row['TOURTYPENAME']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['PRICE']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['TIMETOUR']) . " " . "Ngày" . "</td>";

                                // Hiển thị ảnh tour (giả định ảnh đã được lưu dưới dạng BLOB)
                                echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['IMAGE']) . "' alt='Ảnh' style='width: 100px;'></td>";
                                // if ($row['IMAGE']) {
                                //     echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['IMAGE']) . "' alt='Ảnh' style='width: 100px;'></td>";
                                // } else {
                                //     echo "<td>Không có ảnh</td>";
                                // }

                                echo "<td>
                                        <a href='editTour.php?id=" . $row['TOURID'] . "' class='btn btn-info btn-sm'><i class='fa fa-edit'></i> Sửa</a>
                                        <a href='deleteTour.php?id=" . $row['TOURID'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa không?\");'><i class='fa fa-trash'></i> Xóa</a>
                                      </td>";
                                echo "</tr>";
                                $counter++;
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>Không có tour nào để hiển thị.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
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