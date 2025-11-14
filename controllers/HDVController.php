<?php
// có class chứa các function thực thi xử lý logic 
class HDVController
{
    public $modelHDV;

    public function __construct()
    {
        $this->modelHDV = new HDVModel();
    }

    // Thêm ảnh hướng dẫn viên
    public function uploadPhoto($fieldName, $targetDir)
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

        return null; // upload lỗi
    }

    //function xử lý trang hiển thị danh sách HDV
    public function DanhSach()
    {
        // Lấy dữ liệu từ model
        $dsHDV = $this->modelHDV->getAllHDV();

        // Gọi view để hiển thị dữ liệu
        include './views/quanly_HDV/danhsach_HDV.php';
    }

    // function xử lý upload ảnh HDV
    public function ThemHDV($data)
    {
        // Xử lý ảnh
        $photo = $this->uploadPhoto('photo', 'uploads/img_HDV/');

        // Gắn ảnh vào mảng data
        $data['photo'] = $photo;

        // Gọi Model thêm vào DB
        $this->modelHDV->addHDV($data);

        // Chuyển hướng về trang danh sách HDV
        header('Location: index.php');
        exit();
    }

    // function xử lý thêm HDV
    public function viewThemHDV()
    {
        include './views/quanly_HDV/add_HDV.php';
    }

    public function addHDV($data)
    {
        // Đảm bảo các trường bắt buộc đã được nhập
        $requiredFields = ['full_name', 'birth_date', 'phone', 'email'];
        $missingFields = [];
        
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $missingFields[] = $field;
            }
        }
        
        if (!empty($missingFields)) {
            $fieldNames = [
                'full_name' => 'Họ tên',
                'birth_date' => 'Ngày sinh',
                'phone' => 'Điện thoại',
                'email' => 'Email'
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
        
        // Xử lý upload ảnh
        $photo = $this->uploadPhoto('photo', 'uploads/img_HDV/');
        
        if ($photo === null) {
            $photo = '';
        }
        
        $data['photo'] = $photo;
        
        // Thêm vào DB với xử lý lỗi
        try {
            $result = $this->modelHDV->addHDV($data);
            // Hoàn tất - chuyển về danh sách
            header('Location: index.php?act=/');
            exit();
        } catch (Exception $e) {
            // Nếu thêm DB thất bại, XÓA ảnh đã upload để tránh file rác
            if ($photo !== '' && file_exists('uploads/img_HDV/' . $photo)) {
                unlink('uploads/img_HDV/' . $photo);
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
    public function deleteHDV($id)
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

    // function hiển thị form cập nhật HDV
    public function viewCapNhatHDV($id)
    {
        // Lấy dữ liệu HDV theo ID
        $hdv = $this->modelHDV->getHDVById($id);

        // Gọi view để hiển thị form cập nhật
        include './views/quanly_HDV/edit_HDV.php';
    }

    // function xử lý cập nhật HDV theo ID
    public function editHDV($id, $data)
    {
        try {
            // Đảm bảo các trường bắt buộc đã được nhập
            $requiredFields = ['full_name', 'birth_date', 'phone', 'email'];
            $missingFields = [];
            
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    $missingFields[] = $field;
                }
            }
            
            if (!empty($missingFields)) {
                $fieldNames = [
                    'full_name' => 'Họ tên',
                    'birth_date' => 'Ngày sinh',
                    'phone' => 'Điện thoại',
                    'email' => 'Email'
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
            
            // Xử lý upload ảnh nếu có file mới
            $oldPhoto = $data['old_photo'] ?? null;
            $photo = $oldPhoto; // Giữ ảnh cũ mặc định
            
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                // Tải lên ảnh mới
                $newPhoto = $this->uploadPhoto('photo', 'uploads/img_HDV/');
                
                if ($newPhoto !== null) {
                    // Nếu tải lên thành công, xóa ảnh cũ
                    if ($oldPhoto && file_exists('uploads/img_HDV/' . $oldPhoto)) {
                        unlink('uploads/img_HDV/' . $oldPhoto);
                    }
                    $photo = $newPhoto;
                }
            }
            
            // Gán ảnh vào mảng dữ liệu
            $data['photo'] = $photo;
            
            // Cập nhật trong DB
            $result = $this->modelHDV->updateHDV($id, $data);
            
            if ($result) {
                echo "<script>
                    alert('Cập nhật hướng dẫn viên thành công!');
                    window.location.href = 'index.php?act=/';
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
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $newPhoto = $_FILES['photo']['name'];
                $photoPath = 'uploads/img_HDV/' . $newPhoto;
                if (file_exists($photoPath)) {
                    unlink($photoPath);
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