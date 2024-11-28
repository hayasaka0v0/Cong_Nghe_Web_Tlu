<?php

include 'conn.php';
// Handle flower edit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Fetch the flower details to edit
    $stmt = $pdo->prepare("SELECT * FROM hoa WHERE id = ?");
    $stmt->execute([$id]);
    $flower = $stmt->fetch();
}

// Handle form submission to update the flower
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_flower'])) {
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Edit Flower</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Flower</h2>
        <form action="edit.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $flower['id']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Flower Name</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo htmlspecialchars($flower['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="3" required><?php echo htmlspecialchars($flower['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Upload Flower Image (optional)</label>
                <input type="file" class="form-control" name="image" id="image">
            </div>
            <button type="submit" class="btn btn-success" name="edit_flower">Update Flower</button>
        </form>
    </div>
</body>
</html>
