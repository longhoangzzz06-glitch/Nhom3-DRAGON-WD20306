<?php

class HdvAuthModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Đăng ký HDV
    public function register($name, $email, $password)
    {
        $sql = "INSERT INTO huong_dan_vien (name, email, password)
                VALUES (:name, :email, :password)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ":name" => $name,
            ":email" => $email,
            ":password" => password_hash($password, PASSWORD_BCRYPT)
        ]);

        return $this->conn->lastInsertId();
    }

    // Tìm HDV theo email
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM huong_dan_vien WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":email" => $email]);

        return $stmt->fetch();
    }
}
