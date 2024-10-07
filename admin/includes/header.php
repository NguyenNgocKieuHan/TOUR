    <?php
    // Kết nối cơ sở dữ liệu
    include('includes/db.php');

    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (isset($_SESSION['ADNAME']) && isset($_SESSION['ADID'])) {
        $fullName = $_SESSION['ADNAME'];
        $userID = $_SESSION['ADID'];
        // $usertype = $_SESSION['USERTYPE'];
    } else {
        // Nếu chưa đăng nhập, chuyển hướng tới trang đăng nhập
        header('Location: login.php');
        exit();
    }
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <!-- Basic Page Info -->
        <meta charset="utf-8">
        <title>TravelTour</title>
        <link rel="shortcut icon" href="vendors/images/dolphin.png">

        <!-- Site favicon -->
        <!-- <link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png"> -->
        <!-- <link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png"> -->

        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
        <link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
        <link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="vendors/styles/style.css">

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-119386393-1');
        </script>
    </head>

    <body>

        <div class="header">
            <div class="header-left">
                <div class="menu-icon dw dw-menu"></div>
                <div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
                <div class="header-search">
                    <form>
                        <div class="form-group mb-0">
                            <i class="dw dw-search2 search-icon"></i>
                            <input type="text" class="form-control search-input" placeholder="Search Here">
                            <div class="dropdown">
                                <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
                                    <i class="ion-arrow-down-c"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="header-right">
                <div class="dashboard-setting user-notification">
                    <div class="dropdown">
                        <a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
                            <i class="dw dw-settings2"></i>
                        </a>
                    </div>
                </div>
                <div class="user-notification">
                    <div class="dropdown">
                        <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
                            <i class="icon-copy dw dw-notification"></i>
                            <span class="badge notification-active"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="notification-list mx-h-350 customscroll">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="user-info-dropdown">
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <span class="user-icon">
                                <img src="vendors/images/dolphin.png" alt="">
                            </span>
                            <?php if (($_SESSION['ADID'])): ?>
                                <span class="user-name"><?php echo htmlspecialchars($fullName); ?></span>
                            <?php endif; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <?php if (($_SESSION['ADID'])): ?>
                                <!-- Options for Admin -->
                                <a class="dropdown-item" href="profile.php"><i class="dw dw-user1"></i> Hồ sơ người dùng</a>
                                <a class="dropdown-item" href="profile.php"><i class="dw dw-settings2"></i> Cài đặt</a>
                                <a class="dropdown-item" href="faq.php"><i class="dw dw-help"></i> Giúp đỡ</a>
                                <a class="dropdown-item" href="login.php"><i class="dw dw-logout"></i> Đăng xuất</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="github-link">
                    <a href="https://github.com/NguyenNgocKieuHan" target="_blank"><img src="vendors/images/github.svg" alt=""></a>
                </div>
            </div>
        </div>
        <div class="right-sidebar">
            <div class="sidebar-title">
                <h3 class="weight-600 font-16 text-blue">
                    Layout Settings
                    <span class="btn-block font-weight-400 font-12">User Interface Settings</span>
                </h3>
                <div class="close-sidebar" data-toggle="right-sidebar-close">
                    <i class="icon-copy ion-close-round"></i>
                </div>
            </div>
            <div class="right-sidebar-body customscroll">
                <div class="right-sidebar-body-content">
                    <h4 class="weight-600 font-18 pb-10">Nền tiêu đề</h4>
                    <div class="sidebar-btn-group pb-30 mb-10">
                        <a href="javascript:void(0);" class="btn btn-outline-primary header-white active">Trắng</a>
                        <a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Đen</a>
                    </div>

                    <h4 class="weight-600 font-18 pb-10">Nền thanh bên</h4>
                    <div class="sidebar-btn-group pb-30 mb-10">
                        <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light ">Trắng</a>
                        <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active">Đen</a>
                    </div>

                    <h4 class="weight-600 font-18 pb-10">Biểu tượng thả xuống Menu</h4>
                    <div class="sidebar-radio-group pb-10 mb-10">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="sidebaricon-1" name="menu-dropdown-icon" class="custom-control-input" value="icon-style-1" checked="">
                            <label class="custom-control-label" for="sidebaricon-1"><i class="fa fa-angle-down"></i></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="sidebaricon-2" name="menu-dropdown-icon" class="custom-control-input" value="icon-style-2">
                            <label class="custom-control-label" for="sidebaricon-2"><i class="ion-plus-round"></i></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="sidebaricon-3" name="menu-dropdown-icon" class="custom-control-input" value="icon-style-3">
                            <label class="custom-control-label" for="sidebaricon-3"><i class="fa fa-angle-double-right"></i></label>
                        </div>
                    </div>

                    <h4 class="weight-600 font-18 pb-10">Biểu tượng danh sách Menu</h4>
                    <div class="sidebar-radio-group pb-30 mb-10">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="sidebariconlist-1" name="menu-list-icon" class="custom-control-input" value="icon-list-style-1" checked="">
                            <label class="custom-control-label" for="sidebariconlist-1"><i class="ion-minus-round"></i></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="sidebariconlist-2" name="menu-list-icon" class="custom-control-input" value="icon-list-style-2">
                            <label class="custom-control-label" for="sidebariconlist-2"><i class="fa fa-circle-o" aria-hidden="true"></i></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="sidebariconlist-3" name="menu-list-icon" class="custom-control-input" value="icon-list-style-3">
                            <label class="custom-control-label" for="sidebariconlist-3"><i class="dw dw-check"></i></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="sidebariconlist-4" name="menu-list-icon" class="custom-control-input" value="icon-list-style-4" checked="">
                            <label class="custom-control-label" for="sidebariconlist-4"><i class="icon-copy dw dw-next-2"></i></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="sidebariconlist-5" name="menu-list-icon" class="custom-control-input" value="icon-list-style-5">
                            <label class="custom-control-label" for="sidebariconlist-5"><i class="dw dw-fast-forward-1"></i></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="sidebariconlist-6" name="menu-list-icon" class="custom-control-input" value="icon-list-style-6">
                            <label class="custom-control-label" for="sidebariconlist-6"><i class="dw dw-next"></i></label>
                        </div>
                    </div>

                    <div class="reset-options pt-30 text-center">
                        <button class="btn btn-danger" id="reset-settings">Thiết lập lại</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar (Left Side) -->
        <div class="left-side-bar">
            <div class="brand-logo">
                <a href="index.php">
                    <img src="vendors/images/tenlogo.png" alt="Logo" style="width: 150px; height: auto;" class="light-logo">
                    <img src=" vendors/images/tenlogo.png" alt="" class="dark-logo">
                    <!-- <img src="vendors/images/logo.png" alt="" class="light-logo"> -->
                </a>
                <div class="close-sidebar" data-toggle="left-sidebar-close">
                    <i class="ion-close-round"></i>
                </div>
            </div>
            <div class="menu-block customscroll">
                <div class="sidebar-menu">
                    <ul id="accordion-menu">
                        <?php if (($_SESSION['ADID'])): ?>
                            <li>
                                <a href="dashboard.php" class="dropdown-toggle no-arrow">
                                    <span class="micon dw dw-house-1"></span><span class="mtext">Trang chủ</span>
                                </a>
                            </li>
                            <li>
                                <a href="tourManagement.php" class="dropdown-toggle no-arrow">
                                    <span class="micon fa fa-ship"></span><span class="mtext">Quản lý Tour</span>
                                </a>
                            </li>
                            <li>
                                <a href="destinationManagement.php" class="dropdown-toggle no-arrow">
                                    <span class="micon fa fa-mixcloud"></span><span class="mtext">Quản lý Điểm đến</span>
                                </a>
                            </li>
                            <li>
                                <a href="bookingManagement.php" class="dropdown-toggle no-arrow">
                                    <span class="micon dw dw-library"></span><span class="mtext">Quản lý Đặt tour</span>
                                </a>
                            </li>
                            <li>
                                <a href="userManagement.php" class="dropdown-toggle no-arrow">
                                    <span class="micon fa fa-address-book"></span><span class="mtext">Quản lý Người dùng</span>
                                </a>
                            </li>
                            <li>
                                <a href="reviewandFeedbackManagement.php" class="dropdown-toggle no-arrow">
                                    <span class="micon fa fa-star"></span><span class="mtext"> Quản lý Đánh giá</span>
                                </a>
                            </li>
                            <li>
                                <a href="revenue.php" class="dropdown-toggle no-arrow">
                                    <span class="micon fa fa-file-o"></span><span class="mtext"> Quản lý Doanh thu</span>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="chat.php" class="dropdown-toggle no-arrow">
                                    <span class="micon dw dw-chat3"></span><span class="mtext">Chat</span>
                                </a>
                            </li> -->
                        <?php else: ?>
                            <li>
                                <a href="../traveltour/index.php" class="dropdown-toggle no-arrow">
                                    <span class="micon dw dw-house-1"></span><span class="mtext">Trang chủ</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>