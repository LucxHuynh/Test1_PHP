<?php
require_once ROOT_PATH . '/config/db.php';
require_once ROOT_PATH . '/models/HocPhan.php';

class HocPhanController {
    private $db;
    private $hocphan;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->hocphan = new HocPhan($this->db);
    }

    public function index() {
        $stmt = $this->hocphan->read();
        include ROOT_PATH . '/views/hocphan/index.php';
    }

    public function dangky() {
        if (!isset($_SESSION['MaSV'])) {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['hocphan']) && is_array($_POST['hocphan'])) {
                $success = 0;
                $error = 0;
                foreach ($_POST['hocphan'] as $MaHP) {
                    $this->hocphan->MaHP = $MaHP;
                    if ($this->hocphan->themVaoGioHang()) {
                        $success++;
                    } else {
                        $error++;
                    }
                }
                
                if ($success > 0) {
                    $message = 'Đã thêm ' . $success . ' học phần vào giỏ hàng.';
                    if ($error > 0) {
                        $message .= ' Có ' . $error . ' học phần không thể thêm (đã hết chỗ hoặc đã có trong giỏ).';
                    }
                    header('Location: index.php?controller=hocphan&action=giohang&success=' . urlencode($message));
                } else {
                    header('Location: index.php?controller=hocphan&action=dangky&error=Không thể thêm học phần vào giỏ hàng');
                }
                exit();
            } else {
                header('Location: index.php?controller=hocphan&action=dangky&error=Vui lòng chọn ít nhất một học phần');
                exit();
            }
        }
        
        // Lấy các học phần đã đăng ký để disabled
        $daDangKy = [];
        if (isset($_SESSION['MaSV'])) {
            $this->hocphan->MaSV = $_SESSION['MaSV'];
            $result = $this->hocphan->getDangKyBySV();
            while ($row = $result->fetch_assoc()) {
                $daDangKy[] = $row['MaHP'];
            }
        }
        
        $stmt = $this->hocphan->read();
        include ROOT_PATH . '/views/hocphan/dangky.php';
    }

    public function giohang() {
        if (isset($_SESSION['MaSV'])) {
            $stmt = $this->hocphan->getGioHang();
            include ROOT_PATH . '/views/hocphan/giohang.php';
        } else {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }
    }

    public function xoa() {
        if (isset($_GET['id']) && isset($_SESSION['MaSV'])) {
            $this->hocphan->MaHP = $_GET['id'];
            if ($this->hocphan->xoaKhoiGioHang()) {
                header('Location: index.php?controller=hocphan&action=giohang');
                exit();
            }
        }
        header('Location: index.php?controller=hocphan&action=giohang&error=Không thể xóa học phần');
        exit();
    }

    public function luu() {
        if (isset($_SESSION['MaSV'])) {
            $this->hocphan->MaSV = $_SESSION['MaSV'];
            if ($this->hocphan->luuChiTietDangKy()) {
                header('Location: index.php?controller=hocphan&action=hienthidangky&success=Đăng ký học phần thành công');
            } else {
                header('Location: index.php?controller=hocphan&action=giohang&error=Lỗi khi đăng ký học phần');
            }
            exit();
        }
        header('Location: index.php?controller=auth&action=login');
        exit();
    }

    // Thêm phương thức hiển thị danh sách học phần đã đăng ký
    public function hienthidangky() {
        if (!isset($_SESSION['MaSV'])) {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }
        
        $this->hocphan->MaSV = $_SESSION['MaSV'];
        $result = $this->hocphan->getDangKyBySV();
        include ROOT_PATH . '/views/hocphan/hienthidangky.php';
    }

    public function themgiohang() {
        if (!isset($_SESSION['MaSV'])) {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['hocphan']) && is_array($_POST['hocphan'])) {
                $success = false;
                $errorCount = 0;
                
                foreach ($_POST['hocphan'] as $MaHP) {
                    $this->hocphan->MaHP = $MaHP;
                    $this->hocphan->MaSV = $_SESSION['MaSV'];
                    if ($this->hocphan->themVaoGioHang()) {
                        $success = true;
                    } else {
                        $errorCount++;
                    }
                }
                
                if ($success) {
                    if ($errorCount > 0) {
                        header('Location: index.php?controller=hocphan&action=giohang&success=Đã thêm học phần vào giỏ hàng&warning=Một số học phần không được thêm vào giỏ hàng');
                    } else {
                        header('Location: index.php?controller=hocphan&action=giohang&success=Đã thêm học phần vào giỏ hàng');
                    }
                } else {
                    header('Location: index.php?controller=hocphan&action=dangky&error=Không thể thêm học phần vào giỏ hàng. Học phần có thể đã hết chỗ hoặc đã có trong giỏ hàng.');
                }
            } else {
                header('Location: index.php?controller=hocphan&action=dangky&error=Vui lòng chọn ít nhất một học phần');
            }
            exit();
        }

        header('Location: index.php?controller=hocphan&action=dangky');
        exit();
    }
}
?>