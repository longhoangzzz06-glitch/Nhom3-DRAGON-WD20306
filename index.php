<?php
session_start();
ob_start();
?>
<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>DragonTravel</title>
  <!--begin::Primary Meta Tags-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="title" content="AdminLTE 4 | Sidebar Mini" />
  <meta name="author" content="ColorlibHQ" />
  <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS." />
  <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard" />
  <!--end::Primary Meta Tags-->
  <link rel="icon" type="image/x-icon" href="./uploads/Logo_dragontravel.svg" />
  <!--begin::Fonts-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" />
  <!--end::Fonts-->
  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous" />
  <!--end::Third Party Plugin(OverlayScrollbars)-->
  <!--begin::Third Party Plugin(Bootstrap Icons)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
  <!--end::Third Party Plugin(Bootstrap Icons)-->
  <!--begin::Required Plugin(AdminLTE)-->
  <link rel="stylesheet" href="./views/chung/css/layout/adminlte.css" />
  <!--end::Required Plugin(AdminLTE)-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary">
  <!--begin::App Wrapper-->
  <div class="app-wrapper">
    <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
              <i class="bi bi-list"></i>
            </a>
          </li>
          <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
          <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
          <!--begin::Navbar Search-->
          <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
              <i class="bi bi-search"></i>
            </a>
          </li>
          <!--end::Navbar Search-->
          <!--begin::Messages Dropdown Menu-->
          <li class="nav-item dropdown">
            <a class="nav-link" data-bs-toggle="dropdown" href="#">
              <i class="bi bi-chat-text"></i>
              <span class="navbar-badge badge text-bg-danger">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
              <a href="#" class="dropdown-item">
                <!--begin::Message-->
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <img
                      src="./uploads/img_HDV/1764254625_Nữ 20-24 Việt Nam.png"
                      alt="User Avatar"
                      class="img-size-50 rounded-circle me-3" />
                  </div>
                  <div class="flex-grow-1">
                    <h3 class="dropdown-item-title">
                      Brad Diesel
                      <span class="float-end fs-7 text-danger"><i class="bi bi-star-fill"></i></span>
                    </h3>
                    <p class="fs-7">Call me whenever you can...</p>
                    <p class="fs-7 text-secondary">
                      <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                    </p>
                  </div>
                </div>
                <!--end::Message-->
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <!--begin::Message-->
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <img
                      src="./uploads/img_HDV/1764254695_Nam 40-50 Việt Nam.png"
                      alt="User Avatar"
                      class="img-size-50 rounded-circle me-3" />
                  </div>
                  <div class="flex-grow-1">
                    <h3 class="dropdown-item-title">
                      John Pierce
                      <span class="float-end fs-7 text-secondary">
                        <i class="bi bi-star-fill"></i>
                      </span>
                    </h3>
                    <p class="fs-7">I got your message bro</p>
                    <p class="fs-7 text-secondary">
                      <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                    </p>
                  </div>
                </div>
                <!--end::Message-->
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <!--begin::Message-->
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <img
                      src="./uploads/img_HDV/1764288660_Nữ 17-19 Nga (1).png"
                      alt="User Avatar"
                      class="img-size-50 rounded-circle me-3" />
                  </div>
                  <div class="flex-grow-1">
                    <h3 class="dropdown-item-title">
                      Nora Silvester
                      <span class="float-end fs-7 text-warning">
                        <i class="bi bi-star-fill"></i>
                      </span>
                    </h3>
                    <p class="fs-7">The subject goes here</p>
                    <p class="fs-7 text-secondary">
                      <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                    </p>
                  </div>
                </div>
                <!--end::Message-->
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
          </li>
          <!--end::Messages Dropdown Menu-->
          <!--begin::Notifications Dropdown Menu-->
          <li class="nav-item dropdown">
            <a class="nav-link" data-bs-toggle="dropdown" href="#">
              <i class="bi bi-bell-fill"></i>
              <span class="navbar-badge badge text-bg-warning">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
              <span class="dropdown-item dropdown-header">15 Notifications</span>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="bi bi-envelope me-2"></i> 4 new messages
                <span class="float-end text-secondary fs-7">3 mins</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="bi bi-people-fill me-2"></i> 8 friend requests
                <span class="float-end text-secondary fs-7">12 hours</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                <span class="float-end text-secondary fs-7">2 days</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
            </div>
          </li>
          <!--end::Notifications Dropdown Menu-->
          <!--begin::Fullscreen Toggle-->
          <li class="nav-item">
            <a class="nav-link" href="#" data-lte-toggle="fullscreen">
              <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
              <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
            </a>
          </li>
          <!--end::Fullscreen Toggle-->
          <!--begin::User Menu Dropdown-->
          <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
              <img
                src="./uploads/img_HDV/1764254743_Nam 20-25 Việt Nam.png"
                class="user-image rounded-circle shadow"
                alt="User Image" />
              <span class="d-none d-md-inline">Phạm Minh Tuấn</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
              <!--begin::User Image-->
              <li class="user-header text-bg-primary">
                <img
                  src="./uploads/img_HDV/1764254743_Nam 20-25 Việt Nam.png"
                  class="rounded-circle shadow"
                  alt="User Image" />
                <p>
                  Phạm Minh Tuấn - Web Developer
                  <small>Member since Nov. 2023</small>
                </p>
              </li>
              <!--end::User Image-->
              <!--begin::Menu Body-->
              <li class="user-body">
                <!--begin::Row-->
                <div class="row">
                  <div class="col-4 text-center"><a href="#">Followers</a></div>
                  <div class="col-4 text-center"><a href="#">Sales</a></div>
                  <div class="col-4 text-center"><a href="#">Friends</a></div>
                </div>
                <!--end::Row-->
              </li>
              <!--end::Menu Body-->
              <!--begin::Menu Footer-->
              <li class="user-footer">
                <a href="#" class="btn btn-default btn-flat">Profile</a>
                <a href="#" class="btn btn-default btn-flat float-end">Sign out</a>
              </li>
              <!--end::Menu Footer-->
            </ul>
          </li>
          <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
      </div>
      <!--end::Container-->
    </nav>
    <!--end::Header-->
    <!--begin::Sidebar-->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
      <!--begin::Sidebar Brand-->
      <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="../index.html" class="brand-link">
          <!--begin::Brand Image-->
          <img
            src="./uploads/Logo_dragontravel.svg"
            alt="DragonTravel Logo"
            class="brand-image opacity-75 shadow" />
          <!--end::Brand Image-->
          <!--begin::Brand Text-->
          <span class="brand-text fw-light">DragonTravel</span>
          <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
      </div>
      <!--end::Sidebar Brand-->
      <!--begin::Sidebar Wrapper-->
      <div class="sidebar-wrapper">
        <nav class="mt-2">
          <!--begin::Sidebar Menu-->
          <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
            <!-- Quản lý Hướng dẫn viên -->
            <li class="nav-item" id="nav-hdv">
              <a href="index.php?act=quan-ly-hdv" class="nav-link">
                <i class="nav-icon bi bi-people"></i>
                <p style="color: white;">Quản lý Hướng dẫn viên</p>
              </a>
            </li>
            <!-- Quản lý Tour -->
            <li class="nav-item" id="nav-tour">
              <a href="index.php?act=quan-ly-tours" class="nav-link">
                <i class="nav-icon bi bi-map"></i>
                <p class="nav-text">Quản lý Tour</p>
              </a>
            </li>
            <!-- Quản lý booking -->
            <li class="nav-item" id="nav-booking">
              <a href="index.php?act=quan-ly-booking" class="nav-link">
                <i class="nav-icon bi bi-calendar-check"></i>
                <p class="nav-text">Quản lý Booking</p>
              </a>
            </li>
            <!-- Quản lý Supplier -->
            <li class="nav-item" id="nav-supplier">
              <a href="index.php?act=quan-ly-supplier" class="nav-link">
                <i class="nav-icon bi bi-building"></i>
                <p class="nav-text">Quản lý Nhà cung cấp</p>
              </a>
            </li>
            <!-- Quản lý Hợp đồng -->
            <li class="nav-item" id="nav-hopdong">
              <a href="index.php?act=quan-ly-hopdong" class="nav-link">
                <i class="nav-icon bi bi-file-earmark-text"></i>
                <p class="nav-text">Quản lý Hợp đồng</p>
              </a>
            </li>

            <!-- Quản lý Công nợ -->
            <li class="nav-item" id="nav-congno">
              <a href="index.php?act=quan-ly-congno" class="nav-link">
                <i class="nav-icon bi bi-wallet2"></i>
                <p class="nav-text">Quản lý Công nợ</p>
              </a>
            </li>

            <!-- Quản lý Đánh giá NCC -->
            <li class="nav-item" id="nav-danhgia">
              <a href="index.php?act=quan-ly-danhgia" class="nav-link">
                <i class="nav-icon bi bi-star-half"></i>
                <p class="nav-text">Đánh giá Nhà cung cấp</p>
              </a>
            </li>

            <!-- Báo cáo Tài chính -->
            <li class="nav-item" id="nav-taichinh">
              <a href="index.php?act=bao-cao-taichinh" class="nav-link">
                <i class="nav-icon bi bi-bar-chart-line"></i>
                <p class="nav-text">Báo cáo Tài chính</p>
              </a>
            </li>

          </ul>
          <!--end::Sidebar Menu-->
        </nav>
      </div>
      <!--end::Sidebar Wrapper-->
    </aside>
    <!--end::Sidebar-->
    <!--begin::App Main-->
    <main class="app-main" style="margin: 0 20px">
      <?php
      // Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

      // Require file Common
      require_once './commons/env.php'; // Khai báo biến môi trường
      require_once './commons/function.php'; // Hàm hỗ trợ

      // Require toàn bộ file Controllers
      require_once './controllers/HDVController.php';
      require_once './controllers/TourController.php';
      require_once './controllers/BookingController.php';
      require_once './controllers/SupplierController.php';
      require_once './controllers/HopDongController.php';
      require_once './controllers/CongNoController.php';
      require_once './controllers/DanhGiaNCCController.php';
      require_once './controllers/TaiChinhTourController.php';


      // Require toàn bộ file Models
      require_once './models/HDVModel.php';
      require_once './models/TourModel.php';
      require_once './models/BookingModel.php';
      require_once './models/SupplierModel.php';
      // Require toàn bộ file Models mới
      require_once './models/HopDong.php';
      require_once './models/CongNo.php';
      require_once './models/DanhGiaNCC.php';
      require_once './models/TaiChinhTour.php';


      // Route
      $act = $_GET['act'] ?? '/';

      // Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

      match ($act) {
        // Trang chủ
        '/', 'trang-chu' => (new HDVController())->danhSach(),

        /* Trang quản lý hướng dẫn viên */
        // Hiển thị danh sách hướng dẫn viên
        'quan-ly-hdv' => (new HDVController())->danhSach(),
        // Xử lý thêm hướng dẫn viên
        'view-them-hdv' => (new HDVController())->viewThemHDV(),
        'them-hdv' => (new HDVController())->themHDV($_POST),
        // Xử lý xóa hướng dẫn viên
        'xoa-hdv' => (new HDVController())->xoaHDV($_GET['id']),
        // Xử lý cập nhật hướng dẫn viên
        'view-cap-nhat-hdv' => (new HDVController())->viewCapNhatHDV($_GET['id']),
        'cap-nhat-hdv' => (new HDVController())->capNhatHDV($_GET['id'], $_POST),

        /* Trang quản lý Tours */
        // Hiển thị danh sách Tours
        'quan-ly-tours' => (new TourController())->danhSachTour(),
        // Xử lý thêm Tours
        'view-them-tour' => (new TourController())->viewThemTour(),
        'them-tour' => (new TourController())->themTour($_POST),
        // Xử lý xóa Tours
        'xoa-tour' => (new TourController())->xoaTour($_GET['id']),
        // Xử lý cập nhật Tours
        'view-cap-nhat-tour' => (new TourController())->viewCapNhatTour($_GET['id']),
        'cap-nhat-tour' => (new TourController())->capNhatTour($_GET['id'], $_POST),

        /* Trang quản lý Booking */
        // Hiển thị danh sách Booking
        'quan-ly-booking' => (new BookingController())->danhSachBooking(),
        // Xử lý xóa Booking
        'xoa-booking' => (new BookingController())->delete(),
        // Xử lý cập nhật Booking
        'view-cap-nhat-booking' => (new BookingController())->edit(),
        'cap-nhat-booking' => (new BookingController())->update(),
        // Xử lý đặt booking
        'view-dat-booking' => (new BookingController())->viewDatBooking(),
        'store-booking' => (new BookingController())->datBooking(),
        'dat-booking' => (new BookingController())->datBooking(),
        // API Check-in
        'api-check-in' => (new BookingController())->apiCheckIn(),
        'api-get-customers' => (new BookingController())->apiGetCustomersList(),
        // API Add/Delete Customer
        'api-add-customer' => (new BookingController())->apiAddCustomer(),
        'api-add-customer-link' => (new BookingController())->apiAddCustomerLink(),
        'api-delete-customer' => (new BookingController())->apiDeleteCustomer(),
        /* Trang quản lý Supplier */
        // Hiển thị danh sách Supplier
        'quan-ly-supplier' => (new SupplierController())->index(),

        // Trang thêm Supplier
        'view-them-supplier' => (new SupplierController($db))->create(),
        'them-supplier' => (new SupplierController($db))->store($_POST),

        // Trang cập nhật Supplier
        'view-cap-nhat-supplier' => (new SupplierController())->edit($_GET['id']),
        'cap-nhat-supplier' => (new SupplierController())->update($_GET['id'], $_POST),

        // Xóa Supplier
        'xoa-supplier' => (new SupplierController($db))->delete($_GET['id']),
        /* Trang quản lý Hợp đồng */
        'quan-ly-hopdong' => (new HopDongController($db))->index(),
        'view-them-hopdong' => (new HopDongController($db))->create(),
        'them-hopdong' => (new HopDongController($db))->store($_POST),
        'view-cap-nhat-hopdong' => (new HopDongController($db))->edit($_GET['id']),
        'cap-nhat-hopdong' => (new HopDongController($db))->update($_GET['id'], $_POST),
        'xoa-hopdong' => (new HopDongController($db))->delete($_GET['id']),

        /* Trang quản lý Công nợ */
        'quan-ly-congno' => (new CongNoController($db))->index(),
        'view-them-congno' => (new CongNoController($db))->create(),
        'them-congno' => (new CongNoController($db))->store($_POST),
        'view-cap-nhat-congno' => (new CongNoController($db))->edit($_GET['id']),
        'cap-nhat-congno' => (new CongNoController($db))->update($_GET['id'], $_POST),
        'xoa-congno' => (new CongNoController($db))->delete($_GET['id']),

        /* Trang quản lý Đánh giá NCC */
        'quan-ly-danhgia' => (new DanhGiaNCCController($db))->index(),
        'view-them-danhgia' => (new DanhGiaNCCController($db))->create(),
        'them-danhgia' => (new DanhGiaNCCController($db))->store($_POST),
        'view-cap-nhat-danhgia' => (new DanhGiaNCCController($db))->edit($_GET['id']),
        'cap-nhat-danhgia' => (new DanhGiaNCCController($db))->update($_GET['id'], $_POST),
        'xoa-danhgia' => (new DanhGiaNCCController($db))->delete($_GET['id']),

        /* Trang Báo cáo Tài chính */
        'bao-cao-taichinh' => (new TaiChinhTourController($db))->baoCao(),
      };
      ?>
    </main>
    <!--end::App Main-->
    <!--begin::Footer-->
    <footer class="app-footer">
      <!--begin::To the end-->
      <div class="float-end d-none d-sm-inline">Anything you want</div>
      <!--end::To the end-->
      <!--begin::Copyright-->
      <strong>
        Copyright &copy; 2025-2026&nbsp;
        <a href="#" class="text-decoration-none">DragonTravel</a>.
      </strong>
      All rights reserved.
      <!--end::Copyright-->
    </footer>
    <!--end::Footer-->
  </div>
  <!--end::App Wrapper-->
  <!--begin::Script-->
  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <script
    src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
    integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
    crossorigin="anonymous"></script>
  <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
  <script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
  <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
  <script src="./views/chung/js/layout/adminlte.js"></script>
  <!--end::Required Plugin(AdminLTE)-->

  <!-- ==================== MENU HIGHLIGHTING ==================== -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Lấy route hiện tại từ URL
      const urlParams = new URLSearchParams(window.location.search);
      const currentAct = urlParams.get('act') || '/';

      // Map route đến menu item ID
      const routeToMenuMap = {
        'quan-ly-hdv': 'nav-hdv',
        'view-them-hdv': 'nav-hdv',
        'them-hdv': 'nav-hdv',
        'xoa-hdv': 'nav-hdv',
        'view-cap-nhat-hdv': 'nav-hdv',
        'cap-nhat-hdv': 'nav-hdv',

        'quan-ly-tours': 'nav-tour',
        'view-them-tour': 'nav-tour',
        'them-tour': 'nav-tour',
        'xoa-tour': 'nav-tour',
        'view-cap-nhat-tour': 'nav-tour',
        'cap-nhat-tour': 'nav-tour',

        'quan-ly-booking': 'nav-booking',
        'xoa-booking': 'nav-booking',
        'view-cap-nhat-booking': 'nav-booking',
        'cap-nhat-booking': 'nav-booking',
        'view-dat-booking': 'nav-booking',
        'dat-booking': 'nav-booking',
        'supplier': 'nav-supplier',
        'quan-ly-supplier': 'nav-supplier',
        'view-them-supplier': 'nav-supplier',
        'them-supplier': 'nav-supplier',
        'view-cap-nhat-supplier': 'nav-supplier',
        'cap-nhat-supplier': 'nav-supplier',
        'xoa-supplier': 'nav-supplier',
        'quan-ly-hopdong': 'nav-hopdong',
        'view-them-hopdong': 'nav-hopdong',
        'them-hopdong': 'nav-hopdong',
        'view-cap-nhat-hopdong': 'nav-hopdong',
        'cap-nhat-hopdong': 'nav-hopdong',
        'xoa-hopdong': 'nav-hopdong',

        'quan-ly-congno': 'nav-congno',
        'view-them-congno': 'nav-congno',
        'them-congno': 'nav-congno',
        'view-cap-nhat-congno': 'nav-congno',
        'cap-nhat-congno': 'nav-congno',
        'xoa-congno': 'nav-congno',

        'quan-ly-danhgia': 'nav-danhgia',
        'view-them-danhgia': 'nav-danhgia',
        'them-danhgia': 'nav-danhgia',
        'view-cap-nhat-danhgia': 'nav-danhgia',
        'cap-nhat-danhgia': 'nav-danhgia',
        'xoa-danhgia': 'nav-danhgia',

        'bao-cao-taichinh': 'nav-taichinh',

      };

      // Lấy menu ID tương ứng
      const menuId = routeToMenuMap[currentAct];

      if (menuId) {
        const menuItem = document.getElementById(menuId);
        if (menuItem) {
          const navLink = menuItem.querySelector('.nav-link');
          if (navLink) {
            navLink.classList.add('active');
          }
        }
      }
    });
  </script>
  <!-- ==================== END MENU HIGHLIGHTING ==================== --><!--begin::OverlayScrollbars Configure-->
  <script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'leave',
      scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function() {
      const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
      if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
          scrollbars: {
            theme: Default.scrollbarTheme,
            autoHide: Default.scrollbarAutoHide,
            clickScroll: Default.scrollbarClickScroll,
          },
        });
      }
    });
  </script>
  <!--end::OverlayScrollbars Configure-->

</body>
<!--end::Body-->

</html>
<?php
ob_end_flush();
?>