<?php
class TourPackage {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function allByTour($tour_id) {
        $stmt = $this->db->prepare("SELECT * FROM tour_packages WHERE tour_id = ?");
        $stmt->execute([$tour_id]);
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM tour_packages WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO tour_packages (tour_id, package_name, price, description)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['tour_id'],
            $data['package_name'],
            $data['price'],
            $data['description']
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE tour_packages
                SET package_name = ?, price = ?, description = ?
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['package_name'],
            $data['price'],
            $data['description'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM tour_packages WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
