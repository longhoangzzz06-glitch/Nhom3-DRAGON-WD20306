-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 02, 2025 lúc 05:05 AM
-- Phiên bản máy phục vụ: 8.4.3
-- Phiên bản PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `dragontravel`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dia_diem`
--

CREATE TABLE `dia_diem` (
  `id` int NOT NULL,
  `ten` varchar(150) NOT NULL,
  `tgDi` date NOT NULL,
  `tgVe` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `dia_diem`
--

INSERT INTO `dia_diem` (`id`, `ten`, `tgDi`, `tgVe`) VALUES
(1, 'Hòn Trống Mái', '2025-11-12', '2025-11-13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `don_hang`
--

CREATE TABLE `don_hang` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `hdv_id` int DEFAULT NULL,
  `donHangKhachHang_id` int DEFAULT NULL,
  `tgDatDon` date NOT NULL,
  `datCoc` int NOT NULL,
  `tongTien` int NOT NULL,
  `trangThai` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `don_hang`
--

INSERT INTO `don_hang` (`id`, `tour_id`, `hdv_id`, `donHangKhachHang_id`, `tgDatDon`, `datCoc`, `tongTien`, `trangThai`) VALUES
(23, 2, 5, NULL, '2025-11-29', 3960000, 23760000, 'Chờ duyệt'),
(24, 3, 4, NULL, '2025-11-29', 4680009, 28080000, 'Đã hoàn thành'),
(25, 3, 6, NULL, '2025-11-29', 4680000, 28080000, 'Đã hoàn thành'),
(26, 4, 5, NULL, '2025-11-29', 780000, 4680000, 'Chờ duyệt'),
(27, 4, 5, NULL, '2025-11-29', 780000, 4680000, 'Chờ duyệt'),
(28, 3, 5, NULL, '2025-11-29', 1560000, 9360000, 'Chờ duyệt'),
(29, 4, 7, NULL, '2025-11-29', 390000, 2340000, 'Chờ duyệt');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `don_hang_khach_hang`
--

CREATE TABLE `don_hang_khach_hang` (
  `id` int NOT NULL,
  `donHang_id` int NOT NULL,
  `khachHang_id` int NOT NULL,
  `trangThai_checkin` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `soPhong` varchar(150) NOT NULL,
  `ghiChuDB` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `don_hang_khach_hang`
--

INSERT INTO `don_hang_khach_hang` (`id`, `donHang_id`, `khachHang_id`, `trangThai_checkin`, `soPhong`, `ghiChuDB`) VALUES
(9, 23, 16, NULL, '', ''),
(13, 23, 12, NULL, '', ''),
(26, 24, 16, '1', '', ''),
(31, 24, 12, NULL, '', ''),
(37, 24, 14, NULL, '', ''),
(46, 25, 23, NULL, '', ''),
(47, 25, 16, NULL, '', ''),
(48, 25, 25, NULL, '1', '1'),
(49, 26, 14, NULL, '', ''),
(50, 26, 26, NULL, '100', 'test'),
(51, 27, 14, NULL, '', ''),
(52, 29, 29, NULL, '100', 'test');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hdv`
--

