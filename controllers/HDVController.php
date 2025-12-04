<?php 
class HDVController
{
    public $modelHDV;
    public $modelTaiKhoan;

    public function __construct()
    {
        $this->modelHDV = new HDVModel();
        $this->modelTaiKhoan = new TaiKhoanModel();
    }

    public function danhSach()
    {
        $dsHDV = $this->modelHDV->getAllHDV();
        include './views/HDV/danhsach_HDV.php';
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
                alert('Vui lòng nhập đầy đủ các trường bắt buộc!');
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
                $msg = "Email hoặc Số điện thoại đã tồn tại!";
            }

            echo "<script>
                alert('Lỗi: " . addslashes($msg) . "');
                window.location.href = 'index.php?act=view-them-hdv';
            </script>";
            exit;
        }
    }

    public function xoaHDV($id)
    {
        try {
            $result = $this->modelHDV->deleteHDV($id);

            if ($result) {
                echo "<script>
                    alert('Xóa thành công!');
                    window.location.href = 'index.php?act=quan-ly-hdv';
                </script>";
            } else {
                echo "<script>
                    alert('Xóa thất bại!');
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
                $msg = "Email hoặc Số điện thoại trùng!";
            }

            echo "<script>
                alert('Lỗi: " . addslashes($msg) . "');
                window.history.back();
            </script>";
            exit;
        }
    }
}
