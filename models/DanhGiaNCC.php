<?php
require_once './commons/env.php';

class DanhGiaNCC
{
    private $db;
    private $bang = "danh_gia_ncc";

    public function __construct()
    {
        $this->db = connectDB();
    }

    public function layTatCa()
{
    $sql = "
        SELECT dg.*,
               ncc.ten AS ten_ncc,
               t.ten AS ten_tour
        FROM danh_gia_ncc dg
        JOIN nha_cung_cap ncc ON ncc.id = dg.nha_cung_cap_id
        JOIN tour t ON t.id = dg.tour_id
        ORDER BY dg.id DESC
    ";

    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function tim($id)
{
    $sql = "
        SELECT dg.*,
               ncc.ten AS ten_ncc,
               t.ten AS ten_tour
        FROM danh_gia_ncc dg
        JOIN nha_cung_cap ncc ON ncc.id = dg.nha_cung_cap_id
        JOIN tour t ON t.id = dg.tour_id
        WHERE dg.id = :id
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id'=>$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    public function them($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->bang} (nha_cung_cap_id, tour_id, diem, binh_luan, ngay_danh_gia)
            VALUES (:nha_cung_cap_id, :tour_id, :diem, :binh_luan, :ngay_danh_gia)
        ");
        return $stmt->execute($data);
    }

    public function capNhat($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->bang} SET
                nha_cung_cap_id=:nha_cung_cap_id,
                tour_id=:tour_id,
                diem=:diem,
                binh_luan=:binh_luan,
                ngay_danh_gia=:ngay_danh_gia
            WHERE id=:id
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
