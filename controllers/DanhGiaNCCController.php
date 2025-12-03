<?php
require_once "./models/DanhGiaNCC.php";

class DanhGiaNCCController
{
    private $db;
    private $model;

    public function __construct()
    {
        $this->model = new DanhGiaNCC();
    }

    // Danh sách đánh giá nhà cung cấp
    public function index()
    {
        $danhgias = $this->model->layTatCa();
        require_once "./views/danh_gia_ncc/index.php";
    }

    public function create()
    {
        require_once "./views/danh_gia_ncc/create.php";
    }

    public function store()
    {
        $data = [
            'nha_cung_cap_id' => $_POST['nha_cung_cap_id'],
            'tour_id' => $_POST['tour_id'],
            'diem' => $_POST['diem'], // 1-5
            'binh_luan' => $_POST['binh_luan'],
            'ngay_danh_gia' => $_POST['ngay_danh_gia']
        ];

        $this->model->them($data);
        header("Location: index.php?act=danhgia");
        exit;
    }

    public function edit()
    {
        $danhgia = $this->model->tim($_GET['id']);
        require_once "./views/danh_gia_ncc/edit.php";
    }

    public function update()
    {
        $id = $_POST['id'];
        $data = [
            'nha_cung_cap_id' => $_POST['nha_cung_cap_id'],
            'tour_id' => $_POST['tour_id'],
            'diem' => $_POST['diem'],
            'binh_luan' => $_POST['binh_luan'],
            'ngay_danh_gia' => $_POST['ngay_danh_gia']
        ];

        $this->model->capNhat($id, $data);
        header("Location: index.php?act=danhgia");
        exit;
    }

    public function delete()
    {
        $this->model->xoa($_GET['id']);
        header("Location: index.php?act=danhgia");
        exit;
    }
}
