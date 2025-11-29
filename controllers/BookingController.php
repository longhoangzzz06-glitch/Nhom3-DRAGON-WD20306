<?php
class BookingController {
    private $bookingModel;

    public function __construct() {
        $this->bookingModel = new Booking();
    }

    // Hiển thị danh sách booking
    public function danhSachBooking() 
    {
        $bookings = $this->bookingModel->getAllDonHang();
        require_once './views/bookings/danhSach_Booking.php';
    }

    // Hiển thị form đặt booking
    public function viewDatBooking() 
    {
        $tourList = (new TourModel())->getAllTour();
        $hdvList = (new HDVModel())->getAllHDV();
        $khachHangList = $this->bookingModel->getAllKhachHang();
        require_once './views/bookings/dat_booking.php';
    }

    // Xử lý tạo booking
    public function datBooking() 
    {
        $tour_id = $_POST['tour_id'] ?? null;
        $hdv_id = $_POST['hdv_id'] ?? null;
        $datCoc = $_POST['datCoc'] ?? 0;
        $tongTien = $_POST['tongTien'] ?? 0;
        $tgDatDon = $_POST['tgDatDon'] ?? date('Y-m-d H:i:s');
        $trangThai = $_POST['trangThai'] ?? 'Chờ duyệt';

        // Customer data - KHÁCH HÀNG HIỆN CÓ (từ dropdown)
        $existingKhachHangIds = $_POST['existing_khachHang_id'] ?? [];
        $soPhongExisting = $_POST['soPhong_existing'] ?? [];
        $ghiChuDBExisting = $_POST['ghiChuDB_existing'] ?? [];

        // Customer data - KHÁCH HÀNG MỚI (từ form)
        $tenList = $_POST['ten'] ?? [];
        $tuoiList = $_POST['tuoi'] ?? [];
        $gioiTinhList = $_POST['gioiTinh'] ?? [];
        $dienThoaiList = $_POST['dienThoai'] ?? [];
        $emailList = $_POST['email'] ?? [];
        $soPhongList = $_POST['soPhong'] ?? [];
        $ghiChuDBList = $_POST['ghiChuDB'] ?? [];

        // ==================== KIỂM TRA DỮ LIỆU BOOKING ====================
        if (!$tour_id || !$hdv_id) {
            header("Location: index.php?act=view-dat-booking&error=invalid_data");
            return;
        }

        // Phải có ít nhất một khách hàng (hiện có hoặc mới)
        if (empty($existingKhachHangIds) && empty($tenList)) {
            header("Location: index.php?act=view-dat-booking&error=no_customers");
            return;
        }

        // ==================== KIỂM TRA VÀ VALIDATE TẤT CẢ KHÁCH HÀNG MỚI TRƯỚC KHI LƯU ====================
        $errors = [];
        
        for ($i = 0; $i < count($tenList); $i++) {
            $ten = trim($tenList[$i] ?? '');
            $dienThoai = trim($dienThoaiList[$i] ?? '');
            $email = trim($emailList[$i] ?? '');

            // Bỏ qua hàng trống
            if (empty($ten) && empty($dienThoai)) {
                continue;
            }

            // Kiểm tra tên
            if (empty($ten)) {
                $errors[] = "Hàng " . ($i + 1) . ": Tên khách hàng không được để trống";
            }

            // Kiểm tra điện thoại
            if (empty($dienThoai)) {
                $errors[] = "Hàng " . ($i + 1) . ": Số điện thoại không được để trống";
            } elseif (!preg_match('/^[0-9]{10,11}$/', $dienThoai)) {
                $errors[] = "Hàng " . ($i + 1) . ": Số điện thoại không hợp lệ (phải từ 10-11 chữ số)";
            }

            // Kiểm tra email
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Hàng " . ($i + 1) . ": Email không hợp lệ";
            }

            // Kiểm tra tuổi
            $tuoi = $tuoiList[$i] ?? '';
            if (!empty($tuoi) && (!is_numeric($tuoi) || $tuoi < 0 || $tuoi > 150)) {
                $errors[] = "Hàng " . ($i + 1) . ": Tuổi không hợp lệ";
            }
        }

        // Nếu có lỗi, quay lại form với thông báo
        if (!empty($errors)) {
            $_SESSION['booking_errors'] = $errors;
            header("Location: index.php?act=view-dat-booking&error=validation_failed");
            return;
        }

        // ==================== LƯU BOOKING ====================
        $donHangData = [
            'tour_id' => $tour_id,
            'hdv_id' => $hdv_id,
            'tgDatDon' => $tgDatDon,
            'datCoc' => $datCoc,
            'tongTien' => $tongTien,
            'trangThai' => $trangThai
        ];

