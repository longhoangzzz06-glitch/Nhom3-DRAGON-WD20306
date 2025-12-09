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

                <form id="bookingForm" method="POST" action="index.php?act=dat-booking">

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
                                                data-maxkhach="<?php echo $tour['maxKhach']; ?>">
                                            <?php echo htmlspecialchars($tour['ten']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="">
                            <div class="info-row" style="margin: 10px 0">
                                <span class="info-label">Giá Tour:</span>
                                <span class="info-value" id="display-gia">-</span>
                            </div>
                            <div class="info-row" style="margin: 10px 0">
                                <span class="info-label">Số lượng khách tối đa:</span>
                                <span class="info-value" id="display-maxkhach">-</span>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Ngày bắt đầu:</span>                                    
                                </div>
                                <input type="date" class="form-control" id="tgBatDau" name="tgBatDau" required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Ngày kết thúc:</span>                                    
                                </div>
                                <input type="date" class="form-control" id="tgKetThuc" name="tgKetThuc" required>
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
                    <!-- THÔNG TIN THANH TOÁN -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <i class="fas fa-credit-card"></i>
                            Thông Tin Thanh Toán
                        </h3>

                        <div class="">
                            <div class="info-row">
                                <span class="info-label">Số lượng khách:</span>
                                <span class="info-value" id="display-sokhach">0/0 khách</span>
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
                    document.getElementById('display-maxkhach').textContent = '-';
                    tourPrice = 0;

                    calculateTotal();
                    return;
                }

                const gia = selectedOption.dataset.gia;
                let maxkhach = selectedOption.dataset.maxkhach;

                tourPrice = parseInt(gia) || 0;
                maxkhach = parseInt(maxkhach) || 0;

                document.getElementById('display-gia').textContent = formatCurrency(gia);
                document.getElementById('display-maxkhach').textContent = formatMaxkhach(maxkhach);

                calculateTotal();
            }

            async function sendRequest(url, formData) {
                try {
                    const response = await fetch(url, { method: "POST", body: formData });
                    const raw = await response.text();
                    try {
                        return JSON.parse(raw);
                    } catch (err) {
                        console.error("JSON Parse Error:", err, raw);
                        return { success: false, message: "Phản hồi server không hợp lệ." };
                    }
                } catch (error) {
                    console.error("Fetch Error:", error);
                    return { success: false, message: error.message };
                }
            }

            // ==================== TÍNH TOÁN TỔNG TIỀN ====================
            function calculateTotal() {
                // Đếm số khách đang có trong bảng danh sách
                const soKhach = document.querySelectorAll("table tbody tr").length;
                const maxkhach = parseInt(document.getElementById('tour_id').selectedOptions[0]?.dataset.maxkhach) || 0;

                // Tính tiền
                const datCoc = tourPrice * 0.2 * soKhach;
                const tongDichVu = tourPrice * soKhach;
                const tongTien = tongDichVu;

                // Cập nhật giao diện
                document.getElementById('display-sokhach').textContent = soKhach + '/' + maxkhach + ' khách';
                document.getElementById('display-giakg').textContent = formatCurrency(tourPrice);
                document.getElementById('display-datcoc').textContent = formatCurrency(datCoc);
                document.getElementById('display-tongdichvu').textContent = formatCurrency(tongDichVu);
                document.getElementById('display-tongtien').textContent = formatCurrency(tongTien);

                // Gửi dữ liệu vào input hidden
                document.getElementById('tongTien').value = tongTien;
                document.getElementById('datCoc').value = datCoc;
            }

            // ==================== HÀM HELPER ====================
            function formatCurrency(value) {
                return parseInt(value || 0).toLocaleString('vi-VN') + ' VNĐ';
            }

            function formatMaxkhach(value) {
                return parseInt(value || 0).toLocaleString('vi-VN') + ' khách';
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
                const tgBatDau = document.getElementById('tgBatDau').value;
                const tgKetThuc = document.getElementById('tgKetThuc').value;

                if (!tourId) {
                    alert('Vui lòng chọn tour');
                    return false;
                }

                if (!hdvId) {
                    alert('Vui lòng chọn hướng dẫn viên');
                    return false;
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