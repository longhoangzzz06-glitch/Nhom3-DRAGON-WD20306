<?php
class TourController {
    private $tourModel;

    public function __construct() {
        $this -> tourModel = new TourModel();
    }

    // Hiển thị danh sách tour
    public function danhSachTour() {
        $tours = $this->tourModel->getAllTour();
        require_once './views/tours/danhsach_Tour.php';
    }

    // Lấy dữ liệu tất cả danh mục, nhà cung cấp, chính sách
    public function getAllDanhMucTour() {
        $tourModel = new TourModel();
        return $this->tourModel->getAllDanhMucTour();
    }
    public function getAllNhaCungCap() {
        $tourModel = new TourModel();
        return $this->tourModel->getAllNhaCungCap();
    }
    public function getAllChinhSach() {
        $tourModel = new TourModel();
        return $this->tourModel->getAllChinhSach();
    }

    // function xử lý thêm tour
    public function viewThemTour() {
        require_once './views/tours/them_Tour.php';
    }
    public function themTour() {
        $requiredFields = ['ten', 'danhMuc_id', 'chinhSach_id', 'ncc_id'];
        $missingFields = [];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                $missingFields[] = $field;
            }
        }
        if (!empty($missingFields)) {
            $fieldNames = [
                'ten' => 'Tên Tour',
                'danhMuc_id' => 'Danh mục',
                'chinhSach_id' => 'Chính sách',
                'ncc_id' => 'Nhà cung cấp'
            ];
            $missingLabels = array_map(function($field) use ($fieldNames) {
                return $fieldNames[$field] ?? $field;
            }, $missingFields);
            $errorMessage = "Vui lòng điền đầy đủ các trường: " . implode(', ', $missingLabels);
            echo "<script>
                alert('" . addslashes($errorMessage) . "');
                window.location.href = 'index.php?act=view-them-tour';
            </script>";
            exit();
        }
        try {
            $result = $this->tourModel->addTour($_POST);
            // Hoàn tất - chyển về danh sách
            header('Location: index.php?act=quan-ly-tours');
            exit();
        } catch (Exception $e) {
            // Xử lý tất cả lỗi cơ sở dữ liệu
            $errorMsg = $e->getMessage();
            // Lỗi trùng dữ liệu
            if (strpos($errorMsg, '1062') !== false || strpos($errorMsg, 'Duplicate entry') !== false) {
                echo "<script>
                    alert('Dữ liệu bị trùng - Dữ liệu này đã có trên hệ thống. Vui lòng nhập dữ liệu khác.');
                    window.location.href = 'index.php?act=view-them-tour';
                </script>";
                exit();
            }
            // Kiểm tra lỗi trường null (1048)
            if (strpos($errorMsg, '1048') !== false || strpos($errorMsg, 'cannot be null') !== false) {
                echo "<script>
                    alert('Vui lòng nhập đủ các trường bắt buộc (Tên Tour, Danh mục, Chính sách, Nhà cung cấp).');
                    window.location.href = 'index.php?act=view-them-tour';
                </script>";
                exit();
            }
            // Lỗi khác
            echo "<script>
                alert('Lỗi khi thêm tour: " . addslashes($e->getMessage()) . "');
                window.location.href = 'index.php?act=view-them-tour';
            </script>";
            exit();
        }
    }

    // function hiển thị form cập nhật tour
    public function viewCapNhatTour($id) {
        $tour = $this->tourModel->getTourById($id);
        require_once './views/tours/capNhat_Tour.php';
    }
    // function xử lý cập nhật tour
    public function capNhatTour() {
        try {
            // Đảm bảo các trường bắt buộc đã được nhập
            $requiredFields = ['ten', 'danhMuc_id', 'chinhSach_id', 'ncc_id'];
            $missingFields = [];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $missingFields[] = $field;
                }
            }
            if (!empty($missingFields)) {
                $fieldNames = [
                    'ten' => 'Tên Tour',
                    'danhMuc_id' => 'Danh mục',
                    'chinhSach_id' => 'Chính sách',
                    'ncc_id' => 'Nhà cung cấp'
                ];
                $missingLabels = array_map(function($field) use ($fieldNames) {
                    return $fieldNames[$field] ?? $field;
                }, $missingFields);
                $errorMsg = 'Vui lòng nhập các trường bắt buộc: ' . implode(', ', $missingLabels);
                echo "<script>
                    alert('" . addslashes($errorMsg) . "');
                    window.history.back();
                </script>";
                exit();
            }
            $id = $_POST['id'];
            $data = [
                'ten' => $_POST['ten'],
                'danhMuc_id' => $_POST['danhMuc_id'],
                'moTa' => $_POST['moTa'] ?? '',
                'chinhSach_id' => $_POST['chinhSach_id'],
                'ncc_id' => $_POST['ncc_id'],
                'trangThai' => $_POST['trangThai'] ?? 'Đang Đóng',
                'gia' => $_POST['gia'] ?? 0,
                'tgBatDau' => $_POST['tgBatDau'] ?? null,
                'tgKetThuc' => $_POST['tgKetThuc'] ?? null
            ];
            $result = $this->tourModel->updateTour($id, $data);
            if ($result) {
                echo "<script>
                    alert('Cập nhật tour thành công!');
                    window.location.href = 'index.php?act=quan-ly-tours';
                </script>";
            } else {
                echo "<script>
                    alert('Cập nhật tour thất bại!');
                    window.history.back();
                </script>";
            }
            exit();
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
            if (strpos($errorMsg, '1062') !== false || strpos($errorMsg, 'Duplicate entry') !== false) {
                echo "<script>
                    alert('Dữ liệu bị trùng - Dữ liệu này đã có trên hệ thống. Vui lòng nhập dữ liệu khác.');
                    window.history.back();
                </script>";
                exit();
            }
            if (strpos($errorMsg, '1048') !== false || strpos($errorMsg, 'cannot be null') !== false) {
                echo "<script>
                    alert('Vui lòng nhập đủ các trường bắt buộc (Tên Tour, Danh mục, Chính sách, Nhà cung cấp).');
                    window.history.back();
                </script>";
                exit();
            }
            echo "<script>
                alert('Lỗi khi cập nhật tour: " . addslashes($errorMsg) . "');
                window.history.back();
            </script>";
            exit();
        }
    }

    // Xử lý xóa tour theo ID
    public function xoaTour($id)     
    {
        try {
            $result = $this->tourModel->deleteTour($id);     
            if ($result) {
                // Xóa thành công
                echo "<script>
                    alert('Xóa tour thành công!');
                    window.location.href = 'index.php?act=quan-ly-tours';
                </script>";
            } else {
                // Xóa thất bại
                echo "<script>
                    alert('Xóa tour thất bại!');
                    window.location.href = 'index.php?act=quan-ly-tours';
                </script>";
            }
            exit();
        } catch (Exception $e) {
            // Xử lý lỗi
            echo "<script>
                alert('Lỗi: " . addslashes($e->getMessage()) . "');
                window.location.href = 'index.php?act=quan-ly-tours';
            </script>";
            exit();
        }
    }
}
