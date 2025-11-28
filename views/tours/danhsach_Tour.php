<?php
// Định nghĩa module hiện tại
$currentModule = 'tour';

// Include sidedieu-huongbar
include './views/chung/dieu-huong.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Tour</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./views/tours/css/danhsach_Tour.css" />
</head>
<body>
  <div class="content-wrapper">
    <div class="content-container">
      <div class="header">
        <div>
          <h1>Danh sách Tour</h1>
        </div>
      </div>

      <!-- Search section -->
      <div class="search-section">
        <div class="search-group">
          <label for="quick-search">Tìm kiếm nhanh:</label>
          <input type="text" id="quick-search" placeholder="Nhập tên tour, tên danh mục">
        </div>
        <button class="btn-advanced-search" onclick="openAdvancedSearch()">
          <i class="fas fa-sliders-h"></i> Tìm kiếm chi tiết
        </button>
        <button class="btn-reset" onclick="resetSearch()">
          <i class="fas fa-redo"></i> Đặt lại
        </button>
        <button class="btn-add-tour">
          <a href="index.php?act=view-them-tour" style="color: white; text-decoration: none;">
            <i class="fas fa-plus"></i> Thêm tour
          </a>
        </button>
      </div>

    <div class="main-wrapper">
        <div class="card">      
            <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Tour</th>
                    <th>Danh Mục</th>
                    <th>Ngày tạo</th>
                    <th>Trạng thái</th>                    
                    <th>Hành động</th>  
                </tr>
                </thead>
                <tbody id="tour-table"></tbody>
            </table>
            </div>
        </div>
    </div>

      <!-- Advanced search modal -->
      <div id="advancedSearchModal" class="modal">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Tìm kiếm chi tiết</h2>
            <span class="close-modal" onclick="closeAdvancedSearch()">&times;</span>
          </div>
          <form id="advancedSearchForm" onsubmit="performAdvancedSearch(event)">
            <div class="search-form-group">
              <label for="search-name">Tên Tour:</label>
              <input type="text" id="search-name" placeholder="Nhập tên tour">
            </div>
            <div class="search-form-group">
              <label for="search-category">Danh mục:</label>
              <select id="search-category">
                <option value="">-- Tất cả --</option>
                <?php
                  $danhMuc = (new TourController())->getAllDanhMucTour();
                  foreach ($danhMuc as $dm) {
                      echo '<option value="' . htmlspecialchars($dm['id']) . '">' . htmlspecialchars($dm['ten']) . '</option>';
                  };
                ?>
              </select>
            </div>
            <div class="search-form-group">
              <label for="search-status">Trạng thái:</label>
              <select id="search-status">
                <option value="">-- Tất cả --</option>
                <option value="Đang hoạt động">Đang hoạt động</option>
                <option value="Không hoạt động">Không hoạt động</option>
              </select>
            </div>
            <div class="search-form-group">
              <label for="search-price-min">Giá từ (VNĐ):</label>
              <input type="number" id="search-price-min" placeholder="0">
            </div>
            <div class="search-form-group">
              <label for="search-price-max">Giá đến (VNĐ):</label>
              <input type="number" id="search-price-max" placeholder="500 Tỷ">
            </div>
            <div class="modal-buttons">
              <button type="submit" class="btn-search-submit">Tìm kiếm</button>
              <button type="button" class="btn-search-cancel" onclick="closeAdvancedSearch()">Hủy</button>
            </div>
          </form>
        </div>
      </div>

  <?php
  $__tours_data = isset($tours) ? $tours : array();
  $__chinh_sach_data = (new TourController())->getAllChinhSach();
  ?>

