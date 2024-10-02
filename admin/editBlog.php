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
    <div class="pd-ltr-20 xs-pd-20-10"></div>
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Quản lý nội dung</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Quản lý nội dung</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Default Basic Forms Start -->
        <div class="pd-20 card-box mb-30">
            <div class="row">
                <div class="col-md-12"></div>
                <div class="card-box">
                    <h4 class="text-blue h4">Quản lý nội dung</h4>
                    <p class="mb-30">Cập nhật nội dung</p>
                    <div class="pd-20 card-box mb-30"></div>
                    <form>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Tiêu đề</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control" type="text" value="Tiêu đề" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Nội dung</label>
                            <div class="col-sm-12 col-md-10">
                                <textarea class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group row"></div>
                        <label class="col-sm-12 col-md-2 col-form-label"></label>
                        <div class="col-sm-12 col-md-10"></div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>

<?php
?>