<?php
class Tour {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function all() {
        $sql = "SELECT * FROM tours ORDER BY id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM tours WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO tours (tour_name, start_date, end_date, base_price, description)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['tour_name'],
            $data['start_date'],
            $data['end_date'],
            $data['base_price'],
            $data['description']
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE tours
                SET tour_name = ?, start_date = ?, end_date = ?, base_price = ?, description = ?
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['tour_name'],
            $data['start_date'],
            $data['end_date'],
            $data['base_price'],
            $data['description'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM tours WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
