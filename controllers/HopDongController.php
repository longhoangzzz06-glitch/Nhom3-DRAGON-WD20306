<?php
require_once "./models/HopDong.php";

class HopDongController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new HopDong($db);
    }

    // Danh sách hợp đồng
    public function index()
    {
        $hopdongs = $this->model->layTatCa();
        require_once "./views/contract/index.php";
    }

    // Thêm hợp đồng mới
    public function create()
    {
        require_once "./views/contract/create.php";
    }

    public function store()
    {
        $data = [
            'nha_cung_cap_id' => $_POST['nha_cung_cap_id'],
            'tour_id' => $_POST['tour_id'],
            'file_hop_dong' => null,
            'gia' => $_POST['gia'],
            'ghi_chu' => $_POST['ghi_chu']
        ];

        // Upload file hợp đồng
        if (!empty($_FILES['file_hop_dong']['name'])) {
            $data['file_hop_dong'] = "uploads/contracts/" . time() . "_" . $_FILES['file_hop_dong']['name'];
            move_uploaded_file($_FILES['file_hop_dong']['tmp_name'], $data['file_hop_dong']);
        }

        $this->model->them($data);
        header("Location: index.php?act=hopdong");
        exit;
    }
}
