<?php
class TaiChinhTour
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Tính lãi/lỗ
    public function tinhLaiLo($tourId)
    {
        if (!$tourId) return [];

        // Tổng doanh thu
        $stmt1 = $this->db->prepare("SELECT SUM(sotien) as doanhthu FROM thu_tour WHERE tour_id=:tour_id");
        $stmt1->execute(['tour_id' => $tourId]);
        $doanhthu = $stmt1->fetch(PDO::FETCH_ASSOC)['doanhthu'] ?? 0;

        // Tổng chi phí
        $stmt2 = $this->db->prepare("SELECT SUM(sotien) as chiphi FROM chi_tour WHERE tour_id=:tour_id");
        $stmt2->execute(['tour_id' => $tourId]);
        $chiphi = $stmt2->fetch(PDO::FETCH_ASSOC)['chiphi'] ?? 0;

        return [
            'doanhthu' => $doanhthu,
            'chiphi' => $chiphi,
            'lai_lo' => $doanhthu - $chiphi
        ];
    }
}
