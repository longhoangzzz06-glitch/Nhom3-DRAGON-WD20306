<?php
require_once "./models/TaiChinhTour.php";

class TaiChinhTourController
{
    private $db;
    private $model;

    public function __construct()
    {
        $this->model = new TaiChinhTour();
    }

    // Báo cáo lãi/lỗ từng tour
    public function baoCao()
    {
        $tourId = $_GET['tour_id'] ?? null;
        $baocao = $this->model->tinhLaiLo($tourId);
        require_once "./views/taichinh/baocao.php";
    }
}
