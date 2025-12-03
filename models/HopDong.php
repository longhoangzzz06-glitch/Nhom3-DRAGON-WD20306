<?php
class HopDong
{
    private $db;
    private $bang = "hop_dong";

    public function __construct()
    {
        $this->db = connectDB();
    }

    public function layTatCa()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->bang} ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function them($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->bang} (nha_cung_cap_id, tour_id, file_hop_dong, gia, ghi_chu)
            VALUES (:nha_cung_cap_id, :tour_id, :file_hop_dong, :gia, :ghi_chu)
        ");
        return $stmt->execute($data);
    }
}
