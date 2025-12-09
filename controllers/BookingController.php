<?php

class BookingController {
    private $bookingModel;

    public function __construct() {
        $this->bookingModel = new Booking();
    }

    /* =========================================================
     *  TIỆN ÍCH: TRẢ JSON CHUẨN (KHÔNG CÓ DỮ LIỆU THỪA)
     * ========================================================= */
    private function jsonResponse(array $payload, int $httpStatus = 200): void
    {
        // Loại bỏ mọi output trước JSON (notice/space/HTML sẽ làm JS lỗi)
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        http_response_code($httpStatus);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /* =========================================================
     *  DANH SÁCH BOOKING
     * ========================================================= */
    public function danhSachBooking() {
        $bookings = $this->bookingModel->getAllDonHang();
        require_once './views/bookings/danhSach_Booking.php';
    }

    /* =========================================================
     *  HIỂN THỊ FORM ĐẶT BOOKING
     * ========================================================= */
    public function viewDatBooking() {
        $tourList = (new TourModel())->getAllTour();
        $hdvList  = (new HDVModel())->getAllHDV();
        $khachHangList = $this->bookingModel->getAllKhachHang();

        require_once './views/bookings/dat_booking.php';
    }

    /* =========================================================
     *  ĐẶT BOOKING (FORM submit thường)
     * ========================================================= */
    public function datBooking() {
        $tour_id   = $_POST['tour_id'] ?? null;
        $hdv_id    = $_POST['hdv_id'] ?? null;
        $tgBatDau  = $_POST['tgBatDau'] ?? null;
        $tgKetThuc = $_POST['tgKetThuc'] ?? null;
        $datCoc    = $_POST['datCoc'] ?? 0;
        $tongTien  = $_POST['tongTien'] ?? 0;
        $tgDatDon  = $_POST['tgDatDon'] ?? date('Y-m-d H:i:s');
        $trangThai = $_POST['trangThai'] ?? 'Chờ duyệt';

        /* ---------------- Validate booking ---------------- */
        if (!$tour_id || !$hdv_id) {
            echo "Thiếu dữ liệu bắt buộc (tour_id/hdv_id)";
            echo "<script>window.history.back();</script>";
            return;
        }

        if (!empty($errors)) {
            $_SESSION['booking_errors'] = $errors;
            echo "Lỗi dữ liệu: ".implode(', ', $errors);
            echo "<script>window.history.back();</script>";
            return;
        }

        /* ---------------- Tạo booking ---------------- */
        $donHangData = [
            'tour_id'   => $tour_id,
            'hdv_id'    => $hdv_id,
            'tgBatDau'  => $tgBatDau,
            'tgKetThuc' => $tgKetThuc,
            'tgDatDon'  => $tgDatDon,
            'datCoc'    => $datCoc,
            'tongTien'  => $tongTien,
            'trangThai' => $trangThai
        ];

        try {
            $donHangId = $this->bookingModel->themDonHang($donHangData);
            if (!$donHangId) {
                $_SESSION['booking_errors'] = ['Không thể tạo đơn hàng'];
                echo "<script>window.history.back();</script>";
                return;
            }


            echo "<script>
            alert('Đặt booking thành công!');
            window.location.href = 'index.php?act=quan-ly-booking';
            </script>";

        } catch (Exception $e) {
            error_log("Booking error: ".$e->getMessage());
            $_SESSION['booking_errors'] = ['Lỗi hệ thống: '.$e->getMessage()];
            echo "<script>window.history.back();</script>";
        }
    }

    /* =========================================================
     *  EDIT BOOKING (render view edit)
     * ========================================================= */
    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?act=quan-ly-booking");
            return;
        }

        $countKhachHang = $this->bookingModel->countKhachHangInDonHang($id);
        $donHang = $this->bookingModel->getDonHangById($id);
        $tourList = (new TourModel())->getAllTour();
        $hdvList  = (new HDVModel())->getAllHDV();

        // Danh sách KH đã gắn và danh sách KH chưa gắn
        $donHangKhachHangList = $this->bookingModel->getDonHangKhachHang($id);
        $khachHangChuaThuoc  = $this->bookingModel->getKhachHangChuaThuocBooking($id);

