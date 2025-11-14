<?php 
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
class HDVModel 
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy dữ liệu tất cả hướng dẫn viên
    public function getAllHDV()
    {
        $sql = "SELECT * FROM guides";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $hdvList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $hdvList;
    }

    // Lấy dữ liệu hướng dẫn viên theo ID
    public function getHDVById($id)
    {
        $sql = "SELECT * FROM guides WHERE guide_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $hdv = $stmt->fetch(PDO::FETCH_ASSOC);
        return $hdv;
    }

    // Thêm hướng dẫn viên mới
    public function addHDV($data)
    {
        $sql = "INSERT INTO guides (
                    full_name, birth_date, photo, phone, email, 
                    languages, experience_years, 
                    health_status, status
                ) VALUES (
                    :full_name, :birth_date, :photo, :phone, :email,
                    :languages, :experience_years,
                    :health_status, :status
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'full_name'        => $data['full_name'] ?? '',
            'birth_date'       => $data['birth_date'] ?? null,
            'photo'            => $data['photo'] ?? '',
            'phone'            => $data['phone'] ?? '',
            'email'            => $data['email'] ?? '',
            'languages'        => $data['languages'] ?? '',
            'experience_years' => $data['experience_years'] ?? 0,
            'health_status'    => $data['health_status'] ?? '',
            'status'           => $data['status'] ?? 'Đang hoạt động',
        ]);
    }
    
    // Lấy ảnh theo ID để xóa file
    public function getPhotoById($id)
    {
        $sql = "SELECT photo FROM guides WHERE guide_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['photo'] : null;
    }

    // Xóa hướng dẫn viên theo ID
    public function deleteHDV($id)
    {
        $photo = $this->getPhotoById($id);
        if ($photo) {
            $photoPath = 'uploads/img_HDV/' . $photo;
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }
        $sql = "DELETE FROM guides WHERE guide_id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Cập nhật thông tin hướng dẫn viên
    public function updateHDV($id, $data)
    {
        $sql = "UPDATE guides SET 
                    full_name = :full_name, 
                    birth_date = :birth_date, 
                    photo = :photo, 
                    phone = :phone, 
                    email = :email, 
                    languages = :languages, 
                    experience_years = :experience_years, 
                    health_status = :health_status, 
                    status = :status 
                WHERE guide_id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'full_name'        => $data['full_name'] ?? '',
            'birth_date'       => $data['birth_date'] ?? null,
            'photo'            => $data['photo'] ?? '',
            'phone'            => $data['phone'] ?? '',
            'email'            => $data['email'] ?? '',
            'languages'        => $data['languages'] ?? '',
            'experience_years' => $data['experience_years'] ?? 0,
            'health_status'    => $data['health_status'] ?? '',
            'status'           => $data['status'] ?? 'Đang hoạt động',
            'id'               => $id,
        ]);
    }
}
