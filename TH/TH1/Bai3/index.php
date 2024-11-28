<?php
function remove_bom($str) {
    if (substr($str, 0, 3) === "\xEF\xBB\xBF") {
        $str = substr($str, 3); 
    }
    return $str;
}

$sinhvien = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"])) {
    $file = $_FILES["csv_file"]["tmp_name"];
    if (($handle = fopen($file, "r")) !== FALSE) {
        $headers = fgetcsv($handle, 1000, ",");
        $headers = array_map('remove_bom', $headers); 
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $sinhvien[] = array_combine($headers, $data);
        }
        fclose($handle);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Danh sách sinh viên</h1>
        
        <form method="post" enctype="multipart/form-data" class="mb-4">
            <div class="mb-3">
                <label for="csv_file" class="form-label">Chọn file CSV</label>
                <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required>
            </div>
            <button type="submit" class="btn btn-primary">Tải lên</button>
        </form>

        <?php if (!empty($sinhvien)): ?>
        <table class="table table-bordered table-striped">
            
            <thead class="table-dark">
                <tr>
                    <th>Tên đăng nhập(Mã SV)</th>
                    <th>Mật khẩu</th>
                    <th>Họ</th>
                    <th>Tên</th>
                    <th>Lớp</th>
                    <th>Email</th>
                    <th>Khóa học</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($sinhvien as $sv): ?>
                    <tr>
                        <td><?= htmlspecialchars($sv['username']) ?></td>
                        <td><?= htmlspecialchars($sv['password']) ?></td>
                        <td><?= htmlspecialchars($sv['lastname']) ?></td>
                        <td><?= htmlspecialchars($sv['firstname']) ?></td>
                        <td><?= htmlspecialchars($sv['city']) ?></td>
                        <td><?= htmlspecialchars($sv['email']) ?></td>
                        <td><?= htmlspecialchars($sv['course1']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
        <?php else: ?>
            <p class="text-center">Chưa có dữ liệu để hiển thị. Vui lòng tải lên file CSV.</p>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
