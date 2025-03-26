<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng học phần</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #e9ecef;
        }
        .card {
            border-radius: 15px;
            border: 1px solid #dee2e6;
        }
        .page-header {
            background: linear-gradient(90deg, #4e73df, #1cc88a);
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .btn-primary {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }
        .btn-primary:hover {
            background-color: #17a673;
            border-color: #17a673;
        }
        .btn-danger {
            background-color: #e74a3b;
            border-color: #e74a3b;
        }
        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
        }
        .summary-box {
            background-color: #f8f9fc;
            border-left: 5px solid #1cc88a;
            padding: 1.5rem;
            border-radius: 10px;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
        }
        .nav-menu {
            background-color: white;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 20px;
            box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, 0.08);
        }
        .nav-menu .btn {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="page-header text-center">
            <h2 class="mb-0"><i class="bi bi-cart me-2"></i>Giỏ hàng học phần</h2>
            <p class="text-light mb-0">Danh sách học phần bạn đã chọn</p>
        </div>

        <div class="nav-menu mb-4">
            <a href="index.php?controller=hocphan&action=dangky" class="btn btn-outline-primary">
                <i class="bi bi-journal-plus me-2"></i>Đăng ký học phần
            </a>
            <a href="index.php?controller=hocphan&action=giohang" class="btn btn-primary active">
                <i class="bi bi-cart me-2"></i>Giỏ hàng học phần
            </a>
            <a href="index.php?controller=hocphan&action=hienthidangky" class="btn btn-outline-success">
                <i class="bi bi-journals me-2"></i>Học phần đã đăng ký
            </a>
            <a href="index.php?controller=auth&action=logout" class="btn btn-outline-danger float-end">
                <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
            </a>
        </div>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?php echo htmlspecialchars($_GET['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?php echo htmlspecialchars(is_string($_GET['error']) ? $_GET['error'] : 'Bạn chưa chọn học phần nào để đăng ký!'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['warning'])): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?php echo htmlspecialchars($_GET['warning']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-body">
                <?php 
                if ($stmt->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Mã HP</th>
                                    <th>Tên học phần</th>
                                    <th>Số tín chỉ</th>
                                    <th>Số lượng còn lại</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $tongTC = 0;
                                $hasWarning = false;
                                while ($row = $stmt->fetch_assoc()): 
                                    $tongTC += $row['SoTC'];
                                    if ($row['SoLuongDuKien'] <= 1) {
                                        $hasWarning = true;
                                    }
                                ?>
                                    <tr>
                                        <td><span class="fw-bold"><?php echo $row['MaHP']; ?></span></td>
                                        <td><?php echo $row['TenHP']; ?></td>
                                        <td class="text-center"><?php echo $row['SoTC']; ?></td>
                                        <td>
                                            <?php if($row['SoLuongDuKien'] > 3): ?>
                                                <span class="badge bg-success rounded-pill"><?php echo $row['SoLuongDuKien']; ?> chỗ</span>
                                            <?php elseif($row['SoLuongDuKien'] > 1): ?>
                                                <span class="badge bg-warning rounded-pill"><?php echo $row['SoLuongDuKien']; ?> chỗ</span>
                                            <?php elseif($row['SoLuongDuKien'] == 1): ?>
                                                <span class="badge bg-danger rounded-pill">Còn 1 chỗ duy nhất!</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger rounded-pill">Hết chỗ</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="index.php?controller=hocphan&action=xoa&id=<?php echo $row['MaHP']; ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Bạn có chắc muốn xóa học phần này?')">
                                                <i class="bi bi-trash me-1"></i>Xóa
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if ($hasWarning): ?>
                    <div class="alert alert-warning mt-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Lưu ý:</strong> Một số học phần trong giỏ hàng sắp hết chỗ. Hãy đăng ký sớm để đảm bảo bạn có chỗ học.
                    </div>
                    <?php endif; ?>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="summary-box">
                                <h5 class="mb-3">Thông tin đăng ký</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tổng số học phần:</span>
                                    <span class="fw-bold"><?php echo $stmt->num_rows; ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tổng số tín chỉ:</span>
                                    <span class="fw-bold"><?php echo $tongTC; ?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Ngày đăng ký:</span>
                                    <span class="fw-bold"><?php echo date('d/m/Y'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-grid gap-2 h-100 d-flex align-items-end justify-content-end">
                                <a href="index.php?controller=hocphan&action=dangky" class="btn btn-outline-primary me-2">
                                    <i class="bi bi-arrow-left me-2"></i>Tiếp tục đăng ký
                                </a>
                                <a href="index.php?controller=hocphan&action=luu" 
                                   class="btn btn-success btn-lg"
                                   onclick="return confirm('Bạn có chắc chắn muốn đăng ký các học phần này?')">
                                    <i class="bi bi-check-circle me-2"></i>Xác nhận đăng ký
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-cart-x" style="font-size: 5rem; color: #d1d3e2;"></i>
                        <h4 class="mt-3 mb-3">Giỏ hàng trống!</h4>
                        <p class="text-muted mb-4">Bạn chưa chọn học phần nào để đăng ký</p>
                        <a href="index.php?controller=hocphan&action=dangky" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Đăng ký học phần
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>