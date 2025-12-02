<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Điểm danh khách hàng</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="./views/chung/css/danhsach.css" />
  <style>
    .checkpoint-tabs {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
      overflow-x: auto;
      white-space: nowrap;
      padding-bottom: 10px;
    }
    .checkpoint-tab {
      padding: 12px 20px;
      background: white;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s;
      flex-shrink: 0;
    }
    .checkpoint-tab:hover {
      border-color: #007bff;
    }
    .checkpoint-tab.active {
      background: #007bff;
      color: white;
      border-color: #007bff;
    }
    .checkpoint-tab.completed {
      background: #28a745;
      color: white;
      border-color: #28a745;
    }
    .checkpoint-info {
      background: white;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .customer-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 15px;
    }
    .customer-card {
      background: white;
      border-radius: 8px;
      padding: 15px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      border-left: 4px solid #6c757d;
      transition: all 0.3s;
    }
    .customer-card.checked-in {
      border-left-color: #28a745;
      background: #f8fff9;
    }
    .customer-card.absent {
      border-left-color: #dc3545;
      background: #fff8f8;
    }
    .customer-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 10px;
    }
    .customer-name {
      font-size: 16px;
      font-weight: 600;
      color: #333;
    }
    .customer-info {
      font-size: 13px;
      color: #666;
      margin: 5px 0;
    }
    .check-status {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }
    .btn-check {
      flex: 1;
      padding: 8px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 13px;
      font-weight: 600;
      transition: all 0.3s;
    }
    .btn-present {
      background: #28a745;
      color: white;
    }
    .btn-present:hover {
      background: #218838;
    }
    .btn-absent {
      background: #dc3545;
      color: white;
    }
    .btn-absent:hover {
      background: #c82333;
    }
    .btn-uncheck {
      background: #6c757d;
      color: white;
    }
    .btn-uncheck:hover {
      background: #5a6268;
    }
    .summary-stats {
      display: flex;
      gap: 15px;
      margin-bottom: 20px;
    }
    .stat-card {
      flex: 1;
      background: white;
      padding: 15px;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .stat-number {
      font-size: 32px;
      font-weight: 700;
      margin-bottom: 5px;
    }
    .stat-label {
      font-size: 13px;
      color: #666;
      text-transform: uppercase;
    }
    .stat-card.total {
      border-top: 4px solid #007bff;
    }
    .stat-card.present {
      border-top: 4px solid #28a745;
    }
    .stat-card.present .stat-number {
      color: #28a745;
    }
    .stat-card.absent {
      border-top: 4px solid #dc3545;
    }
    .stat-card.absent .stat-number {
      color: #dc3545;
    }
    .stat-card.pending {
      border-top: 4px solid #ffc107;
    }
    .stat-card.pending .stat-number {
      color: #ffc107;
    }
    .time-display {
      font-size: 24px;
      font-weight: 600;
      color: #007bff;
      text-align: center;
      padding: 15px;
      background: white;
      border-radius: 8px;
      margin-bottom: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .note-section {
      background: #fff3cd;
      padding: 15px;
      border-radius: 8px;
      border-left: 4px solid #ffc107;
      margin-bottom: 20px;
    }
    .note-section h4 {
      margin: 0 0 10px 0;
      color: #856404;
    }
  </style>
</head>
<body>
<div class="content-wrapper">
  <div class="content-container">
    <div class="header">
      <div>
        <h1>Điểm danh khách hàng</h1>
      </div>
    </div>

    <!-- Search section -->
    <div class="search-section">
      <button class="btn-reset" onclick="window.location.href='?act=hdv-chi-tiet-tour&id=<?= $_GET['id'] ?? 2 ?>'">
        <i class="fas fa-arrow-left"></i> Quay lại
      </button>
      <button class="btn-advanced-search" onclick="completeCheckpoint()">
        <i class="fas fa-check-double"></i> Hoàn tất điểm danh
      </button>
    </div>

    <?php
    // Data from controller: $tour, $checkpoints, $customers, $activeCheckpoint
    // No mock data - all data fetched from database
    ?>

    <!-- Tour Info -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
      <h2 style="margin: 0 0 5px 0; font-size: 20px;"><?= htmlspecialchars($tour['ten']) ?></h2>
      <p style="margin: 0; opacity: 0.9; font-size: 14px;"><i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($tour['tgBatDau'])) ?> - <?= date('d/m/Y', strtotime($tour['tgKetThuc'])) ?></p>
    </div>

    <!-- Time Display -->
    <div class="time-display">
      <i class="fas fa-clock"></i> <span id="current-time"></span>
    </div>

    <!-- Checkpoint Tabs -->
    <?php if (!empty($checkpoints)): ?>
    <div class="checkpoint-tabs">
      <?php foreach ($checkpoints as $cp): ?>
      <div class="checkpoint-tab <?= $cp['status'] ?>" 
           onclick="selectCheckpoint(<?= $cp['id'] ?>)">
        <div style="font-weight: 600; margin-bottom: 5px;">
          <?php if ($cp['status'] === 'completed'): ?>
            <i class="fas fa-check-circle"></i>
          <?php elseif ($cp['status'] === 'active'): ?>
            <i class="fas fa-circle"></i>
          <?php else: ?>
            <i class="far fa-circle"></i>
          <?php endif; ?>
          <?= htmlspecialchars($cp['name']) ?>
        </div>
        <div style="font-size: 12px; opacity: 0.9;">
          <i class="fas fa-clock"></i> <?= htmlspecialchars($cp['time']) ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div style="background: #fff3cd; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #ffc107;">
      <p style="margin: 0; color: #856404;"><i class="fas fa-info-circle"></i> <strong>Chưa có checkpoint nào.</strong> Cần chạy migration để tạo checkpoint cho tour này.</p>
    </div>
    <?php endif; ?>

    <!-- Active Checkpoint Info -->
    <div class="checkpoint-info">
      <h3 style="margin: 0 0 10px 0;"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($activeCheckpoint['name']) ?></h3>
      <p style="margin: 5px 0; color: #666;">
        <i class="fas fa-clock"></i> Thời gian: <strong><?= htmlspecialchars($activeCheckpoint['time']) ?></strong>
      </p>
      <p style="margin: 5px 0; color: #666;">
        <i class="fas fa-location-dot"></i> Địa điểm: <strong><?= htmlspecialchars($activeCheckpoint['location']) ?></strong>
      </p>
    </div>

    <?php if (!empty(array_filter($customers, fn($c) => !empty($c['ghiChu'])))): ?>
    <!-- Special Notes -->
    <div class="note-section">
      <h4><i class="fas fa-exclamation-triangle"></i> Lưu ý đặc biệt:</h4>
      <ul style="margin: 0; padding-left: 20px;">
        <?php foreach ($customers as $customer): ?>
          <?php if (!empty($customer['ghiChu'])): ?>
          <li><strong><?= htmlspecialchars($customer['ten']) ?>:</strong> <?= htmlspecialchars($customer['ghiChu']) ?></li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>

    <!-- Statistics -->
    <div class="summary-stats">
      <div class="stat-card total">
        <div class="stat-number" id="total-count"><?= count($customers) ?></div>
        <div class="stat-label">Tổng số khách</div>
      </div>
      <div class="stat-card present">
        <div class="stat-number" id="present-count">0</div>
        <div class="stat-label">Đã có mặt</div>
      </div>
      <div class="stat-card absent">
        <div class="stat-number" id="absent-count">0</div>
        <div class="stat-label">Vắng mặt</div>
      </div>
      <div class="stat-card pending">
        <div class="stat-number" id="pending-count">0</div>
        <div class="stat-label">Chưa điểm danh</div>
      </div>
    </div>

    <div class="main-wrapper">
      <!-- Customer List -->
      <?php if (empty($customers)): ?>
        <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 8px; color: #999;">
          <i class="fas fa-users" style="font-size: 60px; margin-bottom: 20px; opacity: 0.3;"></i>
          <h3>Chưa có khách hàng nào</h3>
          <p>Tour này chưa có khách hàng đăng ký hoặc chưa có booking.</p>
        </div>
      <?php else: ?>
      <div class="customer-grid" id="customer-list">
        <?php foreach ($customers as $customer): ?>
        <div class="customer-card <?= $customer['checkin_status'] === 'present' ? 'checked-in' : ($customer['checkin_status'] === 'absent' ? 'absent' : '') ?>" 
             id="customer-<?= $customer['id'] ?>"
             data-status="<?= $customer['checkin_status'] ?? 'pending' ?>">
          <div class="customer-header">
            <div>
              <div class="customer-name"><?= htmlspecialchars($customer['ten']) ?></div>
              <div class="customer-info">
                <i class="fas fa-<?= $customer['gioiTinh'] === 'Nam' ? 'mars' : 'venus' ?>"></i>
                <?= $customer['tuoi'] ?> tuổi
              </div>
            </div>
            <div style="text-align: right;">
              <span class="status-badge" id="badge-<?= $customer['id'] ?>">
                <?php if ($customer['checkin_status'] === 'present'): ?>
                  <i class="fas fa-check-circle" style="color: #28a745;"></i>
                <?php elseif ($customer['checkin_status'] === 'absent'): ?>
                  <i class="fas fa-times-circle" style="color: #dc3545;"></i>
                <?php else: ?>
                  <i class="fas fa-clock" style="color: #ffc107;"></i>
                <?php endif; ?>
              </span>
            </div>
          </div>
          <div class="customer-info">
            <i class="fas fa-phone"></i> <?= htmlspecialchars($customer['dienThoai']) ?>
          </div>
          <?php if (!empty($customer['ghiChu'])): ?>
          <div class="customer-info" style="color: #dc3545; font-weight: 600;">
            <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($customer['ghiChu']) ?>
          </div>
          <?php endif; ?>
          <div style="display:flex;gap:10px;margin-top:10px;">
            <button onclick="markPresent(<?= $customer['id'] ?>)" style="flex:1;padding:10px;background:#28a745;color:#fff;border:none;border-radius:6px;cursor:pointer;font-size:14px;font-weight:600;font-family:Arial,sans-serif;">
              ✓ Có mặt
            </button>
            <button onclick="markAbsent(<?= $customer['id'] ?>)" style="flex:1;padding:10px;background:#dc3545;color:#fff;border:none;border-radius:6px;cursor:pointer;font-size:14px;font-weight:600;font-family:Arial,sans-serif;">
              ✗ Vắng
            </button>
            <button onclick="markPending(<?= $customer['id'] ?>)" style="flex:0.5;padding:10px;background:#6c757d;color:#fff;border:none;border-radius:6px;cursor:pointer;font-size:14px;font-weight:600;font-family:Arial,sans-serif;">
              ↻
            </button>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
// Update current time
function updateTime() {
  const now = new Date();
  const timeStr = now.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
  document.getElementById('current-time').textContent = timeStr;
}
setInterval(updateTime, 1000);
updateTime();

// Update statistics
function updateStats() {
  const cards = document.querySelectorAll('.customer-card');
  let present = 0, absent = 0, pending = 0;
  
  cards.forEach(card => {
    const status = card.dataset.status;
    if (status === 'present') present++;
    else if (status === 'absent') absent++;
    else pending++;
  });
  
  document.getElementById('present-count').textContent = present;
  document.getElementById('absent-count').textContent = absent;
  document.getElementById('pending-count').textContent = pending;
}

function markPresent(customerId) {
  saveCheckinStatus(customerId, 'present');
}

function markAbsent(customerId) {
  saveCheckinStatus(customerId, 'absent');
}

function markPending(customerId) {
  saveCheckinStatus(customerId, null);
}

function saveCheckinStatus(customerId, status) {
  const card = document.getElementById('customer-' + customerId);
  const badge = document.getElementById('badge-' + customerId);
  
  // Get active checkpoint (first checkpoint or from URL)
  const checkpointId = <?= !empty($checkpoints) ? $checkpoints[0]['id'] : 0 ?>;
  
  // Update UI immediately
  if (status === 'present') {
    card.className = 'customer-card checked-in';
    card.dataset.status = 'present';
    badge.innerHTML = '<i class="fas fa-check-circle" style="color: #28a745;"></i>';
  } else if (status === 'absent') {
    card.className = 'customer-card absent';
    card.dataset.status = 'absent';
    badge.innerHTML = '<i class="fas fa-times-circle" style="color: #dc3545;"></i>';
  } else {
    card.className = 'customer-card';
    card.dataset.status = 'pending';
    badge.innerHTML = '<i class="fas fa-clock" style="color: #ffc107;"></i>';
  }
  
  updateStats();
  
  // Send to backend
  fetch('index.php?act=api-save-checkin', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      donHangKhachHangId: customerId,
      checkpointId: checkpointId,
      status: status,
      hdvId: <?= $_SESSION['hdv_id'] ?? 5 ?>,
      tourId: <?= $tour_id ?>
    })
  })
  .then(response => {
    return response.text().then(text => {
      console.log('Raw response:', text);
      try {
        return JSON.parse(text);
      } catch (e) {
        console.error('JSON parse error:', e);
        console.error('Response was:', text);
        throw new Error('Server returned invalid JSON');
      }
    });
  })
  .then(data => {
    if (data.success) {
      console.log('Đã lưu điểm danh:', data);
      // Update stats from server if provided
      if (data.stats) {
        document.getElementById('present-count').textContent = data.stats.present || 0;
        document.getElementById('absent-count').textContent = data.stats.absent || 0;
        document.getElementById('pending-count').textContent = data.stats.pending || 0;
      }
    } else {
      alert('Lỗi khi lưu điểm danh: ' + (data.message || 'Unknown error'));
      // Revert UI on error
      location.reload();
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Có lỗi xảy ra khi lưu điểm danh! Chi tiết: ' + error.message);
    location.reload();
  });
}

function selectCheckpoint(checkpointId) {
  // Reload page with selected checkpoint
  window.location.href = `?act=hdv-diem-danh&id=<?= $tour_id ?>&checkpoint=${checkpointId}`;
}

function completeCheckpoint() {
  const pending = document.getElementById('pending-count').textContent;
  if (parseInt(pending) > 0) {
    if (!confirm(`Còn ${pending} khách chưa điểm danh. Bạn có chắc muốn hoàn tất không?`)) {
      return;
    }
  }
  
  // Mark checkpoint as completed
  const checkpointId = <?= !empty($checkpoints) ? $checkpoints[0]['id'] : 0 ?>;
  
  fetch('?act=api-complete-checkpoint', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      checkpointId: checkpointId,
      status: 'completed'
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Đã hoàn tất điểm danh checkpoint này!');
      // Reload to update checkpoint status
      location.reload();
    } else {
      alert('Lỗi: ' + (data.message || 'Không thể hoàn tất'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Có lỗi xảy ra!');
  });
}

// Initialize
updateStats();
</script>

</body>
</html>
