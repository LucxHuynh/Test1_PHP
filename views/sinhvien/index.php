<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
        }
        .page-header {
            background: linear-gradient(90deg, #4e73df, #1cc88a);
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        .avatar-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #dee2e6;
        }
        .btn-action {
            margin-right: 5px;
        }
        .table-container {
            overflow-x: auto;
        }
        .alert {
            border-radius: 10px;
        }
        .nav-pills .nav-link.active {
            background-color: #4e73df;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
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
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0"><i class="bi bi-people me-2"></i>Danh sách sinh viên</h2>
                <p class="text-light mb-0">Quản lý thông tin sinh viên trong hệ thống</p>
            </div>
            <a href="index.php?controller=sinhvien&action=create" class="btn btn-light">
                <i class="bi bi-person-plus me-1"></i>Thêm sinh viên
            </a>
        </div>
        
        <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>Thao tác thành công!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Mã SV</th>
                                <th>Hình ảnh</th>
                                <th>Họ tên</th>
                                <th>Ngày sinh</th>
                                <th>Giới tính</th>
                                <th>Mã ngành</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><span class="fw-bold"><?php echo $row['MaSV']; ?></span></td>
                                    <td>
                                        <?php if (!empty($row['Hinh'])): ?>
                                            <img src="Content/images/<?php echo $row['Hinh']; ?>" alt="Student Image" class="avatar-img">
                                        <?php else: ?>
                                            <img src="Content/images/no-image.jpg" alt="No Image" class="avatar-img">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $row['HoTen']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($row['NgaySinh'])); ?></td>
                                    <td>
                                        <?php if($row['GioiTinh'] == 'Nam'): ?>
                                            <span class="badge bg-primary"><i class="bi bi-gender-male me-1"></i>Nam</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><i class="bi bi-gender-female me-1"></i>Nữ</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $row['MaNganh']; ?></td>
                                    <td>
                                        <a href="index.php?controller=sinhvien&action=detail&id=<?php echo $row['MaSV']; ?>" 
                                           class="btn btn-info btn-sm btn-action">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="index.php?controller=sinhvien&action=edit&id=<?php echo $row['MaSV']; ?>" 
                                           class="btn btn-warning btn-sm btn-action">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="index.php?controller=sinhvien&action=delete&id=<?php echo $row['MaSV']; ?>" 
                                           class="btn btn-danger btn-sm btn-action"
                                           onclick="return confirm('Bạn có chắc muốn xóa sinh viên này?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>