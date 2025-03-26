<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lỗi hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            text-align: center;
            max-width: 500px;
        }
        .error-icon {
            font-size: 6rem;
            color: #e74a3b;
            margin-bottom: 2rem;
        }
        .error-code {
            font-size: 1.5rem;
            font-weight: 700;
            color: #e74a3b;
            margin-bottom: 1rem;
        }
        .error-message {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #5a5c69;
        }
        .return-link {
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-container">
            <div class="error-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div class="error-code">Lỗi hệ thống</div>
            <div class="error-message">
                Đã xảy ra lỗi trong quá trình xử lý. Vui lòng thử lại sau hoặc liên hệ quản trị viên để được hỗ trợ.
            </div>
            <div class="return-link">
                <a href="index.php" class="btn btn-primary">
                    <i class="bi bi-house-door me-2"></i>Trở về trang chủ
                </a>
            </div>
            <div class="mt-4 text-muted small">
                Error ID: <?php echo uniqid(); ?>
            </div>
        </div>
    </div>
</body>
</html> 