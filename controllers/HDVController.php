<?php 
require_once "./models/TaiKhoanModel.php";
require_once "./models/HDVModel.php"; 
class HDVController
{
    public $modelHDV;
    public $modelTaiKhoan;
    public $modelCheckpoint;
    public $modelRequirement;
    public $modelReview;
    public $modelTourDetail;

    public function __construct()
    {
        $this->modelHDV = new HDVModel();
        $this->modelTaiKhoan = new TaiKhoanModel();
        $this->modelCheckpoint = new CheckpointModel();
        $this->modelRequirement = new RequirementModel();
        $this->modelReview = new ReviewModel();
        $this->modelTourDetail = new TourDetailModel();
    }

    public function danhSach()
    {
        $dsHDV = $this->modelHDV->getAllHDV();
        include './views/HDV/danhsach_HDV.php';
    }

    public function getDonHangKhachHang($donHangId)
    {
        return $this->modelHDV->getDonHangKhachHang($donHangId);
    }

    public function uploadAnh($fieldName, $targetDir)
    {
        if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . '_' . basename($_FILES[$fieldName]['name']);
        $targetPath = $targetDir . $fileName;

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            return null;
        }

        if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $targetPath)) {
            return $fileName;
        }

        return null;
    }

    public function viewThemHDV()
    {
        include './views/HDV/them_HDV.php';
    }

    public function themHDV($data)
    {
        $requiredFields = ['hoTen', 'ngaySinh', 'dienThoai', 'email', 'nhomHDV_id'];
        $missing = [];

        foreach ($requiredFields as $f) {
            if (empty($data[$f])) $missing[] = $f;
        }

        if (!empty($missing)) {
            echo "<script>
                alert('Vui lòng nhập đầy đủ các trường bắt buộc! (Họ tên, Ngày sinh, điện thoại, Email)');
                window.location.href = 'index.php?act=view-them-hdv';
            </script>";
            exit;
        }

        $data['kinhNghiem'] = empty($data['kinhNghiem']) ? 0 : intval($data['kinhNghiem']);

        $anh = $this->uploadAnh('anh', 'uploads/img_HDV/');
        $data['anh'] = $anh ?? '';

        try {
            $this->modelHDV->addHDV($data);

            echo "<script>
                alert('Thêm HDV thành công!');
                window.location.href = 'index.php?act=quan-ly-hdv';
            </script>";
            exit;

        } catch (Exception $e) {

            if ($anh && file_exists('uploads/img_HDV/' . $anh)) {
                unlink('uploads/img_HDV/' . $anh);
            }

            $msg = $e->getMessage();

            if (strpos($msg, '1062') !== false) {
                $msg = "Email, Số điện thoại, Tên tài khoản đã tồn tại!";
            }

            echo "<script>
                alert('Lỗi: " . addslashes($msg) . "');
                window.history.back();
            </script>";
            exit;
        }
    }

    public function xoaHDV($id)
    {
        try {
            // Lấy thông tin HDV trước
            $hdv = $this->modelHDV->getHDVById($id);

            $result = $this->modelHDV->deleteHDV($id);

            if ($result) {
                // Xóa file ảnh chỉ khi DB xóa thành công
                if (!empty($hdv['anh'])) {
                    $path = 'uploads/img_HDV/' . $hdv['anh'];
                    if (file_exists($path)) unlink($path);
                }

                echo "<script>
                    alert('Xóa thành công!');
                    window.location.href = 'index.php?act=quan-ly-hdv';
                </script>";
            } else {
                echo "<script>
                    alert('Xóa thất bại! Hướng dẫn viên đang có tour không thể xóa.');
                    window.location.href = 'index.php?act=quan-ly-hdv';
                </script>";
            }
            exit;

        } catch (Exception $e) {
            echo "<script>
                alert('Lỗi: " . addslashes($e->getMessage()) . "');
                window.location.href = 'index.php?act=quan-ly-hdv';
            </script>";
            exit;
        }
    }

    // Tính số tour đã phân công cho HDV
    public function countToursByHDV($hdvId)
    {
        return $this->modelHDV->countToursByHDV($hdvId);
    }

    public function getAllNhomHDV()
    {
        return $this->modelHDV->getAllNhomHDV();
    }

    public function viewCapNhatHDV($id)
    {
        $hdv = $this->modelHDV->getHDVById($id);
        include './views/HDV/capNhat_HDV.php';
    }

    public function capNhatHDV($id, $data)
    {
        try {
            /* ==== Validate ==== */
            $required = ['hoTen', 'ngaySinh', 'dienThoai', 'email'];
            foreach ($required as $f) {
                if (empty($data[$f])) {
                    echo "<script>
                        alert('Vui lòng nhập đủ thông tin bắt buộc!');
                        window.history.back();
                    </script>";
                    exit;
                }
            }

            $data['kinhNghiem'] = empty($data['kinhNghiem']) ? 0 : intval($data['kinhNghiem']);

            /* ==== Ảnh ==== */
            $oldAnh = $data['old_anh'] ?? null;
            $anh = $oldAnh;

            if (isset($_FILES['anh']) && $_FILES['anh']['error'] === UPLOAD_ERR_OK) {
                $newAnh = $this->uploadAnh('anh', 'uploads/img_HDV/');

                if ($newAnh) {
                    if ($oldAnh && file_exists('uploads/img_HDV/' . $oldAnh)) {
                        unlink('uploads/img_HDV/' . $oldAnh);
                    }
                    $anh = $newAnh;
                }
            }

            $data['anh'] = $anh;

            /* ==== Update HDV ==== */
            $this->modelHDV->updateHDV($id, $data);

            /* ==== Update tài khoản ==== */
            if (!empty($data['taiKhoan_id'])) {

                $updateTK = [
                    'tenTk' => $data['tenTk'] ?? null,
                    'chucVu' => 'hdv'
                ];

                // Chỉ update mật khẩu khi có nhập
                if (!empty($data['mk'])) {
                    $updateTK['mk'] = $data['mk'];
                }

                $this->modelTaiKhoan->updateTaiKhoan($data['taiKhoan_id'], $updateTK);
            }

            /* ==== DONE ==== */
            echo "<script>
                alert('Cập nhật thành công!');
                window.location.href = 'index.php?act=quan-ly-hdv';
            </script>";
            exit;

        } catch (Exception $e) {

            $msg = $e->getMessage();

            if (strpos($msg, '1062') !== false) {
                $msg = "Email Hoặc Số điện thoại đã được sử dụng!";
            }

            echo "<script>
                alert('Lỗi: " . addslashes($msg) . "');
                window.history.back();
            </script>";
            exit;
        }
    }
    // ===================================================================
    // HDV FEATURE METHODS - NEW
    // ===================================================================

    // Method 1: Hiển thị trang điểm danh khách hàng
    public function diemDanhKhach($tourId)
    {
        try {
            // Lấy thông tin tour
            $tour = $this->modelTourDetail->getTourInfo($tourId);
            $tour_id = $tourId;
            
            // Lấy danh sách checkpoint
            $rawCheckpoints = $this->modelCheckpoint->getCheckpointsByTour($tourId);
            
            // Format checkpoints for view
            $checkpoints = [];
            foreach ($rawCheckpoints as $cp) {
                $checkpoints[] = [
                    'id' => $cp['id'],
                    'name' => $cp['ten'],
                    'time' => date('H:i', strtotime($cp['tgDi'])),
                    'location' => $cp['ten'],
                    'status' => $cp['trangThai'] ?? 'pending'
                ];
            }
            
            // Set active checkpoint
            $activeCheckpointId = isset($_GET['checkpoint']) ? intval($_GET['checkpoint']) : 0;
            $activeCheckpoint = null;
            
            if ($activeCheckpointId > 0) {
                foreach ($checkpoints as $cp) {
                    if ($cp['id'] == $activeCheckpointId) {
                        $activeCheckpoint = $cp;
                        break;
                    }
                }
            }
            
            if (!$activeCheckpoint && !empty($checkpoints)) {
                $activeCheckpoint = $checkpoints[0];
            }
            
            if (!$activeCheckpoint) {
                $activeCheckpoint = ['id' => 0, 'name' => 'N/A', 'time' => 'N/A', 'location' => 'N/A'];
            }
            
            // Lấy danh sách khách hàng với trạng thái điểm danh
            // Pass checkpoint ID to get specific status
            $rawCustomers = $this->modelCheckpoint->getCustomersByTourWithCheckin($tourId, $activeCheckpoint['id']);
            
            // Format customers for view
            $customers = [];
            foreach ($rawCustomers as $c) {
                $customers[] = [
                    'id' => $c['donHangKhachHang_id'],
                    'ten' => $c['khachHang_ten'],
                    'tuoi' => $c['tuoi'],
                    'gioiTinh' => $c['gioiTinh'],
                    'dienThoai' => $c['dienThoai'],
                    'ghiChu' => $c['ghiChuDB'] ?? '',
                    'checkin_status' => $c['trangThai_checkin'] ?? 'pending',
                    'checkin_time' => $c['tgDiemDanh'] ?? null
                ];
            }
            
            // Lấy yêu cầu đặc biệt (cảnh báo)
            $specialRequirements = $this->modelCheckpoint->getSpecialRequirements($tourId);
            
            // Include view
            include './views/HDV/diem_danh_khach.php';
        } catch (Exception $e) {
            echo "<script>alert('Đã xảy ra lỗi khi tải trang điểm danh. Vui lòng thử lại sau.'); window.history.back();</script>";
            exit();
        }
    }

    // Method 2: Lưu trạng thái điểm danh (AJAX API)
    public function saveCheckin()
    {
        header('Content-Type: application/json');
        
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            $required = ['donHangKhachHangId', 'checkpointId', 'hdvId'];
            foreach ($required as $field) {
                if (!isset($data[$field])) {
                    ob_clean();
                    echo json_encode(['success' => false, 'message' => "Missing field: $field"]);
                    exit();
                }
            }
            
            // Allow null status for undo
            $status = $data['status'] ?? null;
            
            // Set timezone to Vietnam (GMT+7)
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $currentDateTime = date('Y-m-d H:i:s');
            
            $result = $this->modelCheckpoint->saveCheckin(
                $data['donHangKhachHangId'],
                $data['checkpointId'],
                $status,
                $data['hdvId'],
                $currentDateTime
            );
            
            if ($result) {
                // Lấy thống kê mới sau khi cập nhật
                $stats = $this->modelCheckpoint->getCheckinStats($data['tourId'] ?? 0, $data['checkpointId']);
                ob_clean();
                echo json_encode([
                    'success' => true, 
                    'stats' => $stats,
                    'checkinTime' => date('H:i d/m/Y', strtotime($currentDateTime))
                ]);
            } else {
                ob_clean();
                echo json_encode(['success' => false, 'message' => 'Failed to save checkin']);
            }
        } catch (Exception $e) {
            ob_clean();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit();
    }

    // Method 3: Hiển thị trang yêu cầu đặc biệt
    public function yeuCauDacBiet($tourId)
    {
        try {
            // Lấy thông tin tour
            $tour = $this->modelTourDetail->getTourInfo($tourId);
            $tour_id = $tourId;
            
            // Lấy danh sách tất cả khách hàng trong tour
            $allCustomers = $this->modelRequirement->getCustomersWithRequirements($tourId);
            
            // Lấy chi tiết các yêu cầu
            $allRequirements = $this->modelRequirement->getRequirementsByTour($tourId);
            
            // Map requirements to customers
            $customers = [];
            foreach ($allCustomers as $cust) {
                $custId = $cust['id'];
                $customers[$custId] = [
                    'id' => $custId,
                    'ten' => $cust['ten'],
                    'tuoi' => $cust['tuoi'],
                    'gioiTinh' => $cust['gioiTinh'],
                    'dienThoai' => $cust['dienThoai'],
                    'requirements' => []
                ];
            }
            
            // Fill requirements
            foreach ($allRequirements as $req) {
                $custId = $req['khachHang_id'];
                if (isset($customers[$custId])) {
                    $customers[$custId]['requirements'][] = [
                        'id' => $req['id'],
                        'category' => $req['loaiYeuCau'],
                        'text' => $req['noiDung'],
                        'priority' => $req['doUuTien'],
                        'note' => $req['ghiChu'] ?? ''
                    ];
                }
            }
            
            // Convert to array values
            $customers = array_values($customers);
            
            // Lấy thống kê
            $stats = $this->modelRequirement->getRequirementStats($tourId);
            
            // Include view
            include './views/HDV/yeu_cau_dac_biet.php';
        } catch (Exception $e) {
            echo "<script>alert('Đã xảy ra lỗi khi tải trang yêu cầu đặc biệt. Vui lòng thử lại sau.'); window.history.back();</script>";
            exit();
        }
    }

    // Method 4: Lưu yêu cầu đặc biệt (AJAX API)
    public function saveRequirement()
    {
        header('Content-Type: application/json');
        
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Inject HDV ID if not present
            if (!isset($data['nguoiTao_id'])) {
                $data['nguoiTao_id'] = $_SESSION['hdv_id'] ?? 5;
            }

            if (isset($data['id']) && $data['id'] > 0) {
                // Update
                $result = $this->modelRequirement->updateRequirement($data['id'], $data);
            } else {
                // Insert
                $result = $this->modelRequirement->addRequirement($data);
            }
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Đã lưu yêu cầu']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lưu thất bại']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit();
    }

    // Method 6: Lưu nhật ký tour (AJAX API)
    public function saveDiary()
    {
        // Bắt toàn bộ output dư thừa
        ob_start();
        header('Content-Type: application/json');

        try {
            $data = $_POST;

            // Inject HDV ID nếu chưa có
            if (!isset($data['hdv_id'])) {
                $data['hdv_id'] = $_SESSION['hdv_id'] ?? 5;
            }

            // Xử lý file upload nếu có
            if (isset($_FILES['photos'])) {
                $uploadedPhotos = $this->uploadMultiplePhotos($_FILES['photos'], 'uploads/tour_diary/');
                if (!empty($uploadedPhotos)) {
                    $data['anhMinhHoa'] = implode(',', $uploadedPhotos);
                }
            }

            // Xác định insert/update
            if (isset($data['id']) && $data['id'] > 0) {
                $result = $this->modelReview->updateDiary($data['id'], $data);
                $message = $result ? 'Đã cập nhật' : 'Cập nhật thất bại';
            } else {
                $result = $this->modelReview->addDiary($data);
                $message = $result ? 'Đã thêm nhật ký' : 'Thêm thất bại';
            }

            // Lấy toàn bộ output dư thừa trước khi encode
            $php_debug = ob_get_clean();

            echo json_encode([
                'success' => $result,
                'message' => $message,
                'debug' => $php_debug
            ]);
        } catch (Exception $e) {
            $php_debug = ob_get_clean();
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
                'debug' => $php_debug
            ]);
        }

        exit();
    }



    // Method 7: Hiển thị trang đánh giá tour
    public function danhGiaTour($tourId)
    {
        try {
            // Lấy thông tin tour
            $tour = $this->modelTourDetail->getTourInfo($tourId);
            $tour_id = $tourId;
            $hdvId = $_SESSION['hdv_id'] ?? 5;
            
            // Lấy danh sách đánh giá trước đó (nếu có)
            $allReviews = $this->modelReview->getReviewsByTour($tourId, 'hdv');
            
            // Find review by current HDV
            $currentReview = null;
            $serviceProviderReviews = [];
            
            foreach ($allReviews as $review) {
                if ($review['hdv_id'] == $hdvId) {
                    $currentReview = $review;
                    // Get service provider reviews
                    $serviceProviderReviews = $this->modelReview->getServiceProviderReviews($review['id']);
                    break; 
                }
            }
            
            // Include view
            include './views/HDV/danh_gia_tour.php';
        } catch (Exception $e) {
            echo "<script>alert('Đã xảy ra lỗi khi tải trang đánh giá tour. Vui lòng thử lại sau.'); window.history.back();</script>";
            exit();
        }
    }

    // Method 8: Lưu đánh giá tour (AJAX API)
    public function saveReview()
    {
        header('Content-Type: application/json');
        
        try {
            // Use $_POST for FormData
            $data = $_POST;
            
            // Inject HDV ID if not present
            if (!isset($data['hdv_id'])) {
                $data['hdv_id'] = $_SESSION['hdv_id'] ?? 5;
            }

            // Handle file upload if exists
            if (isset($_FILES['photos'])) {
                $uploadedPhotos = $this->uploadMultiplePhotos($_FILES['photos'], 'uploads/reviews/');
                if (!empty($uploadedPhotos)) {
                    $data['anhMinhHoa'] = implode(',', $uploadedPhotos);
                }
            }
            
            // Lưu đánh giá chính
            if (isset($data['id']) && $data['id'] > 0) {
                // Update
                $result = $this->modelReview->updateReview($data['id'], $data);
                $reviewId = $data['id'];
            } else {
                // Insert
                $reviewId = $this->modelReview->addReview($data);
                $result = $reviewId !== false;
            }
            
            if ($result && $reviewId) {
                // Lưu đánh giá nhà cung cấp
                // Note: When using FormData, arrays might come as 'serviceProviders' => [['key'=>'val'], ...]
                // or we might need to decode if sent as JSON string in a field
                if (isset($data['serviceProviders'])) {
                    $providers = $data['serviceProviders'];
                    if (is_string($providers)) {
                        $providers = json_decode($providers, true);
                    }
                    
                    if (is_array($providers)) {
                        // Xóa đánh giá NCC cũ
                        $this->modelReview->deleteAllServiceProviderReviews($reviewId);
                        
                        // Thêm mới
                        foreach ($providers as $provider) {
                            if (!empty($provider['tenNCC'])) {
                                $this->modelReview->addServiceProviderReview($reviewId, $provider);
                            }
                        }
                    }
                }
                
                echo json_encode(['success' => true, 'message' => 'Đã lưu đánh giá']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lưu thất bại']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit();
    }

    // Method 9: Lấy lịch làm việc của HDV
    public function lichLamViec($hdvId = 5)
    {
        try {
            // Nếu không truyền hdvId, lấy từ session
            if (!$hdvId) {
                $hdvId = $_SESSION['hdv_id'] ?? 5; // Fallback to 5 for testing
            }

            // Lấy danh sách tour của HDV từ model
            $tours = $this->modelHDV->getToursByHDV($hdvId);
            
            // Include view
            include './views/HDV/lich_lam_viec.php';
        } catch (Exception $e) {
            // Thông báo rõ ràng lỗi
    echo "<pre>";
    echo "LỖI XẢY RA:\n";
    print_r($e->getMessage());
    echo "\n\nSTACK TRACE:\n";
    print_r($e->getTraceAsString());
    echo "</pre>";
    exit();
        }
    }

    // Upload nhiều ảnh
    private function uploadMultiplePhotos($files, $targetDir)
    {
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        $uploadedFiles = [];
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        $count = count($files['name']);
        for ($i = 0; $i < $count; $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $fileName = time() . '_' . $i . '_' . basename($files['name'][$i]);
                $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                if (in_array($ext, $allowed)) {
                    $targetPath = $targetDir . $fileName;
                    if (move_uploaded_file($files['tmp_name'][$i], $targetPath)) {
                        $uploadedFiles[] = $fileName;
                    }
                }
            }
        }
        
        return $uploadedFiles;
    }

    // API: Lấy danh sách yêu cầu theo khách hàng (for modal)
    public function getRequirementsByCustomer()
    {
        header('Content-Type: application/json');
        
        try {
            $tourId = $_GET['tour_id'] ?? 0;
            $customerId = $_GET['customer_id'] ?? 0;
            
            $requirements = $this->modelRequirement->getRequirementsByCustomer($tourId, $customerId);
            echo json_encode(['success' => true, 'data' => $requirements]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit();
    }

    // API: Xóa nhật ký tour
    public function deleteDiary()
    {
        header('Content-Type: application/json');

        try {
            // Nhận dữ liệu JSON từ AJAX
            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['id'])) {
                echo json_encode(['success' => false, 'message' => 'Thiếu ID nhật ký']);
                exit;
            }

            $id = intval($data['id']);

            // Lấy thông tin nhật ký trước khi xóa để xóa ảnh
            $diary = $this->modelReview->getDiaryById($id);

            if (!$diary) {
                echo json_encode(['success' => false, 'message' => 'Nhật ký không tồn tại']);
                exit;
            }

            // Xóa nhật ký
            $result = $this->modelReview->deleteDiary($id);

            if ($result) {

                // Nếu nhật ký có ảnh → xóa khỏi thư mục
                if (!empty($diary['anhMinhHoa'])) {
                    $photos = explode(',', $diary['anhMinhHoa']);
                    foreach ($photos as $photo) {
                        $path = 'uploads/tour_diary/' . $photo;
                        if (file_exists($path)) {
                            unlink($path);
                        }
                    }
                }

                echo json_encode(['success' => true, 'message' => 'Đã xóa nhật ký']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Xóa thất bại']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

        exit;
    }

    // API: Xóa yêu cầu đặc biệt
    public function deleteRequirement()
    {
        header('Content-Type: application/json');
        
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $result = $this->modelRequirement->deleteRequirement($data['id']);
            echo json_encode(['success' => $result]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit();
    }

    // API: Hoàn tất checkpoint
    public function completeCheckpoint()
    {
        header('Content-Type: application/json');
        
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['checkpointId'])) {
                echo json_encode(['success' => false, 'message' => 'Missing checkpointId']);
                exit();
            }
            
            $status = $data['status'] ?? 'completed';
            $result = $this->modelCheckpoint->updateCheckpointStatus($data['checkpointId'], $status);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Checkpoint completed']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update checkpoint']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit();
    }
}
