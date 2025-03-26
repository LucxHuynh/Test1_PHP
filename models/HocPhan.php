<?php
class HocPhan {
    private $conn;
    private $table_name = "HocPhan";
    private $dangky_table = "dangky";
    private $chitiet_table = "chitietdangky"; // Cập nhật tên bảng

    public $MaHP;
    public $TenHP;
    public $SoTC;
    public $SoLuongDuKien;
    public $MaSV;
    public $NgayDK;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Thêm hàm để lấy thông tin chi tiết của 1 học phần
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE MaHP = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->MaHP);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function themVaoGioHang() {
        // Initialize the session array if it doesn't exist
        if (!isset($_SESSION['hocphan'])) {
            $_SESSION['hocphan'] = array();
        }
        
        // Check if course already exists in the cart
        if (!in_array($this->MaHP, $_SESSION['hocphan'])) {
            // Check if course is available
            $query = "SELECT SoLuongDuKien FROM " . $this->table_name . " WHERE MaHP = ? AND SoLuongDuKien > 0";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $this->MaHP);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Add to session cart
                $_SESSION['hocphan'][] = $this->MaHP;
                return true;
            } else {
                // Course not available
                return false;
            }
        }
        // Course already in cart
        return false;
    }

    public function xoaKhoiGioHang() {
        if (isset($_SESSION['hocphan'])) {
            if (($key = array_search($this->MaHP, $_SESSION['hocphan'])) !== false) {
                unset($_SESSION['hocphan'][$key]);
                // Sắp xếp lại mảng sau khi xóa
                $_SESSION['hocphan'] = array_values($_SESSION['hocphan']);
                return true;
            }
        }
        return false;
    }

    public function luuChiTietDangKy() {
        if (!isset($_SESSION['hocphan']) || count($_SESSION['hocphan']) == 0) {
            return false;
        }

        $this->conn->begin_transaction();
        
        try {
            // Thêm vào bảng DangKy
            $query = "INSERT INTO " . $this->dangky_table . " (NgayDK, MaSV) VALUES (?, ?)";
            $stmt = $this->conn->prepare($query);
            $this->NgayDK = date('Y-m-d');
            $stmt->bind_param("ss", $this->NgayDK, $this->MaSV);
            $stmt->execute();
            
            $MaDK = $this->conn->insert_id;
            
            // Thêm từng học phần vào ChiTietDangKy
            foreach ($_SESSION['hocphan'] as $MaHP) {
                $query = "INSERT INTO " . $this->chitiet_table . " (MaDK, MaHP) VALUES (?, ?)";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param("is", $MaDK, $MaHP);
                $stmt->execute();
                
                // Cập nhật số lượng dự kiến
                $query = "UPDATE " . $this->table_name . " 
                         SET SoLuongDuKien = SoLuongDuKien - 1 
                         WHERE MaHP = ? AND SoLuongDuKien > 0";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param("s", $MaHP);
                $stmt->execute();
            }
            
            $this->conn->commit();
            unset($_SESSION['hocphan']);
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function getDangKyBySV() {
        $query = "SELECT hp.*, dk.NgayDK FROM " . $this->table_name . " hp 
                 INNER JOIN " . $this->chitiet_table . " ctdk ON hp.MaHP = ctdk.MaHP 
                 INNER JOIN " . $this->dangky_table . " dk ON ctdk.MaDK = dk.MaDK 
                 WHERE dk.MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->MaSV);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getGioHang() {
        if (!isset($_SESSION['hocphan']) || empty($_SESSION['hocphan'])) {
            // Create an empty result set
            $query = "SELECT * FROM " . $this->table_name . " WHERE 1=0";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->get_result();
        }
        
        $placeholders = str_repeat('?,', count($_SESSION['hocphan']) - 1) . '?';
        $query = "SELECT * FROM " . $this->table_name . " WHERE MaHP IN (" . $placeholders . ")";
        $stmt = $this->conn->prepare($query);
        
        $types = str_repeat('s', count($_SESSION['hocphan']));
        $stmt->bind_param($types, ...$_SESSION['hocphan']);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Kiểm tra xem sinh viên đã đăng ký học phần chưa
    public function ktraHocPhanDaDangKy($MaHP, $MaSV) {
        $query = "SELECT hp.* FROM " . $this->table_name . " hp 
                 INNER JOIN " . $this->chitiet_table . " ctdk ON hp.MaHP = ctdk.MaHP 
                 INNER JOIN " . $this->dangky_table . " dk ON ctdk.MaDK = dk.MaDK 
                 WHERE dk.MaSV = ? AND hp.MaHP = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $MaSV, $MaHP);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}
?>