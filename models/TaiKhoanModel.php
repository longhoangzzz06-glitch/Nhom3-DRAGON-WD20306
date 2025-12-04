<?php
// models/TaiKhoanModel.php
class TaiKhoanModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Update tài khoản — chỉ update password nếu có cung cấp mk
    public function updateTaiKhoan($id, $data)
    {
        // $data có thể chứa 'tenTk' và/hoặc 'mk'
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['tenTk'])) {
            $fields[] = "tenTk = :tenTk";
            $params['tenTk'] = $data['tenTk'];
        }

        if (!empty($data['mk'])) {
            $fields[] = "mk = :mk";
            $params['mk'] = password_hash($data['mk'], PASSWORD_DEFAULT);
        }

        // luôn set chucVu = 'hdv' để đảm bảo
        $fields[] = "chucVu = :chucVu";
        $params['chucVu'] = 'hdv';

        if (count($fields) === 0) {
            return false; // không có gì để update
        }

        $sql = "UPDATE tai_khoan SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    public function getTaiKhoanById($id)
    {
        $sql = "SELECT * FROM tai_khoan WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
