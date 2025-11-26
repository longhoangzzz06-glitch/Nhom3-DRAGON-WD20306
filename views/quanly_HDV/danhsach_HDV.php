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
  <link rel="stylesheet" href="./views/quanly_HDV/css/danhsach_HDV.css" />
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

  <div class="card">
    <table>
      <thead>
        <tr>        
          <th>ID</th>
          <th>Ảnh</th>           
          <th>Họ tên</th>
          <th>Ngày sinh</th>
          <th>Điện thoại</th>
          <th>Email</th>
          <th>Ngôn ngữ</th>
          <th>Kinh nghiệm</th>
          <th>Tình trạng sức khỏe</th>
          <th>Trạng thái</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody id="guide-table"></tbody>
    </table>
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
          <label for="search-email">Email:</label>
          <input type="email" id="search-email" placeholder="Nhập email">
        </div>
        <div class="search-form-group">
          <label for="search-phone">Số điện thoại:</label>
          <input type="text" id="search-phone" placeholder="Nhập số điện thoại">
        </div>
        <div class="search-form-group">
          <label for="search-language">Ngôn ngữ:</label>
          <input type="text" id="search-language" placeholder="Nhập ngôn ngữ">
        </div>
        <div class="search-form-group">
          <label for="search-status">Trạng thái:</label>
          <select id="search-status">
            <option value="">-- Tất cả --</option>
            <option value="active">Đang hoạt động</option>
            <option value="inactive">Không hoạt động</option>
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

let allGuides = [...guides];
const tableBody = document.getElementById("guide-table");
const quickSearchInput = document.getElementById("quick-search");

// Tìm kiếm nhanh
quickSearchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase().trim();
    
    if (searchTerm === '') {
    renderGuides(allGuides);
    } else {
    const filtered = allGuides.filter(g => {
        const fullName = (g.full_name || g.name || '').toLowerCase();
        const email = (g.email || '').toLowerCase();
        const phone = (g.phone || '').toLowerCase();
                
        return fullName.includes(searchTerm) || 
                email.includes(searchTerm) || 
                phone.includes(searchTerm);
    });
    renderGuides(filtered);
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
    
    const name = document.getElementById('search-name').value.toLowerCase().trim();
    const email = document.getElementById('search-email').value.toLowerCase().trim();
    const phone = document.getElementById('search-phone').value.toLowerCase().trim();
    const language = document.getElementById('search-language').value.toLowerCase().trim();
    const status = document.getElementById('search-status').value;
    const experienceMin = parseInt(document.getElementById('search-experience-min').value) || 0;

    const filtered = allGuides.filter(g => {
    const fullName = (g.full_name || g.name || '').toLowerCase();
    const gEmail = (g.email || '').toLowerCase();
    const gPhone = (g.phone || '').toLowerCase();
    const gLanguage = (g.languages || '').toLowerCase();
    const gStatus = (g.status || '').toLowerCase();
    const gExperience = parseInt(g.experience_years || 0);

    return (name === '' || fullName.includes(name)) &&
            (email === '' || gEmail.includes(email)) &&
            (phone === '' || gPhone.includes(phone)) &&
            (language === '' || gLanguage.includes(language)) &&
            (status === '' || gStatus === status) &&
            (gExperience >= experienceMin);
    });

    renderGuides(filtered);
    closeAdvancedSearch();
}

function resetSearch() {
    quickSearchInput.value = '';
    document.getElementById('search-name').value = '';
    document.getElementById('search-email').value = '';
    document.getElementById('search-phone').value = '';
    document.getElementById('search-language').value = '';
    document.getElementById('search-status').value = '';
    document.getElementById('search-experience-min').value = '';
    renderGuides(allGuides);
}

function renderGuides(guidesToRender) {
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
    guidesToRender.forEach(g => {
        const row = document.createElement("tr");
        const photoHtml = g.photo ? `<img src="./uploads/img_HDV/${g.photo}" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:6px">` : "";
        row.innerHTML = `
        <td>${g.guide_id ?? g.id ?? ''}</td>
        <td>${photoHtml}</td>          
        <td>${g.full_name ?? g.name ?? ''}</td>
        <td>${g.birth_date}</td>
        <td>${g.phone ?? ''}</td>
        <td>${g.email ?? ''}</td>
        <td>${g.languages ?? ''}</td>
        <td>${g.experience_years ?? g.experience ?? ''}${(g.experience_years || g.experience) ? ' năm' : ''}</td>   
        <td>${g.health_status ?? ''}</td>
        <td>${g.status ?? ''}</td>
        <td class="actions">
            <a href="index.php?act=view-cap-nhat-hdv&id=${g.guide_id}"><i class='fa-solid fa-pen'></i></a>
            <a href="index.php?act=xoa-hdv&id=${g.guide_id}" class="delete" onclick="return deleteGuide('${g.guide_id}')"><i class='fa-solid fa-trash'></i></a>
        </td>
        `;
        tableBody.appendChild(row);
    });
    }

    document.getElementById("total-guides").innerText = guidesToRender.length;
}

// Xuất danh sách ban đầu
renderGuides(allGuides);

// Thống kê
const hasRating = allGuides.some(g => typeof g.rating === 'number');
if (hasRating && allGuides.length > 0) {
    const avg = (allGuides.reduce((sum, g) => sum + (g.rating || 0), 0) / allGuides.length).toFixed(1);
    document.getElementById("avg-rating").innerText = avg + "/5.0";
} else {
    document.getElementById("avg-rating").innerText = "N/A";
}
const activeSum = allGuides.reduce((sum, g) => sum + (g.activeToursCount || 0), 0);
document.getElementById("active-assignments").innerText = activeSum;

function deleteGuide(id) {
    return confirm('Bạn có chắc muốn xóa hướng dẫn viên này không?');
}

// Đóng modal khi nhấp ra ngoài
window.onclick = function(event) {
    const modal = document.getElementById('advancedSearchModal');
    if (event.target === modal) {
        modal.classList.remove('active');
    }
}
  </script>
    </div>
  </div>
</body>
</html>
