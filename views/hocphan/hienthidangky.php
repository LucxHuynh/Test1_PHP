<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách học phần đã đăng ký</title>
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
        .summary-box {
            background-color: #f8f9fc;
            border-left: 5px solid #1cc88a;
            padding: 1.5rem;
            border-radius: 10px;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
        }
        .badge-success {
            background-color: #1cc88a;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="page-header text-center">
            <h2 class="mb-0"><i class="bi bi-journals me-2"></i>Danh sách học phần đã đăng ký</h2>
            <p class="text-light mb-0">Các học phần sinh viên đã đăng ký thành công</p>
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
                <?php echo htmlspecialchars($_GET['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-body">
                <?php 
                if ($result->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Mã HP</th>
                                    <th>Tên học phần</th>
                                    <th>Số tín chỉ</th>
                                    <th>Ngày đăng ký</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $tongTC = 0;
                                while ($row = $result->fetch_assoc()): 
                                    $tongTC += $row['SoTC'];
                                ?>
                                    <tr>
                                        <td><span class="fw-bold"><?php echo $row['MaHP']; ?></span></td>
                                        <td><?php echo $row['TenHP']; ?></td>
                                        <td class="text-center"><?php echo $row['SoTC']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($row['NgayDK'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="summary-box">
                                <h5 class="mb-3">Tổng kết đăng ký học phần</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tổng số học phần:</span>
                                    <span class="fw-bold"><?php echo $result->num_rows; ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tổng số tín chỉ:</span>
                                    <span class="fw-bold"><?php echo $tongTC; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-grid gap-2 h-100 d-flex align-items-end justify-content-end">
                                <a href="index.php?controller=hocphan&action=dangky" 
                                   class="btn btn-primary btn-lg">
                                    <i class="bi bi-plus-circle me-2"></i>Đăng ký thêm học phần
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-journal-x" style="font-size: 5rem; color: #d1d3e2;"></i>
                        <h4 class="mt-3 mb-3">Bạn chưa đăng ký học phần nào!</h4>
                        <p class="text-muted mb-4">Hãy đăng ký các học phần bạn muốn học</p>
                        <a href="index.php?controller=hocphan&action=dangky" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Đăng ký học phần
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="index.php?controller=hocphan&action=dangky" class="btn btn-outline-primary me-2">
                <i class="bi bi-arrow-left me-1"></i> Quay lại trang đăng ký
            </a>
            <a href="index.php?controller=hocphan&action=giohang" class="btn btn-outline-success">
                <i class="bi bi-cart me-1"></i> Xem giỏ hàng
            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 