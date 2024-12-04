<?php
require_once '../controllers/ProductController.php';

$controller = new ProductController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = $_GET['id'] ?? null;

    switch ($action) {
        case 'add':
            $controller->add();
            break;
        case 'edit':
            if ($id) {
                $controller->edit($id);
            }
            break;
        case 'delete':
            if ($id) {
                $controller->delete($id);
            }
            break;
        default:
            $controller->index();
            break;
    }
} else {
    $controller->index();
}
?>