<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Đơn hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./views/chung/css/danhSach.css" />
    <style>
        .customers-list {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
        }
        .customers-list ul {
            margin: 0;
            padding-left: 20px;
        }
        .customers-list li {
            margin: 5px 0;
            font-size: 0.9em;
        }
        .badge-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85em;
            font-weight: 500;
        }
        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }
        .badge-confirmed {
            background-color: #28a745;
            color: #fff;
        }
        .badge-completed {
            background-color: #17a2b8;
            color: #fff;
        }
        .badge-cancelled {
            background-color: #dc3545;
            color: #fff;
        }
        .modal-body table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95em;
        }
        .modal-body table thead {
            background-color: #f5f5f5;
            font-weight: 600;
        }
        .modal-body table th,
        .modal-body table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .modal-body table tbody tr:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
  <div class="content-wrapper">
    <div class="content-container">
      <div class="header">
        <div>
          <h1>Danh sách Booking</h1>
        </div>
      </div>

      <!-- Search section -->
      <div class="search-section">
        <div class="search-group">
          <label for="quick-search">Tìm kiếm nhanh:</label>
          <input type="text" id="quick-search" placeholder="Nhập tên tour, tên hướng dẫn viên">
        </div>
        <button class="btn-advanced-search" onclick="openAdvancedSearch()">
          <i class="fas fa-sliders-h"></i> Tìm kiếm chi tiết
        </button>
        <button class="btn-reset" onclick="resetSearch()">
          <i class="fas fa-redo"></i> Đặt lại
        </button>
        <button class="btn-add-item">
          <a href="index.php?act=view-dat-booking" style="color: white; text-decoration: none;">
            <i class="fas fa-plus"></i> Thêm Đơn hàng
          </a>
        </button>
      </div>

    <div class="main-wrapper">
        <div class="card">      
            <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>ID Đơn</th>
                    <th>Tên Tour</th>
                    <th>Hướng Dẫn Viên</th>
                    <th>Khách hàng</th>
                    <th>Ngày Đặt</th>
                    <th>Đặt Cọc</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>  
                </tr>
                </thead>
                <tbody id="booking-table"></tbody>
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
              <label for="search-tour">Tên Tour:</label>
              <input type="text" id="search-tour" placeholder="Nhập tên tour">
            </div>
            <div class="search-form-group">
              <label for="search-hdv">Hướng Dẫn Viên:</label>
              <input type="text" id="search-hdv" placeholder="Nhập tên hướng dẫn viên">
            </div>
            <div class="search-form-group">
              <label for="search-status">Trạng thái:</label>
              <select id="search-status">
                <option value="">-- Tất cả --</option>
                <option value="Chưa xác nhận">Chưa xác nhận</option>
                <option value="Đã xác nhận">Đã cọc</option>
                <option value="Hoàn thành">Hoàn thành</option>
                <option value="Hủy">Hủy</option>
              </select>
            </div>
            <div class="search-form-group">
              <label for="search-date-from">Từ ngày:</label>
              <input type="date" id="search-date-from">
            </div>
            <div class="search-form-group">
              <label for="search-date-to">Đến ngày:</label>
              <input type="date" id="search-date-to">
            </div>
            <div class="modal-buttons">
              <button type="submit" class="btn-search-submit">Tìm kiếm</button>
              <button type="button" class="btn-search-cancel" onclick="closeAdvancedSearch()">Hủy</button>
            </div>
          </form>
        </div>
      </div>

  <?php
  $__bookings_data = isset($bookings) ? $bookings : array();
  ?>

