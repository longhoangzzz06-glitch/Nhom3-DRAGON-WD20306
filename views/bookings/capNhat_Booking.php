<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Booking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/chung/css/form.css" />
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
    <div class="content-wrapper">
        <div class="content-container">
            <div class="container">
                <h1>Sửa thông tin Booking</h1>
    
    <?php
    if (!isset($donHang) || !$donHang) {
        echo "<p style='color: red;'>Không tìm thấy dữ liệu booking!</p>";
        exit;
    }
    ?>
        <?php
        // Tìm tour hiện tại
        $currentTour = null;
        foreach ($tourList as $tour) {
            if ($tour['id'] == $donHang['tour_id']) {
                $currentTour = $tour;
                break;
            }
        }

        $gia = $currentTour['gia'] ?? 0;
        $datCoc = $gia * 0.2;
        $tongTien = $gia * $countKhachHang;
        ?>
        <form action="index.php?act=cap-nhat-booking&id=<?php echo htmlspecialchars($donHang['id']);?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($donHang['id']); ?>">
            
            <div class="form-group">
                <label for="tour_id">Tour: <span style="color: red;">*</span></label>
                <select id="tour_id" name="tour_id" required>
                    <option value="">-- Chọn tour --</option>
                    <?php foreach ($tourList as $tour): ?>
                        <option value="<?php echo $tour['id']; ?>"
                                data-gia="<?php echo $tour['gia']; ?>"
                                <?php echo ($donHang['tour_id'] == $tour['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($tour['ten']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="hdv_id">Hướng dẫn viên: <span style="color: red;">*</span></label>
                <select id="hdv_id" name="hdv_id" required>
                    <option value="">-- Chọn HDV --</option>
                    <?php foreach ($hdvList as $hdv): ?>
                        <option value="<?php echo $hdv['id']; ?>" <?php echo ($donHang['hdv_id'] == $hdv['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($hdv['hoTen']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="tgBatDau">Thời gian bắt đầu: <span style="color: red;">*</span></label>
                <input type="datetime-local" id="tgBatDau" name="tgBatDau" value="<?php 
                    $dt = $donHang['tgBatDau'];
                    echo date('Y-m-d\TH:i', strtotime($dt));
                ?>" required>
            </div>

            <div class="form-group">
                <label for="tgKetThuc">Thời gian kết thúc: <span style="color: red;">*</span></label>
                <input type="datetime-local" id="tgKetThuc" name="tgKetThuc" value="<?php 
                    $dt = $donHang['tgKetThuc'];
                    echo date('Y-m-d\TH:i', strtotime($dt));
                ?>" required>
            </div>

            <div class="form-group">
                <label for="tgDatDon">Thời gian đặt đơn: <span style="color: red;">*</span></label>
                <input type="datetime-local" id="tgDatDon" name="tgDatDon" value="<?php 
                    $dt = $donHang['tgDatDon'];
                    echo date('Y-m-d\TH:i', strtotime($dt));
                ?>" required>
            </div>

            <div class="form-group">
                <label for="datCoc">Đặt cọc (VND):</label>
                <input type="number" id="datCoc" name="datCoc" value="<?php echo htmlspecialchars($donHang['datCoc']); ?>" min="0">
            </div>

            <div class="form-group">
                <label for="tongTien">Tổng tiền (VND): <span style="color: red;">*</span></label>
                <input type="number" id="tongTien" name="tongTien" value="<?php echo htmlspecialchars($donHang['tongTien']); ?>" required min="0">
            </div>

            <div class="form-group">
                <label for="trangThai">Trạng thái:</label>
                <select id="trangThai" name="trangThai">
                    <option value="Chờ xác nhận" <?php echo ($donHang['trangThai'] == 'Chờ xác nhận') ? 'selected' : ''; ?>>Chờ xác nhận</option>
                    <option value="Đã cọc" <?php echo ($donHang['trangThai'] == 'Đã cọc') ? 'selected' : ''; ?>>Đã Cọc</option>
                    <option value="Đã hoàn thành" <?php echo ($donHang['trangThai'] == 'Đã hoàn thành') ? 'selected' : ''; ?>>Đã hoàn thành</option>
                    <option value="Đã hủy" <?php echo ($donHang['trangThai'] == 'Đã hủy') ? 'selected' : ''; ?>>Đã hủy</option>
                </select>
            </div>

            <!-- Danh sách khách hàng -->
            <div style="margin-top: 40px;">
                <h2>Danh sách khách hàng</h2>

                <!-- Phần 1: Chọn khách hàng có sẵn -->
                <div style="margin: 20px 0; padding: 15px; background: #e3f2fd; border: 1px solid #1976d2; border-radius: 4px; border-left: 4px solid #1976d2;">
                    <h3 style="margin-top: 0; color: #1565c0; margin-bottom: 15px;">
                        <i class="fas fa-hand-pointer"></i> Chọn Khách Hàng Có Sẵn
                    </h3>
                    <div style="display: grid; grid-template-columns: 1fr; gap: 10px;">
                        <div>
                            <label>Khách Hàng</label>
                            <?php 
                            $bookingModel = new Booking();

                            // 1. Lấy tất cả khách
                            $allKhachHangList = $bookingModel->getAllKhachHang();

                            // 2. Lấy khách đã thuộc booking
                            $donHangKhachHangList = $bookingModel->getDonHangKhachHang($donHang['id']);

                            // 3. Lấy danh sách ID đã có
                            $existingCustomerIds = array_column($donHangKhachHangList, 'khachHang_id');
                            ?>
                            <select id="existing_customer" onchange="addExistingCustomerEdit(<?= $donHang['id']; ?>)"
                                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px;">
                                <option value="">-- Chọn khách hàng --</option>

                                <?php foreach ($allKhachHangList as $kh): ?>
                                    <?php if (in_array($kh['id'], $existingCustomerIds)) continue; ?>
                                    <option value="<?= $kh['id']; ?>"
                                            data-ten="<?= htmlspecialchars($kh['ten']); ?>"
                                            data-dienthoai="<?= htmlspecialchars($kh['dienThoai']); ?>"
                                            data-email="<?= htmlspecialchars($kh['email']); ?>">
                                        <?= htmlspecialchars($kh['ten']); ?> (<?= htmlspecialchars($kh['dienThoai']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Phần 2: Tạo khách hàng mới -->
                <div style="margin: 20px 0; padding: 15px; background: #f3e5f5; border: 1px solid #7b1fa2; border-radius: 4px; border-left: 4px solid #7b1fa2;">
                    <h3 style="margin-top: 0; color: #6a1b9a; margin-bottom: 15px;">
                        <i class="fas fa-user-plus"></i> Tạo Khách Hàng Mới
                    </h3>
                    <div id="newCustomerForm" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                        <div>
                            <label for="newTen">Tên <span style="color: red;">*</span></label>
                            <input type="text" id="newTen" placeholder="Tên khách hàng" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;">
                        </div>
                        <div>
                            <label for="newTuoi">Tuổi</label>
                            <input type="number" id="newTuoi" placeholder="Tuổi" min="0" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;">
                        </div>
                        <div>
                            <label for="newGioiTinh">Giới tính</label>
                            <select id="newGioiTinh" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;">
                                <option value="">-- Chọn --</option>
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                            </select>
                        </div>
                        <div>
                            <label for="newDienThoai">Điện thoại <span style="color: red;">*</span></label>
                            <input type="text" id="newDienThoai" placeholder="Điện thoại" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;">
                        </div>
                        <div>
                            <label for="newEmail">Email</label>
                            <input type="email" id="newEmail" placeholder="Email" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;">
                        </div>
                    </div>
                    <button type="button" onclick="addNewCustomerEdit(<?php echo $donHang['id']; ?>)" style="margin-top: 15px; padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">
                        <i class="fas fa-plus"></i> Thêm khách hàng mới
                    </button>
                </div>

                <!-- Danh sách khách hàng đã thêm -->
                <div style="margin-top: 20px;">
                    <h3>Danh sách hiện tại</h3>
                    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                        <thead>
                            <tr style="background-color: #f5f5f5; border-bottom: 2px solid #ddd;">
                                <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">STT</th>
                                <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Tên</th>
                                <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Tuổi</th>
                                <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Giới tính</th>
                                <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Điện thoại</th>
                                <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Email</th>
                                <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Check-in</th>
                                <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Hành động</th>
                            </tr>
                        </thead>
                            <tbody>
                            <?php if (empty($donHangKhachHangList)): ?>
                                <tr>
                                    <td colspan="8" style="padding: 15px; text-align: center; border: 1px solid #ddd; color: #999;">
                                        Không có khách hàng
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($donHangKhachHangList as $index => $kh): ?>
                                    <tr style="border-bottom: 1px solid #ddd;" class="customer-row">
                                        <td style="padding: 10px; border: 1px solid #ddd;"><?= $index + 1; ?></td>

                                        <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($kh['ten']); ?></td>

                                        <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($kh['tuoi']); ?></td>

                                        <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($kh['gioiTinh']); ?></td>

                                        <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($kh['dienThoai']); ?></td>

                                        <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($kh['email']); ?></td>

                                        <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                                            <span style="
                                                display: inline-block;
                                                padding: 5px 10px;
                                                border-radius: 4px;
                                                font-size: 12px;
                                                font-weight: 500;
                                                <?= ($kh['trangThai_checkin'] == 1) ? 'background-color: #28a745; color: white;' : 'background-color: #dc3545; color: white;'; ?>
                                            ">
                                                <?= ($kh['trangThai_checkin'] == 1) ? '✓ Đã' : '✗ Chưa'; ?>
                                            </span>
                                        </td>

                                        <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                                            <button type="button" class="btn-delete"
                                                    onclick="deleteCustomer(<?= $kh['khachHang_id']; ?>, <?= $donHang['id']; ?>)"
                                                    style="padding: 5px 10px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                    </table>
                </div>
            </div>
            <!-- THÔNG TIN THANH TOÁN -->
            <div class="form-section" style="margin-top: 20px;">
                <h3 class="form-section-title">
                    <i class="fas fa-credit-card"></i>
                    Thông Tin Thanh Toán
                </h3>

                <div class="">
                    <div class="info-row">
                        <span class="info-label">Số lượng khách:</span>
                        <span class="info-value" id="display-sokhach"><?= number_format($countKhachHang, 0, ',', '.') ?>/<?= number_format($donHang['tour_maxKhach'], 0, ',', '.') ?> khách</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Giá/khách:</span>
                        <span class="info-value" id="display-giakg"><?= number_format($donHang['tour_gia'], 0, ',', '.') ?> VNĐ</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tiền đặt cọc (20%):</span>
                        <span class="info-value" id="display-datcoc">
                            <?= number_format($gia * 0.2, 0, ',', '.') ?>
                            VNĐ</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tổng tiền dịch vụ:</span>
                        <span class="info-value" id="display-tongdichvu">
                            <?= number_format(($gia * $countKhachHang) - ($gia * 0.2), 0, ',', '.') ?>
                            VNĐ
                        </span>
                    </div>
                    <div class="info-row" style="border-top: 2px solid #d1d5db; padding-top: 12px; margin-top: 12px;">
                        <span class="info-label" style="font-size: 16px; font-weight: 700;">Tổng cộng:</span>
                        <span class="price-highlight" id="display-tongtien"><?= number_format(($gia * $countKhachHang), 0, ',', '.') ?> VNĐ</span>
                    </div>
                </div>
                <input type="hidden" id="tongTien" name="tongTien" value="<?= $donHang['tongTien'] ?>">
                <input type="hidden" id="datCoc" name="datCoc" value="0">
            </div>
            <div class="button-group">
                <button type="submit" class="btn-submit">Cập nhật</button>
                <button type="button" class="btn-cancel" onclick="window.location.href='index.php?act=quan-ly-booking'">Hủy</button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
    /* ===========================================================
        HELPER FUNCTION – DÙNG CHUNG
    =========================================================== */
    async function sendRequest(url, formData) {
        try {
            const response = await fetch(url, { method: "POST", body: formData });

            const raw = await response.text(); // luôn đọc text trước
            try {
                return JSON.parse(raw);        // thử parse JSON
            } catch (err) {
                console.error("JSON Parse Error:", err, raw);
                return { success: false, message: "Phản hồi server không hợp lệ." };
            }

        } catch (error) {
            console.error("Fetch Error:", error);
            return { success: false, message: error.message };
        }
    }
    /* ===========================================================
        THÊM KHÁCH HÀNG CÓ SẴN
    =========================================================== */
    async function addExistingCustomerEdit(bookingId) {
        const select = document.getElementById("existing_customer");
        const khachHangId = select.value;

        if (!khachHangId) return;

        const formData = new FormData();
        formData.append("donHang_id", bookingId);
        formData.append("khachHang_id", khachHangId);

        const result = await sendRequest("index.php?act=api-add-customer-link", formData);

        if (result.success) {
            alert("Thêm khách hàng thành công");
            location.reload();
        } else {
            alert(result.message || "Không thể thêm khách hàng");
        }

        select.value = "";
    }

    /* ===========================================================
        VALIDATE CƠ BẢN
    =========================================================== */
    function validateNewCustomer() {
        const ten = document.getElementById("newTen").value.trim();
        const dienThoai = document.getElementById("newDienThoai").value.trim();
        const email = document.getElementById("newEmail").value.trim();

        if (!ten) return "Vui lòng nhập tên khách hàng.";
        if (!dienThoai) return "Vui lòng nhập số điện thoại.";
        if (!/^[0-9]{10,11}$/.test(dienThoai)) return "Số điện thoại phải có 10–11 chữ số.";
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) return "Email không hợp lệ.";

        return null;
    }

    /* ===========================================================
        THÊM KHÁCH HÀNG MỚI
    =========================================================== */
    async function addNewCustomerEdit(bookingId) {
        const error = validateNewCustomer();
        if (error) return alert(error);

        const formData = new FormData();
        formData.append("donHang_id", bookingId);
        formData.append("ten", document.getElementById("newTen").value.trim());
        formData.append("tuoi", document.getElementById("newTuoi").value.trim());
        formData.append("gioiTinh", document.getElementById("newGioiTinh").value.trim());
        formData.append("dienThoai", document.getElementById("newDienThoai").value.trim());
        formData.append("email", document.getElementById("newEmail").value.trim());

        const result = await sendRequest("index.php?act=api-add-customer", formData);

        if (result.success) {
            alert("Thêm khách hàng mới thành công");
            location.reload();
        } else {
            alert(result.message || "Không thể thêm khách hàng");
        }
    }

    /* ===========================================================
        XÓA KHÁCH HÀNG
    =========================================================== */
    async function deleteCustomer(customerId, bookingId) {
        if (!confirm("Bạn có chắc chắn muốn xóa khách hàng này?")) return;

        const formData = new FormData();
        formData.append("khachHang_id", customerId);
        formData.append("donHang_id", bookingId);

        const result = await sendRequest("index.php?act=api-delete-customer", formData);

        if (result.success) {
            alert("Xóa khách hàng thành công");
            location.reload();
        } else {
            alert(result.message || "Không thể xóa khách hàng");
        }
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