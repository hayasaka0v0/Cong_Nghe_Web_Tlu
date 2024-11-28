<?php
require '../includes/conn.php';
session_start();

function remove_bom($str) {
    if (substr($str, 0, 3) === "\xEF\xBB\xBF") {
        $str = substr($str, 3); 
    }
    return $str;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"])) {
    $file = $_FILES["csv_file"]["tmp_name"];
    if (($handle = fopen($file, "r")) !== FALSE) {
        $pdo->exec("DELETE FROM students");
        
        $headers = fgetcsv($handle, 1000, ",");
        $headers = array_map('remove_bom', $headers);

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $sql = "INSERT INTO students (username, password, lastname, firstname, city, email, course1) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $data[0], 
                $data[1], 
                $data[2], 
                $data[3], 
                $data[4],
                $data[5], 
                $data[6]
            ]);
        }
        fclose($handle);

        $_SESSION['uploaded'] = true;
        header("Location: " . $_SERVER['PHP_SELF']); 
        exit();
    } else {
        $message = "Không thể mở file. Vui lòng thử lại.";
    }
} elseif (isset($_SESSION['uploaded']) && $_SESSION['uploaded']) {
    $message = "Dữ liệu đã được tải lên và lưu vào CSDL thành công!";
    unset($_SESSION['uploaded']);
}

$stmt = $pdo->query("SELECT * FROM students");
$sinhvien = $stmt->fetchAll();
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

        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if (!empty($sinhvien)): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Lastname</th>
                    <th>Firstname</th>
                    <th>City</th>
                    <th>Email</th>
                    <th>Course1</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1;
                foreach ($sinhvien as $sv): ?>
                    <tr>
                        <td><?= $stt++; ?></td>
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
