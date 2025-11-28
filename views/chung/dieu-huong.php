<!-- CSS -->
<link rel="stylesheet" href="./views/chung/css/dieu-huong.css">

<aside class="sidebar-container">
    <!-- Logo -->
    <div class="sidebar-header">
        <h2 class="sidebar-logo">DRAGON TOUR</h2>
    </div>

    <!-- Menu -->
    <nav class="sidebar-nav">
        <ul class="nav-list">
            <!-- Trang chủ -->
            <!-- <li class="nav-item" id="nav-dashboard">
                <a href="index.php" class="nav-link">
                    <span class="nav-icon">📊</span>
                    <span class="nav-text">Trang chủ</span>
                </a>
            </li> -->

            <!-- Quản lý Hướng dẫn viên -->
            <li class="nav-item" id="nav-hdv">
                <a href="index.php?act=quan-ly-hdv" class="nav-link">
                    <span class="nav-icon">👥</span>
                    <span class="nav-text">Quản lý Hướng dẫn viên</span>
                </a>
            </li>

            <!-- Quản lý Tour -->
            <li class="nav-item" id="nav-tour">
                <a href="index.php?act=quan-ly-tours" class="nav-link">
                    <span class="nav-icon">🗺️</span>
                    <span class="nav-text">Quản lý Tour</span>
                </a>
            </li>

            <!-- Quản lý booking -->
            <li class="nav-item" id="nav-booking">
                <a href="index.php?act=quan-ly-booking" class="nav-link">
                    <span class="nav-icon">📅</span>
                    <span class="nav-text">Quản lý Booking</span>
                </a>
            </li>

            <!-- Đặt booking -->
            <li class="nav-item" id="nav-dat-booking">
                <a href="index.php?act=dat-booking" class="nav-link">
                    <span class="nav-icon">🛎️</span>
                    <span class="nav-text">Đặt Booking</span>
                </a>
            </li>

            <!-- Quản lý Khách hàng
            <li class="nav-item" id="nav-customer">
                <a href="index.php?act=customer" class="nav-link">
                    <span class="nav-icon">🧑</span>
                    <span class="nav-text">Quản lý Khách hàng</span>
                </a>
            </li>

            Cài đặt
            <li class="nav-item" id="nav-settings">
                <a href="index.php?act=settings" class="nav-link">
                    <span class="nav-icon">⚙️</span>
                    <span class="nav-text">Cài đặt</span>
                </a>
            </li> -->
        </ul>
    </nav>

    <!-- Footer -->
    <div class="sidebar-footer">
        <?php
        // Đăng ký/đăng nhập
        if (isset($_SESSION['admin'])) {
            echo '<p>Xin chào, ' . htmlspecialchars($_SESSION['admin']['username']) . '</p>';
            echo '<a href="index.php?act=logout" class="logout-link sidebar-logout">Đăng xuất</a>';
        } else {
            echo '<a href="index.php?act=login" class="login-link sidebar-login">Đăng nhập</a>';
        }
        ?>
    </div>
</aside>

<!-- JavaScript để auto-highlight menu hiện tại -->
<script src="./views/chung/js/dieu-huong.js"></script>