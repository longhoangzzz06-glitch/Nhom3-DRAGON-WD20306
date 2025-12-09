<?php
require_once "./models/HopDong.php";

class HopDongController
{
    private $model;

    public function __construct()
    {
        $this->model = new HopDong();
    }

    // Hiển thị danh sách hợp đồng
    public function index()
    {
        $hopdongs = $this->model->layTatCa();
        require_once "./views/hop_dong/index.php";
    }

    // Form thêm hợp đồng mới
    public function create()
{
    $nccModel = new Supplier();
    $nha_cung_caps = $nccModel->getAll(); // Lấy danh sách nhà cung cấp từ DB
    require_once "./views/hop_dong/create.php";
}

    // Lưu hợp đồng mới
    public function store()
    {
        $data = [
            'nha_cung_cap_id' => $_POST['nha_cung_cap_id'],
            'tour_id' => $_POST['tour_id'],
            'file_hop_dong' => null,
            'gia' => $_POST['gia'],
            'ghi_chu' => $_POST['ghi_chu']
        ];

        if (!empty($_FILES['file_hop_dong']['name'])) {
            $data['file_hop_dong'] = "uploads/hop_dong/" . time() . "_" . $_FILES['file_hop_dong']['name'];
            move_uploaded_file($_FILES['file_hop_dong']['tmp_name'], $data['file_hop_dong']);
        }

        $this->model->them($data);
        header("Location: index.php?act=hopdong");
        exit;
    }

    // Form sửa hợp đồng
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?act=hopdong");
            exit;
        }

            $nccModel = new Supplier();
            $nha_cung_caps = $nccModel->getAll();
        require_once "./views/hop_dong/edit.php";
    }

    // Cập nhật hợp đồng
    public function update()
    {
        $id = $_POST['id'];
        $hopdong = $this->model->layMot($id);

        $data = [
            'nha_cung_cap_id' => $_POST['nha_cung_cap_id'],
            'tour_id' => $_POST['tour_id'],
            'file_hop_dong' => $hopdong['file_hop_dong'], // giữ file cũ nếu không upload mới
            'gia' => $_POST['gia'],
            'ghi_chu' => $_POST['ghi_chu']
        ];

        if (!empty($_FILES['file_hop_dong']['name'])) {
            // Xóa file cũ nếu có
            if ($hopdong['file_hop_dong'] && file_exists($hopdong['file_hop_dong'])) {
                unlink($hopdong['file_hop_dong']);
            }
            $data['file_hop_dong'] = "uploads/hop_dong/" . time() . "_" . $_FILES['file_hop_dong']['name'];
            move_uploaded_file($_FILES['file_hop_dong']['tmp_name'], $data['file_hop_dong']);
        }

        $this->model->capNhat($id, $data);
        header("Location: index.php?act=hopdong");
        exit;
    }

    // Xóa hợp đồng
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $hopdong = $this->model->layMot($id);
            if ($hopdong['file_hop_dong'] && file_exists($hopdong['file_hop_dong'])) {
                unlink($hopdong['file_hop_dong']);
            }
            $this->model->xoa($id);
        }
        header("Location: index.php?act=hopdong");
        exit;
    }
}
