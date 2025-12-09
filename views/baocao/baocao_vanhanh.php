<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Báo cáo vận hành Tour</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="./views/chung/css/danhsach.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  
  <style>
    .stat-card {
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
      border-left: 4px solid #28a745;
    }
    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }
    .stat-card i {
      color: #28a745;
    }
    .stat-card h3 {
      color: #28a745;
      font-weight: bold;
      margin: 10px 0;
    }
    
    .kpi-section {
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
    .kpi-item {
      text-align: center;
      padding: 15px;
    }
    .kpi-item h4 {
      color: #007bff;
      margin: 10px 0;
    }
    
    .chart-container {
      position: relative;
      height: 300px;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
    
    .filter-form {
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      margin-bottom: 20px;
      display: flex;
      gap: 15px;
      align-items: flex-end;
      flex-wrap: wrap;
    }
    .filter-group {
      flex: 1;
      min-width: 200px;
    }
    .filter-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: 500;
      color: #333;
    }
    .filter-group input {
      width: 100%;
      padding: 8px 12px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 14px;
    }
    
    .tab-buttons {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
      border-bottom: 2px solid #e0e0e0;
    }
    .tab-btn {
      padding: 10px 20px;
      background: none;
      border: none;
      cursor: pointer;
      font-size: 14px;
      color: #666;
      border-bottom: 3px solid transparent;
      transition: all 0.3s;
    }
    .tab-btn.active {
      color: #007bff;
      border-bottom-color: #007bff;
      font-weight: 600;
    }
    .tab-btn:hover {
      color: #0056b3;
      background-color: #f8f9fa;
    }
    
    .tab-content {
      display: none;
    }
    .tab-content.active {
      display: block;
    }
    
    .info-alert {
      background: #d1ecf1;
      border-left: 4px solid #0c5460;
      padding: 12px;
      margin: 15px 0;
      border-radius: 4px;
      color: #0c5460;
    }
    .success-alert {
      background: #d4edda;
      border-left: 4px solid #155724;
      padding: 12px;
      margin: 15px 0;
      border-radius: 4px;
      color: #155724;
    }
    
    tbody td {
      vertical-align: middle;
    }
    .text-success {
      color: #28a745 !important;
      font-weight: 600;
    }
  </style>
</head>
<body>
<div class="content-wrapper">
  <div class="content-container">
    <div class="header">
      <div>
        <h1>Báo cáo vận hành Tour</h1>
      </div>
    </div>

    <!-- Search/Filter section -->
    <div class="search-section">
      <form method="get" style="display: flex; gap: 15px; align-items: flex-end; flex: 1;">
        <input type="hidden" name="act" value="bao-cao-van-hanh">
        <div class="search-group" style="flex: 1;">
          <label for="from-date">Từ ngày:</label>
          <input type="date" id="from-date" name="from" value="<?= htmlspecialchars($_GET['from'] ?? '') ?>">
        </div>
        <div class="search-group" style="flex: 1;">
          <label for="to-date">Đến ngày:</label>
          <input type="date" id="to-date" name="to" value="<?= htmlspecialchars($_GET['to'] ?? '') ?>">
        </div>
        <button type="submit" class="btn-advanced-search">
          <i class="fas fa-filter"></i> Lọc báo cáo
        </button>
      </form>
      <button class="btn-reset" onclick="window.location.href='?act=bao-cao-van-hanh'">
        <i class="fas fa-redo"></i> Xem toàn bộ
      </button>
      <button class="btn-add-item">
        <a href="?act=bao-cao-export<?= isset($_GET['from']) ? '&from='.htmlspecialchars($_GET['from']) : '' ?><?= isset($_GET['to']) ? '&to='.htmlspecialchars($_GET['to']) : '' ?>" style="color: white; text-decoration: none;">
          <i class="fas fa-file-excel"></i> Xuất Excel
        </a>
      </button>
    </div>

    <?php
    // Khởi tạo biến mặc định
    $totalRevenue = $totalRevenue ?? 0;
    $totalCost = $totalCost ?? 0;
    $totalProfit = $totalProfit ?? 0;
    $tours = $tours ?? [];
    $dashboardKPI = $dashboardKPI ?? [];
    $categoryStats = $categoryStats ?? [];
    $bookingStatusStats = $bookingStatusStats ?? [];
    $monthlyComparison = $monthlyComparison ?? [];
    $conversionRate = $conversionRate ?? [];
    $conversionByTour = $conversionByTour ?? [];
    $conversionByHDV = $conversionByHDV ?? [];
    ?>

    <!-- Main wrapper -->
    <div class="main-wrapper">
      
      <!-- Financial & Conversion Cards -->
      <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <!-- Revenue Card -->
        <div class="stat-card">
          <i class="fas fa-dollar-sign fa-3x"></i>
          <h6 style="color: #666; text-transform: uppercase; margin: 10px 0 5px;">Tổng Doanh Thu</h6>
          <h3><?= number_format($totalRevenue) ?> ₫</h3>
          <small style="color: #999;">Từ booking hoàn thành</small>
        </div>

        <!-- Cost Card -->
        <div class="stat-card" style="border-left-color: #dc3545;">
          <i class="fas fa-money-bill-wave fa-3x" style="color: #dc3545;"></i>
          <h6 style="color: #666; text-transform: uppercase; margin: 10px 0 5px;">Tổng Chi Phí</h6>
          <h3 style="color: #dc3545;"><?= number_format($totalCost) ?> ₫</h3>
          <small style="color: #999;">Giá tour × Số booking</small>
        </div>

        <!-- Profit Card -->
        <div class="stat-card" style="border-left-color: <?= $totalProfit >= 0 ? '#28a745' : '#dc3545' ?>;">
          <i class="fas fa-chart-line fa-3x" style="color: <?= $totalProfit >= 0 ? '#28a745' : '#dc3545' ?>;"></i>
          <h6 style="color: #666; text-transform: uppercase; margin: 10px 0 5px;">Lợi Nhuận</h6>
          <h3 style="color: <?= $totalProfit >= 0 ? '#28a745' : '#dc3545' ?>;"><?= number_format($totalProfit) ?> ₫</h3>
          <small style="color: #999;">
            <?php if ($totalRevenue > 0): ?>
              Tỷ suất: <?= number_format(($totalProfit / $totalRevenue) * 100, 2) ?>%
            <?php else: ?>
              Doanh thu - Chi phí
            <?php endif; ?>
          </small>
        </div>

        <!-- Conversion Rate Card -->
        <div class="stat-card" style="border-left-color: #17a2b8;">
          <i class="fas fa-chart-line fa-3x" style="color: #17a2b8;"></i>
          <h6 style="color: #666; text-transform: uppercase; margin: 10px 0 5px;">Tỷ Lệ Chuyển Đổi Booking</h6>
          <h3 style="color: #17a2b8;"><?= number_format($conversionRate['conversion_rate'] ?? 0, 2) ?>%</h3>
          <small style="color: #999;">
            <?= $conversionRate['successful_bookings'] ?? 0 ?> thành công / 
            <?= $conversionRate['total_bookings'] ?? 0 ?> tổng booking
          </small>
          <div style="margin-top: 15px; display: flex; justify-content: space-around; padding: 10px 0; border-top: 1px solid #e0e0e0;">
            <div style="text-align: center;">
              <div style="font-size: 20px; font-weight: 600; color: #28a745;">
                <?= $conversionRate['successful_bookings'] ?? 0 ?>
              </div>
              <small style="color: #666;">Đã hoàn thành</small>
            </div>
            <div style="text-align: center;">
              <div style="font-size: 20px; font-weight: 600; color: #ffc107;">
                <?= $conversionRate['pending_bookings'] ?? 0 ?>
              </div>
              <small style="color: #666;">Chờ duyệt</small>
            </div>
          </div>
        </div>
      </div>

      <!-- KPI Section -->
      <div class="kpi-section">
        <h5 style="margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e0e0e0;">
          <i class="fas fa-tachometer-alt"></i> Thống Kê Tổng Quan
        </h5>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px;">
          <div class="kpi-item">
            <h4><?= $dashboardKPI['total_tours'] ?? 0 ?></h4>
            <small style="color: #666;">Tổng số Tour</small>
          </div>
          <div class="kpi-item">
            <h4 style="color: #28a745;"><?= $dashboardKPI['confirmed_bookings'] ?? 0 ?></h4>
            <small style="color: #666;">Booking đã hoàn thành</small>
          </div>
          <div class="kpi-item">
            <h4 style="color: #ffc107;"><?= $dashboardKPI['pending_bookings'] ?? 0 ?></h4>
            <small style="color: #666;">Booking chờ duyệt</small>
          </div>
          <div class="kpi-item">
            <h4 style="color: #17a2b8;"><?= $dashboardKPI['total_customers'] ?? 0 ?></h4>
            <small style="color: #666;">Tổng số khách</small>
          </div>
          <div class="kpi-item">
            <h4 style="color: #6c757d;"><?= number_format($dashboardKPI['avg_booking_value'] ?? 0) ?> ₫</h4>
            <small style="color: #666;">Giá trị TB/Booking</small>
          </div>
          <div class="kpi-item">
            <h4 style="color: #28a745;"><?= $dashboardKPI['total_bookings'] ?? 0 ?></h4>
            <small style="color: #666;">Tổng Booking</small>
          </div>
        </div>
        <?php if (isset($dashboardKPI['top_tour'])): ?>
        <div class="success-alert" style="margin-top: 20px;">
          <i class="fas fa-trophy"></i>
          <strong>Tour hiệu quả nhất:</strong> <?= htmlspecialchars($dashboardKPI['top_tour']) ?>
          (<?= number_format($dashboardKPI['top_tour_revenue']) ?> ₫)
        </div>
        <?php endif; ?>
      </div>

      <!-- Tabs -->
      <div class="tab-buttons">
        <button class="tab-btn active" onclick="switchTab(event, 'tour-report')">
          <i class="fas fa-list"></i> Chi Tiết Tour
        </button>
        <button class="tab-btn" onclick="switchTab(event, 'category-report')">
          <i class="fas fa-tag"></i> Theo Danh Mục
        </button>
        <button class="tab-btn" onclick="switchTab(event, 'conversion-report')">
          <i class="fas fa-chart-line"></i> Tỷ Lệ Chuyển Đổi
        </button>
        <button class="tab-btn" onclick="switchTab(event, 'chart-report')">
          <i class="fas fa-chart-bar"></i> Biểu Đồ
        </button>
      </div>

      <div class="tab-contents">
        
        <!-- Tab 1: Chi tiết tour -->
        <div class="tab-content active" id="tour-report">
          <div class="card">
            <div class="table-wrapper">
              <table>
                <thead>
                  <tr>
                    <th>Mã</th>
                    <th>Tên Tour</th>
                    <th>Danh Mục</th>
                    <th>Doanh Thu</th>
                    <th>Chi Phí</th>
                    <th>Lợi Nhuận</th>
                    <th>Tỷ Suất (%)</th>
                    <th>Booking</th>
                    <th>Khách</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($tours)): ?>
                    <?php foreach ($tours as $t): ?>
                    <?php 
                      $profit = $t['profit'] ?? 0;
                      $profitMargin = ($t['revenue'] ?? 0) > 0 ? (($profit / $t['revenue']) * 100) : 0;
                    ?>
                    <tr>
                      <td><?= htmlspecialchars($t['id'] ?? '') ?></td>
                      <td><?= htmlspecialchars($t['name'] ?? '') ?></td>
                      <td><?= htmlspecialchars($t['category_name'] ?? 'N/A') ?></td>
                      <td class="text-success"><?= number_format($t['revenue'] ?? 0) ?> ₫</td>
                      <td style="color: #dc3545;"><?= number_format($t['total_cost'] ?? 0) ?> ₫</td>
                      <td style="color: <?= $profit >= 0 ? '#28a745' : '#dc3545' ?>; font-weight: 600;">
                        <?= number_format($profit) ?> ₫
                      </td>
                      <td style="text-align: center;">
                        <span style="color: <?= $profitMargin >= 0 ? '#28a745' : '#dc3545' ?>; font-weight: 600;">
                          <?= number_format($profitMargin, 2) ?>%
                        </span>
                      </td>
                      <td style="text-align: center;"><?= $t['bookings'] ?? 0 ?></td>
                      <td style="text-align: center;"><?= $t['total_customers'] ?? 0 ?></td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="9" class="empty-message">
                        <i class="fa-solid fa-inbox"></i>
                        <div>Không có dữ liệu hiển thị</div>
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
                <?php if (!empty($tours)): ?>
                <tfoot style="background-color: #f8f9fa; font-weight: bold;">
                  <tr>
                    <td colspan="3" style="text-align: center;">TỔNG CỘNG</td>
                    <td class="text-success"><?= number_format($totalRevenue) ?> ₫</td>
                    <td style="color: #dc3545;"><?= number_format($totalCost) ?> ₫</td>
                    <td style="color: <?= $totalProfit >= 0 ? '#28a745' : '#dc3545' ?>;">
                      <?= number_format($totalProfit) ?> ₫
                    </td>
                    <td style="text-align: center;">
                      <?= $totalRevenue > 0 ? number_format(($totalProfit / $totalRevenue) * 100, 2) : '0.00' ?>%
                    </td>
                    <td style="text-align: center;"><?= array_sum(array_column($tours, 'bookings')) ?></td>
                    <td style="text-align: center;"><?= array_sum(array_column($tours, 'total_customers')) ?></td>
                  </tr>
                </tfoot>
                <?php endif; ?>
              </table>
            </div>
          </div>
        </div>

        <!-- Tab 2: Theo danh mục -->
        <div class="tab-content" id="category-report">
          <div class="card">
            <div class="table-wrapper">
              <table>
                <thead>
                  <tr>
                    <th>Danh Mục Tour</th>
                    <th>Số Tour</th>
                    <th>Số Booking</th>
                    <th>Số Khách</th>
                    <th>Doanh Thu</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($categoryStats)): ?>
                    <?php foreach ($categoryStats as $cat): ?>
                    <tr>
                      <td style="font-weight: 600;"><?= htmlspecialchars($cat['category_name'] ?? 'N/A') ?></td>
                      <td style="text-align: center;"><?= $cat['total_tours'] ?? 0 ?></td>
                      <td style="text-align: center;"><?= $cat['total_bookings'] ?? 0 ?></td>
                      <td style="text-align: center;"><?= $cat['total_customers'] ?? 0 ?></td>
                      <td class="text-success"><?= number_format($cat['revenue'] ?? 0) ?> ₫</td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="5" class="empty-message">
                        <i class="fa-solid fa-inbox"></i>
                        <div>Chưa có dữ liệu</div>
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>

          <?php if (!empty($categoryStats)): ?>
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
            <div class="chart-container">
              <canvas id="categoryRevenueChart"></canvas>
            </div>
            <div class="chart-container">
              <canvas id="categoryBookingChart"></canvas>
            </div>
          </div>
          <?php endif; ?>
        </div>

        <!-- Tab 3: Tỷ lệ chuyển đổi -->
        <div class="tab-content" id="conversion-report">
          <div class="card" style="margin-bottom: 20px;">
            <div style="padding: 20px;">
              <h5 style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #e0e0e0;">
                <i class="fas fa-chart-line"></i> Tỷ Lệ Chuyển Đổi Theo Tour
              </h5>
              <div class="table-wrapper">
                <table>
                  <thead>
                    <tr>
                      <th>Tên Tour</th>
                      <th>Danh Mục</th>
                      <th>Tổng Booking</th>
                      <th>Đã Hoàn Thành</th>
                      <th>Chờ Duyệt</th>
                      <th>Tỷ Lệ (%)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($conversionByTour)): ?>
                      <?php foreach ($conversionByTour as $item): ?>
                      <tr>
                        <td><?= htmlspecialchars($item['tour_name']) ?></td>
                        <td><?= htmlspecialchars($item['category_name'] ?? 'N/A') ?></td>
                        <td style="text-align: center;"><?= $item['total_bookings'] ?></td>
                        <td style="text-align: center; color: #28a745; font-weight: 600;"><?= $item['successful_bookings'] ?></td>
                        <td style="text-align: center; color: #ffc107; font-weight: 600;"><?= $item['pending_bookings'] ?></td>
                        <td style="text-align: center;">
                          <span style="display: inline-block; padding: 4px 12px; background: <?= $item['conversion_rate'] >= 50 ? '#d4edda' : '#fff3cd' ?>; color: <?= $item['conversion_rate'] >= 50 ? '#155724' : '#856404' ?>; border-radius: 4px; font-weight: 600;">
                            <?= number_format($item['conversion_rate'], 2) ?>%
                          </span>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="6" class="empty-message">
                          <i class="fa-solid fa-inbox"></i>
                          <div>Không có dữ liệu</div>
                        </td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="card">
            <div style="padding: 20px;">
              <h5 style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #e0e0e0;">
                <i class="fas fa-user-tie"></i> Hiệu Quả Theo Hướng Dẫn Viên
              </h5>
              <div class="table-wrapper">
                <table>
                  <thead>
                    <tr>
                      <th>Hướng Dẫn Viên</th>
                      <th>Tổng Booking</th>
                      <th>Đã Hoàn Thành</th>
                      <th>Chờ Duyệt</th>
                      <th>Doanh Thu</th>
                      <th>Tỷ Lệ (%)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($conversionByHDV)): ?>
                      <?php foreach ($conversionByHDV as $item): ?>
                      <tr>
                        <td style="font-weight: 600;"><?= htmlspecialchars($item['hdv_name']) ?></td>
                        <td style="text-align: center;"><?= $item['total_bookings'] ?></td>
                        <td style="text-align: center; color: #28a745; font-weight: 600;"><?= $item['successful_bookings'] ?></td>
                        <td style="text-align: center; color: #ffc107; font-weight: 600;"><?= $item['pending_bookings'] ?></td>
                        <td class="text-success"><?= number_format($item['total_revenue']) ?> ₫</td>
                        <td style="text-align: center;">
                          <span style="display: inline-block; padding: 4px 12px; background: <?= $item['conversion_rate'] >= 50 ? '#d4edda' : '#fff3cd' ?>; color: <?= $item['conversion_rate'] >= 50 ? '#155724' : '#856404' ?>; border-radius: 4px; font-weight: 600;">
                            <?= number_format($item['conversion_rate'], 2) ?>%
                          </span>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="6" class="empty-message">
                          <i class="fa-solid fa-inbox"></i>
                          <div>Không có dữ liệu</div>
                        </td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Tab 4: Biểu đồ -->
        <div class="tab-content" id="chart-report">
          <div class="chart-container" style="height: 400px;">
            <h5 style="text-align: center; margin-bottom: 20px;">Doanh Thu Top 5 Tour</h5>
            <canvas id="topToursChart"></canvas>
          </div>
        </div>
      </div>

      <div style="text-align: center; color: #999; margin-top: 30px; padding: 20px; background: white; border-radius: 8px;">
        <small>
          <?php 
          date_default_timezone_set('Asia/Ho_Chi_Minh');
          ?>
          <i class="fas fa-clock"></i> Báo cáo được tạo lúc: <?= date('d/m/Y H:i:s') ?>
          <?php if ($fromDate ?? false || $toDate ?? false): ?>
            | Khoảng thời gian: 
            <?= ($fromDate ?? false) ? date('d/m/Y', strtotime($fromDate)) : '...' ?> 
            đến 
            <?= ($toDate ?? false) ? date('d/m/Y', strtotime($toDate)) : '...' ?>
          <?php endif; ?>
        </small>
      </div>
    </div>
  </div>
