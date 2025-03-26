<?php
require_once ROOT_PATH . '/config/db.php';
require_once ROOT_PATH . '/models/SinhVien.php';

class SinhVienController {
    private $db;
    private $sinhvien;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->sinhvien = new SinhVien($this->db);
    }

    public function index() {
        $stmt = $this->sinhvien->read();
        include ROOT_PATH . '/views/sinhvien/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->sinhvien->MaSV = $_POST['MaSV'];
            $this->sinhvien->HoTen = $_POST['HoTen'];
            $this->sinhvien->NgaySinh = $_POST['NgaySinh'];
            $this->sinhvien->GioiTinh = $_POST['GioiTinh'];
            $this->sinhvien->MaNganh = $_POST['MaNganh']; // Changed from Lop to MaNganh
            
            // Handle image upload
            $this->sinhvien->Hinh = '';
            if(isset($_FILES['Hinh']) && $_FILES['Hinh']['error'] == 0) {
                $target_dir = ROOT_PATH . "/Content/images/";
                
                // Create directory if it doesn't exist
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                // Generate unique filename
                $file_extension = pathinfo($_FILES["Hinh"]["name"], PATHINFO_EXTENSION);
                $filename = $this->sinhvien->MaSV . '_' . time() . '.' . $file_extension;
                $target_file = $target_dir . $filename;
                
                if(move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file)) {
                    $this->sinhvien->Hinh = $filename;
                }
            }

            if ($this->sinhvien->create()) {
                header('Location: index.php?controller=sinhvien&action=index');
                exit();
            }
        }
        include ROOT_PATH . '/views/sinhvien/create.php';
    }

    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->sinhvien->MaSV = $_POST['MaSV'];
            $this->sinhvien->HoTen = $_POST['HoTen'];
            $this->sinhvien->NgaySinh = $_POST['NgaySinh'];
            $this->sinhvien->GioiTinh = $_POST['GioiTinh'];
            $this->sinhvien->MaNganh = $_POST['MaNganh']; // Changed from Lop to MaNganh
            
            // Get current student data to retrieve existing image
            $currentData = $this->sinhvien->readOne();
            $this->sinhvien->Hinh = $currentData['Hinh']; // Keep existing image by default
            
            // Handle image upload if new image is provided
            if(isset($_FILES['Hinh']) && $_FILES['Hinh']['error'] == 0) {
                $target_dir = ROOT_PATH . "/Content/images/";
                
                // Create directory if it doesn't exist
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                // Delete old image if exists
                if(!empty($currentData['Hinh'])) {
                    $old_file = $target_dir . $currentData['Hinh'];
                    if(file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
                
                // Generate unique filename
                $file_extension = pathinfo($_FILES["Hinh"]["name"], PATHINFO_EXTENSION);
                $filename = $this->sinhvien->MaSV . '_' . time() . '.' . $file_extension;
                $target_file = $target_dir . $filename;
                
                if(move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file)) {
                    $this->sinhvien->Hinh = $filename;
                }
            }

            if ($this->sinhvien->update()) {
                header('Location: index.php?controller=sinhvien&action=index');
                exit();
            }
        } else {
            $this->sinhvien->MaSV = $_GET['id'];
            $sinhvien = $this->sinhvien->readOne();
            include ROOT_PATH . '/views/sinhvien/edit.php';
        }
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $this->sinhvien->MaSV = $_GET['id'];
            if ($this->sinhvien->delete()) {
                header('Location: index.php?controller=sinhvien&action=index');
                exit();
            }
        }
    }

    public function detail() {
        if (isset($_GET['id'])) {
            $this->sinhvien->MaSV = $_GET['id'];
            $sinhvien = $this->sinhvien->readOne();
            include ROOT_PATH . '/views/sinhvien/detail.php';
        } else {
            header('Location: index.php?controller=sinhvien&action=index');
            exit();
        }
    }
}
?>