<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="container my-4">
    <h1 class="mb-3">Quản lý sản phẩm</h1>
    <a href="index.php?action=add" class="btn btn-success mb-3">Thêm mới</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Giá thành</th>
            <th>Thao tác</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['name']); ?></td>
                    <td><?= number_format($product['price'], 0, ',', '.') . ' VND'; ?></td>
                    <td>
                        <a href="index.php?action=edit&id=<?= $product['id']; ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="index.php?action=delete&id=<?= $product['id']; ?>"
                           class="btn btn-danger btn-sm">
                            <i class="bi bi-trash3-fill"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">Không có sản phẩm.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>