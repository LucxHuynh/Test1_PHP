<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký học phần</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f0f2f5;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        .page-header {
            background: linear-gradient(90deg, #1cc88a, #36b9cc);
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .btn-primary {
            background-color: #36b9cc;
            border-color: #36b9cc;
        }
        .btn-primary:hover {
            background-color: #2c9faf;
            border-color: #2c9faf;
        }
        .btn-danger {
            background-color: #e74a3b;
            border-color: #e74a3b;
        }
        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
        }
        .form-check-input:checked {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }
        .progress-bar {
            font-size: 0.9rem;
            font-weight: bold;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fc;
        }
        .badge-success {
            background-color: #1cc88a;
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
            <h2 class="mb-0"><i class="bi bi-journal-plus me-2"></i>Đăng ký học phần</h2>
            <p class="text-light mb-0">Chọn học phần bạn muốn đăng ký</p>
        </div>

        <div class="nav-menu mb-4">
            <a href="index.php?controller=hocphan&action=dangky" class="btn btn-primary active">
                <i class="bi bi-journal-plus me-2"></i>Đăng ký học phần
            </a>
            <a href="index.php?controller=hocphan&action=giohang" class="btn btn-outline-primary">
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
                <?php echo htmlspecialchars($_GET['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="index.php?controller=hocphan&action=themgiohang">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">Chọn</th>
                                    <th width="15%">Mã học phần</th>
                                    <th width="40%">Tên học phần</th>
                                    <th width="15%">Số tín chỉ</th>
                                    <th width="25%">Số lượng còn lại</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()): 
                                    $isRegistered = isset($daDangKy) && in_array($row['MaHP'], $daDangKy);
                                ?>
                                    <tr class="<?php echo $isRegistered ? 'table-success' : ''; ?>">
                                        <td>
                                            <?php if($isRegistered): ?>
                                                <span class="badge bg-success">Đã ĐK</span>
                                            <?php elseif($row['SoLuongDuKien'] > 0): ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="hocphan[]" value="<?php echo $row['MaHP']; ?>" id="hp-<?php echo $row['MaHP']; ?>">
                                                    <label class="form-check-label" for="hp-<?php echo $row['MaHP']; ?>"></label>
                                                </div>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Hết chỗ</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="fw-bold"><?php echo $row['MaHP']; ?></span></td>
                                        <td><?php echo $row['TenHP']; ?></td>
                                        <td class="text-center"><?php echo $row['SoTC']; ?></td>
                                        <td>
                                            <?php if($isRegistered): ?>
                                                <span class="badge bg-success">Đã đăng ký thành công</span>
                                            <?php elseif($row['SoLuongDuKien'] > 3): ?>
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        <?php echo $row['SoLuongDuKien']; ?> chỗ
                                                    </div>
                                                </div>
                                            <?php elseif($row['SoLuongDuKien'] > 0): ?>
                                                <div class="progress">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                        <?php echo $row['SoLuongDuKien']; ?> chỗ
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="progress">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        Hết chỗ
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ hàng
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>