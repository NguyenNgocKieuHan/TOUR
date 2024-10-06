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
?>
<div class="mobile-menu-overlay"></div>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix mb-20">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Quản lý Địa Điểm</h4>
                    </div>
                    <div class="pull-right">
                        <a href="addDestination.php" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Thêm Địa Điểm</a>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Stt</th>
                            <th scope="col">Thành phố</th>
                            <th scope="col">Quận huyện</th>
                            <th scope="col">Tên địa điểm</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Truy vấn và sắp xếp kết quả theo DESTINATIONID từ lớn đến nhỏ
                        $query = "SELECT d.DESTINATIONID, c.CITYNAME, q.DISTRICTNAME, d.DENAME, d.IMAGE
                                  FROM DESTINATION d
                                  JOIN DISTRICT q ON d.DISTRICTID = q.DISTRICTID
                                  JOIN CITY c ON q.CITYID = c.CITYID
                                  ORDER BY d.DESTINATIONID DESC";

                        $result = mysqli_query($conn, $query);

                        // Đếm tổng số bản ghi
                        $totalRows = mysqli_num_rows($result);

                        // Kiểm tra có dữ liệu không
                        if ($totalRows > 0) {
                            $counter = $totalRows; // Bắt đầu từ tổng số bản ghi và đếm ngược

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $counter . "</th>"; // Hiển thị số thứ tự ngược
                                echo "<td>" . htmlspecialchars($row['CITYNAME']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['DISTRICTNAME']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['DENAME']) . "</td>";
                                echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['IMAGE']) . "' alt='Ảnh' style='width: 100px;'></td>";
                                echo "<td>
                                        <a href='editDestination.php?id=" . $row['DESTINATIONID'] . "' class='btn btn-info btn-sm'><i class='fa fa-edit'></i> Sửa</a>
                                        <a href='deleteDestination.php?id=" . $row['DESTINATIONID'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa không?\");'><i class='fa fa-trash'></i> Xóa</a>
                                      </td>";
                                echo "</tr>";
                                $counter--; // Giảm số thứ tự sau mỗi lần lặp
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>Không có địa điểm nào để hiển thị.</td></tr>";
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