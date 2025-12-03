<?php
class GuideModel {
    private $db;

    public function __construct() {
        $this->db = connectDB();
    }

    // Tạo HDV + tài khoản tự động
    public function taoHDVVaTaiKhoan($data) {

        // Tạo mật khẩu ngẫu nhiên
        $matKhauTam = substr(str_shuffle("abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);

        // Mã hoá mật khẩu
        $matKhauMaHoa = password_hash($matKhauTam, PASSWORD_DEFAULT);

        // 1. Thêm user
        $sqlUser = "INSERT INTO users (username, password, role)
                    VALUES (:username, :password, 'guide')";
        $stmtUser = $this->db->prepare($sqlUser);
        $stmtUser->execute([
            'username' => $data['email'],
            'password' => $matKhauMaHoa
        ]);

        $userId = $this->db->lastInsertId();

        // 2. Thêm vào bảng guides
        $sqlGuide = "INSERT INTO guides (name, email, phone, user_id)
                     VALUES (:name, :email, :phone, :user_id)";
        $stmtGuide = $this->db->prepare($sqlGuide);
        $stmtGuide->execute([
            'name'    => $data['name'],
            'email'   => $data['email'],
            'phone'   => $data['phone'],
            'user_id' => $userId
        ]);

        return $matKhauTam; // Trả về mật khẩu tạm
    }

    // Reset mật khẩu HDV
    public function resetMatKhau($userId) {

        $matKhauMoi = substr(str_shuffle("abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ0123456789"), 0, 8);
        $matKhauMaHoa = password_hash($matKhauMoi, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'password' => $matKhauMaHoa,
            'id'       => $userId
        ]);

        return $matKhauMoi;
    }
}
