<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lịch làm việc của tôi</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="./views/chung/css/danhsach.css" />
  <style>
    .tour-list {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 20px;
    }
    .tour-card {
      background: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      border-left: 4px solid #2563eb;
      transition: all 0.3s;
      display: flex;
      flex-direction: column;
      height: 100%;
    }
    .tour-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }
    .tour-card.ongoing {
      border-left-color: #10b981;
    }
    .tour-card.upcoming {
      border-left-color: #ffc107;
    }
    .tour-card.completed {
      border-left-color: #6c757d;
    }
    .tour-title {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 10px;
      color: #333;
    }
    .tour-meta {
      display: flex;
      flex-direction: column;
      gap: 8px;
      color: #666;
      font-size: 14px;
    }
    .tour-meta-item {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .tour-meta-item i {
      width: 20px;
      color: #2563eb;
    }
    .tour-status {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: 600;
      margin-top: 10px;
      align-self: flex-start;
    }
    .status-ongoing {
      background: #d1fae5;
      color: #065f46;
    }
    .status-upcoming {
      background: #fff3cd;
      color: #856404;
    }
    .status-completed {
      background: #e2e3e5;
      color: #383d41;
    }
    .tour-actions {
      margin-top: auto;
      padding-top: 15px;
      display: flex;
      gap: 10px;
    }
    .btn-detail {
      flex: 1;
      padding: 8px;
      background: #2563eb;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
    }
    .btn-detail:hover {
      background: #1d4ed8;
    }
    .btn-diary {
      flex: 1;
      padding: 8px;
      background: #10b981;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
    }
    .btn-diary:hover {
      background: #059669;
    }
    .empty-state {
      text-align: center;
      padding: 60px 20px;
      color: #999;
    }
    .empty-state i {
      font-size: 60px;
      margin-bottom: 20px;
      opacity: 0.3;
    }
  </style>
</head>
<body>
<div class="content-wrapper">
  <div class="content-container">
    <div class="header">
      <div>
        <h1>Lịch làm việc của tôi</h1>
      </div>
    </div>

    <!-- Search section -->
    <div class="search-section">
      <div class="search-group">
        <label>Tháng hiện tại:</label>
        <div style="display: flex; gap: 10px; align-items: center;">
          <button onclick="changeMonth(-1)" style="padding: 8px 12px; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer;">
            <i class="fas fa-chevron-left"></i>
          </button>
          <h4 id="current-month" style="margin: 0; min-width: 120px; text-align: center;">Tháng 12/2025</h4>
          <button onclick="changeMonth(1)" style="padding: 8px 12px; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer;">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Filter Tabs -->
    <div style="background: white; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
      <div style="display: flex; gap: 15px;">
        <button class="tab-btn active" onclick="filterTours('all')" id="filter-all">
          <i class="fas fa-list"></i> Tất cả (<span id="count-all">0</span>)
        </button>
        <button class="tab-btn" onclick="filterTours('ongoing')" id="filter-ongoing">
          <i class="fas fa-play-circle"></i> Đang diễn ra (<span id="count-ongoing">0</span>)
        </button>
        <button class="tab-btn" onclick="filterTours('upcoming')" id="filter-upcoming">
          <i class="fas fa-clock"></i> Sắp diễn ra (<span id="count-upcoming">0</span>)
        </button>
        <button class="tab-btn" onclick="filterTours('completed')" id="filter-completed">
          <i class="fas fa-check-circle"></i> Đã hoàn thành (<span id="count-completed">0</span>)
        </button>
      </div>
    </div>

    <div class="main-wrapper">
      <!-- Tour List -->
      <div class="tour-list" id="tour-list">
        <!-- Tours will be loaded here by JavaScript -->
      </div>

      <!-- Empty State -->
      <div class="empty-state" id="empty-state" style="display: none;">
        <i class="fas fa-calendar-times"></i>
        <h3>Không có tour nào</h3>
        <p>Bạn chưa được phân công tour nào trong thời gian này.</p>
      </div>
    </div>
  </div>
</div>

<script>
// Tours data from database
const tours = <?= json_encode($tours ?? [], JSON_UNESCAPED_UNICODE) ?>;
let currentFilter = 'all';
let currentMonth = new Date();

function getStatus(startDate, endDate) {
  const today = new Date();
  const start = new Date(startDate);
  const end = new Date(endDate);
  
  today.setHours(0, 0, 0, 0);
  start.setHours(0, 0, 0, 0);
  end.setHours(0, 0, 0, 0);
  
  if (today >= start && today <= end) return 'ongoing';
  if (today < start) return 'upcoming';
  return 'completed';
}

function formatDate(dateStr) {
  const date = new Date(dateStr);
  return date.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' });
}

function calculateDays(startDate, endDate) {
  const start = new Date(startDate);
  const end = new Date(endDate);
  const diff = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
  return diff;
}

function isTourInMonth(dh, date) {
    const tourStart = new Date(dh.tgBatDau);
    const tourEnd = new Date(dh.tgKetThuc);
    const monthStart = new Date(date.getFullYear(), date.getMonth(), 1);
    const monthEnd = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    
    // Check overlap: start <= monthEnd AND end >= monthStart
    return tourStart <= monthEnd && tourEnd >= monthStart;
}

function updateMonthDisplay() {
    const monthNames = ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
        "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
    ];
    document.getElementById('current-month').textContent = `${monthNames[currentMonth.getMonth()]}/${currentMonth.getFullYear()}`;
}