<script>
    // ==================== KHAI BÁO DỮ LIỆU ====================
    const bookings = <?php echo json_encode($__bookings_data, JSON_UNESCAPED_UNICODE); ?> || [];
    let allBookings = [...bookings];
    const tableBody = document.getElementById("booking-table");
    const quickSearchInput = document.getElementById("quick-search");

    // ==================== HELPER FUNCTIONS ====================
    function htmlEscape(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function deleteBooking(id) {
        return confirm('Bạn có chắc muốn xóa đơn hàng này không?');
    }

    function formatCurrency(value) {
        return parseInt(value || 0).toLocaleString('vi-VN') + ' VNĐ';
    }

    function formatDate(dateString) {
        if (!dateString) return '';
        return new Date(dateString).toLocaleDateString('vi-VN');
    }

    function getStatusBadge(status) {
        const statusMap = {
            'Chưa xác nhận': 'badge-pending',
            'Đã xác nhận': 'badge-confirmed',
            'Hoàn thành': 'badge-completed',
            'Hủy': 'badge-cancelled'
        };
        const badgeClass = statusMap[status] || 'badge-pending';
        return `<span class="badge-status ${badgeClass}">${status || 'N/A'}</span>`;
    }

    // ==================== TÌM KIẾM NHANH ====================
    quickSearchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        if (searchTerm === '') {
            renderBookings(allBookings);
        } else {
            const filtered = allBookings.filter(b => {
                const tourName = (b.tour_ten || '').toLowerCase();
                const hdvName = (b.hdv_hoTen || '').toLowerCase();
                return tourName.includes(searchTerm) || hdvName.includes(searchTerm);
            });
            renderBookings(filtered);
        }
    });

    // ==================== TÌM KIẾM NÂNG CAO ====================
    function openAdvancedSearch() {
        document.getElementById('advancedSearchModal').classList.add('active');
    }

    function closeAdvancedSearch() {
        document.getElementById('advancedSearchModal').classList.remove('active');
    }

    function performAdvancedSearch(event) {
        event.preventDefault();
        
        const searchTour = document.getElementById('search-tour').value.toLowerCase().trim();
        const searchHdv = document.getElementById('search-hdv').value.toLowerCase().trim();
        const searchStatus = document.getElementById('search-status').value;
        const searchDateFrom = document.getElementById('search-date-from').value;
        const searchDateTo = document.getElementById('search-date-to').value;

        const filtered = allBookings.filter(b => {
            const tourName = (b.tour_ten || '').toLowerCase();
            const hdvName = (b.hdv_hoTen || '').toLowerCase();
            const status = (b.trangThai || '').toLowerCase();
            const bookingDate = new Date(b.tgDatDon || '');
            const fromDate = searchDateFrom ? new Date(searchDateFrom) : new Date(0);
            const toDate = searchDateTo ? new Date(searchDateTo) : new Date('2100-01-01');

            return (searchTour === '' || tourName.includes(searchTour)) &&
                    (searchHdv === '' || hdvName.includes(searchHdv)) &&
                    (searchStatus === '' || status.includes(searchStatus.toLowerCase())) &&
                    (bookingDate >= fromDate && bookingDate <= toDate);
        });
        
        renderBookings(filtered);
        closeAdvancedSearch();
    }

    function resetSearch() {
        quickSearchInput.value = '';
        document.getElementById('search-tour').value = '';
        document.getElementById('search-hdv').value = '';
        document.getElementById('search-status').value = '';
        document.getElementById('search-date-from').value = '';
        document.getElementById('search-date-to').value = '';
        renderBookings(allBookings);
    }

    // ==================== RENDER BẢNG ĐƠN HÀNG ====================
    function renderBookings(bookingsToRender) {
        tableBody.innerHTML = '';

        if (bookingsToRender.length === 0) {
            tableBody.innerHTML = `
                <tr>
                <td colspan="9" class="empty-message">
                    <i class="fa-solid fa-inbox"></i>
                    <div>Không có dữ liệu đơn hàng</div>
                </td>
                </tr>
            `;
        } else {
            bookingsToRender.forEach(b => {
                const row = document.createElement("tr");
                const bookingDate = formatDate(b.tgDatDon);
                row.innerHTML = `
                <td>${b.id ?? ''}</td>
                <td>${htmlEscape(b.tour_ten ?? '')}</td>
                <td>${htmlEscape(b.hdv_hoTen ?? '')}</td>
                <td><a href="javascript:void(0)" onclick="showCustomersList(${b.id})" class="link-customers">Xem danh sách</a></td>
                <td>${bookingDate}</td>
                <td>${formatCurrency(b.datCoc)}</td>
                <td>${formatCurrency(b.tongTien)}</td>
                <td>${getStatusBadge(b.trangThai)}</td>
                <td class="actions">
                    <a href="javascript:void(0)" onclick="showDetailModal(${b.id})" title="Xem chi tiết"><i class='fa-solid fa-eye'></i></a>
                    <a href="index.php?act=view-cap-nhat-booking&id=${b.id}" title="Sửa"><i class='fa-solid fa-pen'></i></a>
                    <a href="index.php?act=xoa-booking&id=${b.id}" class="delete" onclick="return deleteBooking('${b.id}')" title="Xóa"><i class='fa-solid fa-trash'></i></a>
                    <a href="javascript:void(0)" onclick="showCheckInModal(${b.id})" title="Check-in khách"><i class='fa-solid fa-check-circle'></i></a>
                </td>
                `;
                tableBody.appendChild(row);
            });
        }
    }

    // Render initial list
    renderBookings(allBookings);

    // ==================== MODAL CHI TIẾT ĐƠN HÀNG ====================
    function showDetailModal(bookingId) {
        const booking = allBookings.find(b => b.id === bookingId);
        if (!booking) {
            alert('Không tìm thấy dữ liệu khách hàng');
            return;
        }

        const statusBadge = getStatusBadge(booking.trangThai);
        const detailHTML = `
            <table>
                <colgroup class="detail-table-colgroup">
                    <col style="width:150px;">
                    <col style="width:auto;">
                </colgroup>
                <tr class="detail-table-row">
                    <td class="detail-table-label">ID Đơn Hàng</td>
                    <td class="detail-table-value">${booking.id ?? ''}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Tên Tour</td>
                    <td class="detail-table-value">${htmlEscape(booking.tour_ten ?? '')}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Hướng Dẫn Viên</td>
                    <td class="detail-table-value">${htmlEscape(booking.hdv_hoTen ?? '')}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Ngày Bắt Đầu</td>
                    <td class="detail-table-value">${formatDate(booking.tgBatDau)}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Ngày Kết Thúc</td>
                    <td class="detail-table-value">${formatDate(booking.tgKetThuc)}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Ngày Đặt Đơn</td>
                    <td class="detail-table-value">${formatDate(booking.tgDatDon)}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Tiền Đặt Cọc</td>
                    <td class="detail-table-value">${formatCurrency(booking.datCoc)}</td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Tổng Tiền</td>
                    <td class="detail-table-value"><strong>${formatCurrency(booking.tongTien)}</strong></td>
                </tr>
                <tr class="detail-table-row">
                    <td class="detail-table-label">Trạng thái</td>
                    <td class="detail-table-value">${statusBadge}</td>
                </tr>
            </table>
            <div class="detail-actions">
                <a href="index.php?act=view-cap-nhat-booking&id=${booking.id}">
                    <i class="fas fa-pen"></i> Chỉnh sửa
                </a>
                <button onclick="deleteAndClose(${booking.id})">
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

    function deleteAndClose(bookingId) {
        if (confirm('Bạn có chắc muốn xóa đơn hàng này không?')) {
            window.location.href = 'index.php?act=xoa-booking&id=' + bookingId;
        }
    }

    // ==================== MODAL DANH SÁCH KHÁCH HÀNG ====================
    function showCustomersList(donHangId) {
        // Hiển thị loading nhỏ nếu muốn
        fetch('index.php?act=lay-don-hang-khach-hang&don_hang_id=' + encodeURIComponent(donHangId), {
            credentials: 'same-origin'
        })
        .then(response => {
            console.log("HTTP Status:", response.status);
            if (!response.ok) {
                throw new Error('HTTP error, status = ' + response.status);
            }
            return response.text();
        })
        .then(text => {
            console.log("=== RAW RESPONSE START ===");
            console.log(text);
            console.log("=== RAW RESPONSE END ===");

            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                console.error('JSON parse error:', e);
                console.error('Response text:', text);
                alert('Lỗi JSON: ' + e.message + '. Kiểm tra console để xem raw response.');
                return;
            }

            if (!data.success) {
                console.error('API Error:', data.message);
                alert('API lỗi: ' + (data.message || 'Không xác định'));
                return;
            }

            const customers = data.data || [];

            let html = `
                <table style="width:100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="padding:8px; text-align:left;">ID</th>
                            <th style="padding:8px; text-align:left;">Họ tên</th>
                            <th style="padding:8px; text-align:left;">Giới tính</th>
                            <th style="padding:8px; text-align:left;">Tuổi</th>
                            <th style="padding:8px; text-align:left;">Điện thoại</th>
                            <th style="padding:8px; text-align:left;">Email</th>
                            <th style="padding:8px; text-align:left;">Check-in</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            if (customers.length === 0) {
                html += `<tr><td colspan="7" style="padding:10px;"><em>Chưa có khách hàng nào</em></td></tr>`;
            } else {
                customers.forEach(c => {
                    // Tính tuổi nếu có ngày sinh
                    let tuoi = 'N/A';
                    if (c.ngaySinh) {
                        try {
                            const dob = new Date(c.ngaySinh);
                            const diff = new Date().getFullYear() - dob.getFullYear();
                            tuoi = isNaN(diff) ? 'N/A' : diff;
                        } catch (err) { tuoi = 'N/A'; }
                    } else if (c.tuoi) {
                        tuoi = c.tuoi;
                    }

                    html += `
                        <tr>
                            <td style="padding:8px; border-top:1px solid #eee;">${c.khachHang_id ?? c.id ?? ''}</td>
                            <td style="padding:8px; border-top:1px solid #eee;">${htmlEscape(c.ten || '')}</td>
                            <td style="padding:8px; border-top:1px solid #eee;">${htmlEscape(c.gioiTinh || '')}</td>
                            <td style="padding:8px; border-top:1px solid #eee;">${tuoi}</td>
                            <td style="padding:8px; border-top:1px solid #eee;">${htmlEscape(c.dienThoai || 'N/A')}</td>
                            <td style="padding:8px; border-top:1px solid #eee;">${htmlEscape(c.email || 'N/A')}</td>
                            <td style="padding:8px; border-top:1px solid #eee;">
                                ${c.trangThai_checkin == 1 ? '<span style="color: green; font-weight: 600;">Đã check-in</span>' : '<span style="color: red; font-weight: 600;">Chưa check-in</span>'}
                            </td>
                        </tr>
                    `;
                });
            }

            html += `</tbody></table>`;

            // Ghi vào modal
            const contentEl = document.getElementById('customersContent');
            if (contentEl) contentEl.innerHTML = html;
            const modal = document.getElementById('customersModal');
            if (modal) modal.classList.add('active');

        })
        .catch(err => {
            console.error('Fetch error:', err);
            alert('Lỗi khi lấy danh sách khách hàng: ' + err.message);
        });
    }

    // Simple HTML escape
    function htmlEscape(str) {
        if (!str) return '';
        return String(str).replace(/[&<>"']/g, function(m) {
            return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m];
        });
    }

    function closeCustomersModal() {
        const modal = document.getElementById('customersModal');
        if (modal) modal.classList.remove('active');
    }


    // ==================== MODAL CHECK-IN KHÁCH ====================
    function showCheckInModal(bookingId) {
        const booking = allBookings.find(b => b.id === bookingId);
        if (!booking) {
            alert('Không tìm thấy dữ liệu đơn hàng');
            return;
        }

        // Fetch customer list chi tiết từ server
        fetch('index.php?act=lay-don-hang-khach-hang&don_hang_id=' + bookingId)
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP error, status = ' + response.status);
            }
            return response.text();
        })
        .then(text => {
            try {
                const result = JSON.parse(text);
                if (result.success && result.data) {
                    renderCheckInModal(bookingId, booking, result.data);
                } else {
                    alert('Lỗi: ' + (result.message || 'Không thể lấy danh sách khách hàng'));
                }
            } catch (e) {
                console.error('Parse error:', e);
                console.error('Response was:', text);
                alert('Lỗi khi xử lý danh sách khách hàng: ' + e.message);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Lỗi khi lấy danh sách khách hàng: ' + error.message);
        });
    }

    function renderCheckInModal(bookingId, booking, customers) {
        let customersHTML = '';
        
        if (customers.length > 0) {
            customersHTML = customers.map((c, idx) => {
                const isCheckedIn = c.trangThai_checkin === 1 || c.trangThai_checkin === '1';
                const genderDisplay = c.gioiTinh === 'Nam' ? '👨' : (c.gioiTinh === 'Nữ' ? '👩' : '');
                const statusColor = isCheckedIn ? '#28a745' : '#dc3545';
                const statusText = isCheckedIn ? 'Đã check-in' : 'Chưa check-in';
                
                return `
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px; border: 1px solid #ddd; margin-bottom: 10px; border-radius: 4px;">
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                <input type="checkbox" name="customer_${bookingId}_${idx}" value="${c.id}" ${isCheckedIn ? 'checked' : ''} style="margin-right: 10px; width: 18px; height: 18px; cursor: pointer;">
                                <strong style="font-size: 14px;">${htmlEscape(c.ten)}</strong>
                                <span style="margin-left: 8px; font-size: 16px;">${genderDisplay}</span>
                            </div>
                            <div style="font-size: 12px; color: #666; margin-left: 28px;">
                                Tuổi: ${c.tuoi || 'N/A'} | SĐT: ${htmlEscape(c.dienThoai || 'N/A')}
                            </div>
                        </div>
                        <div style="background-color: ${statusColor}; color: white; padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: 600; white-space: nowrap; margin-left: 10px;">
                            ${statusText}
                        </div>
                    </div>
                `;
            }).join('');
        } else {
            customersHTML = '<div style="padding: 20px; text-align: center; color: #999;"><em>Chưa có khách hàng nào</em></div>';
        }

        const checkInHTML = `
            <div style="padding: 20px;">
                <h3 style="margin-bottom: 15px;">Check-in cho đơn hàng #${bookingId}</h3>
                <div class="detail-table-label" style="margin-bottom: 10px; font-weight: 600;">Tour: ${htmlEscape(booking.tour_ten ?? '')}</div>
                <div class="detail-table-label" style="margin-bottom: 15px; font-weight: 600;">Hướng dẫn viên: ${htmlEscape(booking.hdv_hoTen ?? '')}</div>
                <div class="customers-list" style="max-height: 400px; overflow-y: auto;">
                    <div style="font-weight: 600; margin-bottom: 15px;">Danh sách khách hàng:</div>
                    ${customersHTML}
                </div>
                <div style="margin-top: 20px;">
                    <button onclick="completeCheckIn(${bookingId})" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-check"></i> Xác nhận Check-in
                    </button>
                </div>
            </div>
        `;

        document.getElementById('checkInContent').innerHTML = checkInHTML;
        document.getElementById('checkInModal').classList.add('active');
    }

    function closeCheckInModal() {
        document.getElementById('checkInModal').classList.remove('active');
    }

    function completeCheckIn(bookingId) {
        console.log('Starting check-in for booking:', bookingId);
        
        // Lấy danh sách khách được chọn
        const checkboxes = document.querySelectorAll(`input[name^="customer_${bookingId}_"]:checked`);
        const customerIds = Array.from(checkboxes).map(cb => cb.value);
        
        console.log('Selected customers:', customerIds);
        
        if (customerIds.length === 0) {
            alert('Vui lòng chọn ít nhất một khách hàng để check-in');
            return;
        }
        
        // Tạo FormData để gửi dữ liệu
        const formData = new FormData();
        formData.append('booking_id', bookingId);
        customerIds.forEach(id => {
            formData.append('customer_ids[]', id);
        });
        
        fetch('index.php?act=api-check-in', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.status);
            }
            return response.text();
        })
        .then(text => {
            console.log('Response text:', text);
            try {
                const data = JSON.parse(text);
                console.log('Parsed data:', data);
                
                if (data.success) {
                    alert('Check-in thành công cho ' + data.count + ' khách hàng');
                    closeCheckInModal();
                    // Reload page to see updated status
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    alert('Lỗi: ' + data.message);
                }
            } catch (parseError) {
                console.error('JSON parse error:', parseError);
                console.error('Response was:', text);
                alert('Lỗi khi xử lý phản hồi: ' + text);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Có lỗi xảy ra khi check-in: ' + error.message);
        });
    }

    // ==================== EVENT LISTENERS ====================
    window.onclick = function(event) {
        const modals = ['advancedSearchModal', 'detailModal', 'customersModal', 'checkInModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (event.target === modal) {
                modal.classList.remove('active');
            }
        });
    }
