<?php
ob_start();
session_start();

// Commons
require_once './commons/env.php';
require_once './commons/function.php';

// Controllers
require_once './controllers/HDVController.php';
require_once './controllers/TourController.php';
require_once './controllers/BookingController.php';
require_once './controllers/ReportController.php';
require_once './controllers/TourDetailController.php';
require_once './controllers/DiaDiemController.php';
require_once './controllers/NCCController.php';

// Models
require_once './models/HDVModel.php';
require_once './models/TourModel.php';
require_once './models/BookingModel.php';
require_once './models/ReportModel.php';
require_once './models/CheckpointModel.php';
require_once './models/RequirementModel.php';
require_once './models/ReviewModel.php';
require_once './models/TourDetailModel.php';
require_once './models/DiaDiemModel.php';
require_once './models/TaiKhoanModel.php';
require_once './models/NCCModel.php';
require_once './models/NCCTourModel.php';

$act = $_GET['act'] ?? '/';
$apiRoutes = [
    'hdv-save-checkin',
    'hdv-complete-checkpoint',
    'hdv-save-requirement',
    'hdv-delete-requirement',
    'hdv-get-requirements-by-customer',
    'hdv-save-diary',
    'hdv-delete-diary',
    'hdv-save-review',
    'api-update-diadiem-order'
];

// Nếu là API
if (in_array($act, $apiRoutes)) {
        match ($act) {
            'hdv-save-checkin' => (new HDVController())->saveCheckin(),
            'hdv-complete-checkpoint' => (new HDVController())->completeCheckpoint(),
            'hdv-save-requirement' => (new HDVController())->saveRequirement(),
            'hdv-delete-requirement' => (new HDVController())->deleteRequirement(),
            'hdv-get-requirements-by-customer' => (new HDVController())->getRequirementsByCustomer(),
            'hdv-save-diary' => (new HDVController())->saveDiary(),
            'hdv-delete-diary' => (new HDVController())->deleteDiary(),
            'hdv-save-review' => (new HDVController())->saveReview(),
            'api-update-diadiem-order' => (new DiaDiemController())->updateOrder(),
        };
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>DragonTravel</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE 4 | Sidebar Mini" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."/>
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"/>
    <link rel="icon" type="image/x-icon" href="./uploads/Logo_dragontravel.svg"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous"/>
    <link rel="stylesheet" href="./views/chung/css/layout/adminlte.css" />
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
            <li class="nav-item d-none d-md-block"><a href="index.php" class="nav-link">Home</a></li>
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
                        class="img-size-50 rounded-circle me-3"
                      />
                    </div>
                    <div class="flex-grow-1">
                      <h3 class="dropdown-item-title">
                        Brad Diesel
                        <span class="float-end fs-7 text-danger"
                          ><i class="bi bi-star-fill"></i
                        ></span>
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
                        class="img-size-50 rounded-circle me-3"
                      />
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
                        class="img-size-50 rounded-circle me-3"
                      />
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
                  alt="User Image"
                />
                <span class="d-none d-md-inline">Phạm Minh Tuấn</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--begin::User Image-->
                <li class="user-header text-bg-primary">
                  <img
                    src="./uploads/img_HDV/1764254743_Nam 20-25 Việt Nam.png"
                    class="rounded-circle shadow"
                    alt="User Image"
                  />
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
          <a href="index.php" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="./uploads/Logo_dragontravel.svg"
              alt="DragonTravel Logo"
              class="brand-image"
            />
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
              <!-- Báo cáo vận hành -->
              <li class="nav-item" id="nav-report">
                  <a href="index.php?act=bao-cao-van-hanh" class="nav-link">
                      <i class="nav-icon bi bi-graph-up"></i>
                      <p class="nav-text">Báo cáo Vận hành</p>
                  </a>
              </li>              
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

              <!-- HDV - Lịch làm việc -->
              <li class="nav-item" id="nav-hdv-work">
                  <a href="index.php?act=hdv-lich-lam-viec" class="nav-link">
                      <i class="nav-icon bi bi-calendar3"></i>
                      <p class="nav-text">Lịch làm việc HDV</p>
                  </a>
              </li>   
              <!-- HDV - Địa điểm -->
              <li class="nav-item" id="nav-diadiem">
                  <a href="index.php?act=quan-ly-dia-diem" class="nav-link">
                      <i class="nav-icon bi bi-geo-alt"></i>
                      <p class="nav-text">Quản lý Địa điểm</p>
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
      <?php require_once './views/chung/router.php'; ?>
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
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="./views/chung/js/layout/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)-->
    
    <!-- ==================== MENU HIGHLIGHTING ==================== -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Lấy route hiện tại từ URL
        const urlParams = new URLSearchParams(window.location.search);
        const currentAct = urlParams.get('act') || '/';
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
      document.addEventListener('DOMContentLoaded', function () {
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
