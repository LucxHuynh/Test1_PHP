<?php
require_once ROOT_PATH . '/config/db.php';
require_once ROOT_PATH . '/models/SinhVien.php';

class AuthController {
    private $db;
    private $sinhvien;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->sinhvien = new SinhVien($this->db);
    }

    public function login() {
        // Nếu đã đăng nhập, chuyển hướng đến trang đăng ký học phần
        if (isset($_SESSION['MaSV'])) {
            header('Location: index.php?controller=hocphan&action=dangky');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kiểm tra nếu mã sinh viên trống
            if (empty($_POST['MaSV'])) {
                $error = "Vui lòng nhập mã sinh viên!";
                include ROOT_PATH . '/views/auth/login.php';
                return;
            }

            $this->sinhvien->MaSV = $_POST['MaSV'];
            $sinhvien = $this->sinhvien->readOne();

            if ($sinhvien) {
                // Tạo session với mã SV và tên SV
                $_SESSION['MaSV'] = $this->sinhvien->MaSV;
                $_SESSION['HoTen'] = $sinhvien['HoTen'];
                
                // Log đăng nhập thành công
                $ip = $_SERVER['REMOTE_ADDR'];
                $userAgent = $_SERVER['HTTP_USER_AGENT'];
                error_log("Đăng nhập thành công: Mã SV: " . $_SESSION['MaSV'] . ", IP: " . $ip . ", User-Agent: " . $userAgent);
                
                // Chuyển hướng đến trang đăng ký học phần
                header('Location: index.php?controller=hocphan&action=dangky');
                exit();
            } else {
                $error = "Mã sinh viên không hợp lệ!";
                include ROOT_PATH . '/views/auth/login.php';
            }
        } else {
            include ROOT_PATH . '/views/auth/login.php';
        }
    }

    public function logout() {
        // Lưu mã SV trước khi hủy session để log
        $maSV = isset($_SESSION['MaSV']) ? $_SESSION['MaSV'] : 'unknown';
        
        // Hủy session
        session_unset();
        session_destroy();
        
        // Log đăng xuất
        error_log("Đăng xuất: Mã SV: " . $maSV);
        
        // Chuyển hướng về trang đăng nhập
        header('Location: index.php?controller=auth&action=login');
        exit();
    }
    
    // Phương thức kiểm tra quyền truy cập
    public function checkAuth() {
        if (!isset($_SESSION['MaSV'])) {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }
        return true;
    }
}
?> 