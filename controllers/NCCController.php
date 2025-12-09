<?php
class NCCController {
    private $nccModel;

    public function __construct() 
    {
        $this->nccModel = new NCCModel();
    }

    // Hiển thị danh sách nhà cung cấp
    public function danhSachNCC() 
    {
        $nccList = $this->nccModel->getAllNCC();
        include 'views/ncc/danhsach_NCC.php';
    }

    public function layNccByTourId($id) 
    {
        return $this->nccModel->layNccByTourId($id);
    }

    // Xử lý thêm nhà cung cấp
    public function themNCC($data) 
    {
        try {
            $result = $this->nccModel->insertNCC($data);
            if ($result) {
                echo "<script>
                    alert('Thêm nhà cung cấp thành công!');
                    window.location.href = 'index.php?act=quan-ly-ncc';
                </script>";
            } else {
                echo "<script>
                    alert('Thêm nhà cung cấp thất bại!');
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
                    alert('Vui lòng nhập đủ các trường bắt buộc (Tên NCC, Địa chỉ, Số điện thoại).');
                    window.history.back();
                </script>";
                exit();
            }
            echo "<script>
                alert('Lỗi khi thêm nhà cung cấp: " . addslashes($errorMsg) . "');
                window.history.back();
            </script>";
            exit();
        }
    }

    // Thêm NCC vào tour
    public function themNccVaoTour() {
        $tour_id = $_GET['tour_id'] ?? null;
        $ncc_id  = $_GET['ncc_id'] ?? null;

        try {
        if ($tour_id && $ncc_id) {
            $nccTourModel = new NccTourModel();
            $nccTourModel->addNccToTour($tour_id, $ncc_id);
        }
        echo "<script>
        alert('Thêm NCC vào Tour thành công')
        window.history.back();                          
        </script>";

        }catch(Exception $e){
        $msg = $e->getMessage();
        if (strpos($msg, '1062') !== false){    
            $msg = "Đã có NCC này trong Tour";
            }
        echo "<script>
        alert (' Lỗi: " . addslashes($msg) . "');
        window.history.back();                          
        </script>";
        }
    }

    // Xử lý xóa nhà cung cấp theo ID
    public function xoaNccKhoiTour() {
        $tour_id = $_GET['tour_id'];
        $ncc_id = $_GET['ncc_id'];

    try {
        if ($tour_id && $ncc_id) {
        $nccTourModel = new NccTourModel();
        $nccTourModel->deleteOne($tour_id, $ncc_id);
        }        
        echo "<script>
        alert('Xóa NCC khỏi Tour thành công');
        window.location.href = document.referrer;
        </script>";

    }catch(Exception $e){
        $msg = $e->getMessage();
        echo "<script>
        alert (' Lỗi: " . addslashes($msg) . "');
        window.history.back();
        </script>";
        }
    }
}