<?php
// Định nghĩa module hiện tại
$currentModule = 'hdv';

// Include dieu-huong
include './views/chung/dieu-huong.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản lý Hướng dẫn viên</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./views/HDV/css/danhsach_HDV.css" />
</head>
<body>
  <div class="content-wrapper">
    <div class="content-container">
      <div class="header">
    <div>
      <h1>Danh sách Hướng dẫn viên</h1>
    </div>
  </div>

      <!-- Search section -->
      <div class="search-section">
        <div class="search-group">
          <label for="quick-search">Tìm kiếm nhanh:</label>
          <input type="text" id="quick-search" placeholder="Nhập tên, email, số điện thoại">
        </div>
        <button class="btn-advanced-search" onclick="openAdvancedSearch()">
          <i class="fas fa-sliders-h"></i> Tìm kiếm chi tiết
        </button>
        <button class="btn-reset" onclick="resetSearch()">
          <i class="fas fa-redo"></i> Đặt lại
        </button>
        <button class="btn-add-guide">
        <a href="index.php?act=view-them-hdv" style="color: white; text-decoration: none;">
            <i class="fas fa-plus"></i> Thêm hướng dẫn viên 
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
              <th>Ảnh</th>           
              <th>Họ tên</th> 
              <th>Điện thoại</th>
              <th>Email</th>
              <th>Trạng thái</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody id="guide-table"></tbody>
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
          <label for="search-name">Họ tên:</label>
          <input type="text" id="search-name" placeholder="Nhập họ tên">
        </div>
        <div class="search-form-group">
          <label for="search-phone">Số điện thoại:</label>
          <input type="text" id="search-phone" placeholder="Nhập số điện thoại">
        </div>        
        <div class="search-form-group">
          <label for="search-email">Email:</label>
          <input type="email" id="search-email" placeholder="Nhập email">
        </div>
        <div class="search-form-group">
          <label for="search-language">Ngôn ngữ:</label>
          <input type="text" id="search-language" placeholder="Nhập ngôn ngữ">
        </div>
        <div class="search-form-group">
          <label for="search-nhomhdv">Nhóm HDV:</label>
          <select id="search-nhomhdv">
            <option value="">-- Tất cả --</option>
            <?php
            $nhomList = (new HDVController())->getAllNhomHDV();
            foreach ($nhomList as $nhom) {
                echo '<option value="' . htmlspecialchars($nhom['id']) . '">' . htmlspecialchars($nhom['ten']) . '</option>';
            }?>
          </select>
        </div>        
        <div class="search-form-group">
          <label for="search-status">Trạng thái:</label>
          <select id="search-status">
            <option value="">-- Tất cả --</option>
            <option value="Đang Hoạt Động">Đang Hoạt Động</option>
            <option value="Không Hoạt Động">Không Hoạt Động</option>
          </select>
        </div>
        <div class="search-form-group">
          <label for="search-experience-min">Kinh nghiệm tối thiểu (năm):</label>
          <input type="number" id="search-experience-min" placeholder="0">
        </div>
        <div class="modal-buttons">
          <button type="submit" class="btn-search-submit">Tìm kiếm</button>
          <button type="button" class="btn-search-cancel" onclick="closeAdvancedSearch()">Hủy</button>
        </div>
      </form>
    </div>
  </div>

  <?php
    // Truyền dữ liệu HDV từ PHP sang JavaScript
    $__guides_data = isset($dsHDV) ? $dsHDV : array();
  ?>

  <script>
    const guides = <?php echo json_encode($__guides_data, JSON_UNESCAPED_UNICODE); ?> || [];

    let allHDV = [...guides];
    const tableBody = document.getElementById("guide-table");
    const quickSearchInput = document.getElementById("quick-search");

// Tìm kiếm nhanh
quickSearchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase().trim();
    
    if (searchTerm === '') {
    renderHDV(allHDV);
    } else {
    const filtered = allHDV.filter(g => {
        const hoTen = (g.hoTen || '').toLowerCase();
        const email = (g.email || '').toLowerCase();
        const dienThoai = (g.dienThoai || '').toLowerCase();
        return hoTen.includes(searchTerm) || 
                email.includes(searchTerm) || 
                dienThoai.includes(searchTerm);
    });
    renderHDV(filtered);
    }
});

