<?php
// Database connection
$host = 'localhost';
$db   = 'qlhoa';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Handle flower deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM hoa WHERE id = ?");
    $stmt->execute([$delete_id]);
    header("Location: index.php"); // Redirect to the list page after deleting
    exit;
}

// Handle flower edit
if (isset($_POST['edit_flower'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    // Check if an image was uploaded for the update
    if ($_FILES['image']['error'] === 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_new_name = uniqid('', true) . '.' . pathinfo($image_name, PATHINFO_EXTENSION);
        $image_upload_path = '../Assets/Images/' . $image_new_name;

        // Move the uploaded image
        if (move_uploaded_file($image_tmp_name, $image_upload_path)) {
            $stmt = $pdo->prepare("UPDATE hoa SET name = ?, description = ?, image = ? WHERE id = ?");
            $stmt->execute([$name, $description, $image_upload_path, $id]);
        }
    } else {
        // If no new image, update only name and description
        $stmt = $pdo->prepare("UPDATE hoa SET name = ?, description = ? WHERE id = ?");
        $stmt->execute([$name, $description, $id]);
    }
    header("Location: index.php"); // Redirect after updating
    exit;
}

// Fetch flowers from the database
$stmt = $pdo->query("SELECT * FROM hoa");
$flowers = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Hoa CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="box1">
        <h2>Flowers</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Thêm hoa</button>
    </div>

    <!-- Table -->
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>Ten hoa</th>
                <th>Mo ta</th>
                <th>Anh</th>
                <th>Chuc nang</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($flowers as $flower): ?>
        <tr>
            <td><?php echo htmlspecialchars($flower['name']); ?></td>
            <td><?php echo htmlspecialchars($flower['description']); ?></td>
            <td><img src="<?php echo htmlspecialchars($flower['image']); ?>" alt="<?php echo htmlspecialchars($flower['name']); ?>" style="width: 50px; height: auto;"></td>
            <td>
                <a href="edit.php?id=<?php echo $flower['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="?delete_id=<?php echo $flower['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this flower?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

    </table>

    <!-- Modal Form for Adding Flower with Image Upload -->
    <form action="" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Flower</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Flower Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter flower name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter flower description" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="image" class="form-label">Upload Flower Image</label>
                            <input type="file" class="form-control" name="image" id="image" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-success" name="add_flower" value="Add Flower">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
