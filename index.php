<?php
// Khởi động session
session_start();

// Xử lý lỗi và hiển thị chúng (chỉ mở khi cần debug)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Định nghĩa hằng số cho đường dẫn
define('ROOT_PATH', __DIR__);

// Tạo cấu trúc CSDL nếu cần
require_once ROOT_PATH . '/config/db.php';
$database = new Database();
$database->createTablesIfNotExist();

// Điều hướng mặc định
$controller = isset($_GET['controller']) ? filter_var($_GET['controller'], FILTER_SANITIZE_SPECIAL_CHARS) : 'auth';
$action = isset($_GET['action']) ? filter_var($_GET['action'], FILTER_SANITIZE_SPECIAL_CHARS) : 'login';

// Kiểm tra file controller tồn tại
$controllerFile = ROOT_PATH . '/controllers/' . ucfirst($controller) . 'Controller.php';
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    // Tạo tên class controller
    $controllerClass = ucfirst($controller) . 'Controller';
    
    // Khởi tạo controller
    $controllerInstance = new $controllerClass();
    
    // Kiểm tra method tồn tại
    if (method_exists($controllerInstance, $action)) {
        try {
            // Gọi method
            $controllerInstance->$action();
        } catch (Exception $e) {
            error_log("[ERROR] " . date('Y-m-d H:i:s') . " - " . $e->getMessage());
            include ROOT_PATH . '/views/error.php';
        }
    } else {
        error_log("[ERROR] " . date('Y-m-d H:i:s') . " - Action không tồn tại: " . $action);
        include ROOT_PATH . '/views/error.php';
    }
} else {
    error_log("[ERROR] " . date('Y-m-d H:i:s') . " - Controller không tồn tại: " . $controller);
    include ROOT_PATH . '/views/error.php';
}
?> 