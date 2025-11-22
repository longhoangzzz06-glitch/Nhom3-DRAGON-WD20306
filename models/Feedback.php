<?php

class Feedback {
    private $db;
    private $table = 'feedbacks';

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $sql = "SELECT f.*, t.tour_name, s.name as supplier_name
                FROM {$this->table} f
                LEFT JOIN tours t ON f.tour_id = t.id
                LEFT JOIN suppliers s ON f.supplier_id = s.id
                ORDER BY f.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO {$this->table} 
                (tour_id, supplier_id, customer_name, customer_phone, rating_tour, rating_service, rating_staff, comment, image)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['tour_id'] ?? null,
            $data['supplier_id'] ?? null,
            $data['customer_name'],
            $data['customer_phone'],
            $data['rating_tour'],
            $data['rating_service'],
            $data['rating_staff'],
            $data['comment'] ?? null,
            $data['image'] ?? null
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} 
                SET tour_id = ?, supplier_id = ?, customer_name = ?, customer_phone = ?, 
                    rating_tour = ?, rating_service = ?, rating_staff = ?, comment = ?, image = ? 
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['tour_id'] ?? null,
            $data['supplier_id'] ?? null,
            $data['customer_name'],
            $data['customer_phone'],
            $data['rating_tour'],
            $data['rating_service'],
            $data['rating_staff'],
            $data['comment'] ?? null,
            $data['image'] ?? null,
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}