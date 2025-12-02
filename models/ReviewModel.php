<?php 
// Model xử lý nhật ký tour và đánh giá tour/NCC
class ReviewModel 
{
    public $conn;
    
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // ===================================================================
    // NHẬT KÝ TOUR (DIARY)
    // ===================================================================

    // Lấy danh sách nhật ký theo tour
    public function getDiaryEntries($tourId, $loai = null)
    {
        $sql = "SELECT 
                    nk.*,
                    hdv.hoTen as hdv_ten
                FROM nhat_ky_tour nk
                INNER JOIN hdv ON nk.hdv_id = hdv.id
                WHERE nk.tour_id = :tour_id";
        
        if ($loai) {
            $sql .= " AND nk.loai = :loai";
        }
        
        $sql .= " ORDER BY nk.ngayTao DESC";
        
        $stmt = $this->conn->prepare($sql);
        $params = ['tour_id' => $tourId];
        if ($loai) $params['loai'] = $loai;
        
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm nhật ký mới
    public function addDiary($data)
    {
        $sql = "INSERT INTO nhat_ky_tour 
                (tour_id, hdv_id, loai, tieuDe, noiDung, doUuTien, viTri, tags, anhMinhHoa) 
                VALUES 
                (:tour_id, :hdv_id, :loai, :tieuDe, :noiDung, :doUuTien, :viTri, :tags, :anhMinhHoa)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'tour_id' => $data['tour_id'],
            'hdv_id' => $data['hdv_id'],
            'loai' => $data['loai'],
            'tieuDe' => $data['tieuDe'],
            'noiDung' => $data['noiDung'],
            'doUuTien' => $data['doUuTien'] ?? 'normal',
            'viTri' => $data['viTri'] ?? '',
            'tags' => $data['tags'] ?? '',
            'anhMinhHoa' => $data['anhMinhHoa'] ?? ''
        ]);
    }

    // Cập nhật nhật ký
    public function updateDiary($id, $data)
    {
        $sql = "UPDATE nhat_ky_tour 
                SET loai = :loai,
                    tieuDe = :tieuDe,
                    noiDung = :noiDung,
                    doUuTien = :doUuTien,
                    viTri = :viTri,
                    tags = :tags,
                    anhMinhHoa = :anhMinhHoa
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'loai' => $data['loai'],
            'tieuDe' => $data['tieuDe'],
            'noiDung' => $data['noiDung'],
            'doUuTien' => $data['doUuTien'],
            'viTri' => $data['viTri'] ?? '',
            'tags' => $data['tags'] ?? '',
            'anhMinhHoa' => $data['anhMinhHoa'] ?? '',
            'id' => $id
        ]);
    }

    // Xóa nhật ký
    public function deleteDiary($id)
    {
        // Lấy thông tin ảnh để xóa file
        $diary = $this->getDiaryById($id);
        if ($diary && !empty($diary['anhMinhHoa'])) {
            $photos = explode(',', $diary['anhMinhHoa']);
            foreach ($photos as $photo) {
                $photoPath = 'uploads/tour_diary/' . trim($photo);
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }
        }
        
        $sql = "DELETE FROM nhat_ky_tour WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Lấy chi tiết nhật ký theo ID
    public function getDiaryById($id)
    {
        $sql = "SELECT 
                    nk.*,
                    hdv.hoTen as hdv_ten
                FROM nhat_ky_tour nk
                INNER JOIN hdv ON nk.hdv_id = hdv.id
                WHERE nk.id = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy thống kê nhật ký
    public function getDiaryStats($tourId)
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN loai = 'event' THEN 1 ELSE 0 END) as events,
                    SUM(CASE WHEN loai = 'activity' THEN 1 ELSE 0 END) as activities,
                    SUM(CASE WHEN loai = 'incident' THEN 1 ELSE 0 END) as incidents,
                    SUM(CASE WHEN loai = 'note' THEN 1 ELSE 0 END) as notes,
                    SUM(CASE WHEN doUuTien IN ('high', 'critical') THEN 1 ELSE 0 END) as high_priority
                FROM nhat_ky_tour
                WHERE tour_id = :tour_id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tour_id' => $tourId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ===================================================================
    // ĐÁNH GIÁ TOUR (REVIEW)
    // ===================================================================

    // Lấy danh sách đánh giá theo tour
    public function getReviewsByTour($tourId, $loai = null)
    {
        $sql = "SELECT 
                    dg.*,
                    kh.ten as khachHang_ten,
                    hdv.hoTen as hdv_ten
                FROM khach_hang_danh_gia dg
                LEFT JOIN khach_hang kh ON dg.khachHang_id = kh.id
                LEFT JOIN hdv ON dg.hdv_id = hdv.id
                WHERE dg.tour_id = :tour_id";
        
        if ($loai) {
            $sql .= " AND dg.loai = :loai";
        }
        
        $sql .= " ORDER BY dg.tgTao DESC";
        
        $stmt = $this->conn->prepare($sql);
        $params = ['tour_id' => $tourId];
        if ($loai) $params['loai'] = $loai;
        
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm đánh giá mới (HDV hoặc khách hàng)
    public function addReview($data)
    {
        $sql = "INSERT INTO khach_hang_danh_gia 
                (tour_id, khachHang_id, hdv_id, diem, danhGia_anToan, danhGia_haiLong, 
                 binhLuan, diemNoiBat, vanDe, anhMinhHoa, loai, trangThai, tgTao) 
                VALUES 
                (:tour_id, :khachHang_id, :hdv_id, :diem, :danhGia_anToan, :danhGia_haiLong,
                 :binhLuan, :diemNoiBat, :vanDe, :anhMinhHoa, :loai, :trangThai, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            'tour_id' => $data['tour_id'],
            'khachHang_id' => $data['khachHang_id'] ?? null,
            'hdv_id' => $data['hdv_id'] ?? null,
            'diem' => $data['diem'] ?? 0,
            'danhGia_anToan' => $data['danhGia_anToan'] ?? null,
            'danhGia_haiLong' => $data['danhGia_haiLong'] ?? null,
            'binhLuan' => $data['binhLuan'] ?? '',
            'diemNoiBat' => $data['diemNoiBat'] ?? '',
            'vanDe' => $data['vanDe'] ?? '',
            'anhMinhHoa' => $data['anhMinhHoa'] ?? '',
            'loai' => $data['loai'] ?? 'khach_hang',
            'trangThai' => $data['trangThai'] ?? 'draft'
        ]);
        
        return $result ? $this->conn->lastInsertId() : false;
    }

    // Cập nhật đánh giá
    public function updateReview($id, $data)
    {
        $sql = "UPDATE khach_hang_danh_gia 
                SET diem = :diem,
                    danhGia_anToan = :danhGia_anToan,
                    danhGia_haiLong = :danhGia_haiLong,
                    binhLuan = :binhLuan,
                    diemNoiBat = :diemNoiBat,
                    vanDe = :vanDe,
                    anhMinhHoa = :anhMinhHoa,
                    trangThai = :trangThai
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'diem' => $data['diem'],
            'danhGia_anToan' => $data['danhGia_anToan'],
            'danhGia_haiLong' => $data['danhGia_haiLong'],
            'binhLuan' => $data['binhLuan'],
            'diemNoiBat' => $data['diemNoiBat'],
            'vanDe' => $data['vanDe'],
            'anhMinhHoa' => $data['anhMinhHoa'] ?? '',
            'trangThai' => $data['trangThai'],
            'id' => $id
        ]);
    }

    // Lấy chi tiết đánh giá
    public function getReviewById($id)
    {
        $sql = "SELECT 
                    dg.*,
                    kh.ten as khachHang_ten,
                    hdv.hoTen as hdv_ten
                FROM khach_hang_danh_gia dg
                LEFT JOIN khach_hang kh ON dg.khachHang_id = kh.id
                LEFT JOIN hdv ON dg.hdv_id = hdv.id
                WHERE dg.id = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ===================================================================
    // ĐÁNH GIÁ NHÀ CUNG CẤP
    // ===================================================================

    // Thêm đánh giá nhà cung cấp
    public function addServiceProviderReview($danhGiaId, $data)
    {
        $sql = "INSERT INTO danh_gia_nha_cung_cap 
                (danhGia_id, loaiNCC, tenNCC, diem, nhanXet) 
                VALUES 
                (:danhGia_id, :loaiNCC, :tenNCC, :diem, :nhanXet)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'danhGia_id' => $danhGiaId,
            'loaiNCC' => $data['loaiNCC'],
            'tenNCC' => $data['tenNCC'],
            'diem' => $data['diem'],
            'nhanXet' => $data['nhanXet'] ?? ''
        ]);
    }

    // Lấy đánh giá nhà cung cấp theo danhGia_id
    public function getServiceProviderReviews($danhGiaId)
    {
        $sql = "SELECT * FROM danh_gia_nha_cung_cap 
                WHERE danhGia_id = :danhGia_id 
                ORDER BY loaiNCC ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['danhGia_id' => $danhGiaId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật đánh giá nhà cung cấp
    public function updateServiceProviderReview($id, $data)
    {
        $sql = "UPDATE danh_gia_nha_cung_cap 
                SET tenNCC = :tenNCC,
                    diem = :diem,
                    nhanXet = :nhanXet
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'tenNCC' => $data['tenNCC'],
            'diem' => $data['diem'],
            'nhanXet' => $data['nhanXet'],
            'id' => $id
        ]);
    }

    // Xóa đánh giá nhà cung cấp
    public function deleteServiceProviderReview($id)
    {
        $sql = "DELETE FROM danh_gia_nha_cung_cap WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Xóa tất cả đánh giá NCC của một đánh giá tour
    public function deleteAllServiceProviderReviews($danhGiaId)
    {
        $sql = "DELETE FROM danh_gia_nha_cung_cap WHERE danhGia_id = :danhGia_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['danhGia_id' => $danhGiaId]);
    }

    // Lấy thống kê đánh giá tour
    public function getReviewStats($tourId)
    {
        $sql = "SELECT 
                    COUNT(*) as total_reviews,
                    AVG(diem) as avg_rating,
                    AVG(danhGia_anToan) as avg_safety,
                    AVG(danhGia_haiLong) as avg_satisfaction,
                    SUM(CASE WHEN loai = 'hdv' THEN 1 ELSE 0 END) as hdv_reviews,
                    SUM(CASE WHEN loai = 'khach_hang' THEN 1 ELSE 0 END) as customer_reviews
                FROM khach_hang_danh_gia
                WHERE tour_id = :tour_id 
                AND trangThai = 'submitted'";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tour_id' => $tourId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