// Tìm kiếm nâng cao
function openAdvancedSearch() {
    document.getElementById('advancedSearchModal').classList.add('active');
}

function closeAdvancedSearch() {
    document.getElementById('advancedSearchModal').classList.remove('active');
}

function performAdvancedSearch(event) {
    event.preventDefault();
    
    const searchHoTen = document.getElementById('search-name').value.toLowerCase().trim();
    const searchEmail = document.getElementById('search-email').value.toLowerCase().trim();
    const searchDienThoai = document.getElementById('search-phone').value.toLowerCase().trim();
    const searchNgonNgu = document.getElementById('search-language').value.toLowerCase().trim();
    const searchTrangThai = document.getElementById('search-status').value;
    const searchNhomHDV = document.getElementById('search-nhomhdv').value;  
    const experienceMin = parseInt(document.getElementById('search-experience-min').value) || 0;

    const filtered = allHDV.filter(g => {
        const gHoTen = (g.hoTen || '').toLowerCase();
        const gEmail = (g.email || '').toLowerCase();
        const gPhone = (g.dienThoai || '').toLowerCase();
        const gLanguage = (g.ngonNgu || '').toLowerCase();
        const gStatus = (g.trangThai || '');
        const gNhomHDV = String(g.nhomHDV_id || '');
        const gExperience = parseInt(g.kinhNghiem || 0);

        return (searchHoTen === '' || gHoTen.includes(searchHoTen)) &&
                (searchEmail === '' || gEmail.includes(searchEmail)) &&
                (searchDienThoai === '' || gPhone.includes(searchDienThoai)) &&
                (searchNgonNgu === '' || gLanguage.includes(searchNgonNgu)) &&
                (searchTrangThai === '' || gStatus.includes(searchTrangThai)) &&
                (searchNhomHDV === '' || gNhomHDV.includes(searchNhomHDV)) &&
                (gExperience >= experienceMin);
    });

    renderHDV(filtered);
    closeAdvancedSearch();
}

function resetSearch() {
    quickSearchInput.value = '';
    document.getElementById('search-name').value = '';
    document.getElementById('search-email').value = '';
    document.getElementById('search-phone').value = '';
    document.getElementById('search-language').value = '';
    document.getElementById('search-status').value = '';
    document.getElementById('search-nhomhdv').value = '';
    document.getElementById('search-experience-min').value = '';
    renderHDV(allHDV);
}

function renderHDV(guidesToRender) {
    tableBody.innerHTML = '';

    if (guidesToRender.length === 0) {
    tableBody.innerHTML = `
        <tr>
        <td colspan="13" class="empty-message">
            <i class="fa-solid fa-inbox"></i>
            <div>Không có dữ liệu hướng dẫn viên</div>
        </td>
        </tr>
    `;
    } else {
    guidesToRender.forEach(hdv => {
        const row = document.createElement("tr");
        const photoHtml = hdv.anh ? `<img src="./uploads/img_HDV/${hdv.anh}" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:6px">` : "";
        row.innerHTML = `
        <td>${hdv.id ?? ''}</td>
        <td>${photoHtml}</td>          
        <td>${hdv.hoTen ?? ''}</td>
        <td>${hdv.dienThoai ?? ''}</td>
        <td>${hdv.email ?? ''}</td>
        <td>${hdv.trangThai ?? ''}</td>
        <td class="actions">
            <a href="javascript:void(0)" onclick="showDetailModal(${hdv.id})"><i class='fa-solid fa-user'></i></a>
            <a href="index.php?act=view-cap-nhat-hdv&id=${hdv.id}"><i class='fa-solid fa-pen'></i></a>
            <a href="index.php?act=xoa-hdv&id=${hdv.id}" class="delete" onclick="return xoaHDV('${hdv.id}')"><i class='fa-solid fa-trash'></i></a>
        </td>
        `;
        tableBody.appendChild(row);
    });
    }

    document.getElementById("total-guides").innerText = guidesToRender.length;
}

