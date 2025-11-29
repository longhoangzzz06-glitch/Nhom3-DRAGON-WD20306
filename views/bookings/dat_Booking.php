<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Booking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 30px;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 24px;
            color: #111;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-title i {
            color: #2563eb;
            font-size: 28px;
        }

        /* Form Section */
        .form-section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f9fafb;
            border-radius: 8px;
            border-left: 4px solid #2563eb;
        }

        .form-section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #111;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-section-title i {
            color: #2563eb;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-row.full {
            grid-template-columns: 1fr;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .form-group label .required {
            color: #dc2626;
            margin-left: 4px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-group input:read-only {
            background: #f3f4f6;
            cursor: not-allowed;
        }

        /* Info Box */
        .info-box {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            margin-top: 16px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            font-size: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #6b7280;
            font-weight: 500;
        }

        .info-value {
            color: #111;
            font-weight: 600;
        }

        .price-highlight {
            color: #dc2626;
            font-size: 18px;
            font-weight: bold;
        }

        /* Table */
        .table-wrapper {
            overflow-x: auto;
            margin-top: 16px;
        }

        .customers-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .customers-table thead {
            background: #f3f4f6;
        }

        .customers-table th {
            padding: 12px 4px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e5e7eb;
            font-size: 13px;
            color: #374151;
        }

        .customers-table td {
            padding: 12px 4px;
            border-bottom: 1px solid #e5e7eb;
        }

        .customers-table input,select {
            width: 100%;
            padding: 8px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 13px;
            font-family: inherit;
        }

        .customers-table input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        }

        .btn-remove {
            background: #ef4444;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.2s;
        }

        .btn-remove:hover {
            background: #dc2626;
        }

        .btn-remove:disabled {
            background: #d1d5db;
            cursor: not-allowed;
        }

        .btn-add {
            background: #10b981;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 16px;
            transition: background 0.2s;
        }

        .btn-add:hover {
            background: #059669;
        }

        /* Button Group */
        .button-group {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            flex: 1;
        }

        .btn-submit {
            background: #2563eb;
            color: white;
        }

        .btn-submit:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-cancel {
            background: #9ca3af;
            color: white;
        }

        .btn-cancel:hover {
            background: #6b7280;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
            }

            .customers-table {
                font-size: 12px;
            }

            .customers-table th,
            .customers-table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 class="card-title">
                <i class="fas fa-plus-circle"></i>
                Tạo Đơn Booking Mới
            </h1>

            <?php
            // Hiển thị lỗi nếu có
            $errors = $_SESSION['booking_errors'] ?? [];
            if (!empty($errors)):
            ?>
            <div style="background-color: #fee; border: 1px solid #fcc; border-radius: 6px; padding: 15px; margin-bottom: 20px; color: #c33;">
                <h4 style="margin-top: 0; color: #c33; font-weight: 600;">
                    <i class="fas fa-exclamation-circle"></i> Lỗi Xác Thực Dữ Liệu
                </h4>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <?php foreach ($errors as $error): ?>
                        <li style="margin: 5px 0;"><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php
            unset($_SESSION['booking_errors']);
            endif;
            ?>

            <form id="bookingForm" method="POST" action="index.php?act=store-booking">

                <!-- CHỌN TOUR -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-map"></i>
                        Chọn Tour
                    </h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label>
                                Tên Tour
                                <span class="required">*</span>
                            </label>
                            <select id="tour_id" name="tour_id" required onchange="updateTourInfo()">
                                <option value="">-- Chọn tour --</option>
                                <?php foreach ($tourList as $tour): ?>
                                    <option value="<?php echo $tour['id']; ?>"
                                            data-gia="<?php echo $tour['gia']; ?>"
                                            data-batdau="<?php echo $tour['tgBatDau']; ?>"
                                            data-ketthuc="<?php echo $tour['tgKetThuc']; ?>">
                                        <?php echo htmlspecialchars($tour['ten']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="">
                        <div class="info-row">
                            <span class="info-label">Giá Tour:</span>
                            <span class="info-value" id="display-gia">-</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Ngày bắt đầu:</span>
                            <span class="info-value" id="display-batdau">-</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Ngày kết thúc:</span>
                            <span class="info-value" id="display-ketthuc">-</span>
                        </div>
                    </div>
                </div>

                <!-- CHỌN HƯỚNG DẪN VIÊN -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-user-tie"></i>
                        Chọn Hướng Dẫn Viên
                    </h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label>
                                Hướng Dẫn Viên
                                <span class="required">*</span>
                            </label>
                            <select id="hdv_id" name="hdv_id" required>
                                <option value="">-- Chọn hướng dẫn viên --</option>
                                <?php foreach ($hdvList as $hdv): ?>
                                    <option value="<?php echo $hdv['id']; ?>">
                                        <?php echo htmlspecialchars($hdv['hoTen']); ?>
                                        (<?php echo htmlspecialchars($hdv['dienThoai']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- DANH SÁCH KHÁCH HÀNG -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-users"></i>
                        Danh Sách Khách Hàng
                    </h3>

                    <!-- Phần 1: Chọn khách hàng có sẵn -->
                    <div style="margin-bottom: 30px; padding: 15px; background: #e3f2fd; border-radius: 6px; border-left: 4px solid #1976d2;">
                        <h4 style="margin-top: 0; color: #1565c0; font-weight: 600; margin-bottom: 15px;">
                            <i class="fas fa-hand-pointer"></i> Chọn Khách Hàng Có Sẵn
                        </h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Khách Hàng</label>
                                <select id="existing_customer" onchange="addExistingCustomer()">
                                    <option value="">-- Chọn khách hàng --</option>
                                    <?php 
                                    foreach ($khachHangList as $kh):
                                    ?>
                                        <option value="<?php echo $kh['id']; ?>" 
                                                data-ten="<?php echo htmlspecialchars($kh['ten']); ?>"
                                                data-dienthoai="<?php echo htmlspecialchars($kh['dienThoai']); ?>"
                                                data-email="<?php echo htmlspecialchars($kh['email']); ?>">
                                            <?php echo htmlspecialchars($kh['ten']); ?> (<?php echo htmlspecialchars($kh['dienThoai']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="table-wrapper" id="selected-customers" style="margin-top: 15px; display: none;">
                            <table class="customers-table">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">STT</th>
                                        <th style="width: 20%;">Tên</th>
                                        <th style="width: 15%;">Điện Thoại</th>
                                        <th style="width: 20%;">Email</th>
                                        <th style="width: 10%;">Số Phòng</th>
                                        <th style="width: 20%;">Ghi Chú</th>
                                        <th style="width: 10%;">Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody id="selected-customers-tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Phần 2: Tạo khách hàng mới -->
                    <div style="margin-bottom: 20px; padding: 15px; background: #f3e5f5; border-radius: 6px; border-left: 4px solid #7b1fa2;">
                        <h4 style="margin-top: 0; color: #6a1b9a; font-weight: 600; margin-bottom: 15px;">
                            <i class="fas fa-user-plus"></i> Tạo Khách Hàng Mới
                        </h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Tên <span class="required">*</span></label>
                                <input type="text" id="newCustomerTen" placeholder="Nhập tên khách hàng">
                            </div>
                            <div class="form-group">
                                <label>Tuổi</label>
                                <input type="number" id="newCustomerTuoi" placeholder="Tuổi" min="0">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Giới Tính</label>
                                <select id="newCustomerGioiTinh">
                                    <option value="Khác">Khác</option>
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Điện Thoại <span class="required">*</span></label>
                                <input type="tel" id="newCustomerDienThoai" placeholder="0123456789">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="newCustomerEmail" placeholder="email@example.com">
                            </div>
                            <div class="form-group">
                                <label>Số Phòng</label>
                                <input type="text" id="newCustomerSoPhong" placeholder="101">
                            </div>
                        </div>
                        <div class="form-row full">
                            <div class="form-group">
                                <label>Ghi Chú</label>
                                <input type="text" id="newCustomerGhiChu" placeholder="Ghi chú thêm">
                            </div>
                        </div>
                        <button type="button" class="btn-add" onclick="addNewCustomer()">
                            <i class="fas fa-plus"></i>
                            Thêm Khách Hàng Mới
                        </button>
                    </div>

                    <!-- Danh sách khách hàng đã thêm -->
                    <div class="table-wrapper">
                        <table class="customers-table">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">STT</th>
                                    <th style="width: 12%;">Tên <span class="required">*</span></th>
                                    <th style="width: 8%;">Tuổi</th> 
                                    <th style="width: 10%;">Giới Tính</th>
                                    <th style="width: 12%;">Điện Thoại <span class="required">*</span></th>
                                    <th style="width: 14%;">Email</th>
                                    <th style="width: 8%;">Số Phòng</th>
                                    <th style="width: 20%;">Ghi Chú</th>
                                    <th style="width: 8%;">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody id="customers-tbody">
                                <tr class="customer-row" data-row-index="0">
                                    <td class="row-number">1</td>
                                    <td><input type="text" name="ten[]" placeholder="Nhập tên" required></td>
                                    <td><input type="number" name="tuoi[]" placeholder="Tuổi"></td>
                                    <td><select name="gioiTinh[]">
                                        <option value="Khác">Khác</option>                                        
                                        <option value="Nam">Nam</option>
                                        <option value="Nữ">Nữ</option>
                                    </select></td>
                                    <td><input type="tel" name="dienThoai[]" placeholder="0123456789" required></td>
                                    <td><input type="email" name="email[]" placeholder="email@example.com"></td>
                                    <td><input type="text" name="soPhong[]" placeholder="101"></td>
                                    <td><input type="text" name="ghiChuDB[]" placeholder="Ghi chú thêm"></td>
                                    <td><button type="button" class="btn-remove" onclick="removeCustomer(this)" style="display: none;"><i class="fas fa-trash"></i> Xóa</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <button type="button" class="btn-add" onclick="addCustomer()">
                        <i class="fas fa-plus"></i>
                        Thêm Hàng Trống
                    </button>
                </div>

                <!-- THÔNG TIN THANH TOÁN -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-credit-card"></i>
                        Thông Tin Thanh Toán
                    </h3>

                    <div class="">
                        <div class="info-row">
                            <span class="info-label">Số lượng khách:</span>
                            <span class="info-value" id="display-sokhach">0 khách</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Giá/khách:</span>
                            <span class="info-value" id="display-giakg">-</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tiền đặt cọc (20%):</span>
                            <span class="info-value" id="display-datcoc">-</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tổng tiền dịch vụ:</span>
                            <span class="info-value" id="display-tongdichvu">-</span>
                        </div>
                        <div class="info-row" style="border-top: 2px solid #d1d5db; padding-top: 12px; margin-top: 12px;">
                            <span class="info-label" style="font-size: 16px; font-weight: 700;">Tổng cộng:</span>
                            <span class="price-highlight" id="display-tongtien">0 VNĐ</span>
                        </div>
                    </div>

                    <input type="hidden" id="tongTien" name="tongTien" value="0">
                    <input type="hidden" id="datCoc" name="datCoc" value="0">
                </div>

                <!-- THÔNG TIN KHÁC -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-info-circle"></i>
                        Thông Tin Khác
                    </h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Ngày Đặt Đơn</label>
                            <input type="datetime-local" id="tgDatDon" name="tgDatDon" readonly>
                        </div>
                        <div class="form-group">
                            <label>Trạng Thái</label>
                            <input type="text" id="trangThai" name="trangThai" value="Chờ duyệt" readonly>
                        </div>
                    </div>
                </div>

                <!-- NÚT HÀNH ĐỘNG -->
                <div class="button-group">
                    <a class="btn btn-submit" href="javascript:void(0);" onclick="submitForm();">
                        <i class="fas fa-save"></i>
                        Tạo Đơn Booking
                    </a>
                    <a class="btn btn-cancel" href="index.php?act=quan-ly-booking">
                        <i class="fas fa-times"></i>
                        Hủy
                    </a>
                </div>

            </form>
        </div>
    </div>

    <script>
        // ==================== KHAI BÁO DỮ LIỆU ====================
        let customerRowCount = 1;
        let tourPrice = 0;

        // ==================== HÀM HELPER: HTML ESCAPE ====================
        function htmlEscape(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // ==================== KHỞI TẠO ====================
        document.addEventListener('DOMContentLoaded', function() {
            // Set thời gian hiện tại
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hour = String(now.getHours()).padStart(2, '0');
            const minute = String(now.getMinutes()).padStart(2, '0');
            
            document.getElementById('tgDatDon').value = `${year}-${month}-${day}T${hour}:${minute}`;
        });

        // ==================== CẬP NHẬT THÔNG TIN TOUR ====================
        function updateTourInfo() {
            const tourSelect = document.getElementById('tour_id');
            const selectedOption = tourSelect.options[tourSelect.selectedIndex];
            
            if (selectedOption.value === '') {
                document.getElementById('display-gia').textContent = '-';
                document.getElementById('display-batdau').textContent = '-';
                document.getElementById('display-ketthuc').textContent = '-';
                tourPrice = 0;
                calculateTotal();
                return;
            }

            const gia = selectedOption.dataset.gia;
            const batDau = selectedOption.dataset.batdau;
            const ketThuc = selectedOption.dataset.ketthuc;

            tourPrice = parseInt(gia) || 0;

            document.getElementById('display-gia').textContent = formatCurrency(gia);
            document.getElementById('display-batdau').textContent = formatDate(batDau);
            document.getElementById('display-ketthuc').textContent = formatDate(ketThuc);

            calculateTotal();
        }

        // ==================== THÊM KHÁCH HÀNG CÓ SẴN ====================
        function addExistingCustomer() {
            const select = document.getElementById('existing_customer');
            const khachHangId = select.value;
            
            if (!khachHangId) return;

            const selectedOption = select.options[select.selectedIndex];
            const ten = selectedOption.dataset.ten;
            const dienThoai = selectedOption.dataset.dienthoai;
            const email = selectedOption.dataset.email;

            // Kiểm tra khách hàng đã được chọn chưa (kiểm tra hidden input)
            const existingIds = document.querySelectorAll('input[name="existing_khachHang_id[]"]');
            for (let input of existingIds) {
                if (input.value === khachHangId) {
                    alert('Khách hàng này đã được chọn!');
                    select.value = '';
                    return;
                }
            }

            // Lưu khachHang_id vào hidden input
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'existing_khachHang_id[]';
            hiddenInput.value = khachHangId;
            document.getElementById('bookingForm').appendChild(hiddenInput);

            // Hiển thị trong bảng
            const selectedCustomersContainer = document.getElementById('selected-customers');
            const tbody = document.getElementById('selected-customers-tbody');
            
            selectedCustomersContainer.style.display = 'block';
            
            const rowIndex = tbody.children.length + 1;
            const row = document.createElement('tr');
            row.className = 'selected-customer-row';
            row.dataset.khachHangId = khachHangId;
            row.innerHTML = `
                <td>${rowIndex}</td>
                <td>${htmlEscape(ten)}</td>
                <td>${htmlEscape(dienThoai)}</td>
                <td>${htmlEscape(email)}</td>
                <td><input type="text" name="soPhong_existing[]" placeholder="101" style="width: 100%;"></td>
                <td><input type="text" name="ghiChuDB_existing[]" placeholder="Ghi chú" style="width: 100%;"></td>
                <td><button type="button" class="btn-remove" onclick="removeExistingCustomer(this)"><i class="fas fa-trash"></i> Xóa</button></td>
            `;
            
            tbody.appendChild(row);

            // Reset select
            select.value = '';
        }

        // ==================== XÓA KHÁCH HÀNG CÓ SẴN ====================
        function removeExistingCustomer(button) {
            const row = button.closest('tr');
            const khachHangId = row.dataset.khachHangId;
            
            // Xóa hidden input tương ứng
            const hiddenInputs = document.querySelectorAll('input[name="existing_khachHang_id[]"]');
            for (let input of hiddenInputs) {
                if (input.value === khachHangId) {
                    input.remove();
                    break;
                }
            }
            
            // Xóa dòng từ bảng
            row.remove();
            
            // Ẩn bảng nếu không còn khách hàng
            if (document.getElementById('selected-customers-tbody').children.length === 0) {
                document.getElementById('selected-customers').style.display = 'none';
            }
            
            // Cập nhật STT
            const rows = document.querySelectorAll('#selected-customers-tbody tr');
            rows.forEach((r, index) => {
                r.querySelector('td:first-child').textContent = index + 1;
            });
        }

        // ==================== THÊM KHÁCH HÀNG MỚI ====================
        function addNewCustomer() {
            const ten = document.getElementById('newCustomerTen').value.trim();
            const tuoi = document.getElementById('newCustomerTuoi').value.trim();
            const gioiTinh = document.getElementById('newCustomerGioiTinh').value.trim();
            const dienThoai = document.getElementById('newCustomerDienThoai').value.trim();
            const email = document.getElementById('newCustomerEmail').value.trim();
            const soPhong = document.getElementById('newCustomerSoPhong').value.trim();
            const ghiChu = document.getElementById('newCustomerGhiChu').value.trim();

            // Validate
            if (!ten) {
                alert('Vui lòng nhập tên khách hàng');
                return;
            }
            if (!dienThoai) {
                alert('Vui lòng nhập số điện thoại');
                return;
            }
            if (!/^[0-9]{10,11}$/.test(dienThoai)) {
                alert('Số điện thoại không hợp lệ (phải từ 10-11 chữ số)');
                return;
            }
            if (email && !email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                alert('Email không hợp lệ');
                return;
            }

            const tbody = document.getElementById('customers-tbody');
            const rowIndex = customerRowCount;
            
            const row = document.createElement('tr');
            row.className = 'customer-row';
            row.dataset.rowIndex = rowIndex;
            row.innerHTML = `
                <td class="row-number">1</td>
                <td><input type="text" name="ten[]" value="${ten}" required></td>
                <td><input type="number" name="tuoi[]" value="${tuoi}"></td>
                <td>
                    <select name="gioiTinh[]">
                        <option value="Khác" ${gioiTinh === 'Khác' ? 'selected' : ''}>Khác</option>                                        
                        <option value="Nam" ${gioiTinh === 'Nam' ? 'selected' : ''}>Nam</option>
                        <option value="Nữ" ${gioiTinh === 'Nữ' ? 'selected' : ''}>Nữ</option>
                    </select>
                </td>
                <td><input type="tel" name="dienThoai[]" value="${dienThoai}" required></td>
                <td><input type="email" name="email[]" value="${email}"></td>
                <td><input type="text" name="soPhong[]" value="${soPhong}"></td>
                <td><input type="text" name="ghiChuDB[]" value="${ghiChu}"></td>
                <td><button type="button" class="btn-remove" onclick="removeCustomer(this)"><i class="fas fa-trash"></i> Xóa</button></td>
            `;
            
            tbody.appendChild(row);
            customerRowCount++;

            // Reset form
            document.getElementById('newCustomerTen').value = '';
            document.getElementById('newCustomerTuoi').value = '';
            document.getElementById('newCustomerGioiTinh').value = 'Khác';
            document.getElementById('newCustomerDienThoai').value = '';
            document.getElementById('newCustomerEmail').value = '';
            document.getElementById('newCustomerSoPhong').value = '';
            document.getElementById('newCustomerGhiChu').value = '';

            updateRowNumbers();
            updateRemoveButtons();
            calculateTotal();
        }

        // ==================== THÊM KHÁCH HÀNG ====================
        function addCustomer() {
            const tbody = document.getElementById('customers-tbody');
            const rowIndex = customerRowCount;
            
            const row = document.createElement('tr');
            row.className = 'customer-row';
            row.dataset.rowIndex = rowIndex;
            row.innerHTML = `
                <td class="row-number">1</td>
                <td><input type="text" name="ten[]" placeholder="Nhập tên" required></td>
                <td><input type="number" name="tuoi[]" placeholder="Tuổi"></td>
                <td>
                    <select name="gioiTinh[]">
                        <option value="Khác">Khác</option>                                        
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                    </select>
                </td>
                <td><input type="tel" name="dienThoai[]" placeholder="0123456789" required></td>
                <td><input type="email" name="email[]" placeholder="email@example.com"></td>
                <td><input type="text" name="soPhong[]" placeholder="101"></td>
                <td><input type="text" name="ghiChuDB[]" placeholder="Ghi chú thêm"></td>
                <td><button type="button" class="btn-remove" onclick="removeCustomer(this)"><i class="fas fa-trash"></i> Xóa</button></td>
            `;
            
            tbody.appendChild(row);
            customerRowCount++;

            updateRemoveButtons();
            calculateTotal();
        }

        // ==================== XÓA KHÁCH HÀNG ====================
        function removeCustomer(button) {
            const row = button.closest('tr');
            row.remove();
            
            updateRowNumbers();
            updateRemoveButtons();
            calculateTotal();
        }

        // ==================== CẬP NHẬT SỐ HÀNG ====================
        function updateRowNumbers() {
            const rows = document.querySelectorAll('.customer-row');
            rows.forEach((row, index) => {
                row.querySelector('.row-number').textContent = index + 1;
                row.dataset.rowIndex = index;
            });
        }

        // ==================== CẬP NHẬT NÚT XÓA ====================
        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.customer-row');
            rows.forEach(row => {
                const removeBtn = row.querySelector('.btn-remove');
                removeBtn.style.display = rows.length > 1 ? 'block' : 'none';
            });
        }

        // ==================== TÍNH TOÁN TỔNG TIỀN ====================
        function calculateTotal() {
            // Đếm khách hàng hiện có (từ dropdown chọn)
            const existingRows = document.querySelectorAll('#selected-customers-tbody tr').length;
            // Đếm khách hàng mới (từ form input)
            const newRows = document.querySelectorAll('#customers-tbody .customer-row').length;
            
            const soKhach = existingRows + newRows;
            const datCoc = tourPrice * 0.2 * soKhach;
            const tongDichVu = tourPrice * soKhach;
            const tongTien = tongDichVu + datCoc;

            document.getElementById('display-sokhach').textContent = soKhach + ' khách';
            document.getElementById('display-giakg').textContent = formatCurrency(tourPrice);
            document.getElementById('display-datcoc').textContent = formatCurrency(datCoc);
            document.getElementById('display-tongdichvu').textContent = formatCurrency(tongDichVu);
            document.getElementById('display-tongtien').textContent = formatCurrency(tongTien);
            document.getElementById('tongTien').value = Math.round(tongTien);
            document.getElementById('datCoc').value = Math.round(datCoc);
        }

        // ==================== HÀM HELPER ====================
        function formatCurrency(value) {
            return parseInt(value || 0).toLocaleString('vi-VN') + ' VNĐ';
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('vi-VN');
        }

        // ==================== XÁC THỰC FORM ====================
        function validateForm() {
            const tourId = document.getElementById('tour_id').value;
            const hdvId = document.getElementById('hdv_id').value;
            const existingRows = document.querySelectorAll('#selected-customers-tbody tr');
            const newRows = document.querySelectorAll('#customers-tbody .customer-row');
            const totalRows = existingRows.length + newRows.length;

            if (!tourId) {
                alert('Vui lòng chọn tour');
                return false;
            }

            if (!hdvId) {
                alert('Vui lòng chọn hướng dẫn viên');
                return false;
            }

            if (totalRows === 0) {
                alert('Vui lòng thêm ít nhất một khách hàng (từ dropdown hoặc form mới)');
                return false;
            }

            // Kiểm tra dữ liệu khách hàng mới
            for (let row of newRows) {
                const tenInput = row.querySelector('input[name="ten[]"]');
                const dienThoaiInput = row.querySelector('input[name="dienThoai[]"]');

                if (!tenInput.value.trim() || !dienThoaiInput.value.trim()) {
                    alert('Vui lòng điền tên và điện thoại cho tất cả khách hàng mới');
                    return false;
                }
            }

            return true;
        }

        // ==================== GỬI FORM ====================
        function submitForm() {
            if (validateForm()) {
                document.getElementById('bookingForm').submit();
            }
        }

        // Cập nhật tổng tiền khi thay đổi dữ liệu khách hàng
        document.addEventListener('change', function(e) {
            if (e.target.name && (e.target.name.startsWith('ten') || e.target.name.startsWith('dienThoai'))) {
                calculateTotal();
            }
        });

        // Tính toán ban đầu
        calculateTotal();
    </script>
</body>
</html>