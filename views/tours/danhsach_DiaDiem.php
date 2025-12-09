<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Địa điểm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./views/chung/css/danhsach.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <style>
        .draggable-row {
            cursor: move;
        }
        .draggable-row:hover {
            background-color: #f8f9fa;
        }
        .sortable-ghost {
            opacity: 0.4;
            background-color: #c8ebfb;
        }
    </style>
</head>
<body>
  <div class="content-wrapper">
    <div class="content-container">
      <div class="header">
        <div>
          <h1>Danh sách Địa điểm</h1>
        </div>
      </div>

      <!-- Search section -->
      <div class="search-section">
        <div class="search-group">
          <label for="quick-search">Tìm kiếm nhanh:</label>
          <input type="text" id="quick-search" placeholder="Nhập tên địa điểm, tên tour">
        </div>
        <button class="btn-add-item">
          <a href="index.php?act=view-them-dia-diem" style="color: white; text-decoration: none;">
            <i class="fas fa-plus"></i> Thêm địa điểm
          </a>
        </button>
      </div>

    <div class="main-wrapper">
        <div class="card">      
            <div class="table-wrapper">
            <table id="main-table">
                <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>ID</th>
                    <th>Tên Địa điểm</th>
                    <th>Loại</th>
                    <th>Thời gian đi</th>
                    <th>Thời gian về</th>
                    <th>Trạng thái</th>                    
                    <th>Hành động</th>  
                </tr>
                </thead>
                <tbody id="diadiem-table-body-container">
                    <!-- Content will be rendered here -->
                </tbody>
            </table>
            </div>
        </div>
    </div>

  <?php
  $__diadiem_data = isset($listDiaDiem) ? $listDiaDiem : array();
  ?>