function renderTours() {
  const container = document.getElementById('tour-list');
  const emptyState = document.getElementById('empty-state');
  
  // Filter by month first, then by status
  const toursInMonth = tours.filter(tour => isTourInMonth(tour, currentMonth));
  
  const filtered = toursInMonth.filter(tour => {
    if (currentFilter === 'all') return true;
    return getStatus(tour.tgBatDau, tour.tgKetThuc) === currentFilter;
  });
  
  // Update counts based on tours in the current month
  document.getElementById('count-all').textContent = toursInMonth.length;
  document.getElementById('count-ongoing').textContent = toursInMonth.filter(t => getStatus(t.tgBatDau, t.tgKetThuc) === 'ongoing').length;
  document.getElementById('count-upcoming').textContent = toursInMonth.filter(t => getStatus(t.tgBatDau, t.tgKetThuc) === 'upcoming').length;
  document.getElementById('count-completed').textContent = toursInMonth.filter(t => getStatus(t.tgBatDau, t.tgKetThuc) === 'completed').length;
  
  if (filtered.length === 0) {
    container.style.display = 'none';
    emptyState.style.display = 'block';
    // Update empty state message based on month
    const monthStr = `${currentMonth.getMonth() + 1}/${currentMonth.getFullYear()}`;
    emptyState.querySelector('p').textContent = `Bạn chưa được phân công tour nào trong tháng ${monthStr}.`;
    return;
  }
  
  container.style.display = 'grid';
  emptyState.style.display = 'none';
  
  container.innerHTML = filtered.map(tour => {
    const status = getStatus(tour.tgBatDau, tour.tgKetThuc);
    const statusClass = status === 'ongoing' ? 'status-ongoing' : status === 'upcoming' ? 'status-upcoming' : 'status-completed';
    const statusText = status === 'ongoing' ? 'Đang diễn ra' : status === 'upcoming' ? 'Sắp diễn ra' : 'Đã hoàn thành';
    const cardClass = status === 'ongoing' ? 'ongoing' : status === 'upcoming' ? 'upcoming' : 'completed';
    const days = calculateDays(tour.tgBatDau, tour.tgKetThuc);
    
    return `
      <div class="tour-card ${cardClass}">
        <div class="tour-title">${tour.ten}</div>
        <div class="tour-meta">
          <div class="tour-meta-item">
            <i class="fas fa-calendar"></i>
            <span>${formatDate(tour.tgBatDau)} - ${formatDate(tour.tgKetThuc)} (${days} ngày)</span>
          </div>
          <div class="tour-meta-item">
            <i class="fas fa-map-marker-alt"></i>
            <span>${tour.moTa}</span>
          </div>
          <div class="tour-meta-item">
            <i class="fas fa-tag"></i>
            <span>${tour.danhMuc}</span>
          </div>
          <div class="tour-meta-item">
            <i class="fas fa-users"></i>
            <span>${tour.customer_count} khách (${tour.booking_count} booking)</span>
          </div>
        </div>
        <span class="tour-status ${statusClass}">${statusText}</span>
        <div class="tour-actions">
          <button class="btn-detail" onclick="viewTourDetail(${tour.id})">
            <i class="fas fa-eye"></i> Xem chi tiết
          </button>
          <button class="btn-diary" onclick="viewTourDiary(${tour.id})">
            <i class="fas fa-book"></i> Nhật ký tour
          </button>
        </div>
      </div>
    `;
  }).join('');
}

function filterTours(filter) {
  currentFilter = filter;
  
  // Update active tab
  document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
  document.getElementById('filter-' + filter).classList.add('active');
  
  renderTours();
}

function viewTourDetail(tourId) {
  window.location.href = `?act=hdv-chi-tiet-tour&id=${tourId}`;
}

function viewTourDiary(tourId) {
  window.location.href = `?act=hdv-nhat-ky-tour&id=${tourId}`;
}

function changeMonth(delta) {
  currentMonth.setMonth(currentMonth.getMonth() + delta);
  updateMonthDisplay();
  renderTours();
}

// Initialize
updateMonthDisplay();
renderTours();
</script>

</body>
</html>
