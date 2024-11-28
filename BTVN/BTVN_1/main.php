<link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
    />
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<?php
// Start the session to persist data

// include 'index.php';
session_start();

// Initialize employees array in the session
if (!isset($_SESSION['employees'])) {
    $_SESSION['employees'] = [
        ['name' => 'Vu Duc Huy', 'email' => 'huyham1511@gmail.com', 'address' => 'Hà Nội, Việt Nam', 'phone' => '0123456789'],
        ['name' => 'Trần Thị Bảo', 'email' => 'tranthib@asdqwd.com', 'address' => 'Hồ Chí Minh, Việt Nam', 'phone' => '0987654321'],
        ['name' => 'Lê Văn Luyện', 'email' => 'levanc@example.com', 'address' => 'Đà Nẵng, Việt Nam', 'phone' => '0123456789'],
        ['name' => 'Phạm Thị Dung', 'email' => 'phamthid@example.com', 'address' => 'Cần Thơ, Việt Nam', 'phone' => '0987654321'],
        ['name' => 'Đặng Văn Dũng', 'email' => 'dangvane@example.com', 'address' => 'Hải Phòng, Việt Nam', 'phone' => '0123456789'],
    ];
}

// Fetch employees from the session
$employees = $_SESSION['employees'];

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_index'])) {
    $index = (int) $_POST['delete_index'];
    if (isset($employees[$index])) {
        unset($employees[$index]); // Remove the target row
        $_SESSION['employees'] = array_values($employees); // Save updated data to session
    }
}

// Handle editing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_index'])) {
    $index = (int) $_POST['edit_index'];
    if (isset($employees[$index])) {
        $employees[$index] = [
            'name' => htmlspecialchars($_POST['name']),
            'email' => htmlspecialchars($_POST['email']),
            'address' => htmlspecialchars($_POST['address']),
            'phone' => htmlspecialchars($_POST['phone']),
        ];
        $_SESSION['employees'] = $employees; // Save updated data to session
    }
}

// Check if we are in edit mode
$editMode = isset($_POST['action']) && $_POST['action'] === 'edit';
$editIndex = $editMode ? (int) $_POST['index'] : null;
$employeeToEdit = $editMode ? $employees[$editIndex] : null;
?>

<main>
    <div class="linear-gradient" style="background: linear-gradient(0,#ffffff,gray); height: 2rem;"></div>
    <div class="container-header">
        <div class="content-header d-flex justify-content-between p-3 mb-2 bg-primary text-white">
            <h3 class="text-uppercase">quản lý <strong>sinh viên</strong></h3>
        </div>
    </div>
    <div class="p-3">
        <div class="row border-top border-bottom pb-3 pt-3 mb-2">
            <div class="col"><label>Ho và Tên</label></div>
            <div class="col"><label>Thư điện tử</label></div>
            <div class="col"><label>Địa chỉ</label></div>
            <div class="col"><label>Số điện thoại</label></div>
            <div class="col"><label>Hành động</label></div>
        </div>
        <div>
            <?php foreach ($employees as $index => $employee): ?>
                <div class="row border-top border-bottom pb-2 pt-2">
                    <div class="col"><label><?= htmlspecialchars($employee['name']) ?></label></div>
                    <div class="col"><label><?= htmlspecialchars($employee['email']) ?></label></div>
                    <div class="col"><label><?= htmlspecialchars($employee['address']) ?></label></div>
                    <div class="col"><label><?= htmlspecialchars($employee['phone']) ?></label></div>
                    <div class="col">
                        <!-- Edit Button -->
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="index" value="<?= $index ?>">
                            <button type="submit" class="btn btn-link"><i class="material-icons">&#xE254;</i></button>
                        </form>
                        <!-- Delete Button -->
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="delete_index" value="<?= $index ?>">
                            <button type="submit" class="btn btn-link"><i class="material-icons">&#xE872;</i></button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($editMode && $employeeToEdit): ?>
        <div class="edit-form">
            <form method="POST" action="">
                <input type="hidden" name="edit_index" value="<?= $editIndex ?>">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" value="<?= htmlspecialchars($employeeToEdit['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($employeeToEdit['email']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" name="address" id="address" value="<?= htmlspecialchars($employeeToEdit['address']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($employeeToEdit['phone']) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href=''">Cancel</button>
            </form>
        </div>
        <?php endif; ?>
        
    </div>
</main>
<script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"
></script>

<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"
></script>