        require_once './views/bookings/capnhat_Booking.php';
    }

    /* =========================================================
     *  UPDATE BOOKING (form submit)
     * ========================================================= */
    public function update()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $_SESSION['booking_errors'] = ['Thiếu ID đơn hàng.'];
            echo "<script>alert('Thiếu ID đơn hàng.');
            window.history.back();
            </script>";
            exit;
        }

        // Thu thập dữ liệu đúng theo form (bạn đang có tgBatDau/tgKetThuc trong view)
        $data = [
            'tour_id'   => $_POST['tour_id']   ?? null,
            'hdv_id'    => $_POST['hdv_id']    ?? null,
            'tgBatDau'  => $_POST['tgBatDau']  ?? null,
            'tgKetThuc' => $_POST['tgKetThuc'] ?? null,
            'tgDatDon'  => $_POST['tgDatDon']  ?? null,
            'datCoc'    => $_POST['datCoc'] ?? 0,
            'tongTien'  => $_POST['tongTien'] ?? 0,
            'trangThai' => $_POST['trangThai'] ?? 'Chờ xác nhận',
        ];

        // (Tùy chọn nhưng nên có) kiểm tra logic thời gian
        if (!empty($data['tgBatDau']) && !empty($data['tgKetThuc']) &&
            strtotime($data['tgKetThuc']) < strtotime($data['tgBatDau'])) {
            $_SESSION['booking_errors'] = ['Ngày kết thúc phải lớn hơn (hoặc bằng) ngày bắt đầu.'];
            echo "<script>alert('Ngày kết thúc phải lớn hơn (hoặc bằng) ngày bắt đầu.');
            window.history.back();
            </script>";
            exit;
        }

        $ok = $this->bookingModel->capNhatDonHang($id, $data);

        if ($ok) {
            echo "<script>alert('Cập nhật booking thành công.');</script>";
            header('Location: index.php?act=quan-ly-booking');
        } else {
            $_SESSION['booking_errors'] = ['Cập nhật booking thất bại (có lỗi SQL).'];
            echo "<script>alert('Cập nhật booking thất bại (có lỗi SQL).');
            window.history.back();
            </script>";
        }
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?act=quan-ly-booking");
            return;
        }

        $ok = $this->bookingModel->xoaDonHang($id);
        if ($ok) {
            echo "<script>
            alert('Xóa booking thành công!');
            window.location.href = 'index.php?act=quan-ly-booking';
            </script>";
        } else {
            echo "<script>
            alert('Xóa booking thất bại!');
            window.location.href = 'index.php?act=quan-ly-booking';
            </script>";
        }
    }

    /* =========================================================
     *  API: THÊM KHÁCH HÀNG CÓ SẴN VÀO BOOKING (api-add-customer-link)
     * ========================================================= */
    public function apiAddCustomerLink() {
        $bookingId   = $_POST['donHang_id'] ?? null;
        $khachHangId = $_POST['khachHang_id'] ?? null;
        $soPhong     = $_POST['soPhong'] ?? '';
        $ghiChuDB    = $_POST['ghiChuDB'] ?? '';

        if (!$bookingId || !$khachHangId) {
            return $this->jsonResponse(['success' => false, 'message' => 'Thiếu tham số (donHang_id/khachHang_id)'], 400);
        }

        try {
            // kiểm tra trùng
            $current = $this->bookingModel->getDonHangKhachHang($bookingId);
            foreach ($current as $row) {
                if ((int)$row['khachHang_id'] === (int)$khachHangId) {
                    return $this->jsonResponse(['success' => false, 'code' => 'DUPLICATE', 'message' => 'Khách hàng đã có trong booking'], 409);
                }
            }

            $ok = $this->bookingModel->themDonHangKhachHang([
                'donHang_id'   => $bookingId,
                'khachHang_id' => $khachHangId,
                'soPhong'      => $soPhong,
                'ghiChuDB'     => $ghiChuDB
            ]);

            if ($ok) {
                return $this->jsonResponse(['success' => true, 'message' => 'Thêm khách hàng thành công'], 200);
            }
            return $this->jsonResponse(['success' => false, 'message' => 'Không thể thêm khách hàng vào booking'], 500);

        } catch (Exception $e) {
            error_log("apiAddCustomerLink error: ".$e->getMessage());
            return $this->jsonResponse(['success' => false, 'message' => 'Lỗi server: '.$e->getMessage()], 500);
        }
    }

    /* =========================================================
     *  API: TẠO KHÁCH HÀNG MỚI + GẮN VÀO BOOKING (api-add-customer)
     * ========================================================= */
    public function apiAddCustomer() {
        $bookingId = $_POST['donHang_id'] ?? null;
        $ten       = trim($_POST['ten'] ?? '');
        $tuoi      = trim($_POST['tuoi'] ?? 0);
        $gioiTinh  = trim($_POST['gioiTinh'] ?? 'Khác');
        $dienThoai = trim($_POST['dienThoai'] ?? '');
        $email     = trim($_POST['email'] ?? '');

        if (!$bookingId || !$ten || !$dienThoai) {
            return $this->jsonResponse(['success' => false, 'message' => 'Thiếu dữ liệu bắt buộc (donHang_id/ten/dienThoai)'], 400);
        }
        if (!preg_match('/^[0-9]{10,11}$/', $dienThoai)) {
            return $this->jsonResponse(['success' => false, 'message' => 'Số điện thoại không hợp lệ'], 400);
        }
        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->jsonResponse(['success' => false, 'message' => 'Email không hợp lệ'], 400);
        }

        try {
            // tạo KH mới
            $khachHangId = $this->bookingModel->themKhachHang([
                'ten'       => $ten,
                'tuoi'      => $tuoi ?: 0,
                'gioiTinh'  => $gioiTinh,
                'dienThoai' => $dienThoai,
                'email'     => $email
            ]);

            if (!$khachHangId) {
                return $this->jsonResponse(['success' => false, 'message' => 'Không tạo được khách hàng'], 500);
            }

            // gắn vào booking
            $ok = $this->bookingModel->themDonHangKhachHang([
                'donHang_id'   => $bookingId,
                'khachHang_id' => $khachHangId,
                'soPhong'      => '',
                'ghiChuDB'     => ''
            ]);

            if ($ok) {
                return $this->jsonResponse(['success' => true, 'message' => 'Thêm khách hàng thành công'], 200);
            }

            return $this->jsonResponse(['success' => false, 'message' => 'Không thể gắn khách hàng vào booking'], 500);

        } catch (Exception $e) {
            error_log("apiAddCustomer error: ".$e->getMessage());
            return $this->jsonResponse(['success' => false, 'message' => 'Lỗi server: '.$e->getMessage()], 500);
        }
    }

    /* =========================================================
     *  API: XÓA KHÁCH HÀNG KHỎI BOOKING (api-delete-customer)
     * ========================================================= */
    public function apiDeleteCustomer() {
        $bookingId   = $_POST['donHang_id'] ?? null;
        $khachHangId = $_POST['khachHang_id'] ?? null;

        if (!$bookingId || !$khachHangId) {
            return $this->jsonResponse(['success' => false, 'message' => 'Thiếu tham số (donHang_id/khachHang_id)'], 400);
        }

        try {
            $ok = $this->bookingModel->xoaDonHangKhachHang($bookingId, $khachHangId);
            if ($ok) {
                return $this->jsonResponse(['success' => true, 'message' => 'Xóa khách hàng thành công'], 200);
            }
            return $this->jsonResponse(['success' => false, 'message' => 'Không thể xóa khách hàng'], 500);

        } catch (Exception $e) {
            error_log("apiDeleteCustomer error: ".$e->getMessage());
            return $this->jsonResponse(['success' => false, 'message' => 'Lỗi server: '.$e->getMessage()], 500);
        }
    }
    
    public function getDonHangKhachHang($donHangId)
    {
        // Trả JSON, sạch output trước
        while (ob_get_level()) { ob_end_clean(); }
        header('Content-Type: application/json; charset=UTF-8');

        try {
            if (empty($donHangId)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Thiếu tham số don_hang_id'
                ]);
                return;
            }

            $rows = $this->modelHDV->getDonHangKhachHang($donHangId);

            echo json_encode([
                'success' => true,
                'data' => $rows
            ]);
            return;
        } catch (Throwable $e) {
            // Trả lỗi dạng JSON để JS còn parse và hiện rõ thông tin lỗi
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return;
        }
    }
}
?>
