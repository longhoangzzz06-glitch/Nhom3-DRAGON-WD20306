<?php 
class HDVController
{
    public $modelHDV;

    public function __construct()
    {
        $this -> modelHDV = new HDVModel();
    }

    // function xử lý trang hiển thị danh sách HDV
    public function danhSach()
    {
        $dsHDV = $this->modelHDV->getAllHDV();
        include './views/HDV/danhsach_HDV.php';
    }

    // Thêm ảnh hướng dẫn viên
    public function uploadAnh($fieldName, $targetDir)
    {
        if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK){
            return null; // Không có file được tải lên hoặc có lỗi
        }
        // Tạo thư mục nếu chưa tồn tại
        if (!is_dir($targetDir)){
            mkdir($targetDir, 0777, true);
        }
        $fileName = time() . '_' . basename($_FILES[$fieldName]['name']);
        $targetPath = $targetDir . $fileName;
        // Kiểm tra phần mở rộng
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)){
            return null;
        }
        if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $targetPath)){
            return $fileName; // trả về tên file để lưu vào DB
        }
        return null;
    }

    // function xử lý thêm HDV
    public function viewThemHDV(){
        include './views/HDV/them_HDV.php';
    }
    public function themHDV($data){
        // Đảm bảo các trường bắt buộc đã được nhập
        $requiredFields = ['hoTen', 'ngaySinh', 'dienThoai', 'email', 'nhomHDV_id'];
        $missingFields = [];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $missingFields[] = $field;
            }
        }
        if (!empty($missingFields)) {
            $fieldNames = [
                'hoTen'     => 'Họ tên',
                'ngaySinh'  => 'Ngày sinh',
                'dienThoai' => 'Điện thoại',
                'email'     => 'Email',
                'nhomHDV_id' => 'Nhóm HDV'
            ];
            $missingLabels = array_map(function($field) use ($fieldNames) {
                return $fieldNames[$field] ?? $field;
            }, $missingFields);
            $errorMsg = 'Vui lòng nhập các trường bắt buộc: ' . implode(', ', $missingLabels);
            echo "<script>
                alert('" . addslashes($errorMsg) . "');
                window.location.href = 'index.php?act=view-them-hdv';
            </script>";
            exit();
        }
        // Xử lý giá trị trống cho các trường số
        if (empty($data['kinhNghiem'])) {
            $data['kinhNghiem'] = 0;
        } else {
            $data['kinhNghiem'] = intval($data['kinhNghiem']);
        }
        // Xử lý upload ảnh
        $anh = $this->uploadAnh('anh', 'uploads/img_HDV/');
        if ($anh === null) {
            $anh = '';
        }
        $data['anh'] = $anh;
        // Thêm vào DB với xử lý lỗi
        try {
            $result = $this->modelHDV->addHDV($data);
            // Hoàn tất - chuyển về danh sách
            header('Location: index.php?act=/');
            exit();
        } catch (Exception $e) {
            // Nếu thêm DB thất bại, XÓA ảnh đã upload để tránh file rác
            if ($anh !== '' && file_exists('uploads/img_HDV/' . $anh)) {
                unlink('uploads/img_HDV/' . $anh);
            }
            // Xử lý tất cả lỗi cơ sở dữ liệu
            $errorMsg = $e->getMessage();
            // Kiểm tra lỗi trùng lặp (1062)
            if (strpos($errorMsg, '1062') !== false || strpos($errorMsg, 'Duplicate entry') !== false) {
                echo "<script>
                    alert('Dữ liệu bị trùng - Dữ liệu này đã có trên hệ thống. Vui lòng nhập dữ liệu khác.');
                    window.location.href = 'index.php?act=view-them-hdv';
                </script>";
                exit();
            }
            // Kiểm tra lỗi trường null (1048)
            if (strpos($errorMsg, '1048') !== false || strpos($errorMsg, 'cannot be null') !== false) {
                echo "<script>
                    alert('Vui lòng nhập đủ các trường bắt buộc (Họ tên, Ngày sinh, Điện thoại, Email).');
                    window.location.href = 'index.php?act=view-them-hdv';
                </script>";
                exit();
            }
            // Cho các lỗi khác, hiển thị thông báo chung
            echo "<script>
                alert('Lỗi: " . addslashes(substr($errorMsg, 0, 100)) . "');
                window.location.href = 'index.php?act=view-them-hdv';
            </script>";
            exit();
        }
    }

    // function xử lý xóa HDV theo ID
    public function xoaHDV($id)
    {
        try {
            $result = $this->modelHDV->deleteHDV($id);
            
            if ($result) {
                // Xóa thành công
                echo "<script>
                    alert('Xóa hướng dẫn viên thành công!');
                    window.location.href = 'index.php?act=/';
                </script>";
            } else {
                // Xóa thất bại
                echo "<script>
                    alert('Xóa hướng dẫn viên thất bại!');
                    window.location.href = 'index.php?act=/';
                </script>";
            }
            exit();
        } catch (Exception $e) {
            // Xử lý lỗi
            echo "<script>
                alert('Lỗi: " . addslashes($e->getMessage()) . "');
                window.location.href = 'index.php?act=/';
            </script>";
            exit();
        }
    }

    // function xử lý lấy nhóm HDV theo ID
    public function getAllNhomHDV()
    {
        return $this->modelHDV->getAllNhomHDV();
    }

    // function hiển thị form cập nhật HDV
    public function viewCapNhatHDV($id)
    {
        $hdv = $this->modelHDV->getHDVById($id);
        include './views/HDV/capNhat_HDV.php';
    }

    // function xử lý cập nhật HDV theo ID
    public function capNhatHDV($id, $data)
    {
        try {
            // Đảm bảo các trường bắt buộc đã được nhập
            $requiredFields = ['hoTen', 'ngaySinh', 'dienThoai', 'email'];
            $missingFields = [];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    $missingFields[] = $field;
                }
            }          
            if (!empty($missingFields)) {
                $fieldNames = [
                    'hoTen'     => 'Họ tên',
                    'ngaySinh'  => 'Ngày sinh',
                    'dienThoai' => 'Điện thoại',
                    'email'     => 'Email'
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
            // Xử lý giá trị trống cho các trường số
            if (empty($data['kinhNghiem'])) {
                $data['kinhNghiem'] = 0;
            } else {
                $data['kinhNghiem'] = intval($data['kinhNghiem']);
            }
            // Xử lý upload ảnh nếu có file mới
            $oldAnh = $data['old_anh'] ?? null;
            $anh = $oldAnh; // Giữ ảnh cũ mặc định
            if (isset($_FILES['anh']) && $_FILES['anh']['error'] === UPLOAD_ERR_OK) {
                // Tải lên ảnh mới
                $newAnh = $this->uploadAnh('anh', 'uploads/img_HDV/');
                if ($newAnh !== null) {
                    // Nếu tải lên thành công, xóa ảnh cũ
                    if ($oldAnh && file_exists('uploads/img_HDV/' . $oldAnh)) {
                        unlink('uploads/img_HDV/' . $oldAnh);
                    }
                    $anh = $newAnh;
                }
            }
            
            // Gán ảnh vào mảng dữ liệu
            $data['anh'] = $anh;
            
            // Cập nhật trong DB
            $result = $this->modelHDV->updateHDV($id, $data);
            
            if ($result) {
                echo "<script>
                    alert('Cập nhật hướng dẫn viên thành công!');
                    window.location.href = 'index.php?act=quan-ly-hdv';
                </script>";
            } else {
                echo "<script>
                    alert('Cập nhật hướng dẫn viên thất bại!');
                    window.history.back();
                </script>";
            }
            exit();
            
        } catch (Exception $e) {
            // Nếu có lỗi và có ảnh mới đã upload, xóa ảnh đó để tránh file rác
            if (isset($_FILES['anh']) && $_FILES['anh']['error'] === UPLOAD_ERR_OK) {
                $newAnh = $_FILES['anh']['name'];
                $anhPath = 'uploads/img_HDV/' . $newAnh;
                if (file_exists($anhPath)) {
                    unlink($anhPath);
                }
            }
            
            // Xử lý tất cả lỗi cơ sở dữ liệu
            $errorMsg = $e->getMessage();
            
            // Kiểm tra lỗi trùng lặp (1062)
            if (strpos($errorMsg, '1062') !== false || strpos($errorMsg, 'Duplicate entry') !== false) {
                echo "<script>
                    alert('Dữ liệu bị trùng - Số điện thoại hoặc email này đã tồn tại. Vui lòng nhập dữ liệu khác.');
                    window.history.back();
                </script>";
                exit();
            }
            
            // Kiểm tra lỗi trường null (1084)
            echo "<script>
                alert('Lỗi: " . addslashes(substr($errorMsg, 0, 100)) . "');
                window.history.back();
            </script>";
            exit();
        }
    }
}