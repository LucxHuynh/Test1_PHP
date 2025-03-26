<?php
class SinhVien {
    private $conn;
    private $table_name = "SinhVien";

    public $MaSV;
    public $HoTen;
    public $NgaySinh;
    public $GioiTinh;
    public $MaNganh; // Changed from Lop to MaNganh
    public $Hinh;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (MaSV, HoTen, NgaySinh, GioiTinh, MaNganh, Hinh) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bind_param("ssssss", $this->MaSV, $this->HoTen, $this->NgaySinh, $this->GioiTinh, $this->MaNganh, $this->Hinh);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->MaSV);
        $stmt->execute();
        $row = $stmt->get_result();
        return $row->fetch_assoc();
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET HoTen = ?, NgaySinh = ?, GioiTinh = ?, MaNganh = ?, Hinh = ? WHERE MaSV = ?";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bind_param("ssssss", $this->HoTen, $this->NgaySinh, $this->GioiTinh, $this->MaNganh, $this->Hinh, $this->MaSV);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->MaSV);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>