</script>

  <!-- Detail Modal -->
  <div id="detailModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
      <div class="modal-header">
        <h2>Chi tiết Đơn Hàng</h2>
        <span class="close-modal" onclick="closeDetailModal()">&times;</span>
      </div>
      <div id="detailContent">
        <!-- Content will be loaded here -->
      </div>
    </div>
  </div>

  <!-- Customers List Modal -->
<div id="customersModal" class="modal" style="display:none; position:fixed; inset:0; align-items:center; justify-content:center;">
  <div style="background:#fff; width:90%; max-width:900px; border-radius:8px; box-shadow:0 8px 30px rgba(0,0,0,0.2); overflow:hidden;">
    <div style="padding:12px 16px; background:#f5f5f5; display:flex; justify-content:space-between; align-items:center;">
      <h3 style="margin:0;">Danh sách khách hàng</h3>
      <button onclick="closeCustomersModal()" style="background:transparent; border:0; font-size:18px; cursor:pointer;">✕</button>
    </div>
    <div id="customersContent" style="padding:16px; max-height:60vh; overflow:auto;">
      <!-- Nội dung table sẽ được JS render ở đây -->
    </div>
    <div style="padding:12px; text-align:right; background:#fafafa;">
      <button onclick="closeCustomersModal()" style="padding:8px 12px; border-radius:6px; background:#ddd; border:0; cursor:pointer;">Đóng</button>
    </div>
  </div>
</div>

  <!-- Check-in Modal -->
  <div id="checkInModal" class="modal">
    <div class="modal-content" style="max-width: 500px;">
      <div class="modal-header">
        <h2>Check-in Khách Hàng</h2>
        <span class="close-modal" onclick="closeCheckInModal()">&times;</span>
      </div>
      <div id="checkInContent" style="padding: 20px;">
        <!-- Content will be loaded here -->
      </div>
    </div>
  </div>

    </div>
  </div>
</body>
</html>