        try {
            $donHangId = $this->bookingModel->themDonHang($donHangData);

            if (!$donHangId) {
                $_SESSION['booking_errors'] = ['Lỗi: Không thể tạo đơn hàng'];
                header("Location: index.php?act=view-dat-booking&error=booking_failed");
                return;
            }

            $customersAdded = 0;

            // ==================== LIÊN KẾT KHÁCH HÀNG HIỆN CÓ ====================
            for ($i = 0; $i < count($existingKhachHangIds); $i++) {
                $khachHangId = intval($existingKhachHangIds[$i]);
                $soPhong = trim($soPhongExisting[$i] ?? '');
                $ghiChuDB = trim($ghiChuDBExisting[$i] ?? '');

                if ($khachHangId > 0) {
                    $this->bookingModel->themDonHangKhachHang([
                        'donHang_id' => $donHangId,
                        'khachHang_id' => $khachHangId,
                        'soPhong' => $soPhong,
                        'ghiChuDB' => $ghiChuDB
                    ]);
                    $customersAdded++;
                }
            }

            // ==================== LƯU KHÁCH HÀNG MỚI ====================
            for ($i = 0; $i < count($tenList); $i++) {
                $ten = trim($tenList[$i] ?? '');
                $tuoi = trim($tuoiList[$i] ?? '');
                $gioiTinh = trim($gioiTinhList[$i] ?? 'Khác');
                $dienThoai = trim($dienThoaiList[$i] ?? '');
                $email = trim($emailList[$i] ?? '');
                $soPhong = trim($soPhongList[$i] ?? '');
                $ghiChuDB = trim($ghiChuDBList[$i] ?? '');

                // Bỏ qua hàng trống
                if (empty($ten) && empty($dienThoai)) {
                    continue;
                }

                $khachHangData = [
                    'ten' => $ten,
                    'tuoi' => $tuoi ?: 0,
                    'gioiTinh' => $gioiTinh,
                    'dienThoai' => $dienThoai,
                    'email' => $email
                ];

                // Lưu khách hàng
                $khachHangId = $this->bookingModel->themKhachHang($khachHangData);
                
                if ($khachHangId) {
                    // Liên kết khách hàng với booking
                    $this->bookingModel->themDonHangKhachHang([
                        'donHang_id' => $donHangId,
                        'khachHang_id' => $khachHangId,
                        'soPhong' => $soPhong,
                        'ghiChuDB' => $ghiChuDB
                    ]);
                    $customersAdded++;
                }
            }

            // Kiểm tra có khách hàng nào được thêm không
            if ($customersAdded === 0) {
                // Xóa booking vừa tạo vì không có khách hàng nào
                $this->bookingModel->xoaDonHang($donHangId);
                $_SESSION['booking_errors'] = ['Lỗi: Phải có ít nhất một khách hàng'];
                header("Location: index.php?act=view-dat-booking&error=no_customers");
                return;
            }

            header("Location: index.php?act=quan-ly-booking&success=1");

        } catch (Exception $e) {
            error_log("Booking error: " . $e->getMessage());
            $_SESSION['booking_errors'] = ['Lỗi hệ thống: ' . $e->getMessage()];
            header("Location: index.php?act=view-dat-booking&error=system_error");
            return;
        }
    }

    // Hiển thị form cập nhật booking
    public function edit() 
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?act=quan-ly-booking");
            return;
        }
        $donHang = $this->bookingModel->getDonHangById($id);
        $tourList = (new TourModel())->getAllTour();
        $hdvList = (new HDVModel())->getAllHDV();
        require_once './views/bookings/capnhat_Booking.php';
    }

    // Xử lý cập nhật booking
    public function update() 
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header("Location: index.php?act=quan-ly-booking");
            return;
        }

        $data = [
            'tour_id' => $_POST['tour_id'] ?? null,
            'hdv_id' => $_POST['hdv_id'] ?? null,
            'tgDatDon' => $_POST['tgDatDon'] ?? null,
            'datCoc' => $_POST['datCoc'] ?? 0,
            'tongTien' => $_POST['tongTien'] ?? 0,
            'trangThai' => $_POST['trangThai'] ?? 'Chờ duyệt'
        ];

        $this->bookingModel->capNhatDonHang($id, $data);
        header("Location: index.php?act=quan-ly-booking");
    }

    // Xử lý xóa booking
    public function delete() 
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?act=quan-ly-booking");
            return;
        }
        $this->bookingModel->xoaDonHang($id);
        header("Location: index.php?act=quan-ly-booking");
    }

    // API: Check-in booking
    public function apiCheckIn()
    {
        // Đóng output buffering để gửi JSON sạch
        if (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        header('Content-Type: application/json');
        
        $bookingId = $_POST['booking_id'] ?? null;
        $customerIds = $_POST['customer_ids'] ?? [];
        
        if (!$bookingId) {
            echo json_encode(['success' => false, 'message' => 'ID booking không hợp lệ']);
            exit;
        }

        try {
            // Nếu có customer_ids được gửi
            if (!empty($customerIds)) {
                $result = $this->bookingModel->checkInDonHang($bookingId, $customerIds);
                $count = is_int($result) ? $result : count($customerIds);
            } else {
                // Nếu không có, cập nhật tất cả
                $result = $this->bookingModel->checkInDonHang($bookingId, []);
                $count = 0; // Không biết số lượng chính xác
            }
            
            if ($result) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Check-in thành công',
                    'count' => $count ?? count($customerIds)
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi khi check-in - không có dữ liệu được cập nhật']);
            }
        } catch (Exception $e) {
            error_log("Check-in error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()]);
        }
        exit;
    }

    // API: Lấy danh sách khách hàng chi tiết của booking
    public function apiGetCustomersList()
    {
        if (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        header('Content-Type: application/json');
        
        $bookingId = $_GET['booking_id'] ?? null;
        
        if (!$bookingId) {
            echo json_encode(['success' => false, 'message' => 'ID booking không hợp lệ']);
            exit;
        }

        try {
            $customers = $this->bookingModel->getDonHangKhachHangList($bookingId);
            echo json_encode(['success' => true, 'data' => $customers]);
        } catch (Exception $e) {
            error_log("Get customers error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()]);
        }
        exit;
    }

    // API: Thêm khách hàng vào booking
    public function apiAddCustomer()
    {
        // Clear output buffer
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        // Set JSON header
        header('Content-Type: application/json; charset=UTF-8');
        
        try {
            $bookingId = $_POST['donHang_id'] ?? null;
            $ten = trim($_POST['ten'] ?? '');
            $tuoi = trim($_POST['tuoi'] ?? '');
            $gioiTinh = trim($_POST['gioiTinh'] ?? 'Khác');
            $dienThoai = trim($_POST['dienThoai'] ?? '');
            $email = trim($_POST['email'] ?? '');

            // Validate
            if (!$bookingId || !$ten || !$dienThoai) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không đủ']);
                exit;
            }

            if (!preg_match('/^[0-9]{10,11}$/', $dienThoai)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Số điện thoại không hợp lệ']);
                exit;
            }

            if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Email không hợp lệ']);
                exit;
            }

            // Tạo khách hàng mới
            $khachHangData = [
                'ten' => $ten,
                'tuoi' => $tuoi ?: 0,
                'gioiTinh' => $gioiTinh,
                'dienThoai' => $dienThoai,
                'email' => $email
            ];

            $khachHangId = $this->bookingModel->themKhachHang($khachHangData);
            
            if (!$khachHangId) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Lỗi khi tạo khách hàng']);
                exit;
            }

            // Liên kết khách hàng với booking
            $linkResult = $this->bookingModel->themDonHangKhachHang([
                'donHang_id' => $bookingId,
                'khachHang_id' => $khachHangId,
                'soPhong' => '',
                'ghiChuDB' => ''
            ]);
            
            if (!$linkResult) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Lỗi khi liên kết khách hàng với booking']);
                exit;
            }

            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Thêm khách hàng thành công']);
        } catch (Exception $e) {
            error_log("Add customer error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    // API: Liên kết khách hàng hiện có với booking (sử dụng khachHang_id)
    public function apiAddCustomerLink()
    {
        // Clear output buffer
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        // Set JSON header
        header('Content-Type: application/json; charset=UTF-8');
        
        try {
            $bookingId = $_POST['donHang_id'] ?? null;
            $khachHangId = $_POST['khachHang_id'] ?? null;
            $soPhong = trim($_POST['soPhong'] ?? '');
            $ghiChuDB = trim($_POST['ghiChuDB'] ?? '');

            // Validate
            if (!$bookingId || !$khachHangId) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
                exit;
            }

            // Kiểm tra khách hàng đã được liên kết chưa
            $existingLink = $this->bookingModel->getDonHangKhachHangList($bookingId);
            foreach ($existingLink as $link) {
                if ($link['khachHang_id'] == $khachHangId) {
                    http_response_code(409);
                    echo json_encode(['success' => false, 'message' => 'Khách hàng này đã được thêm vào booking']);
                    exit;
                }
            }

            // Liên kết khách hàng với booking
            $result = $this->bookingModel->themDonHangKhachHang([
                'donHang_id' => $bookingId,
                'khachHang_id' => $khachHangId,
                'soPhong' => $soPhong,
                'ghiChuDB' => $ghiChuDB
            ]);
            
            if (!$result) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Không thể thêm khách hàng vào booking']);
                exit;
            }
            
            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Thêm khách hàng thành công']);
        } catch (Exception $e) {
            error_log("Add customer link error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    // API: Xóa khách hàng khỏi booking
    public function apiDeleteCustomer()
    {
        if (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        header('Content-Type: application/json');
        
        $customerId = $_POST['khachHang_id'] ?? null;
        $bookingId = $_POST['donHang_id'] ?? null;

        if (!$customerId || !$bookingId) {
            echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
            exit;
        }

        try {
            // Xóa liên kết giữa booking và khách hàng
            $result = $this->bookingModel->xoaDonHangKhachHang($bookingId, $customerId);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Xóa khách hàng thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi khi xóa khách hàng']);
            }
        } catch (Exception $e) {
            error_log("Delete customer error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()]);
        }
        exit;
    }
}
