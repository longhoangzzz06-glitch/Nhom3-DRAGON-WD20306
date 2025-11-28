<?php
class Booking {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Lấy danh sách booking
    public function getAllDonHang() {
        $sql = "SELECT b.*, t.tour_name, p.package_name
                FROM don_hang b
                JOIN tours t ON b.tour_id = t.id
                JOIN tour_packages p ON b.package_id = p.id
                ORDER BY b.id DESC";

        return $this->db->query($sql)->fetchAll();
    }

    // Lấy dữ liệu booking theo ID
    public function getDonHangById($id) {
        $sql = "SELECT * FROM don_hang WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Thêm booking mới
    public function themDonHang($data) {
        $sql = "INSERT INTO don_hang (tour_id, package_id, customer_name, phone, email, total_price)
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

    // Cập nhật booking theo ID
    public function capNhatDonHang($id, $data) {
        $sql = "UPDATE don_hang
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

    // Xóa booking theo ID
    public function xoaDonHang($id) {
        $stmt = $this->db->prepare("DELETE FROM don_hang WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
