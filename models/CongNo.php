<?php
require_once './commons/env.php';

class CongNo
{
    private $db;
    private $bang = "cong_no";

    public function __construct()
    {
        $this->db = connectDB();
    }

    public function layTatCa()
{
    $sql = "
        SELECT cn.*,
               ncc.ten AS ten_ncc,
               t.ten AS ten_tour
        FROM cong_no cn
        JOIN nha_cung_cap ncc ON ncc.id = cn.nha_cung_cap_id
        JOIN tour t ON t.id = cn.tour_id
        ORDER BY cn.id DESC
    ";

    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function tim($id)
{
    $sql = "
        SELECT cn.*,
               ncc.ten AS ten_ncc,
               t.ten AS ten_tour
        FROM cong_no cn
        JOIN nha_cung_cap ncc ON ncc.id = cn.nha_cung_cap_id
        JOIN tour t ON t.id = cn.tour_id
        WHERE cn.id = :id
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    public function them($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->bang} (nha_cung_cap_id, tour_id, sotien, loai, ghi_chu, ngay)
            VALUES (:nha_cung_cap_id, :tour_id, :sotien, :loai, :ghi_chu, :ngay)
        ");
        return $stmt->execute($data);
    }

    public function capNhat($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->bang} SET
                nha_cung_cap_id = :nha_cung_cap_id,
                tour_id = :tour_id,
                sotien = :sotien,
                loai = :loai,
                ghi_chu = :ghi_chu,
                ngay = :ngay
            WHERE id = :id
        ");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function xoa($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->bang} WHERE id=:id");
        return $stmt->execute(['id'=>$id]);
    }
}
