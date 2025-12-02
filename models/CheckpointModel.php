<?php 
// Model xử lý điểm danh khách hàng tại các checkpoint
class CheckpointModel 
{
    public $conn;
    
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy danh sách checkpoint theo tour_id
    public function getCheckpointsByTour($tourId)
    {
        // TEMPORARY: Check if migration columns exist
        try {
            $checkCol = $this->conn->query("SHOW COLUMNS FROM dia_diem LIKE 'tour_id'");
            $hasMigration = $checkCol->rowCount() > 0;
        } catch (Exception $e) {
            $hasMigration = false;
        }
        
        if ($hasMigration) {
            // Use migration columns
            $sql = "SELECT * FROM dia_diem 
                    WHERE tour_id = :tour_id 
                    AND loai = 'checkpoint'
                    ORDER BY thuTu ASC, tgDi ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['tour_id' => $tourId]);
        } else {
            // FALLBACK: Get all dia_diem (no tour_id filter available)
            // This returns ALL checkpoints for testing
            $sql = "SELECT id, ten, tgDi, tgVe FROM dia_diem ORDER BY tgDi ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách khách hàng của tour với trạng thái điểm danh
    public function getCustomersByTourWithCheckin($tourId, $checkpointId = null)
    {
        $sql = "SELECT 
                    kh.id as khachHang_id,
                    kh.ten as khachHang_ten,
                    kh.tuoi,
                    kh.gioiTinh,
                    kh.dienThoai,
                    dhkh.id as donHangKhachHang_id,
                    dd.trangThai as trangThai_checkin,
                    dd.diaDiem_id as diem_danh_id,
                    dd.tgDiemDanh,
                    dd.hdv_xacNhan_id,
                    yc.noiDung as ghiChuDB
                FROM don_hang dh
                INNER JOIN don_hang_khach_hang dhkh ON dh.id = dhkh.donHang_id
                INNER JOIN khach_hang kh ON dhkh.khachHang_id = kh.id
                LEFT JOIN diem_danh dd ON dhkh.id = dd.donHangKhachHang_id" 
                . ($checkpointId ? " AND dd.diaDiem_id = :checkpoint_id" : "") . "
                LEFT JOIN yeu_cau_dac_biet yc ON kh.id = yc.khachHang_id AND yc.tour_id = :tour_id AND yc.trangThai = 'active'
                WHERE dh.tour_id = :tour_id
                ORDER BY kh.ten ASC";
        
        $stmt = $this->conn->prepare($sql);
        $params = ['tour_id' => $tourId];
        if ($checkpointId) {
            $params['checkpoint_id'] = $checkpointId;
        }
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lưu trạng thái điểm danh
    public function saveCheckin($donHangKhachHangId, $checkpointId, $status, $hdvId)
    {
        // If status is null, delete the checkin record (undo)
        if ($status === null || $status === '') {
            $sql = "DELETE FROM diem_danh 
                    WHERE donHangKhachHang_id = :dhkh_id 
                    AND diaDiem_id = :dd_id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'dhkh_id' => $donHangKhachHangId,
                'dd_id' => $checkpointId
            ]);
        }
        
        // Insert or update checkin record
        $sql = "INSERT INTO diem_danh 
                (donHangKhachHang_id, diaDiem_id, trangThai, hdv_xacNhan_id, tgDiemDanh)
                VALUES (:dhkh_id, :dd_id, :status, :hdv_id, NOW())
                ON DUPLICATE KEY UPDATE 
                    trangThai = :status,
                    hdv_xacNhan_id = :hdv_id,
                    tgDiemDanh = NOW()";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'dhkh_id' => $donHangKhachHangId,
            'dd_id' => $checkpointId,
            'status' => $status,
            'hdv_id' => $hdvId
        ]);
    }

    // Lấy thống kê điểm danh theo checkpoint
    public function getCheckinStats($tourId, $checkpointId)
    {
        $sql = "SELECT 
                    COUNT(DISTINCT dhkh.id) as total,
                    SUM(CASE WHEN dd.trangThai = 'present' THEN 1 ELSE 0 END) as present,
                    SUM(CASE WHEN dd.trangThai = 'absent' THEN 1 ELSE 0 END) as absent,
                    SUM(CASE WHEN dd.trangThai IS NULL THEN 1 ELSE 0 END) as pending
                FROM don_hang dh
                INNER JOIN don_hang_khach_hang dhkh ON dh.id = dhkh.donHang_id
                LEFT JOIN diem_danh dd ON dhkh.id = dd.donHangKhachHang_id AND dd.diaDiem_id = :checkpoint_id
                WHERE dh.tour_id = :tour_id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'tour_id' => $tourId,
            'checkpoint_id' => $checkpointId
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy khách hàng có yêu cầu đặc biệt (để hiển thị cảnh báo khi điểm danh)
    public function getSpecialRequirements($tourId)
    {
        $sql = "SELECT 
                    kh.id as khachHang_id,
                    kh.ten as khachHang_ten,
                    yc.loaiYeuCau,
                    yc.noiDung,
                    yc.doUuTien
                FROM yeu_cau_dac_biet yc
                INNER JOIN khach_hang kh ON yc.khachHang_id = kh.id
                WHERE yc.tour_id = :tour_id 
                AND yc.trangThai = 'active'
                AND yc.doUuTien IN ('urgent', 'critical')
                ORDER BY 
                    FIELD(yc.doUuTien, 'critical', 'urgent'),
                    kh.ten ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tour_id' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái checkpoint
    public function updateCheckpointStatus($checkpointId, $status)
    {
        $sql = "UPDATE dia_diem 
                SET trangThai = :status 
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'status' => $status,
            'id' => $checkpointId
        ]);
    }

    // Tạo checkpoint mới
    public function createCheckpoint($data)
    {
        $sql = "INSERT INTO dia_diem 
                (ten, tgDi, tgVe, loai, moTa, tour_id, thuTu, trangThai) 
                VALUES 
                (:ten, :tgDi, :tgVe, 'checkpoint', :moTa, :tour_id, :thuTu, :trangThai)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'ten' => $data['ten'],
            'tgDi' => $data['tgDi'],
            'tgVe' => $data['tgVe'],
            'moTa' => $data['moTa'] ?? '',
            'tour_id' => $data['tour_id'],
            'thuTu' => $data['thuTu'] ?? 1,
            'trangThai' => $data['trangThai'] ?? 'pending'
        ]);
    }

    // Xóa checkpoint
    public function deleteCheckpoint($checkpointId)
    {
        // Xóa điểm danh liên quan (CASCADE sẽ tự động xóa)
        // Xóa checkpoint
        $sql = "DELETE FROM dia_diem WHERE id = :id AND loai = 'checkpoint'";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $checkpointId]);
    }
}
