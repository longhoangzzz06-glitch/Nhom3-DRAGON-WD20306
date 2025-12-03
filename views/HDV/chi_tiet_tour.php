<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chi tiết Tour & Danh sách khách</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="./views/chung/css/danhsach.css" />
  <style>
    .tour-detail-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 30px;
      border-radius: 8px;
      margin-bottom: 20px;
    }
    .tour-detail-header h1 {
      margin: 0 0 10px 0;
      font-size: 28px;
    }
    .tour-detail-header p {
      margin: 5px 0;
      opacity: 0.9;
    }
    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 20px;
    }
    .info-card {
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      border-left: 4px solid #007bff;
    }
    .info-card h3 {
      margin: 0 0 15px 0;
      font-size: 16px;
      color: #666;
      text-transform: uppercase;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .info-card h3 i {
      color: #007bff;
    }
    .info-item {
      margin: 10px 0;
      display: flex;
      align-items: flex-start;
      gap: 10px;
    }
    .info-item i {
      width: 20px;
      color: #007bff;
      margin-top: 3px;
    }
    .itinerary-section {
      background: white;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
    .itinerary-section h2 {
      margin: 0 0 20px 0;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .day-item {
      border-left: 3px solid #007bff;
      padding-left: 20px;
      margin-bottom: 25px;
      position: relative;
    }
    .day-item::before {
      content: '';
      position: absolute;
      left: -8px;
      top: 5px;
      width: 13px;
      height: 13px;
      background: #007bff;
      border-radius: 50%;
      border: 3px solid white;
      box-shadow: 0 0 0 2px #007bff;
    }
    .day-title {
      font-size: 18px;
      font-weight: 600;
      color: #333;
      margin-bottom: 10px;
    }
    .day-activities {
      color: #666;
      line-height: 1.8;
    }
    .customer-section {
      background: white;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .customer-section h2 {
      margin: 0 0 20px 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .customer-card {
      background: #f8f9fa;
      padding: 15px;
      border-radius: 6px;
      margin-bottom: 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: all 0.3s;
    }
    .customer-card:hover {
      background: #e9ecef;
      transform: translateX(5px);
    }
    .customer-info {
      flex: 1;
    }
    .customer-name {
      font-weight: 600;
      font-size: 16px;
      color: #333;
      margin-bottom: 5px;
    }
    .customer-details {
      display: flex;
      gap: 20px;
      font-size: 14px;
      color: #666;
    }
    .customer-status {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 5px;
    }
    .badge-checkin {
      padding: 4px 12px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: 600;
    }
    .badge-checked {
      background: #d4edda;
      color: #155724;
    }
    .badge-not-checked {
      background: #fff3cd;
      color: #856404;
    }
    .special-note {
      background: #fff3cd;
      padding: 3px 8px;
      border-radius: 4px;
      font-size: 12px;
      color: #856404;
    }
    .back-button {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 20px;
      background: white;
      color: #007bff;
      border: 2px solid #007bff;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
      margin-bottom: 20px;
      text-decoration: none;
    }
    .back-button:hover {
      background: #007bff;
      color: white;
    }
  </style>
</head>
<body>
<div class="content-wrapper">
  <div class="content-container">
    <div class="header">
      <div>
        <h1>Chi tiết Tour</h1>
      </div>
    </div>

    <!-- Search section -->
    <div class="search-section">
      <button class="btn-reset" onclick="window.location.href='?act=hdv-lich-lam-viec'">
        <i class="fas fa-arrow-left"></i> Quay lại
      </button>
      <button class="btn-advanced-search" onclick="window.location.href='?act=hdv-diem-danh&id=<?= $_GET['id'] ?? 2 ?>'">
        <i class="fas fa-clipboard-check"></i> Điểm danh
      </button>
      <button class="btn-advanced-search" onclick="window.location.href='?act=hdv-yeu-cau-dac-biet&id=<?= $_GET['id'] ?? 2 ?>'">
        <i class="fas fa-exclamation-circle"></i> Yêu cầu đặc biệt
      </button>
      <button class="btn-advanced-search" onclick="window.location.href='?act=hdv-nhat-ky-tour&id=<?= $_GET['id'] ?? 2 ?>'">
        <i class="fas fa-book"></i> Nhật ký
      </button>
      <button class="btn-advanced-search" onclick="window.location.href='?act=hdv-danh-gia-tour&id=<?= $_GET['id'] ?? 2 ?>'">
        <i class="fas fa-star"></i> Đánh giá
      </button>
    </div>

    <?php
    // Data from controller: $tour, $customers, $itinerary
    // No mock data - all data fetched from database
    ?>

    <!-- Tour Info Card -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 8px; margin-bottom: 20px;">
      <h2 style="margin: 0 0 10px 0; font-size: 24px;"><?= htmlspecialchars($tour['ten'] ?? '') ?></h2>
      <p style="margin: 5px 0; opacity: 0.9;"><i class="fas fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($tour['tgBatDau'])) ?> - <?= date('d/m/Y', strtotime($tour['tgKetThuc'])) ?></p>
      <p style="margin: 5px 0; opacity: 0.9;"><i class="fas fa-tag"></i> Danh mục: <?= htmlspecialchars($tour['danhMuc'] ?? '') ?> | <i class="fas fa-money-bill-wave"></i> Giá: <?= number_format($tour['gia'], 0, ',', '.') ?> VNĐ</p>
    </div>

    <div class="main-wrapper">

    <!-- Tour Description -->
    <?php if (!empty($tour['moTa'])): ?>
    <div class="info-card" style="margin-bottom: 20px;">
      <h3><i class="fas fa-info-circle"></i> Mô tả Tour</h3>
      <div class="info-item">
        <span><?= htmlspecialchars($tour['moTa'] ?? '') ?></span>
      </div>
    </div>
    <?php endif; ?>

    <!-- Itinerary Section -->
    <div class="itinerary-section">
      <h2><i class="fas fa-route"></i> Lịch trình chi tiết</h2>
      <?php foreach ($itinerary as $day): ?>
      <div class="day-item">
        <div class="day-title">Ngày <?= $day['day'] ?>: <?= htmlspecialchars($day['title'] ?? '') ?></div>
        <div class="day-activities"><?= nl2br(htmlspecialchars($day['activities'] ?? '')) ?></div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Customer List Section -->
    <div class="customer-section">
      <h2>
        <span><i class="fas fa-users"></i> Danh sách khách tham gia (<?= count($customers) ?> người)</span>
      </h2>

      <?php foreach ($customers as $customer): ?>
      <div class="customer-card">
        <div class="customer-info">
          <div class="customer-name">
            <?= $customer['gioiTinh'] === 'Nam' ? '👨' : '👩' ?>
            <?= htmlspecialchars($customer['ten'] ?? '') ?>
          </div>
          <div class="customer-details">
            <span><i class="fas fa-birthday-cake"></i> <?= $customer['tuoi'] ?> tuổi</span>
            <span><i class="fas fa-phone"></i> <?= htmlspecialchars($customer['dienThoai'] ?? '') ?></span>
            <span><i class="fas fa-envelope"></i> <?= htmlspecialchars($customer['email'] ?? '') ?></span>
            <?php if (!empty($customer['soPhong'])): ?>
            <span><i class="fas fa-bed"></i> Phòng <?= htmlspecialchars($customer['soPhong'] ?? '') ?></span>
            <?php endif; ?>
          </div>
        </div>
        <div class="customer-status">
          <span class="badge-checkin <?= $customer['checkin'] ? 'badge-checked' : 'badge-not-checked' ?>">
            <i class="fas <?= $customer['checkin'] ? 'fa-check-circle' : 'fa-clock' ?>"></i>
            <?= $customer['checkin'] ? 'Đã check-in' : 'Chưa check-in' ?>
          </span>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  </div>
</div>

<script>
function exportCustomerList() {
  alert('Chức năng xuất danh sách đang phát triển');
}
</script>

</body>
</html>
