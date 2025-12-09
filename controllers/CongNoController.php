<?php
require_once "./models/CongNo.php";
require_once "./models/SupplierModel.php";
require_once "./models/TourModel.php";

class CongNoController
{
    private $nha_cung_caps;  // danh sách nhà cung cấp
    private $tours;          // danh sách tour

    private $model;

    public function __construct()
    {
        $this->model = new CongNo();
    }

    // Danh sách công nợ
    public function index()
    {
        $congnos = $this->model->layTatCa();
        require_once "./views/cong_no/index.php";
    }

    // Form thêm
    public function create()
    {
        $nccModel = new Supplier();
        $toursModel = new TourModel();
        $nha_cung_caps = $nccModel->getAll();
        $tours = $toursModel->getAllTour();

        require_once "./views/cong_no/create.php";
    }

    // Lưu công nợ mới
    public function store()
    {
        $data = [
            'nha_cung_cap_id' => (int)$_POST['nha_cung_cap_id'],
            'tour_id' => (int)$_POST['tour_id'],
            'sotien' => (float)$_POST['sotien'],
            'loai' => $_POST['loai'],
            'ghi_chu' => $_POST['ghi_chu'],
            'ngay' => $_POST['ngay']
        ];

        $this->model->them($data);
        header("Location: index.php?act=quan-ly-congno");
        exit;
    }

    // Form edit
    public function edit()
    {
        $congno = $this->model->tim($_GET['id']);
        $nccModel = new Supplier();
        $toursModel = new TourModel();
        $nha_cung_caps = $nccModel->getAll();
        $tours = $toursModel->getAllTour();

        require_once "./views/cong_no/edit.php";
    }

    // Cập nhật công nợ
    public function update()
    {
        $id = (int)$_POST['id'];
        $data = [
            'nha_cung_cap_id' => (int)$_POST['nha_cung_cap_id'],
            'tour_id' => (int)$_POST['tour_id'],
            'sotien' => (float)$_POST['sotien'],
            'loai' => $_POST['loai'],
            'ghi_chu' => $_POST['ghi_chu'],
            'ngay' => $_POST['ngay']
        ];

        $this->model->capNhat($id, $data);
        header("Location: index.php?act=quan-ly-congno");
        exit;
    }

    // Xóa công nợ
    public function delete()
    {
        $this->model->xoa((int)$_GET['id']);
        header("Location: index.php?act=quan-ly-congno");
        exit;
    }
}