</div>

<script>
// ==================== TAB SWITCHING ====================
function switchTab(event, tabId) {
  // Remove active from all buttons
  document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
  // Add active to clicked button
  event.currentTarget.classList.add('active');
  
  // Hide all tab contents
  document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
  // Show selected tab
  document.getElementById(tabId).classList.add('active');
  
  // Trigger chart resize
  setTimeout(() => window.dispatchEvent(new Event('resize')), 100);
}

// ==================== CHART DATA ====================
const tours = <?= json_encode($tours ?? []) ?>;
const categoryStats = <?= json_encode($categoryStats ?? []) ?>;

const top5Tours = tours.slice(0, 5);

// Biểu đồ 1: Top 5 tour theo doanh thu
if (tours.length > 0) {
  const ctx1 = document.getElementById('topToursChart');
  if (ctx1) {
    new Chart(ctx1, {
      type: 'bar',
      data: {
        labels: top5Tours.map(t => t.name),
        datasets: [{
          label: 'Doanh Thu (VNĐ)',
          data: top5Tours.map(t => t.revenue),
          backgroundColor: 'rgba(40, 167, 69, 0.7)',
          borderColor: 'rgba(40, 167, 69, 1)',
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: true },
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.dataset.label + ': ' + context.parsed.y.toLocaleString('vi-VN') + ' ₫';
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return (value / 1000000).toFixed(1) + 'M';
              }
            }
          }
        }
      }
    });
  }
}