<script>
    // ==================== KHAI BÁO DỮ LIỆU ====================
    const diaDiemList = <?php echo json_encode($__diadiem_data, JSON_UNESCAPED_UNICODE); ?> || [];
    let allDiaDiem = [...diaDiemList];
    const mainTable = document.getElementById("main-table");
    const quickSearchInput = document.getElementById("quick-search");

    // ==================== HELPER FUNCTIONS ====================
    function htmlEscape(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function xoaDiaDiem(id) {
        return confirm('Bạn có chắc muốn xóa địa điểm này không?');
    }

    function getLoaiLabel(loai) {
        const map = {
            'destination': 'Điểm đến',
            'checkpoint': 'Điểm tập trung'
        };
        return map[loai] || loai;
    }

    function getTrangThaiLabel(status) {
        const map = {
            'pending': 'Chưa Hoàn Thành',
            'active': 'Hoạt động',
            'completed': 'Hoàn thành'
        };
        return map[status] || status;
    }

    // ==================== TÌM KIẾM NHANH ====================
    quickSearchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        if (searchTerm === '') {
            renderDiaDiem(allDiaDiem);
        } else {
            const filtered = allDiaDiem.filter(d => {
                const ten = (d.ten || '').toLowerCase();
                const tenTour = (d.ten_tour || '').toLowerCase();
                return ten.includes(searchTerm) || tenTour.includes(searchTerm);
            });
            renderDiaDiem(filtered);
        }
    });

    // ==================== RENDER BẢNG ĐỊA ĐIỂM ====================
    function renderDiaDiem(listToRender) {
        // Clear all existing tbodies to prevent duplicates and clear old data
        const existingTbodies = mainTable.querySelectorAll('tbody');
        existingTbodies.forEach(tbody => tbody.remove());

        if (listToRender.length === 0) {
            const tbody = document.createElement('tbody');
            tbody.innerHTML = `
                <tr>
                <td colspan="8" class="empty-message">
                    <i class="fa-solid fa-inbox"></i>
                    <div>Không có dữ liệu địa điểm</div>
                </td>
                </tr>
            `;
            mainTable.appendChild(tbody);
            return;
        }

        // Group by Tour AND Type
        const grouped = {};
        listToRender.forEach(item => {
            const tourName = item.ten_tour || 'Chưa gán';
            const type = item.loai || 'destination';
            
            if (!grouped[tourName]) {
                grouped[tourName] = {};
            }
            if (!grouped[tourName][type]) {
                grouped[tourName][type] = [];
            }
            grouped[tourName][type].push(item);
        });

        // Sort groups by name
        const sortedTourNames = Object.keys(grouped).sort();

        sortedTourNames.forEach(tourName => {
            // Header Row for Tour
            const tourHeaderRow = document.createElement('tr');
            tourHeaderRow.innerHTML = `
                <td colspan="8" style="background-color: #e9ecef; font-weight: bold; color: #495057; padding: 12px 15px; text-align: left;">
                    <i class="fas fa-map-marked-alt" style="margin-right: 8px;"></i> ${htmlEscape(tourName)}
                </td>
            `;
            
            const tourHeaderTbody = document.createElement('tbody');
            tourHeaderTbody.appendChild(tourHeaderRow);
            mainTable.appendChild(tourHeaderTbody);

            const tourGroups = grouped[tourName];
            // Sort types (destination first, then checkpoint)
            // 'destination' > 'checkpoint' alphabetically? d > c.
            // If we want destination first, we can just sort reverse.
            const sortedTypes = Object.keys(tourGroups).sort().reverse(); 
            
            sortedTypes.forEach(type => {
                const groupItems = tourGroups[type];
                // Sort items by thuTu
                groupItems.sort((a, b) => (parseInt(a.thuTu) || 0) - (parseInt(b.thuTu) || 0));

                const tbody = document.createElement('tbody');
                tbody.className = 'type-group-tbody';
                
                // Header Row for Type
                const typeLabel = getLoaiLabel(type);
                const typeIcon = type === 'destination' ? 'fa-map-marker-alt' : 'fa-flag-checkered';
                const typeColor = type === 'destination' ? '#0d6efd' : '#dc3545'; // Blue for dest, Red for checkpoint

                const typeHeaderRow = document.createElement('tr');
                typeHeaderRow.className = 'type-header-row';
                typeHeaderRow.innerHTML = `
                    <td colspan="8" style="background-color: #f8f9fa; font-weight: 600; color: ${typeColor}; padding: 8px 15px 8px 30px; text-align: left; border-bottom: 2px solid #dee2e6;">
                        <i class="fas ${typeIcon}" style="margin-right: 8px;"></i> ${htmlEscape(typeLabel)}
                    </td>
                `;
                tbody.appendChild(typeHeaderRow);

                // Item Rows
                groupItems.forEach(d => {
                    const row = document.createElement("tr");
                    row.className = 'draggable-row';
                    row.setAttribute('data-id', d.id);
                    row.setAttribute('data-tour', tourName);
                    row.setAttribute('data-type', type);
                    
                    const tgDi = d.tgDi ? new Date(d.tgDi).toLocaleDateString('vi-VN') : '';
                    const tgVe = d.tgVe ? new Date(d.tgVe).toLocaleDateString('vi-VN') : '';
                    
                    row.innerHTML = `
                    <td class="drag-handle" style="cursor: grab; text-align: center;"><i class="fas fa-grip-vertical"></i> ${d.thuTu || 0}</td>
                    <td>${d.id ?? ''}</td>
                    <td>${htmlEscape(d.ten ?? '')}</td>
                    <td>${htmlEscape(getLoaiLabel(d.loai ?? ''))}</td>
                    <td>${tgDi}</td>
                    <td>${tgVe}</td>
                    <td>${htmlEscape(getTrangThaiLabel(d.trangThai ?? ''))}</td>
                    <td class="actions">
                        <a href="index.php?act=view-cap-nhat-dia-diem&id=${d.id}"><i class='fa-solid fa-pen'></i></a>
                        <a href="index.php?act=xoa-dia-diem&id=${d.id}" class="delete" onclick="return xoaDiaDiem('${d.id}')"><i class='fa-solid fa-trash'></i></a>
                    </td>
                    `;
                    tbody.appendChild(row);
                });

                mainTable.appendChild(tbody);

                // Initialize Sortable for this tbody
                new Sortable(tbody, {
                    animation: 150,
                    handle: '.drag-handle',
                    draggable: '.draggable-row',
                    filter: '.type-header-row', // Do not drag header
                    onEnd: function (evt) {
                        updateOrder(evt.from);
                    }
                });
            });
        });
    }

    function updateOrder(tbody) {
        const rows = tbody.querySelectorAll('.draggable-row');
        const items = [];
        rows.forEach((row, index) => {
            const id = row.getAttribute('data-id');
            const newOrder = index + 1;
            // Update UI immediately
            row.querySelector('.drag-handle').innerHTML = `<i class="fas fa-grip-vertical"></i> ${newOrder}`;
            items.push({ id: id, thuTu: newOrder });
        });

        // Send API request
        fetch('index.php?act=api-update-diadiem-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ items: items })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'success') {
                console.error('Update failed:', data);
                alert('Cập nhật thứ tự thất bại');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Lỗi kết nối');
        });
    }

    // Render initial list
    renderDiaDiem(allDiaDiem);
</script>

    </div>
  </div>
</body>
</html>
