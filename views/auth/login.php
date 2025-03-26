<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #4e73df;
            background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: white;
            border-bottom: 1px solid #e3e6f0;
            border-top-left-radius: 1rem !important;
            border-top-right-radius: 1rem !important;
            padding: 2rem 1rem 1rem;
            text-align: center;
        }
        .card-body {
            padding: 2rem;
        }
        .form-floating {
            margin-bottom: 1rem;
        }
        .btn-login {
            font-size: 0.9rem;
            letter-spacing: 0.05rem;
            padding: 0.75rem 1rem;
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-login:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
        .login-heading {
            font-weight: 300;
        }
        .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
            background-color: #4e73df;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin: 0 auto 1rem;
        }
        .features {
            background-color: #f8f9fc;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
            border-left: 4px solid #4e73df;
        }
        .features ul {
            margin-bottom: 0;
            padding-left: 1.5rem;
        }
        .features ul li {
            margin-bottom: 0.5rem;
        }
        .features ul li:last-child {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-header">
                        <div class="logo">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <h3 class="login-heading mb-1">Đăng nhập hệ thống</h3>
                        <p class="text-muted mb-0">Hệ thống đăng ký học phần sinh viên</p>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div><?php echo htmlspecialchars($error); ?></div>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="MaSV" name="MaSV" placeholder="Nhập mã sinh viên" required autofocus>
                                <label for="MaSV"><i class="bi bi-person-badge me-1"></i>Mã sinh viên</label>
                                <div class="form-text">Nhập mã số sinh viên để đăng nhập hệ thống</div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-login text-uppercase fw-bold">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập
                                </button>
                            </div>
                            
                            <div class="features mt-4">
                                <h6><i class="bi bi-info-circle me-1"></i>Chức năng hệ thống:</h6>
                                <ul class="small">
                                    <li>Đăng ký học phần với giao diện trực quan</li>
                                    <li>Quản lý các học phần trong giỏ hàng</li>
                                    <li>Theo dõi các học phần đã đăng ký thành công</li>
                                    <li>Hiển thị số lượng chỗ còn lại theo thời gian thực</li>
                                </ul>
                            </div>
                            
                            <div class="text-center mt-4">
                                <div class="small text-muted">© <?php echo date('Y'); ?> Hệ thống quản lý đào tạo</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>