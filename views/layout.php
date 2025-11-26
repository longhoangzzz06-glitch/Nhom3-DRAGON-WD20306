<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Quản lý Hướng dẫn viên'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* ===== Reset & Base ===== */

        /* ===== Sidebar ===== */
        .sidebar {
            width: 280px;
            background: #1e1e1e;
            color: #fff;
            padding: 20px 0;
            overflow-y: auto;
            border-right: 1px solid #333;
            flex-shrink: 0;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #2a2a2a;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #555;
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #777;
        }

        .sidebar-logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #333;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar-logo i {
            font-size: 24px;
            color: #2563eb;
        }

        .sidebar-section {
            padding: 0;
            margin-bottom: 10px;
        }

        .sidebar-section-title {
            padding: 12px 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: #999;
            letter-spacing: 0.5px;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu-item {
            margin: 0;
        }

        .sidebar-menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu-link:hover {
            background: #2a2a2a;
            color: #fff;
            border-left-color: #2563eb;
        }

        .sidebar-menu-link.active {
            background: #2563eb;
            color: #fff;
            border-left-color: #fff;
        }

        .sidebar-menu-link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .sidebar-menu-link span {
            flex: 1;
            font-size: 14px;
        }

  
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-map-location-dot"></i>
            <span>DRAGON TOUR</span>
        </div>

        <!-- Hướng dẫn viên -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Hướng dẫn viên</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="index.php?act=/" class="sidebar-menu-link <?php echo ($act === '/' || $act === 'home') ? 'active' : ''; ?>">
                        <i class="fas fa-list"></i>
                        <span>Danh sách HDV</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="index.php?act=view-them-hdv" class="sidebar-menu-link <?php echo $act === 'view-them-hdv' ? 'active' : ''; ?>">
                        <i class="fas fa-user-plus"></i>
                        <span>Thêm HDV</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tour -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Quản lý tour</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="index.php?act=tours" class="sidebar-menu-link <?php echo $act === 'tours' ? 'active' : ''; ?>">
                        <i class="fas fa-route"></i>
                        <span>Danh sách tour</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="index.php?act=tour-packages" class="sidebar-menu-link <?php echo $act === 'tour-packages' ? 'active' : ''; ?>">
                        <i class="fas fa-boxes"></i>
                        <span>Gói tour</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="index.php?act=bookings" class="sidebar-menu-link <?php echo $act === 'bookings' ? 'active' : ''; ?>">
                        <i class="fas fa-calendar-check"></i>
                        <span>Đặt tour</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Nhà cung cấp -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Nhà cung cấp</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="index.php?act=suppliers" class="sidebar-menu-link <?php echo $act === 'suppliers' ? 'active' : ''; ?>">
                        <i class="fas fa-building"></i>
                        <span>Nhà cung cấp</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="index.php?act=supplier-contracts" class="sidebar-menu-link <?php echo $act === 'supplier-contracts' ? 'active' : ''; ?>">
                        <i class="fas fa-file-contract"></i>
                        <span>Hợp đồng</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="index.php?act=supplier-quotes" class="sidebar-menu-link <?php echo $act === 'supplier-quotes' ? 'active' : ''; ?>">
                        <i class="fas fa-receipt"></i>
                        <span>Báo giá</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="index.php?act=supplier-debts" class="sidebar-menu-link <?php echo $act === 'supplier-debts' ? 'active' : ''; ?>">
                        <i class="fas fa-credit-card"></i>
                        <span>Công nợ</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tài chính -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Tài chính</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="index.php?act=debts" class="sidebar-menu-link <?php echo $act === 'debts' ? 'active' : ''; ?>">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span>Công nợ</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="index.php?act=finance" class="sidebar-menu-link <?php echo $act === 'finance' ? 'active' : ''; ?>">
                        <i class="fas fa-chart-line"></i>
                        <span>Tài chính</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Phản hồi -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Khác</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="index.php?act=feedback" class="sidebar-menu-link <?php echo $act === 'feedback' ? 'active' : ''; ?>">
                        <i class="fas fa-comments"></i>
                        <span>Phản hồi khách hàng</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="index.php?act=payment-reminders" class="sidebar-menu-link <?php echo $act === 'payment-reminders' ? 'active' : ''; ?>">
                        <i class="fas fa-bell"></i>
                        <span>Nhắc thanh toán</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <div class="top-bar">
            <div class="top-bar-left" id="pageTitle"><?php echo $pageTitle ?? 'Quản lý hệ thống'; ?></div>
            <div class="top-bar-right">
                <div style="font-size: 14px; color: #666;">
                    <span>Xin chào, <strong>Admin</strong></span>
                </div>
                <i class="fas fa-user-circle" style="font-size: 28px; color: #2563eb; cursor: pointer;"></i>
            </div>
        </div>

        <div class="content-area">
            <div class="content-wrapper">
                <?php 
                    // Nội dung sẽ được include ở đây
                    // Variable $contentView chứa đường dẫn file view
                    if (isset($contentView) && file_exists($contentView)) {
                        include $contentView;
                    }
                ?>
            </div>
        </div>
    </div>

    <script>
        // Highlight active menu based on current page
        document.addEventListener('DOMContentLoaded', function() {
            const currentAct = '<?php echo $act; ?>';
            const menuLinks = document.querySelectorAll('.sidebar-menu-link');
            
            menuLinks.forEach(link => {
                link.classList.remove('active');
            });
            
            // Find and highlight current link
            menuLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href.includes('act=' + currentAct)) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
