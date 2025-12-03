<?php
require_once "./models/TaiChinhTour.php";

class TaiChinhTourController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new TaiChinhTour($db);
    }

    // Báo cáo lãi/lỗ từng tour
    public function baoCao()
    {
        $tourId = $_GET['tour_id'] ?? null;
        $baocao = $this->model->tinhLaiLo($tourId);
        require_once "./views/taichinh/index.php";
    }
}
