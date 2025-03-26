<?php
// db.php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "test1";
    public $conn;
    private static $instance = null;

    // Sử dụng Singleton pattern
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            $this->conn->set_charset("utf8");
            
            if ($this->conn->connect_error) {
                $this->logError("Lỗi kết nối cơ sở dữ liệu: " . $this->conn->connect_error);
                throw new Exception("Lỗi kết nối: " . $this->conn->connect_error);
            }
            
            // Ghi log thành công
            $this->logInfo("Kết nối cơ sở dữ liệu thành công từ: " . $_SERVER['REMOTE_ADDR']);
        } catch(Exception $e) {
            $this->logError("Lỗi kết nối: " . $e->getMessage());
            echo "Lỗi kết nối: " . $e->getMessage();
        }
        return $this->conn;
    }
    
    // Phương thức ghi log lỗi
    private function logError($message) {
        error_log("[ERROR] " . date('Y-m-d H:i:s') . " - " . $message);
    }
    
    // Phương thức ghi log thông tin
    private function logInfo($message) {
        error_log("[INFO] " . date('Y-m-d H:i:s') . " - " . $message);
    }
    
    // Tạo cấu trúc bảng nếu chưa tồn tại
    public function createTablesIfNotExist() {
        try {
            $conn = $this->getConnection();
            
            // Tạo bảng SinhVien nếu chưa tồn tại
            $sqlSinhVien = "CREATE TABLE IF NOT EXISTS SinhVien (
                MaSV VARCHAR(10) PRIMARY KEY,
                HoTen VARCHAR(100) NOT NULL,
                NgaySinh DATE,
                GioiTinh VARCHAR(10),
                MaNganh VARCHAR(10),
                Hinh VARCHAR(255)
            )";
            
            // Tạo bảng HocPhan nếu chưa tồn tại
            $sqlHocPhan = "CREATE TABLE IF NOT EXISTS HocPhan (
                MaHP VARCHAR(10) PRIMARY KEY,
                TenHP VARCHAR(100) NOT NULL,
                SoTC INT,
                SoLuongDuKien INT DEFAULT 10
            )";
            
            // Tạo bảng DangKy nếu chưa tồn tại
            $sqlDangKy = "CREATE TABLE IF NOT EXISTS dangky (
                MaDK INT AUTO_INCREMENT PRIMARY KEY,
                NgayDK DATE,
                MaSV VARCHAR(10),
                FOREIGN KEY (MaSV) REFERENCES SinhVien(MaSV)
            )";
            
            // Tạo bảng ChiTietDangKy nếu chưa tồn tại
            $sqlChiTietDangKy = "CREATE TABLE IF NOT EXISTS chitietdangky (
                MaCTDK INT AUTO_INCREMENT PRIMARY KEY,
                MaDK INT,
                MaHP VARCHAR(10),
                FOREIGN KEY (MaDK) REFERENCES dangky(MaDK),
                FOREIGN KEY (MaHP) REFERENCES HocPhan(MaHP)
            )";
            
            $conn->query($sqlSinhVien);
            $conn->query($sqlHocPhan);
            $conn->query($sqlDangKy);
            $conn->query($sqlChiTietDangKy);
            
            return true;
        } catch(Exception $e) {
            $this->logError("Lỗi tạo bảng: " . $e->getMessage());
            return false;
        }
    }
}
?>
