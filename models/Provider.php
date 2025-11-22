<?php
class Provider  {

    protected $table = "providers";
    private $db;

    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO {$this->table}(name, type, address, contact_person, phone, email, description, capacity)
                VALUES(?,?,?,?,?,?,?,?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['name'] ?? null,
            $data['type'] ?? null,
            $data['address'] ?? null,
            $data['contact_person'] ?? null,
            $data['phone'] ?? null,
            $data['email'] ?? null,
            $data['description'] ?? null,
            $data['capacity'] ?? null
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET 
                name=?, type=?, address=?, contact_person=?, phone=?, email=?, description=?, capacity=?
                WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['name'] ?? null,
            $data['type'] ?? null,
            $data['address'] ?? null,
            $data['contact_person'] ?? null,
            $data['phone'] ?? null,
            $data['email'] ?? null,
            $data['description'] ?? null,
            $data['capacity'] ?? null,
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}