// Biểu đồ 2 & 3: Phân bố theo danh mục
if (categoryStats.length > 0) {
  const ctx2 = document.getElementById('categoryRevenueChart');
  if (ctx2) {
    new Chart(ctx2, {
      type: 'pie',
      data: {
        labels: categoryStats.map(c => c.category_name),
        datasets: [{
          data: categoryStats.map(c => c.revenue),
          backgroundColor: [
            'rgba(40, 167, 69, 0.7)',
            'rgba(0, 123, 255, 0.7)',
            'rgba(255, 193, 7, 0.7)',
            'rgba(23, 162, 184, 0.7)',
            'rgba(220, 53, 69, 0.7)'
          ],
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          title: {
            display: true,
            text: 'Doanh Thu Theo Danh Mục'
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.label + ': ' + context.parsed.toLocaleString('vi-VN') + ' ₫';
              }
            }
          }
        }
      }
    });
  }

  const ctx3 = document.getElementById('categoryBookingChart');
  if (ctx3) {
    new Chart(ctx3, {
      type: 'doughnut',
      data: {
        labels: categoryStats.map(c => c.category_name),
        datasets: [{
          data: categoryStats.map(c => c.total_bookings),
          backgroundColor: [
            'rgba(40, 167, 69, 0.7)',
            'rgba(0, 123, 255, 0.7)',
            'rgba(255, 193, 7, 0.7)',
            'rgba(23, 162, 184, 0.7)',
            'rgba(220, 53, 69, 0.7)'
          ],
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          title: {
            display: true,
            text: 'Booking Theo Danh Mục'
          }
        }
      }
    });
  }
}
</script>
</body>
</html>
