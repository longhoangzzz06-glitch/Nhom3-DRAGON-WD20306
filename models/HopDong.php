<?php
require_once './commons/env.php'; // file chứa hàm connectDB()

class HopDong
{
    private $db;
    private $bang = "hop_dong";

    public function __construct()
    {
        $this->db = connectDB();
    }

    /**
     * Lấy tất cả hợp đồng
     */
    public function layTatCa()
    {
        $sql = "
            SELECT 
                hd.*,
                ncc.ten AS ten_nha_cung_cap,
                t.ten AS ten_tour
            FROM hop_dong hd
            JOIN nha_cung_cap ncc ON ncc.id = hd.nha_cung_cap_id
            JOIN tour t ON t.id = hd.tour_id
            ORDER BY hd.id DESC
        ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function layMot($id)
{
    $sql = "
        SELECT 
            hd.*,
            ncc.ten AS ten_nha_cung_cap,
            t.ten AS ten_tour
        FROM hop_dong hd
        JOIN nha_cung_cap ncc ON ncc.id = hd.nha_cung_cap_id
        JOIN tour t ON t.id = hd.tour_id
        WHERE hd.id = :id
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    /**
     * Thêm hợp đồng mới
     */
    public function them($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->bang} 
                (nha_cung_cap_id, tour_id, file_hop_dong, gia, ghi_chu) 
            VALUES 
                (:nha_cung_cap_id, :tour_id, :file_hop_dong, :gia, :ghi_chu)
        ");

        // Ép kiểu dữ liệu để tránh lỗi SQL
        $data['nha_cung_cap_id'] = (int)$data['nha_cung_cap_id'];
        $data['tour_id'] = (int)$data['tour_id'];
        $data['gia'] = (float)$data['gia'];

        return $stmt->execute($data);
    }

    /**
     * Cập nhật hợp đồng theo ID
     */
    public function capNhat($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->bang} SET
                nha_cung_cap_id = :nha_cung_cap_id,
                tour_id = :tour_id,
                file_hop_dong = :file_hop_dong,
                gia = :gia,
                ghi_chu = :ghi_chu
            WHERE id = :id
        ");

        // Ép kiểu dữ liệu
        $data['nha_cung_cap_id'] = (int)$data['nha_cung_cap_id'];
        $data['tour_id'] = (int)$data['tour_id'];
        $data['gia'] = (float)$data['gia'];
        $data['id'] = $id;

        return $stmt->execute($data);
    }

    /**
     * Xóa hợp đồng theo ID
     */
    public function xoa($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->bang} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
