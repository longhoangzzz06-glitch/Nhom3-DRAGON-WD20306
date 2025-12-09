<?php
class NccTourModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // Lấy danh sách NCC theo tour_id
    public function getNccByTourId($tour_id) {
        $sql = "SELECT ncc_id FROM ncc_tour WHERE tour_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Thêm NCC mới cho tour
    public function addNccToTour($tour_id, $ncc_id) {
        $sql = "INSERT INTO ncc_tour (tour_id, ncc_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$tour_id, $ncc_id]);
    }

    // Xóa một NCC khỏi tour
    public function deleteOne($tour_id, $ncc_id) {
    $sql = "DELETE FROM ncc_tour WHERE tour_id = ? AND ncc_id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$tour_id, $ncc_id]);
    }

    // Lấy thông tin đầy đủ của NCC theo tour_id
    public function getFullNccByTourId($tour_id) {
        $sql = "SELECT n.id, n.ten, n.dvCungCap 
                FROM ncc_tour nt
                JOIN ncc n ON nt.ncc_id = n.id
                WHERE nt.tour_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
