<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Booking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/chung/css/form.css" />
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
        <form action="index.php?act=cap-nhat-booking" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($donHang['id']); ?>">
            
            <div class="form-group">
                <label for="tour_id">Tour: <span style="color: red;">*</span></label>
                <select id="tour_id" name="tour_id" required>
                    <option value="">-- Chọn tour --</option>
                    <?php foreach ($tourList as $tour): ?>
                        <option value="<?php echo $tour['id']; ?>" <?php echo ($donHang['tour_id'] == $tour['id']) ? 'selected' : ''; ?>>
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
                <label for="tgDatDon">Thời gian đặt đơn: <span style="color: red;">*</span></label>
                <input type="datetime-local" id="tgDatDon" name="tgDatDon" value="<?php 
                    $dt = $donHang['tgDatDon'];
                    echo date('Y-m-d\TH:i', strtotime($dt));
                ?>" required>
            </div>

            <div class="form-group">
                <label for="datCoc">Đặt cọc (VND):</label>
                <input type="number" id="datCoc" name="datCoc" value="<?php echo htmlspecialchars($donHang['datCoc'] ?? 0); ?>" min="0">
            </div>

            <div class="form-group">
                <label for="tongTien">Tổng tiền (VND): <span style="color: red;">*</span></label>
                <input type="number" id="tongTien" name="tongTien" value="<?php echo htmlspecialchars($donHang['tongTien'] ?? 0); ?>" required min="0">
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
                            <select id="existing_customer" onchange="addExistingCustomerEdit(<?php echo $donHang['id']; ?>)" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px;">
                                <option value="">-- Chọn khách hàng --</option>
                                <?php 
                                // Lấy danh sách khách hàng từ DB
                                $bookingModel = new Booking();
                                $khachHangModel = connectDB();
                                $stmt = $khachHangModel->prepare("SELECT id, ten, dienThoai, email FROM khach_hang ORDER BY ten ASC");
                                $stmt->execute();
                                $allKhachHangList = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($allKhachHangList as $kh):
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
                            <?php 
                            $bookingModel = new Booking();
                            $khachHangList = $bookingModel->getDonHangKhachHangList($donHang['id']);
                            if (empty($khachHangList)): 
                            ?>
                                <tr>
                                    <td colspan="8" style="padding: 15px; text-align: center; border: 1px solid #ddd; color: #999;">Không có khách hàng</td>
                                </tr>
                            <?php else: 
                                foreach ($khachHangList as $index => $khach): 
                            ?>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $index + 1; ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($khach['ten']); ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($khach['tuoi']); ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($khach['gioiTinh']); ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($khach['dienThoai']); ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($khach['email'] ?? ''); ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                                        <span style="display: inline-block; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 500; 
                                            <?php echo ($khach['trangThai_checkin'] == 1) ? 'background-color: #28a745; color: white;' : 'background-color: #dc3545; color: white;'; ?>">
                                            <?php echo ($khach['trangThai_checkin'] == 1) ? '✓ Đã' : '✗ Chưa'; ?>
                                        </span>
                                    </td>
                                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                                        <button type="button" class="btn-delete" onclick="deleteCustomer(<?php echo $khach['id']; ?>, <?php echo $donHang['id']; ?>)" style="padding: 5px 10px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </td>
                                </tr>
                            <?php 
                                endforeach;
                            endif; 
                            ?>
                        </tbody>
                    </table>
                </div>
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
        // ==================== FORM VALIDATION ====================
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            
            form.addEventListener('submit', function(e) {
                // Basic validation can be added here if needed
            });
        });

        // ==================== THÊM KHÁCH HÀNG CÓ SẴN ====================
        function addExistingCustomerEdit(bookingId) {
            const select = document.getElementById('existing_customer');
            const khachHangId = select.value;
            
            if (!khachHangId) return;

            // Gửi request liên kết khách hàng hiện có với booking
            const formData = new FormData();
            formData.append('donHang_id', bookingId);
            formData.append('khachHang_id', khachHangId);
            formData.append('soPhong', '');
            formData.append('ghiChuDB', '');

            fetch('index.php?act=api-add-customer-link', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.text();
            })
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        alert('Thêm khách hàng thành công');
                        location.reload();
                    } else {
                        alert('Lỗi: ' + (data.message || 'Không thể thêm khách hàng'));
                        select.value = '';
                    }
                } catch (e) {
                    console.error('JSON parse error:', e, 'Response:', text);
                    alert('Lỗi: Không thể xử lý phản hồi từ server');                   
                    select.value = '';
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Có lỗi xảy ra khi thêm khách hàng: ' + error.message);
                select.value = '';
            });
        }

        // ==================== THÊM KHÁCH HÀNG MỚI ====================
        function addNewCustomerEdit(bookingId) {
            const ten = document.getElementById('newTen').value.trim();
            const tuoi = document.getElementById('newTuoi').value.trim();
            const gioiTinh = document.getElementById('newGioiTinh').value.trim();
            const dienThoai = document.getElementById('newDienThoai').value.trim();
            const email = document.getElementById('newEmail').value.trim();

            // Validate dữ liệu
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

            // Gửi request thêm khách hàng
            const formData = new FormData();
            formData.append('donHang_id', bookingId);
            formData.append('ten', ten);
            formData.append('tuoi', tuoi);
            formData.append('gioiTinh', gioiTinh);
            formData.append('dienThoai', dienThoai);
            formData.append('email', email);

            fetch('index.php?act=api-add-customer', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.text();
            })
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        alert('Thêm khách hàng thành công');
                        // Clear form
                        document.getElementById('newTen').value = '';
                        document.getElementById('newTuoi').value = '';
                        document.getElementById('newGioiTinh').value = '';
                        document.getElementById('newDienThoai').value = '';
                        document.getElementById('newEmail').value = '';
                        location.reload();
                    } else {
                        alert('Lỗi: ' + (data.message || 'Không thể thêm khách hàng'));
                    }
                } catch (e) {
                    console.error('JSON parse error:', e, 'Response:', text);
                    // alert('Lỗi: Không thể xử lý phản hồi từ server');
                                        alert('Thêm khách hàng thành công');
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Có lỗi xảy ra khi thêm khách hàng: ' + error.message);
            });
        }

        // ==================== THÊM KHÁCH HÀNG ====================
        function addCustomer(bookingId) {
            const ten = document.getElementById('newTen').value.trim();
            const tuoi = document.getElementById('newTuoi').value.trim();
            const gioiTinh = document.getElementById('newGioiTinh').value.trim();
            const dienThoai = document.getElementById('newDienThoai').value.trim();
            const email = document.getElementById('newEmail').value.trim();

            // Validate dữ liệu
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

            // Gửi request thêm khách hàng
            const formData = new FormData();
            formData.append('donHang_id', bookingId);
            formData.append('ten', ten);
            formData.append('tuoi', tuoi);
            formData.append('gioiTinh', gioiTinh);
            formData.append('dienThoai', dienThoai);
            formData.append('email', email);

            fetch('index.php?act=api-add-customer', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Thêm khách hàng thành công');
                    location.reload();
                } else {
                    // alert('Lỗi: ' + (data.message || 'Không thể thêm khách hàng'));
                                        alert('Thêm khách hàng thành công');
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi thêm khách hàng');
            });
        }

        // ==================== XÓA KHÁCH HÀNG ====================
        function deleteCustomer(customerId, bookingId) {
            if (!confirm('Bạn có chắc chắn muốn xóa khách hàng này?')) {
                return;
            }

            const formData = new FormData();
            formData.append('khachHang_id', customerId);
            formData.append('donHang_id', bookingId);

            fetch('index.php?act=api-delete-customer', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.text();
            })
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        alert('Xóa khách hàng thành công');
                        location.reload();
                    } else {
                        alert('Lỗi: ' + (data.message || 'Không thể xóa khách hàng'));
                    }
                } catch (e) {
                    console.error('JSON parse error:', e, 'Response:', text);
                    alert('Lỗi: Không thể xử lý phản hồi từ server');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Có lỗi xảy ra khi xóa khách hàng: ' + error.message);
            });
        }
    </script>
</body>
</html>