<?php
require_once './commons/env.php';

class DiaDiemModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllDiaDiem()
    {
        $sql = "SELECT dd.*, t.ten as ten_tour 
                FROM dia_diem dd 
                LEFT JOIN tour t ON dd.tour_id = t.id 
                ORDER BY dd.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDiaDiemById($id)
    {
        $sql = "SELECT * FROM dia_diem WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertDiaDiem($data)
    {
        $sql = "INSERT INTO dia_diem (ten, tgDi, tgVe, loai, moTa, tour_id, thuTu, trangThai) 
                VALUES (:ten, :tgDi, :tgVe, :loai, :moTa, :tour_id, :thuTu, :trangThai)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'ten' => $data['ten'],
            'tgDi' => $data['tgDi'],
            'tgVe' => $data['tgVe'],
            'loai' => $data['loai'] ?? 'destination',
            'moTa' => $data['moTa'] ?? '',
            'tour_id' => !empty($data['tour_id']) ? $data['tour_id'] : null,
            'thuTu' => $data['thuTu'] ?? 1,
            'trangThai' => $data['trangThai'] ?? 'pending'
        ]);
    }

    public function updateDiaDiem($id, $data)
    {
        $sql = "UPDATE dia_diem 
                SET ten = :ten, 
                    tgDi = :tgDi, 
                    tgVe = :tgVe, 
                    loai = :loai, 
                    moTa = :moTa, 
                    tour_id = :tour_id, 
                    thuTu = :thuTu, 
                    trangThai = :trangThai 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'ten' => $data['ten'],
            'tgDi' => $data['tgDi'],
            'tgVe' => $data['tgVe'],
            'loai' => $data['loai'] ?? 'destination',
            'moTa' => $data['moTa'] ?? '',
            'tour_id' => !empty($data['tour_id']) ? $data['tour_id'] : null,
            'thuTu' => $data['thuTu'] ?? 1,
            'trangThai' => $data['trangThai'] ?? 'pending'
        ]);
    }

    public function updateOrder($id, $thuTu)
    {
        $sql = "UPDATE dia_diem SET thuTu = :thuTu WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id, 'thuTu' => $thuTu]);
    }

    public function deleteDiaDiem($id)
    {
        $sql = "DELETE FROM dia_diem WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    public function getAllTours() {
        $sql = "SELECT id, ten FROM tour ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMaxThuTu($tourId, $loai)
    {
        $sql = "SELECT MAX(thuTu) as max_thuTu FROM dia_diem WHERE tour_id = :tour_id AND loai = :loai";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tour_id' => $tourId, 'loai' => $loai]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['max_thuTu'] ? $result['max_thuTu'] : 0;
    }
}
