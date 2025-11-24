<?php
class BookingCustomer {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function allByBooking($booking_id) {
        $stmt = $this->db->prepare("
            SELECT * FROM tour_customers
            WHERE booking_id = ?
            ORDER BY id DESC
        ");
        $stmt->execute([$booking_id]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO tour_customers (booking_id, customer_name, passport)
                VALUES (?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['booking_id'],
            $data['customer_name'],
            $data['passport']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM tour_customers WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
