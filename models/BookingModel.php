<?php
class Booking {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function all() {
        $sql = "SELECT b.*, t.tour_name, p.package_name
                FROM bookings b
                JOIN tours t ON b.tour_id = t.id
                JOIN tour_packages p ON b.package_id = p.id
                ORDER BY b.id DESC";

        return $this->db->query($sql)->fetchAll();
    }

    public function find($id) {
        $sql = "SELECT * FROM bookings WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO bookings (tour_id, package_id, customer_name, phone, email, total_price)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['tour_id'],
            $data['package_id'],
            $data['customer_name'],
            $data['phone'],
            $data['email'],
            $data['total_price']
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE bookings
                SET tour_id = ?, package_id = ?, customer_name = ?, phone = ?, email = ?, total_price = ?
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['tour_id'],
            $data['package_id'],
            $data['customer_name'],
            $data['phone'],
            $data['email'],
            $data['total_price'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM bookings WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
