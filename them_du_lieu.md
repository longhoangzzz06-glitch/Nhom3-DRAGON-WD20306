Các bảng dữ liệu cần thêm vào để chạy cần thêm những bảng sau

CREATE TABLE nha_cung_cap (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(255) NOT NULL,
    loai_dich_vu VARCHAR(255),       -- Khách sạn, Nhà hàng, Vận chuyển, ...
    dien_thoai VARCHAR(50),
    email VARCHAR(100),
    dia_chi VARCHAR(255),
    ghi_chu TEXT,
    logo VARCHAR(255)
);
CREATE TABLE hop_dong (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nha_cung_cap_id INT NOT NULL,
    tour_id INT NOT NULL,
    file_hop_dong VARCHAR(255),
    gia DECIMAL(15,2),
    ghi_chu TEXT,
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nha_cung_cap_id) REFERENCES nha_cung_cap(id)
    -- tour_id có thể liên kết bảng tours nếu có
);
CREATE TABLE cong_no (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nha_cung_cap_id INT NOT NULL,
    tour_id INT NOT NULL,
    sotien DECIMAL(15,2) NOT NULL,
    loai ENUM('con_no','da_thanh_toan') DEFAULT 'con_no',
    ghi_chu TEXT,
    ngay DATE NOT NULL,
    FOREIGN KEY (nha_cung_cap_id) REFERENCES nha_cung_cap(id)
);
CREATE TABLE danh_gia_ncc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nha_cung_cap_id INT NOT NULL,
    tour_id INT NOT NULL,
    diem TINYINT NOT NULL,           -- 1-5
    binh_luan TEXT,
    ngay_danh_gia DATE NOT NULL,
    FOREIGN KEY (nha_cung_cap_id) REFERENCES nha_cung_cap(id)
);
-- Thu nhập từ tour
CREATE TABLE thu_tour (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tour_id INT NOT NULL,
    sotien DECIMAL(15,2) NOT NULL,
    nguon VARCHAR(255),              -- Khách hàng, đối tác,...
    ngay DATE NOT NULL
);

-- Chi phí cho tour
CREATE TABLE chi_tour (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tour_id INT NOT NULL,
    sotien DECIMAL(15,2) NOT NULL,
    dich_vu VARCHAR(255),            -- Khách sạn, Nhà hàng, Vận chuyển,...
    ngay DATE NOT NULL
);