// Xuất danh sách ban đầu
renderHDV(allHDV);

function xoaHDV(id) {
    return confirm('Bạn có chắc muốn xóa hướng dẫn viên này không?');
}

// Chi tiết modal functions
function showDetailModal(Id) {
    const hdv = allHDV.find(hdv => hdv.id === Id);
    if (!hdv) {
        alert('Không tìm thấy dữ liệu hướng dẫn viên');
        return;
    }
    const photoHtml = hdv.anh ? `<img src="./uploads/img_HDV/${hdv.anh}" alt="" style="width:100px;height:100px;object-fit:cover;border-radius:8px;">` : '<div style="width:100px;height:100px;background:#f3f4f6;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-user" style="font-size:36px;color:#9ca3af;"></i></div>';
    const statusClass = (hdv.trangThai === 'Đang Hoạt Động') ? 'status-active' : 'status-inactive';
    const detailHTML = `
        <div class="detail-header">
            <div>${photoHtml}</div>
            <div class="detail-info">
                <h3>${htmlEscape(hdv.hoTen ?? '')}</h3>
                <p><strong>Trạng thái:</strong> <span class="status-badge ${statusClass}">${hdv.trangThai ?? 'Không hoạt động'}</span></p>
                <p><strong>Điện thoại:</strong> ${htmlEscape(hdv.dienThoai ?? '')}</p>
                <p><strong>Email:</strong> ${htmlEscape(hdv.email ?? '')}</p>
            </div>
        </div>
        <table>
            <colgroup class="detail-table-colgroup">
                <col style="width:150px;">
                <col style="width:auto;">
            </colgroup>
            <tr class="detail-table-row">
                <td class="detail-table-label">ID</td>
                <td class="detail-table-value">${hdv.id ?? ''}</td>
            </tr>
            <tr class="detail-table-row">
                <td class="detail-table-label">Ngày sinh</td>
                <td class="detail-table-value">${hdv.ngaySinh ?? ''}</td>
            </tr>
            <tr class="detail-table-row">
                <td class="detail-table-label">Ngôn ngữ</td>
                <td class="detail-table-value">${htmlEscape(hdv.ngonNgu ?? '')}</td>
            </tr>
            <tr class="detail-table-row">
                <td class="detail-table-label">Kinh nghiệm</td>
                <td class="detail-table-value">${hdv.kinhNghiem ?? '0'} năm</td>
            </tr>
            <tr class="detail-table-row">
                <td class="detail-table-label">Nhóm</td>
                <td class="detail-table-value">${hdv.nhom_ten ?? ''}</td>
            </tr>            
            <tr class="detail-table-row">
                <td class="detail-table-label">Sức khỏe</td>
                <td class="detail-table-value">${htmlEscape(hdv.sucKhoe ?? '')}</td>
            </tr>
            <tr class="detail-table-row">
                <td class="detail-table-label">Trạng thái</td>
                <td class="detail-table-value"><span class="status-badge ${statusClass}">${hdv.trangThai ?? 'Không hoạt động'}</span></td>
            </tr>
        </table>

        <div class="detail-actions">
            <a href="index.php?act=view-cap-nhat-hdv&id=${hdv.id}">
                <i class="fas fa-pen"></i> Chỉnh sửa
            </a>
            <button onclick="deleteAndClose(${hdv.id})">
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

function deleteAndClose(Id) {
    if (confirm('Bạn có chắc muốn xóa hướng dẫn viên này không?')) {
        window.location.href = 'index.php?act=xoa-hdv&id=' + Id;
    }
}

function htmlEscape(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Đóng modal khi nhấp ra ngoài
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
        <h2>Chi tiết Hướng dẫn viên</h2>
        <span class="close-modal" onclick="closeDetailModal()">&times;</span>
      </div>
      <div id="detailContent" style="padding: 20px;">
        <!-- Content will be loaded here -->
      </div>
    </div>
  </div>

    </div>
  </div>
</body>
</html>
