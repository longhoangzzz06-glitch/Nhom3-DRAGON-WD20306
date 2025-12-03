<?php
require_once "./models/CongNo.php";

class CongNoController
{
    private $db;
    private $model;

    public function __construct()
    {
        $this->model = new CongNo();
    }

    // Danh sách công nợ & thanh toán
    public function index()
    {
        $congnos = $this->model->layTatCa();
        require_once "./views/cong_no/index.php";
    }

    public function create()
    {
        require_once "./views/cong_no/create.php";
    }

    public function store()
    {
        $data = [
            'nha_cung_cap_id' => $_POST['nha_cung_cap_id'],
            'tour_id' => $_POST['tour_id'],
            'sotien' => $_POST['sotien'],
            'loai' => $_POST['loai'], // "con_no" hoặc "da_thanh_toan"
            'ghi_chu' => $_POST['ghi_chu'],
            'ngay' => $_POST['ngay']
        ];

        $this->model->them($data);
        header("Location: index.php?act=congno");
        exit;
    }

    public function edit()
    {
        $congno = $this->model->tim($_GET['id']);
        require_once "./views/cong_no/edit.php";
    }

    public function update()
    {
        $id = $_POST['id'];
        $data = [
            'nha_cung_cap_id' => $_POST['nha_cung_cap_id'],
            'tour_id' => $_POST['tour_id'],
            'sotien' => $_POST['sotien'],
            'loai' => $_POST['loai'],
            'ghi_chu' => $_POST['ghi_chu'],
            'ngay' => $_POST['ngay']
        ];

        $this->model->capNhat($id, $data);
        header("Location: index.php?act=congno");
        exit;
    }

    public function delete()
    {
        $this->model->xoa($_GET['id']);
        header("Location: index.php?act=congno");
        exit;
    }
}
