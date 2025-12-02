<?php 
// Model xử lý yêu cầu đặc biệt của khách hàng
class RequirementModel 
{
    public $conn;
    
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy danh sách yêu cầu đặc biệt theo tour
    public function getRequirementsByTour($tourId, $loai = null, $doUuTien = null)
    {
        $sql = "SELECT 
                    yc.*,
                    kh.ten as khachHang_ten,
                    kh.tuoi,
                    kh.gioiTinh,
                    kh.dienThoai,
                    hdv.hoTen as nguoiTao_ten
                FROM yeu_cau_dac_biet yc
                INNER JOIN khach_hang kh ON yc.khachHang_id = kh.id
                LEFT JOIN hdv ON yc.nguoiTao_id = hdv.id
                WHERE yc.tour_id = :tour_id";
        
        if ($loai) {
            $sql .= " AND yc.loaiYeuCau = :loai";
        }
        
        if ($doUuTien) {
            $sql .= " AND yc.doUuTien = :doUuTien";
        }
        
        $sql .= " ORDER BY 
                    FIELD(yc.doUuTien, 'critical', 'urgent', 'normal'),
                    yc.ngayTao DESC";
        
        $stmt = $this->conn->prepare($sql);
        $params = ['tour_id' => $tourId];
        if ($loai) $params['loai'] = $loai;
        if ($doUuTien) $params['doUuTien'] = $doUuTien;
        
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy yêu cầu theo khách hàng
    public function getRequirementsByCustomer($tourId, $khachHangId)
    {
        $sql = "SELECT * FROM yeu_cau_dac_biet 
                WHERE tour_id = :tour_id 
                AND khachHang_id = :khachHang_id
                AND trangThai = 'active'
                ORDER BY 
                    FIELD(doUuTien, 'critical', 'urgent', 'normal'),
                    ngayTao DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'tour_id' => $tourId,
            'khachHang_id' => $khachHangId
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy khách hàng với số lượng yêu cầu
    public function getCustomersWithRequirements($tourId)
    {
        $sql = "SELECT 
                    kh.id,
                    kh.ten,
                    kh.tuoi,
                    kh.gioiTinh,
                    kh.dienThoai,
                    COUNT(yc.id) as total_requirements,
                    SUM(CASE WHEN yc.doUuTien = 'critical' THEN 1 ELSE 0 END) as critical_count,
                    SUM(CASE WHEN yc.doUuTien = 'urgent' THEN 1 ELSE 0 END) as urgent_count,
                    MAX(yc.doUuTien) as highest_priority
                FROM don_hang dh
                INNER JOIN don_hang_khach_hang dhkh ON dh.id = dhkh.donHang_id
                INNER JOIN khach_hang kh ON dhkh.khachHang_id = kh.id
                LEFT JOIN yeu_cau_dac_biet yc ON kh.id = yc.khachHang_id AND yc.tour_id = dh.tour_id AND yc.trangThai = 'active'
                WHERE dh.tour_id = :tour_id
                GROUP BY kh.id
                ORDER BY 
                    FIELD(MAX(yc.doUuTien), 'critical', 'urgent', 'normal'),
                    total_requirements DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tour_id' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm yêu cầu đặc biệt mới
    public function addRequirement($data)
    {
        $sql = "INSERT INTO yeu_cau_dac_biet 
                (tour_id, khachHang_id, loaiYeuCau, noiDung, doUuTien, trangThai, ghiChu, nguoiTao_id) 
                VALUES 
                (:tour_id, :khachHang_id, :loaiYeuCau, :noiDung, :doUuTien, :trangThai, :ghiChu, :nguoiTao_id)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'tour_id' => $data['tour_id'],
            'khachHang_id' => $data['khachHang_id'],
            'loaiYeuCau' => $data['loaiYeuCau'],
            'noiDung' => $data['noiDung'],
            'doUuTien' => $data['doUuTien'] ?? 'normal',
            'trangThai' => $data['trangThai'] ?? 'active',
            'ghiChu' => $data['ghiChu'] ?? '',
            'nguoiTao_id' => $data['nguoiTao_id'] ?? null
        ]);
    }

    // Cập nhật yêu cầu
    public function updateRequirement($id, $data)
    {
        $sql = "UPDATE yeu_cau_dac_biet 
                SET loaiYeuCau = :loaiYeuCau,
                    noiDung = :noiDung,
                    doUuTien = :doUuTien,
                    trangThai = :trangThai,
                    ghiChu = :ghiChu
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'loaiYeuCau' => $data['loaiYeuCau'],
            'noiDung' => $data['noiDung'],
            'doUuTien' => $data['doUuTien'],
            'trangThai' => $data['trangThai'],
            'ghiChu' => $data['ghiChu'] ?? '',
            'id' => $id
        ]);
    }

    // Xóa yêu cầu (soft delete - chuyển sang cancelled)
    public function deleteRequirement($id)
    {
        $sql = "UPDATE yeu_cau_dac_biet 
                SET trangThai = 'cancelled' 
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Xóa vĩnh viễn (hard delete)
    public function hardDeleteRequirement($id)
    {
        $sql = "DELETE FROM yeu_cau_dac_biet WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Lấy thống kê yêu cầu theo loại
    public function getRequirementStats($tourId)
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN doUuTien = 'critical' THEN 1 ELSE 0 END) as critical,
                    SUM(CASE WHEN doUuTien = 'urgent' THEN 1 ELSE 0 END) as urgent,
                    SUM(CASE WHEN loaiYeuCau = 'food' THEN 1 ELSE 0 END) as food,
                    SUM(CASE WHEN loaiYeuCau = 'medical' THEN 1 ELSE 0 END) as medical,
                    SUM(CASE WHEN loaiYeuCau = 'mobility' THEN 1 ELSE 0 END) as mobility,
                    SUM(CASE WHEN loaiYeuCau = 'other' THEN 1 ELSE 0 END) as other,
                    COUNT(DISTINCT khachHang_id) as total_customers
                FROM yeu_cau_dac_biet
                WHERE tour_id = :tour_id 
                AND trangThai = 'active'";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tour_id' => $tourId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Đánh dấu yêu cầu đã xử lý
    public function resolveRequirement($id, $ghiChu = '')
    {
        $sql = "UPDATE yeu_cau_dac_biet 
                SET trangThai = 'resolved',
                    ghiChu = :ghiChu
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'ghiChu' => $ghiChu,
            'id' => $id
        ]);
    }

    // Lấy chi tiết yêu cầu theo ID
    public function getRequirementById($id)
    {
        $sql = "SELECT 
                    yc.*,
                    kh.ten as khachHang_ten,
                    kh.dienThoai,
                    hdv.hoTen as nguoiTao_ten
                FROM yeu_cau_dac_biet yc
                INNER JOIN khach_hang kh ON yc.khachHang_id = kh.id
                LEFT JOIN hdv ON yc.nguoiTao_id = hdv.id
                WHERE yc.id = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
