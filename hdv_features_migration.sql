USE dragontravel;

-- ================================================================
-- 1. ALTER TABLE: don_hang_khach_hang (for ĐIỂM DANH feature)
-- ================================================================
ALTER TABLE `don_hang_khach_hang`
ADD COLUMN `diem_danh_id` INT DEFAULT NULL COMMENT 'ID của điểm tập trung',
ADD COLUMN `tgDiemDanh` DATETIME DEFAULT NULL COMMENT 'Thời gian điểm danh',
ADD COLUMN `hdv_xacNhan_id` INT DEFAULT NULL COMMENT 'HDV xác nhận điểm danh',
ADD KEY `idx_diem_danh` (`diem_danh_id`);

-- ================================================================
-- 2. ALTER TABLE: khach_hang_danh_gia (for ĐÁNH GIÁ TOUR feature)
-- ================================================================
ALTER TABLE `khach_hang_danh_gia`
ADD COLUMN `hdv_id` INT DEFAULT NULL COMMENT 'HDV đánh giá (null nếu khách đánh giá)',
ADD COLUMN `danhGia_anToan` INT DEFAULT NULL COMMENT 'Đánh giá an toàn 1-5',
ADD COLUMN `danhGia_haiLong` INT DEFAULT NULL COMMENT 'Đánh giá hài lòng 1-5',
ADD COLUMN `diemNoiBat` TEXT COMMENT 'Điểm nổi bật/điều tốt',
ADD COLUMN `vanDe` TEXT COMMENT 'Vấn đề/cần cải thiện',
ADD COLUMN `anhMinhHoa` VARCHAR(500) DEFAULT NULL COMMENT 'Ảnh minh họa, phân tách bằng dấu phẩy',
ADD COLUMN `loai` VARCHAR(50) DEFAULT 'khach_hang' COMMENT 'khach_hang hoặc hdv',
ADD COLUMN `trangThai` VARCHAR(50) DEFAULT 'draft' COMMENT 'draft hoặc submitted',
ADD KEY `idx_hdv` (`hdv_id`),
ADD KEY `idx_loai` (`loai`);

-- Add foreign key for hdv_id
ALTER TABLE `khach_hang_danh_gia`
ADD CONSTRAINT `fk_danhgia_hdv` FOREIGN KEY (`hdv_id`) REFERENCES `hdv`(`id`) ON DELETE SET NULL;

-- ================================================================
-- 3. ALTER TABLE: dia_diem (for ĐIỂM TẬP TRUNG feature)
-- ================================================================
ALTER TABLE `dia_diem`
ADD COLUMN `loai` VARCHAR(50) DEFAULT 'destination' COMMENT 'checkpoint hoặc destination',
ADD COLUMN `moTa` TEXT COMMENT 'Mô tả địa điểm',
ADD COLUMN `tour_id` INT DEFAULT NULL COMMENT 'Tour liên quan',
ADD COLUMN `thuTu` INT DEFAULT 1 COMMENT 'Thứ tự trong lịch trình',
ADD COLUMN `trangThai` VARCHAR(50) DEFAULT 'pending' COMMENT 'pending, active, completed',
ADD KEY `idx_tour` (`tour_id`),
ADD KEY `idx_loai` (`loai`);

-- Add foreign key for tour_id
ALTER TABLE `dia_diem`
ADD CONSTRAINT `fk_diadiem_tour` FOREIGN KEY (`tour_id`) REFERENCES `tour`(`id`) ON DELETE CASCADE;

-- ================================================================
-- 4. CREATE TABLE: yeu_cau_dac_biet (NEW)
-- ================================================================
CREATE TABLE `yeu_cau_dac_biet` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tour_id` INT NOT NULL COMMENT 'ID tour',
  `khachHang_id` INT NOT NULL COMMENT 'ID khách hàng',
  `loaiYeuCau` VARCHAR(50) NOT NULL COMMENT 'food, medical, mobility, other',
  `noiDung` TEXT NOT NULL COMMENT 'Nội dung yêu cầu',
  `doUuTien` VARCHAR(50) DEFAULT 'normal' COMMENT 'normal, urgent, critical',
  `trangThai` VARCHAR(50) DEFAULT 'active' COMMENT 'active, resolved, cancelled',
  `ghiChu` TEXT COMMENT 'Ghi chú xử lý',
  `nguoiTao_id` INT DEFAULT NULL COMMENT 'HDV tạo yêu cầu',
  `ngayTao` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `ngayCapNhat` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tour` (`tour_id`),
  KEY `idx_khachhang` (`khachHang_id`),
  KEY `idx_loai` (`loaiYeuCau`),
  KEY `idx_uutien` (`doUuTien`),
  CONSTRAINT `fk_yeucau_tour` FOREIGN KEY (`tour_id`) REFERENCES `tour`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_yeucau_khachhang` FOREIGN KEY (`khachHang_id`) REFERENCES `khach_hang`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_yeucau_hdv` FOREIGN KEY (`nguoiTao_id`) REFERENCES `hdv`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ================================================================