<script>
    // ==================== KHAI BÁO DỮ LIỆU ====================
    const tours = <?php echo json_encode($__tours_data, JSON_UNESCAPED_UNICODE); ?> || [];
    const chinhSach = <?php echo json_encode($__chinh_sach_data, JSON_UNESCAPED_UNICODE); ?> || [];
    let allChinhSach = [...chinhSach];
    let allTours = [...tours];
    const tableBody = document.getElementById("tour-table");
    const quickSearchInput = document.getElementById("quick-search");

    // ==================== HELPER FUNCTIONS ====================
    function htmlEscape(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function xoaTour(id) {
        return confirm('Bạn có chắc muốn xóa tour này không?');
    }

    // ==================== TÌM KIẾM NHANH ====================
    quickSearchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        if (searchTerm === '') {
            renderTours(allTours);
        } else {
            const filtered = allTours.filter(t => {
                const ten = (t.ten || '').toLowerCase();
                const danhMuc = (t.danh_muc_ten || '').toLowerCase();
                return ten.includes(searchTerm) || danhMuc.includes(searchTerm);
            });
            renderTours(filtered);
        }
    });

    // ==================== TÌM KIẾM NÂNG CAO ====================
    function openAdvancedSearch() {
        document.getElementById('advancedSearchModal').classList.add('active');
    }

    function closeAdvancedSearch() {
        document.getElementById('advancedSearchModal').classList.remove('active');
        closeAdvancedSearch();
    }

    function performAdvancedSearch(event) {
        event.preventDefault();
        
        const searchTen = document.getElementById('search-name').value.toLowerCase().trim();
        const searchDanhMuc = document.getElementById('search-category').value;
        const searchTrangThai = document.getElementById('search-status').value;
        const searchGiaMin = parseInt(document.getElementById('search-price-min').value) || 0;
        const searchGiaMax = parseInt(document.getElementById('search-price-max').value) || 500000000000;

        const filtered = allTours.filter(t => {
            const tTen = (t.ten || '').toLowerCase();
            const tDanhMuc = String(t.danhMuc_id || '');
            const tTrangThai = (t.trangThai || '').toLowerCase();
            const tGia = t.gia !== null && t.gia !== undefined ? parseInt(t.gia) : 0;

            return (searchTen === '' || tTen.includes(searchTen)) &&
                    (searchDanhMuc === '' || tDanhMuc === searchDanhMuc) &&
                    (searchTrangThai === '' || tTrangThai === searchTrangThai.toLowerCase()) &&
                    (tGia >= searchGiaMin && tGia <= searchGiaMax);
        });
        
        renderTours(filtered);
        closeAdvancedSearch();
    }

    function resetSearch() {
        quickSearchInput.value = '';
        document.getElementById('search-name').value = '';
        document.getElementById('search-category').value = '';
        document.getElementById('search-status').value = '';
        document.getElementById('search-price-min').value = '';
        document.getElementById('search-price-max').value = '';
        renderTours(allTours);
    }

    // ==================== RENDER BẢNG TOUR ====================
    function renderTours(toursToRender) {
        tableBody.innerHTML = '';

        if (toursToRender.length === 0) {
            tableBody.innerHTML = `
                <tr>
                <td colspan="6" class="empty-message">
                    <i class="fa-solid fa-inbox"></i>
                    <div>Không có dữ liệu tour</div>
                </td>
                </tr>
            `;
        } else {
            toursToRender.forEach(t => {
                const row = document.createElement("tr");
                const createdDate = t.tgTao ? new Date(t.tgTao).toLocaleDateString('vi-VN') : '';
                row.innerHTML = `
                <td>${t.id ?? ''}</td>
                <td>${htmlEscape(t.ten ?? '')}</td>
                <td>${htmlEscape(t.danh_muc_ten ?? '')}</td>
                <td>${createdDate}</td>
                <td>${t.trangThai ?? ''}</td>
                <td class="actions">
                    <a href="javascript:void(0)" onclick="showDetailModal(${t.id})"><i class='fa-solid fa-map'></i></a>
                    <a href="index.php?act=view-cap-nhat-tour&id=${t.id}"><i class='fa-solid fa-pen'></i></a>
                    <a href="index.php?act=xoa-tour&id=${t.id}" class="delete" onclick="return xoaTour('${t.id}')"><i class='fa-solid fa-trash'></i></a>
                </td>
                `;
                tableBody.appendChild(row);
            });
        }
    }

    // Render initial list
    renderTours(allTours);

    // ==================== MODAL CHI TIẾT TOUR ====================
    function showDetailModal(tourId) {
        const tour = allTours.find(t => t.id === tourId);
        if (!tour) {
            alert('Không tìm thấy dữ liệu tour');
            return;
        }

        const statusClass = (tour.trangThai === 'Đang hoạt động') ? 'status-active' : 'status-inactive';
        const detailHTML = `
            <table>
                <colgroup class="detail-table-colgroup">
                    <col style="width:150px;">
                    <col style="width:auto;">
                </colgroup>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Tên Tour</td>
                    <td class="detail-table-value">${htmlEscape(tour.ten ?? '')}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Danh Mục</td>
                    <td class="detail-table-value">${htmlEscape(tour.danh_muc_ten ?? '')}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Giá</td>
                    <td class="detail-table-value">${(tour.gia ?? 0).toLocaleString('vi-VN')} VNĐ</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Ngày tạo</td>
                    <td class="detail-table-value">${tour.tgTao ? new Date(tour.tgTao).toLocaleDateString('vi-VN') : ''}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Ngày bắt đầu</td>
                    <td class="detail-table-value">${tour.tgBatDau ? new Date(tour.tgBatDau).toLocaleDateString('vi-VN') : ''}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Ngày kết thúc</td>
                    <td class="detail-table-value">${tour.tgKetThuc ? new Date(tour.tgKetThuc).toLocaleDateString('vi-VN') : ''}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Mô tả</td>
                    <td class="detail-table-value">${htmlEscape(tour.moTa ?? '')}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label"><a href="javascript:void(0)" onclick="showChinhSachModal(${tour.chinhSach_id})">Chính sách <i class="fas fa-info-circle"></i></a></td>
                    <td class="detail-table-value">${htmlEscape(tour.chinh_sach_ten ?? 'Không có')}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Trạng thái</td>
                    <td class="detail-table-value"><span class="status-badge ${statusClass}">${tour.trangThai ?? ''}</span></td>
                </tr>
            </table>
            <div class="detail-actions">
                <a href="index.php?act=view-cap-nhat-tour&id=${tour.id}">
                    <i class="fas fa-pen"></i> Chỉnh sửa
                </a>
                <button onclick="deleteAndClose(${tour.id})">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </div>
        `;

        document.getElementById('detailContent').innerHTML = detailHTML;
        document.getElementById('detailModal').classList.add('active');
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.remove('active');
    }

    function deleteAndClose(tourId) {
        if (confirm('Bạn có chắc muốn xóa tour này không?')) {
            window.location.href = 'index.php?act=xoa-tour&id=' + tourId;
        }
    }

    // ==================== MODAL CHỈ TIẾT CHÍNH SÁCH ====================
    function showChinhSachModal(chinhSachId) {
        const chinhSach = allChinhSach.find(cs => cs.id === chinhSachId);
        if (!chinhSach) {
            alert('Không tìm thấy dữ liệu chính sách');
            return;
        }        

        const detailHTML = `
            <table>
                <colgroup class="detail-table-colgroup">
                    <col style="width:150px;">
                    <col style="width:auto;">
                </colgroup>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Tên chính sách</td>
                    <td class="detail-table-value">${htmlEscape(chinhSach.ten ?? '')}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Chính sách giá</td>
                    <td class="detail-table-value">${htmlEscape(chinhSach.gia ?? '')}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Chính sách hoàn - hủy</td>
                    <td class="detail-table-value">${htmlEscape(chinhSach.hoanHuy ?? '')}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Chính sách đặt cọc - thanh toán</td>
                    <td class="detail-table-value">${htmlEscape(chinhSach.datCoc_thanhToan ?? '')}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Chính sách cho trẻ em</td>
                    <td class="detail-table-value">${htmlEscape(chinhSach.treEm ?? '')}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Chính sách bảo hiểm</td>
                    <td class="detail-table-value">${htmlEscape(chinhSach.baoHiem ?? '')}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Chính sách thay đổi dịch vụ</td>
                    <td class="detail-table-value">${htmlEscape(chinhSach.thayDoiDichVu ?? '')}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Chính sách bao gồm - không bao gồm</td>
                    <td class="detail-table-value">${htmlEscape(chinhSach.baoGom_khongBaoGom ?? '')}</td>
                </tr>
            </table>
        `;
        
        document.getElementById('chinhSachContent').innerHTML = detailHTML;
        document.getElementById('chinhSachModal').classList.add('active');
    }

    function closeChinhSachModal() {
        document.getElementById('chinhSachModal').classList.remove('active');
    }

    // ==================== EVENT LISTENERS ====================
    window.onclick = function(event) {
        const modal = document.getElementById('advancedSearchModal');
        if (event.target === modal) {
            modal.classList.remove('active');
        }
    }
</script>

  <!-- Detail Modal -->
  <div id="detailModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
      <div class="modal-header">
        <h2>Chi tiết Tours</h2>
        <span class="close-modal" onclick="closeDetailModal()">&times;</span>
      </div>
      <div id="detailContent">
        <!-- Content will be loaded here -->
      </div>
    </div>
  </div>

  <!-- Chính Sách Modal -->
  <div id="chinhSachModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
      <div class="modal-header">
        <h2>Chi tiết Chính sách</h2>
        <span class="close-modal" onclick="closeChinhSachModal()">&times;</span>
      </div>
      <div id="chinhSachContent">
        <!-- Content will be loaded here -->
      </div>
    </div>
  </div>

    </div>
  </div>
</body>
</html>