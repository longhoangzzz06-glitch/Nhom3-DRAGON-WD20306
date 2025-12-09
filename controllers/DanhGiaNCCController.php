<?php
require_once "./models/DanhGiaNCC.php";
require_once "./models/SupplierModel.php";
require_once "./models/TourModel.php";

class DanhGiaNCCController
{
    private $nha_cung_caps;  // danh sách nhà cung cấp
    private $tours;          // danh sách tour

    private $model;

    public function __construct()
    {
        $this->model = new DanhGiaNCC();
    }

    public function index()
    {
        $danhgias = $this->model->layTatCa();
        require_once "./views/danh_gia_ncc/index.php";
    }

    public function create()
    {
        $nccModel = new Supplier();
        $toursModel = new TourModel();
        $nha_cung_caps = $nccModel->getAll();
        $tours = $toursModel->getAllTour();

        require_once "./views/danh_gia_ncc/create.php";
    }

    public function store()
    {
        $data = [
            'nha_cung_cap_id' => (int)$_POST['nha_cung_cap_id'],
            'tour_id' => (int)$_POST['tour_id'],
            'diem' => (int)$_POST['diem'],
            'binh_luan' => $_POST['binh_luan'],
            'ngay_danh_gia' => $_POST['ngay_danh_gia']
        ];

        $this->model->them($data);
        header("Location: index.php?act=quan-ly-danhgia");
        exit;
    }

    public function edit()
    {
        $danhgia = $this->model->tim($_GET['id']);
        $nccModel = new Supplier();
        $toursModel = new TourModel();
        $nha_cung_caps = $nccModel->getAll();
        $tours = $toursModel->getAllTour();

        require_once "./views/danh_gia_ncc/edit.php";
    }

    public function update()
    {
        $id = (int)$_POST['id'];
        $data = [
            'nha_cung_cap_id' => (int)$_POST['nha_cung_cap_id'],
            'tour_id' => (int)$_POST['tour_id'],
            'diem' => (int)$_POST['diem'],
            'binh_luan' => $_POST['binh_luan'],
            'ngay_danh_gia' => $_POST['ngay_danh_gia']
        ];

        $this->model->capNhat($id, $data);
        header("Location: index.php?act=quan-ly-danhgia");
        exit;
    }

    public function delete()
    {
        $this->model->xoa((int)$_GET['id']);
        header("Location: index.php?act=quan-ly-danhgia");
        exit;
    }
}
