<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý yêu cầu đặc biệt</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="./views/chung/css/danhsach.css" />
  <style>
    .category-tabs {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }
    .category-tab {
      padding: 10px 20px;
      background: white;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s;
      font-weight: 600;
    }
    .category-tab:hover {
      border-color: #007bff;
    }
    .category-tab.active {
      background: #007bff;
      color: white;
      border-color: #007bff;
    }
    .category-tab .count {
      background: rgba(0,0,0,0.1);
      padding: 2px 8px;
      border-radius: 10px;
      font-size: 12px;
      margin-left: 5px;
    }
    .customer-list {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 20px;
    }
    .customer-card {
      background: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      border-left: 4px solid #6c757d;
    }
    .customer-card.food {
      border-left-color: #28a745;
    }
    .customer-card.medical {
      border-left-color: #dc3545;
    }
    .customer-card.mobility {
      border-left-color: #ffc107;
    }
    .customer-card.other {
      border-left-color: #17a2b8;
    }
    .customer-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 15px;
      padding-bottom: 10px;
      border-bottom: 2px solid #f0f0f0;
    }
    .customer-name {
      font-size: 18px;
      font-weight: 600;
      color: #333;
    }
    .customer-meta {
      font-size: 13px;
      color: #666;
      margin-top: 5px;
    }
    .requirement-list {
      margin: 15px 0;
    }
    .requirement-item {
      background: #f8f9fa;
      padding: 12px;
      border-radius: 6px;
      margin-bottom: 10px;
      border-left: 3px solid #007bff;
    }
    .requirement-item.urgent {
      background: #fff3cd;
      border-left-color: #ffc107;
    }
    .requirement-item.critical {
      background: #f8d7da;
      border-left-color: #dc3545;
    }
    .requirement-category {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 12px;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      margin-bottom: 5px;
    }
    .cat-food {
      background: #d4edda;
      color: #155724;
    }
    .cat-medical {
      background: #f8d7da;
      color: #721c24;
    }
    .cat-mobility {
      background: #fff3cd;
      color: #856404;
    }
    .cat-other {
      background: #d1ecf1;
      color: #0c5460;
    }
    .requirement-text {
      color: #333;
      font-size: 14px;
      line-height: 1.6;
      margin: 5px 0;
    }
    .requirement-note {
      font-size: 12px;
      color: #666;
      font-style: italic;
      margin-top: 5px;
    }
    .action-buttons {
      display: flex;
      gap: 10px;
      margin-top: 15px;
    }
    .btn-action {
      flex: 1;
      padding: 8px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 13px;
      font-weight: 600;
    }
    .btn-edit {
      background: #007bff;
      color: white;
    }
    .btn-edit:hover {
      background: #0056b3;
    }
    .btn-add-note {
      background: #28a745;
      color: white;
    }
    .btn-add-note:hover {
      background: #218838;
    }
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
    }
    .modal.active {
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .modal-content {
      background: white;
      padding: 30px;
      border-radius: 8px;
      max-width: 600px;
      width: 90%;
      max-height: 90vh;
      overflow-y: auto;
    }
    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 2px solid #e0e0e0;
    }
    .close-modal {
      font-size: 30px;
      color: #999;
      cursor: pointer;
    }
    .close-modal:hover {
      color: #333;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: #333;
    }
    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 14px;
    }
    .form-group textarea {
      min-height: 100px;
      resize: vertical;
    }
    .checkbox-group {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .checkbox-item {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .summary-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
      margin-bottom: 20px;
    }
    .summary-card {
      background: white;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .summary-number {
      font-size: 36px;
      font-weight: 700;
      margin-bottom: 5px;
    }
    .summary-label {
      font-size: 13px;
      color: #666;
      text-transform: uppercase;
    }
  </style>
</head>
<body>
<div class="content-wrapper">
  <div class="content-container">
    <div class="header">
      <div>
        <h1>Yêu cầu đặc biệt của khách</h1>
      </div>
    </div>

    <!-- Search section -->
    <div class="search-section">
      <div class="search-group">
        <input type="text" id="search-customer" placeholder="Tìm kiếm khách hàng..." onkeyup="searchCustomer()">
      </div>
      <button class="btn-reset" onclick="window.location.href='?act=hdv-chi-tiet-tour&id=<?= $_GET['id'] ?? 2 ?>'">
        <i class="fas fa-arrow-left"></i> Quay lại
      </button>
      <button class="btn-add-item" onclick="openAddModal()">
        <i class="fas fa-plus"></i> Thêm yêu cầu mới
      </button>
    </div>

    <?php
    // Data from controller: $tour, $customers (with requirements nested)
    // No mock data - all data fetched from database
    
    // Count by category
    $categoryCount = ['all' => 0, 'food' => 0, 'medical' => 0, 'mobility' => 0, 'other' => 0];
    if (!empty($customers) && is_array($customers)) {
      foreach ($customers as $customer) {
        if (!empty($customer['requirements']) && is_array($customer['requirements'])) {
          foreach ($customer['requirements'] as $req) {
            if (isset($req['category']) && isset($categoryCount[$req['category']])) {
              $categoryCount[$req['category']]++;
            }
            $categoryCount['all']++;
          }
        }
      }
    }
    ?>

    <!-- Tour Info -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
      <h2 style="margin: 0 0 5px 0; font-size: 20px;"><?= htmlspecialchars($tour['ten']) ?></h2>
      <p style="margin: 0; opacity: 0.9; font-size: 14px;"><i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($tour['tgBatDau'])) ?> - <?= date('d/m/Y', strtotime($tour['tgKetThuc'])) ?></p>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
      <div class="summary-card" style="border-top: 4px solid #007bff;">
        <div class="summary-number" style="color: #007bff;"><?= count($customers) ?></div>
        <div class="summary-label">Khách có yêu cầu</div>
      </div>
      <div class="summary-card" style="border-top: 4px solid #dc3545;">
        <div class="summary-number" style="color: #dc3545;"><?php 
          $criticalCount = 0;
          if (!empty($customers)) {
            foreach ($customers as $c) {
              if (!empty($c['requirements'])) {
                foreach ($c['requirements'] as $r) {
                  if (isset($r['priority']) && $r['priority'] === 'critical') $criticalCount++;
                }
              }
            }
          }
          echo $criticalCount;
        ?></div>
        <div class="summary-label">ƯU tiên cao</div>
      </div>
      <div class="summary-card" style="border-top: 4px solid #28a745;">
        <div class="summary-number" style="color: #28a745;"><?= $categoryCount['food'] ?></div>
        <div class="summary-label">Yêu cầu ăn uống</div>
      </div>
      <div class="summary-card" style="border-top: 4px solid #ffc107;">
        <div class="summary-number" style="color: #ffc107;"><?= $categoryCount['medical'] ?></div>
        <div class="summary-label">Y tế / Sức khỏe</div>
      </div>
    </div>

    <!-- Category Filter -->
    <div class="category-tabs">
      <div class="category-tab active" onclick="filterCategory('all')">
        <i class="fas fa-list"></i> Tất cả
        <span class="count"><?= $categoryCount['all'] ?></span>
      </div>
      <div class="category-tab" onclick="filterCategory('food')">
        <i class="fas fa-utensils"></i> Ăn uống
        <span class="count"><?= $categoryCount['food'] ?></span>
      </div>
      <div class="category-tab" onclick="filterCategory('medical')">
        <i class="fas fa-heart-pulse"></i> Y tế
        <span class="count"><?= $categoryCount['medical'] ?></span>
      </div>
      <div class="category-tab" onclick="filterCategory('mobility')">
        <i class="fas fa-wheelchair"></i> Di chuyển
        <span class="count"><?= $categoryCount['mobility'] ?></span>
      </div>
      <div class="category-tab" onclick="filterCategory('other')">
        <i class="fas fa-ellipsis-h"></i> Khác
        <span class="count"><?= $categoryCount['other'] ?></span>
      </div>
    </div>

    <div class="main-wrapper">
      <!-- Customer List -->
      <div class="customer-list" id="customer-list">
        <?php if (empty($customers)): ?>
          <div style="text-align: center; padding: 60px; color: #999;">
            <i class="fas fa-inbox" style="font-size: 60px; margin-bottom: 20px; opacity: 0.3;"></i>
            <h3>Chưa có yêu cầu đặc biệt nào</h3>
            <p>Khách hàng chưa có yêu cầu đặc biệt nào cho tour này.</p>
          </div>
        <?php else: ?>
        <?php foreach ($customers as $customer): ?>
        <div class="customer-card" data-customer="<?= strtolower($customer['ten']) ?>">
          <div class="customer-header">
            <div>
              <div class="customer-name"><?= htmlspecialchars($customer['ten']) ?></div>
              <div class="customer-meta">
                <i class="fas fa-<?= $customer['gioiTinh'] === 'Nam' ? 'mars' : 'venus' ?>"></i>
                <?= $customer['tuoi'] ?> tuổi | 
                <i class="fas fa-phone"></i> <?= htmlspecialchars($customer['dienThoai']) ?>
              </div>
            </div>
            <div>
              <span style="background: #007bff; color: white; padding: 5px 10px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                <?= count($customer['requirements']) ?> yêu cầu
              </span>
            </div>
          </div>

          <div class="requirement-list">
            <?php foreach ($customer['requirements'] as $req): ?>
            <div class="requirement-item <?= $req['priority'] ?>" data-category="<?= $req['category'] ?>">
              <span class="requirement-category cat-<?= $req['category'] ?>">
                <?php
                $icons = ['food' => 'utensils', 'medical' => 'heart-pulse', 'mobility' => 'wheelchair', 'other' => 'info-circle'];
                $labels = ['food' => 'Ăn uống', 'medical' => 'Y tế', 'mobility' => 'Di chuyển', 'other' => 'Khác'];
                ?>
                <i class="fas fa-<?= $icons[$req['category']] ?>"></i> <?= $labels[$req['category']] ?>
              </span>
              <?php if ($req['priority'] === 'critical'): ?>
              <span style="background: #dc3545; color: white; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 700; margin-left: 5px;">QUAN TRỌNG</span>
              <?php endif; ?>
              <div class="requirement-text"><?= htmlspecialchars($req['text']) ?></div>
              <?php if (!empty($req['note'])): ?>
              <div class="requirement-note">
                <i class="fas fa-sticky-note"></i> <?= htmlspecialchars($req['note']) ?>
              </div>
              <?php endif; ?>
            </div>
            <?php endforeach; ?>
          </div>

          <div class="action-buttons">
            <button class="btn-action btn-edit" onclick="editRequirements(<?= $customer['id'] ?>)">
              <i class="fas fa-edit"></i> Chỉnh sửa
            </button>
            <button class="btn-action btn-add-note" onclick="addNote(<?= $customer['id'] ?>)">
              <i class="fas fa-plus"></i> Thêm ghi chú
            </button>
          </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Add/Edit Modal -->
<div id="requirementModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 id="modal-title">Thêm yêu cầu đặc biệt</h2>
      <span class="close-modal" onclick="closeModal()">&times;</span>
    </div>
    <form id="requirementForm" onsubmit="saveRequirement(event)">
      <div class="form-group">
        <label>Khách hàng:</label>
        <select id="customer-select" required>
          <option value="">-- Chọn khách hàng --</option>
          <?php if (!empty($customers)): ?>
          <?php foreach ($customers as $customer): ?>
          <option value="<?= $customer['id'] ?>"><?= htmlspecialchars($customer['ten']) ?></option>
          <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>

      <div class="form-group">
        <label>Loại yêu cầu:</label>
        <select id="requirement-category" required>
          <option value="food">Ăn uống</option>
          <option value="medical">Y tế / Sức khỏe</option>
          <option value="mobility">Di chuyển</option>
          <option value="other">Khác</option>
        </select>
      </div>

      <div class="form-group">
        <label>Mức độ ưu tiên:</label>
        <select id="requirement-priority" required>
          <option value="normal">Bình thường</option>
          <option value="urgent">Quan trọng</option>
          <option value="critical">Rất quan trọng</option>
        </select>
      </div>

      <div class="form-group">
        <label>Mô tả yêu cầu:</label>
        <textarea id="requirement-text" required placeholder="VD: Ăn chay, dị ứng hải sản..."></textarea>
      </div>

      <div class="form-group">
        <label>Ghi chú thêm (tùy chọn):</label>
        <textarea id="requirement-note" placeholder="Các thông tin bổ sung..."></textarea>
      </div>

      <div class="form-actions">
        <button type="button" class="btn-cancel" onclick="closeModal()">Hủy</button>
        <button type="submit" class="btn-submit">
          <i class="fas fa-save"></i> Lưu yêu cầu
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function filterCategory(category) {
  // Update active tab
  document.querySelectorAll('.category-tab').forEach(tab => tab.classList.remove('active'));
  event.target.closest('.category-tab').classList.add('active');

  // Filter requirements
  const items = document.querySelectorAll('.requirement-item');
  items.forEach(item => {
    if (category === 'all' || item.dataset.category === category) {
      item.style.display = 'block';
    } else {
      item.style.display = 'none';
    }
  });
}

function searchCustomer() {
  const query = document.getElementById('search-customer').value.toLowerCase();
  const cards = document.querySelectorAll('.customer-card');
  
  cards.forEach(card => {
    const name = card.dataset.customer;
    if (name.includes(query)) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
}

function openAddModal() {
  document.getElementById('modal-title').textContent = 'Thêm yêu cầu đặc biệt';
  document.getElementById('requirementForm').reset();
  document.getElementById('requirementModal').classList.add('active');
}

function closeModal() {
  document.getElementById('requirementModal').classList.remove('active');
}

function editRequirements(customerId) {
  alert('Chỉnh sửa yêu cầu của khách #' + customerId);
  // TODO: Load and edit
}

function addNote(customerId) {
  alert('Thêm ghi chú cho khách #' + customerId);
  // TODO: Implement
}

function saveRequirement(event) {
  event.preventDefault();
  alert('Đã lưu yêu cầu đặc biệt!');
  closeModal();
  // TODO: Send to backend
}

// Close modal when clicking outside
window.onclick = function(event) {
  const modal = document.getElementById('requirementModal');
  if (event.target === modal) {
    closeModal();
  }
}
</script>

</body>
</html>