-- 5. CREATE TABLE: nhat_ky_tour (NEW)
-- ================================================================
CREATE TABLE `nhat_ky_tour` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tour_id` INT NOT NULL COMMENT 'ID tour',
  `hdv_id` INT NOT NULL COMMENT 'HDV ghi nhật ký',
  `loai` VARCHAR(50) NOT NULL COMMENT 'event, activity, incident, note',
  `tieuDe` VARCHAR(200) NOT NULL COMMENT 'Tiêu đề',
  `noiDung` TEXT NOT NULL COMMENT 'Nội dung chi tiết',
  `doUuTien` VARCHAR(50) DEFAULT 'normal' COMMENT 'normal, high, critical',
  `viTri` VARCHAR(200) DEFAULT NULL COMMENT 'Vị trí/địa điểm',
  `tags` VARCHAR(500) DEFAULT NULL COMMENT 'Tags, phân tách bằng dấu phẩy',
  `anhMinhHoa` VARCHAR(500) DEFAULT NULL COMMENT 'Ảnh minh họa, phân tách bằng dấu phẩy',
  `ngayTao` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `ngayCapNhat` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tour` (`tour_id`),
  KEY `idx_hdv` (`hdv_id`),
  KEY `idx_loai` (`loai`),
  CONSTRAINT `fk_nhatky_tour` FOREIGN KEY (`tour_id`) REFERENCES `tour`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_nhatky_hdv` FOREIGN KEY (`hdv_id`) REFERENCES `hdv`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ================================================================
-- 6. CREATE TABLE: danh_gia_nha_cung_cap (NEW)
-- ================================================================
CREATE TABLE `danh_gia_nha_cung_cap` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `danhGia_id` INT NOT NULL COMMENT 'ID từ khach_hang_danh_gia',
  `loaiNCC` VARCHAR(50) NOT NULL COMMENT 'hotel, restaurant, transport, local_guide',
  `tenNCC` VARCHAR(200) NOT NULL COMMENT 'Tên nhà cung cấp',
  `diem` INT NOT NULL COMMENT 'Đánh giá 1-5',
  `nhanXet` TEXT COMMENT 'Nhận xét chi tiết',
  `ngayTao` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_danhgia` (`danhGia_id`),
  KEY `idx_loaincc` (`loaiNCC`),
  CONSTRAINT `fk_danhgia_ncc` FOREIGN KEY (`danhGia_id`) REFERENCES `khach_hang_danh_gia`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- Migration: Thêm bảng theo dõi điểm danh theo địa điểm
-- Mỗi khách hàng có thể được điểm danh ở nhiều địa điểm khác nhau trong cùng 1 tour

CREATE TABLE IF NOT EXISTS diem_danh (
    id INT PRIMARY KEY AUTO_INCREMENT,
    donHangKhachHang_id INT NOT NULL COMMENT 'ID khách hàng trong đơn hàng',
    diaDiem_id INT NOT NULL COMMENT 'ID địa điểm điểm danh (từ bảng dia_diem)',
    trangThai ENUM('present', 'absent') NOT NULL COMMENT 'Có mặt / Vắng mặt',
    tgDiemDanh DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời gian điểm danh',
    hdv_xacNhan_id INT NULL COMMENT 'HDV xác nhận điểm danh',
    ghiChu TEXT NULL COMMENT 'Ghi chú khi điểm danh',
    
    FOREIGN KEY (donHangKhachHang_id) REFERENCES don_hang_khach_hang(id) ON DELETE CASCADE,
    FOREIGN KEY (diaDiem_id) REFERENCES dia_diem(id) ON DELETE CASCADE,
    FOREIGN KEY (hdv_xacNhan_id) REFERENCES hdv(id) ON DELETE SET NULL,
    
    -- Mỗi khách hàng chỉ được điểm danh 1 lần tại 1 địa điểm
    UNIQUE KEY unique_checkin (donHangKhachHang_id, diaDiem_id),
    
    INDEX idx_dia_diem (diaDiem_id),
    INDEX idx_khach_hang (donHangKhachHang_id),
    INDEX idx_trang_thai (trangThai),
    INDEX idx_diem_danh_time (tgDiemDanh)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