CREATE TABLE `hdv` (
  `id` int NOT NULL,
  `hoTen` varchar(150) NOT NULL,
  `ngaySinh` date NOT NULL,
  `dienThoai` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `kinhNghiem` int NOT NULL,
  `nhomHDV_id` int NOT NULL,
  `ngonNgu` varchar(150) NOT NULL,
  `sucKhoe` varchar(150) NOT NULL,
  `trangThai` varchar(150) NOT NULL,
  `anh` varchar(150) NOT NULL,
  `taiKhoan_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `hdv`
--

INSERT INTO `hdv` (`id`, `hoTen`, `ngaySinh`, `dienThoai`, `email`, `kinhNghiem`, `nhomHDV_id`, `ngonNgu`, `sucKhoe`, `trangThai`, `anh`, `taiKhoan_id`) VALUES
(3, 'Phạm Như Hùng', '1974-03-27', '0782114299', 'Hung1974@gmail.com', 169, 2, 'Tiếng Việt, Tiếng Anh, Tiếng Trung, Tiếng Nga, Tiếng Hàn, Tiếng Nhật, Tiếng Bồ Đào Nha', 'Tốt', 'Không Hoạt Động', '1764254695_Nam 40-50 Việt Nam.png', 1),
(4, 'Vũ Cuồng Thiên', '2025-05-08', '0123456785', 'phammtuan2k5@gmail.com', 205, 4, 'Tiếng Việt, Tiếng Anh, Tiếng Trung', 'Tốt', 'Đang Hoạt Động', '1764287700_Nam 40-50 Việt Nam (1).png', 2),
(5, 'Phạm Tiến Dũng ', '2000-09-02', '0782115399', 'dungthin2000@gmail.com', 36, 1, 'Tiếng Việt, Tiếng Anh, Tiếng Trung, Tiếng Nga, Tiếng Hàn', 'Tốt', 'Đang Hoạt Động', '1764254743_Nam 20-25 Việt Nam.png', 3),
(6, 'Đỗ Thị Tâm', '1976-09-27', '0795222148', 'tam1976@gmail.com', 30, 6, 'Tiếng Việt, Tiếng Nga, Tiếng Hàn', 'Tốt', 'Đang Hoạt Động', '1764254815_Nữ 40-50 Việt Nam.png', 4),
(7, 'Trần Thùy Linh ', '2006-05-11', '0373736222', 'linh2006@gmail.com', 3, 3, 'Tiếng Việt, Tiếng Trung', 'Khá', 'Đang Hoạt Động', '1764254625_Nữ 20-24 Việt Nam.png', 5),
(8, 'Vũ Huyền Trang', '2005-03-31', '0767781529', 'trang2005@gmail.com', 10, 4, 'Tiếng Việt, Tiếng Anh, Tiếng Trung, Tiếng Nga, Tiếng Hàn, Tiếng Nhật, Tiếng Ấn, Tiếng Bồ Đào Nha', 'Tốt', 'Đang Hoạt Động', '1764255181_Nữ 25-28 Việt Nam.png', 6),
(9, 'Nguyễn Thị Anna', '1111-11-11', '0782114293', 'anna@gmail.com', 5, 8, 'Tiếng Nga, Tiếng Anh, Tiếng Việt', 'Tốt', 'Đang Hoạt Động', '1764286466_Nữ 17-19 Nga (1).png', 7);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hdv_nhom`
--

CREATE TABLE `hdv_nhom` (
  `id` int NOT NULL,
  `ten` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `moTa` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `hdv_nhom`
--

INSERT INTO `hdv_nhom` (`id`, `ten`, `moTa`) VALUES
(1, 'HDV chuyên tuyến Miền Bắc', 'Hướng dẫn viên am hiểu sâu về văn hóa, lịch sử, địa lý và các điểm du lịch Miền Bắc như Hà Nội, Hạ Long, Sapa, Ninh Bình, Hà Giang…'),
(2, 'HDV chuyên tuyến Miền Trung', 'Hướng dẫn viên có kinh nghiệm dẫn tour ở Miền Trung, hiểu biết về Huế – Đà Nẵng – Hội An, Quy Nhơn, Phú Yên, Nha Trang và các tuyến di sản miền Trung.'),
(3, 'HDV chuyên tuyến Miền Nam', 'Hướng dẫn viên hiểu rõ các tuyến điểm khu vực Miền Nam: TP.HCM, Tây Nam Bộ, miền Tây sông nước, Cần Thơ, An Giang, Đồng Tháp…'),
(4, 'HDV chuyên tuyến biển đảo', 'Hướng dẫn viên chuyên dẫn tour biển đảo như Phú Quốc, Lý Sơn, Côn Đảo, Cô Tô, Nam Du… nắm rõ hoạt động biển, thời tiết, an toàn và trải nghiệm biển.'),
(5, 'HDV tour văn hóa – lịch sử', 'Hướng dẫn viên có kiến thức sâu về văn hóa truyền thống, tôn giáo, lịch sử Việt Nam, di tích, lễ hội và các câu chuyện gắn với các địa danh.'),
(6, 'HDV tour sinh thái – khám phá thiên nhiên', 'Hướng dẫn viên có kinh nghiệm dẫn tour sinh thái, trekking, khám phá rừng – núi, có kiến thức về tự nhiên, sinh vật, bảo tồn, và kỹ năng xử lý an toàn khi khám phá.'),
(7, 'HDV chuyên khách lẻ', 'Hướng dẫn viên có khả năng phục vụ nhóm khách nhỏ hoặc khách đi một mình, linh hoạt trong chăm sóc khách, xử lý yêu cầu cá nhân và thay đổi lịch trình.'),
(8, 'HDV chuyên khách đoàn', 'Hướng dẫn viên chuyên dẫn đoàn đông, có khả năng quản lý nhóm lớn, điều phối hoạt động, tạo không khí sôi động và đảm bảo an toàn – đúng tiến độ cho đoàn.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khach_hang`
--

CREATE TABLE `khach_hang` (
  `id` int NOT NULL,
  `ten` varchar(150) NOT NULL,
  `tuoi` int NOT NULL,
  `gioiTinh` varchar(150) NOT NULL,
  `dienThoai` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `khach_hang`
--

INSERT INTO `khach_hang` (`id`, `ten`, `tuoi`, `gioiTinh`, `dienThoai`, `email`) VALUES
(11, 'Nguyễn Thùy Linh', 19, 'Nữ', '0123456789', 'linh@gmail.com'),
(12, 'Trần Thùy Linh', 19, 'Nữ', '0987654321', 'tranlinh@gmail.com'),
(14, 'Trần Hoàng Ngân', 16, 'Nữ', '0678954321', 'g@gmail.com'),
(16, 'Phạm Minh Tuấn', 19, 'Nam', '0795222148', 'tcdemon06@gmail.com'),
(23, 'Phạm Như Hùng', 50, 'Nam', '0228494222', 'hung1974@gmail.com'),
(25, '1', 1, 'Nam', '0123467895', '1@gmail.com'),
(26, 'test', 10, 'Nam', '0123456879', 'test@gmail.com'),
(29, 'Hùng', 1, 'Nam', '0792222148', 'tuan@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khach_hang_danh_gia`
--

CREATE TABLE `khach_hang_danh_gia` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `khachHang_id` int NOT NULL,
  `diem` int NOT NULL,
  `binhLuan` varchar(500) NOT NULL,
  `tgTao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lịch_trinh`
--

CREATE TABLE `lịch_trinh` (
  `id` int NOT NULL,
  `diaDiem_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `lịch_trinh`
--

INSERT INTO `lịch_trinh` (`id`, `diaDiem_id`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ncc`
--

CREATE TABLE `ncc` (
  `id` int NOT NULL,
  `ten` varchar(150) NOT NULL,
  `dichVu_NCC_id` int NOT NULL,
  `diaChi` varchar(150) NOT NULL,
  `dienThoai` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `ncc`
--

INSERT INTO `ncc` (`id`, `ten`, `dichVu_NCC_id`, `diaChi`, `dienThoai`, `email`) VALUES
(1, 'Xe Khách Phương Trang', 1, '80 Trần Hưng Đạo, Q.1, TP.HCM', '19006067', 'hotro@futabus.vn'),
(2, 'Khách sạn Mường Thanh', 2, '60 Trần Phú, Nha Trang', '02583898888', 'info@muongthanh.vn'),
(3, 'Nhà hàng Sen Tây Hồ', 3, '614 Lạc Long Quân, Hà Nội', '02437199242', 'lienhe@sentayho.com.vn'),
(4, 'Sun World Ba Na Hills', 5, 'An Sơn, Hòa Vang, Đà Nẵng', '0905766777', 'banahills@sunworld.vn'),
(5, 'Bảo hiểm Bảo Việt', 6, '233 Đồng Khởi, Q.1, TP.HCM', '1900558899', 'service@baoviet.com.vn'),
(6, 'Du thuyền Emperor Cruises', 7, 'Cảng Nha Trang, Khánh Hòa', '0886048888', 'sales@emperorcruises.com'),
(7, 'Công ty Sự kiện HoaBinh', 8, '29 Đoàn Thị Điểm, Hà Nội', '0913311911', 'info@hoabinhevents.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ncc_dich_vu`
--

CREATE TABLE `ncc_dich_vu` (
  `id` int NOT NULL,
  `ten` varchar(150) NOT NULL,
  `moTa` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `ncc_dich_vu`
--

INSERT INTO `ncc_dich_vu` (`id`, `ten`, `moTa`) VALUES
(1, 'Dịch vụ vận chuyển', 'Nhà xe đưa đón\r\nXe du lịch (4–45 chỗ)\r\nThuê xe limousine\r\nXe chạy tuyến cố định\r\nTàu cao tốc\r\nPhà / cano\r\nMáy bay (đại lý vé)'),
(2, 'Dịch vụ lưu trú', 'Khách sạn (1–5 sao)\r\nResort\r\nHomestay\r\nVilla\r\nFarmstay'),
(3, 'Dịch vụ ăn uống', 'Nhà hàng\r\nChuỗi F&B / Buffet\r\nSuất ăn theo đoàn\r\nDịch vụ catering'),
(5, 'Dịch vụ vé tham quan', 'Khu du lịch (SunWorld, VinWonders…)\r\nBảo tàng\r\nCông viên giải trí\r\nKhu sinh thái\r\nDi tích\r\nShow biểu diễn (vũ kịch, thực cảnh…)'),
(6, 'Dịch vụ bảo hiểm', 'Bảo hiểm du lịch nội địa / quốc tế\r\nBảo hiểm y tế theo tour\r\nBảo hiểm rủi ro cho khách'),
(7, 'Dịch vụ trải nghiệm trong tour', 'Thuê tàu du lịch\r\nThuê ghe / thuyền\r\nThuê xe đạp\r\nCa nô\r\nCano kéo dù\r\nLặn ngắm san hô\r\nTeambuilding\r\nGala dinner\r\nChụp ảnh / quay phim'),
(8, 'Dịch vụ sự kiện – logistics', 'Thuê âm thanh – ánh sáng\r\nThuê MC\r\nThuê sân khấu\r\nThuê background / banner\r\nThuê hội trường');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tai_khoan`
--

CREATE TABLE `tai_khoan` (
  `id` int NOT NULL,
  `tenTk` varchar(150) NOT NULL,
  `mk` varchar(150) NOT NULL,
  `chucVu` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `tai_khoan`
--

INSERT INTO `tai_khoan` (`id`, `tenTk`, `mk`, `chucVu`) VALUES
(1, '1', '1', ''),
(2, '2', '2', ''),
(3, '3', '3', ''),
(4, '4', '4', ''),
(5, '5', '5', ''),
(6, '6', '6', ''),
(7, '7', '7', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour`
--

CREATE TABLE `tour` (
  `id` int NOT NULL,
  `ten` varchar(150) NOT NULL,
  `danhMuc_id` int NOT NULL,
  `moTa` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lichTrinh_id` int DEFAULT NULL,
  `chinhSach_id` int NOT NULL,
  `ncc_id` int NOT NULL,
  `trangThai` varchar(150) NOT NULL,
  `gia` int NOT NULL,
  `tgBatDau` date NOT NULL,
  `tgKetThuc` date NOT NULL,
  `tgTao` date NOT NULL,
  `nguoiTao_id` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `tour`
--

INSERT INTO `tour` (`id`, `ten`, `danhMuc_id`, `moTa`, `lichTrinh_id`, `chinhSach_id`, `ncc_id`, `trangThai`, `gia`, `tgBatDau`, `tgKetThuc`, `tgTao`, `nguoiTao_id`) VALUES
(1, 'Tour Hà Nội - Sapa 3N2Đ', 1, 'Khám phá núi rừng Tây Bắc (Miền Bắc)', 1, 1, 1, 'Không Hoạt động', 3500000, '2025-12-05', '2025-12-07', '2025-11-28', '1'),
(2, 'Tour Du lịch Thái Lan 5N4Đ', 2, 'Bangkok, Pattaya, Chợ nổi (Đông Nam Á)', 1, 1, 1, 'Đang Hoạt động', 9900000, '2025-12-15', '2025-12-19', '2025-11-28', '1'),
(3, 'Tour Resort Phú Quốc 4N3Đ', 3, 'Nghỉ dưỡng tại resort cao cấp/Villa', 1, 1, 1, 'Đang Hoạt động', 7800000, '2025-12-24', '2025-12-27', '2025-11-28', '1'),
(4, 'Tour Lễ hội Cồng Chiêng Tây Nguyên 2N1Đ', 4, 'Tìm hiểu văn hóa bản địa (Tây Nguyên)', 1, 1, 1, 'Không Hoạt Động', 1950000, '2026-01-10', '2026-01-11', '2025-11-28', '1'),
(5, 'Tour Tùy chỉnh (Đà Nẵng 4N3Đ)', 5, 'Tour theo yêu cầu riêng của khách', 1, 1, 1, 'Đang Hoạt động', 4500000, '2026-01-20', '2026-01-23', '2025-11-28', '1'),
(6, 'Tour Hàn Quốc Mùa Đông 6N5Đ', 2, 'Seoul, trượt tuyết, đảo Nami (Đông Bắc Á)', 1, 1, 1, 'Đang Hoạt động', 15500000, '2026-02-01', '2026-02-06', '2025-11-28', '1'),
(7, 'Tour Vịnh Hạ Long Cao Cấp 2N1Đ', 1, 'Du thuyền, chèo thuyền Kayak', 1, 1, 1, 'Đang Hoạt động', 4200000, '2026-02-15', '2026-02-16', '2025-11-28', '1'),
(11, '1', 4, '1', NULL, 1, 5, 'Không Hoạt Động', 1, '2025-11-29', '2025-11-30', '2025-11-29', NULL),
(12, '6', 3, '6', NULL, 1, 2, 'Đang Hoạt Động', 6, '2025-11-12', '2025-11-30', '2025-11-29', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_chinh_sach`
--

CREATE TABLE `tour_chinh_sach` (
  `id` int NOT NULL,
  `ten` varchar(150) NOT NULL,
  `gia` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `hoanHuy` varchar(500) NOT NULL,
  `datCoc_thanhToan` varchar(500) NOT NULL,
  `treEm` varchar(500) NOT NULL,
  `baoHiem` varchar(500) NOT NULL,
  `thayDoiDichVu` varchar(500) NOT NULL,
  `baoGom_khongBaoGom` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_chinh_sach`
--

INSERT INTO `tour_chinh_sach` (`id`, `ten`, `gia`, `hoanHuy`, `datCoc_thanhToan`, `treEm`, `baoHiem`, `thayDoiDichVu`, `baoGom_khongBaoGom`) VALUES
(1, 'Chính sách của Tour trong nước', 'Giá áp dụng theo mùa cao điểm – thấp điểm\r\nGiá theo độ tuổi (người lớn, trẻ em, em bé)\r\nGiá nhóm theo số lượng khách\r\nPhụ thu phòng đơn, phụ thu lễ Tết', 'Hủy trước 10 ngày: hoàn 90%\r\nHủy trước 7 ngày: hoàn 50%\r\nHủy trong 3 ngày: không hoàn\r\nKhông có mặt đúng giờ: không hoàn\r\nDời ngày có thể phát sinh phụ phí', 'Đặt cọc 30–50% giá tour khi đăng ký\r\nThanh toán đủ trước ngày khởi hành X ngày\r\nKhông đặt cọc → không giữ chỗ', 'Dưới 2 tuổi: miễn phí\r\n2–6 tuổi: 50% giá tour\r\n6–11 tuổi: 75% giá tour\r\nPhải có người lớn đi cùng', 'Bảo hiểm tai nạn du lịch\r\nBảo hiểm hành lý\r\nQuy định mức đền bù\r\nCác trường hợp loại trừ', 'Đổi tên khách (có thể thu phí)\r\nĐổi ngày khởi hành\r\nĐổi loại phòng / khách sạn\r\nTùy điều kiện thực tế có thể thu thêm phụ phí', 'Bao gồm:\r\nKhách sạn, vé tham quan, ăn uống, HDV\r\nXe đưa đón, bảo hiểm du lịch\r\nKhông bao gồm:\r\nVAT 10%\r\nChi phí cá nhân\r\nTips tài xế – HDV\r\nPhụ thu lễ Tết');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_danh_muc`
--

CREATE TABLE `tour_danh_muc` (
  `id` int NOT NULL,
  `ten` varchar(150) NOT NULL,
  `moTa` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_danh_muc`
--

INSERT INTO `tour_danh_muc` (`id`, `ten`, `moTa`) VALUES
(1, 'Tour Nội địa', 'Miền Bắc\r\nMiền Trung\r\nMiền Nam\r\nTây Nguyên\r\nTây Bắc – Đông Bắc\r\nBiển đảo (Phú Quốc, Cô Tô, Lý Sơn…)'),
(2, 'Tour Quốc tế', 'Đông Nam Á (Thái, Malaysia, Singapore…)\r\nĐông Bắc Á (Hàn, Nhật, Đài Loan)\r\nChâu Âu\r\nChâu Úc\r\nChâu Mỹ\r\nTrung Đông'),
(3, 'Tour Nghỉ dưỡng', 'Resort cao cấp\r\nVilla / Biệt thự nghỉ dưỡng\r\nCombo khách sạn + vé máy bay'),
(4, 'Tour Văn hóa', 'Lễ hội truyền thống\r\nKhám phá văn hóa bản địa\r\nTham quan di tích lịch sử'),
(5, 'Tour theo yêu cầu', '');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `dia_diem`
--
ALTER TABLE `dia_diem`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `don_hang_ibfk_2` (`donHangKhachHang_id`),
  ADD KEY `hdv_id` (`hdv_id`);

--
-- Chỉ mục cho bảng `don_hang_khach_hang`
--
ALTER TABLE `don_hang_khach_hang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `donHang_id` (`donHang_id`,`khachHang_id`),
  ADD KEY `khachHang_id` (`khachHang_id`);

--
-- Chỉ mục cho bảng `hdv`
--
ALTER TABLE `hdv`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hoTen` (`hoTen`),
  ADD UNIQUE KEY `dienThoai` (`dienThoai`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `nhomTour_id` (`nhomHDV_id`),
  ADD KEY `taiKhoan_id` (`taiKhoan_id`);

--
-- Chỉ mục cho bảng `hdv_nhom`
--
ALTER TABLE `hdv_nhom`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dienThoai` (`dienThoai`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `khach_hang_danh_gia`
--
ALTER TABLE `khach_hang_danh_gia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `khachHang_id` (`khachHang_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `lịch_trinh`
--
ALTER TABLE `lịch_trinh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diaDiem_id` (`diaDiem_id`);

--
-- Chỉ mục cho bảng `ncc`
--
ALTER TABLE `ncc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten` (`ten`),
  ADD UNIQUE KEY `diaChi` (`diaChi`),
  ADD UNIQUE KEY `dienThoai` (`dienThoai`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `dichVu_NCC_id` (`dichVu_NCC_id`);

--
-- Chỉ mục cho bảng `ncc_dich_vu`
--
ALTER TABLE `ncc_dich_vu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tai_khoan`
--
ALTER TABLE `tai_khoan`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten` (`ten`),
  ADD KEY `ncc_id` (`ncc_id`),
  ADD KEY `chinhSach_id` (`chinhSach_id`),
  ADD KEY `danhMuc_id` (`danhMuc_id`),
  ADD KEY `lichTrinh_id` (`lichTrinh_id`);

--
-- Chỉ mục cho bảng `tour_chinh_sach`
--
ALTER TABLE `tour_chinh_sach`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten` (`ten`);

--
-- Chỉ mục cho bảng `tour_danh_muc`
--
ALTER TABLE `tour_danh_muc`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `dia_diem`
--
ALTER TABLE `dia_diem`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `don_hang_khach_hang`
--
ALTER TABLE `don_hang_khach_hang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT cho bảng `hdv`
--
ALTER TABLE `hdv`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `hdv_nhom`
--
ALTER TABLE `hdv_nhom`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `khach_hang_danh_gia`
--
ALTER TABLE `khach_hang_danh_gia`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `lịch_trinh`
--
ALTER TABLE `lịch_trinh`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `ncc`
--
ALTER TABLE `ncc`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `ncc_dich_vu`
--
ALTER TABLE `ncc_dich_vu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `tai_khoan`
--
ALTER TABLE `tai_khoan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `tour`
--
ALTER TABLE `tour`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `tour_chinh_sach`
--
ALTER TABLE `tour_chinh_sach`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tour_danh_muc`
--
ALTER TABLE `tour_danh_muc`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `don_hang_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `don_hang_ibfk_2` FOREIGN KEY (`donHangKhachHang_id`) REFERENCES `don_hang_khach_hang` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `don_hang_ibfk_3` FOREIGN KEY (`hdv_id`) REFERENCES `hdv` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Các ràng buộc cho bảng `don_hang_khach_hang`
--
ALTER TABLE `don_hang_khach_hang`
  ADD CONSTRAINT `don_hang_khach_hang_ibfk_1` FOREIGN KEY (`donHang_id`) REFERENCES `don_hang` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `don_hang_khach_hang_ibfk_2` FOREIGN KEY (`khachHang_id`) REFERENCES `khach_hang` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Các ràng buộc cho bảng `hdv`
--
ALTER TABLE `hdv`
  ADD CONSTRAINT `hdv_ibfk_1` FOREIGN KEY (`nhomHDV_id`) REFERENCES `hdv_nhom` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `hdv_ibfk_2` FOREIGN KEY (`taiKhoan_id`) REFERENCES `tai_khoan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Các ràng buộc cho bảng `khach_hang_danh_gia`
--
ALTER TABLE `khach_hang_danh_gia`
  ADD CONSTRAINT `khach_hang_danh_gia_ibfk_1` FOREIGN KEY (`khachHang_id`) REFERENCES `khach_hang` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `khach_hang_danh_gia_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Các ràng buộc cho bảng `lịch_trinh`
--
ALTER TABLE `lịch_trinh`
  ADD CONSTRAINT `lịch_trinh_ibfk_1` FOREIGN KEY (`diaDiem_id`) REFERENCES `dia_diem` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Các ràng buộc cho bảng `ncc`
--
ALTER TABLE `ncc`
  ADD CONSTRAINT `ncc_ibfk_1` FOREIGN KEY (`dichVu_NCC_id`) REFERENCES `ncc_dich_vu` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Các ràng buộc cho bảng `tour`
--
ALTER TABLE `tour`
  ADD CONSTRAINT `tour_ibfk_1` FOREIGN KEY (`ncc_id`) REFERENCES `ncc` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `tour_ibfk_2` FOREIGN KEY (`chinhSach_id`) REFERENCES `tour_chinh_sach` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `tour_ibfk_3` FOREIGN KEY (`danhMuc_id`) REFERENCES `tour_danh_muc` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `tour_ibfk_4` FOREIGN KEY (`lichTrinh_id`) REFERENCES `lịch_trinh` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
