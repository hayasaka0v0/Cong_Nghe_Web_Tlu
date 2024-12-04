<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h1 class="mb-4">Sửa sản phẩm</h1>
    <?php if (isset($product)): ?>
        <form method="POST" action="index.php?action=edit&id=<?= htmlspecialchars($product['id']) ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text"
                       class="form-control"
                       id="name"
                       name="name"
                       value="<?= htmlspecialchars($product['name']) ?>"
                       required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number"
                       class="form-control"
                       id="price"
                       name="price"
                       value="<?= htmlspecialchars($product['price']) ?>"
                       required>
            </div>
            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            <a href="index.php" class="btn btn-secondary">Hủy</a>
        </form>
    <?php else: ?>
        <div class="alert alert-danger">
            Không tìm thấy sản phẩm.
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>