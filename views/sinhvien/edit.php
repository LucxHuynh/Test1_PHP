<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin sinh viên</title>
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
            background-color: #f8ac59;
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-secondary {
            background-color: #858796;
            border-color: #858796;
        }
        .form-control:focus, .form-select:focus {
            border-color: #bac8f3;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
        .required-field::after {
            content: " *";
            color: red;
        }
        .image-preview {
            max-height: 200px;
            border-radius: 5px;
        }
        .current-image {
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #fff;
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
                <li class="breadcrumb-item active">Sửa thông tin</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Sửa thông tin sinh viên</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="MaSV" class="form-label">Mã sinh viên</label>
                                    <input type="text" class="form-control bg-light" id="MaSV" name="MaSV" value="<?php echo $sinhvien['MaSV']; ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="MaNganh" class="form-label required-field">Mã ngành</label>
                                    <input type="text" class="form-control" id="MaNganh" name="MaNganh" value="<?php echo $sinhvien['MaNganh']; ?>" required>
                                    <div class="invalid-feedback">
                                        Vui lòng nhập mã ngành
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="HoTen" class="form-label required-field">Họ tên</label>
                                <input type="text" class="form-control" id="HoTen" name="HoTen" value="<?php echo $sinhvien['HoTen']; ?>" required>
                                <div class="invalid-feedback">
                                    Vui lòng nhập họ tên sinh viên
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="NgaySinh" class="form-label required-field">Ngày sinh</label>
                                    <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" value="<?php echo $sinhvien['NgaySinh']; ?>" required>
                                    <div class="invalid-feedback">
                                        Vui lòng chọn ngày sinh
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="GioiTinh" class="form-label required-field">Giới tính</label>
                                    <select class="form-select" id="GioiTinh" name="GioiTinh" required>
                                        <option value="Nam" <?php echo $sinhvien['GioiTinh'] == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                                        <option value="Nữ" <?php echo $sinhvien['GioiTinh'] == 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Vui lòng chọn giới tính
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="Hinh" class="form-label">Hình ảnh</label>
                                <?php if (!empty($sinhvien['Hinh'])): ?>
                                <div class="current-image mb-2">
                                    <div class="mb-2"><strong>Ảnh hiện tại:</strong></div>
                                    <img src="Content/images/<?php echo $sinhvien['Hinh']; ?>" alt="Student Image" class="image-preview">
                                </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" id="Hinh" name="Hinh" accept="image/*" onchange="previewImage(this)">
                                <div class="form-text">Để trống nếu không muốn thay đổi hình ảnh</div>
                                <img id="imagePreview" src="#" alt="Preview" class="image-preview mt-2" style="display: none;">
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <a href="index.php?controller=sinhvien&action=index" class="btn btn-secondary me-md-2">
                                    <i class="bi bi-arrow-left me-1"></i>Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i>Cập nhật
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
        
        // Image preview
        function previewImage(input) {
            var preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>