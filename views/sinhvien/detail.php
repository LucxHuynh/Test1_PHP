<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .card-header {
            background-color: #36b9cc;
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }
        .student-image {
            width: 100%;
            max-height: 250px;
            object-fit: cover;
            border-radius: 10px;
            border: 5px solid #fff;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .student-info {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .info-label {
            color: #5a5c69;
            font-weight: 600;
        }
        .info-value {
            font-weight: 400;
        }
        .btn-warning {
            background-color: #f6c23e;
            border-color: #f6c23e;
        }
        .btn-secondary {
            background-color: #858796;
            border-color: #858796;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-mortarboard-fill me-2"></i>Quản lý đào tạo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?controller=sinhvien&action=index">Sinh viên</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=hocphan&action=dangky">Đăng ký học phần</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?controller=sinhvien&action=index">Sinh viên</a></li>
                <li class="breadcrumb-item active">Chi tiết</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><i class="bi bi-person-badge me-2"></i>Thông tin chi tiết sinh viên</h3>
                        <span class="badge bg-light text-dark"><?php echo $sinhvien['MaSV']; ?></span>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <?php if (!empty($sinhvien['Hinh'])): ?>
                                        <img src="Content/images/<?php echo $sinhvien['Hinh']; ?>" alt="Student Image" 
                                            class="student-image mb-3">
                                    <?php else: ?>
                                        <img src="Content/images/no-image.jpg" alt="No Image" 
                                            class="student-image mb-3">
                                    <?php endif; ?>
                                    
                                    <div class="d-grid gap-2 mt-3">
                                        <a href="index.php?controller=sinhvien&action=edit&id=<?php echo $sinhvien['MaSV']; ?>" 
                                        class="btn btn-warning">
                                            <i class="bi bi-pencil-square me-1"></i>Sửa thông tin
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="student-info">
                                    <h4 class="mb-4 fw-bold text-primary"><?php echo $sinhvien['HoTen']; ?></h4>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-4 info-label">Mã sinh viên:</div>
                                        <div class="col-md-8 info-value"><?php echo $sinhvien['MaSV']; ?></div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-4 info-label">Họ tên:</div>
                                        <div class="col-md-8 info-value"><?php echo $sinhvien['HoTen']; ?></div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-4 info-label">Ngày sinh:</div>
                                        <div class="col-md-8 info-value"><?php echo date('d/m/Y', strtotime($sinhvien['NgaySinh'])); ?></div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-4 info-label">Giới tính:</div>
                                        <div class="col-md-8 info-value">
                                            <?php if($sinhvien['GioiTinh'] == 'Nam'): ?>
                                                <span class="badge bg-primary"><i class="bi bi-gender-male me-1"></i>Nam</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger"><i class="bi bi-gender-female me-1"></i>Nữ</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-4 info-label">Mã ngành:</div>
                                        <div class="col-md-8 info-value"><?php echo $sinhvien['MaNganh']; ?></div>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                    <a href="index.php?controller=sinhvien&action=index" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left me-1"></i>Quay lại danh sách
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>