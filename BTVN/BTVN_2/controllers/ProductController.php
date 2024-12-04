<?php
include_once '../config/database.php';
include_once '../models/Product.php';

class ProductController
{
    private $productModel;

    public function __construct()
    {
        global $pdo;
        $this->productModel = new Product($pdo);
    }

    public function index()
    {
        $products = $this->productModel->getAll();
        include '../views/index.php';
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->productModel->add($_POST['name'], $_POST['price']);
            header('Location: index.php');
            exit();
        }
        include '../views/add_product.php';
    }

    public function edit($id)
    {
        $product = $this->productModel->getById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->productModel->update($id, $_POST['name'], $_POST['price']);
            header('Location: index.php');
            exit();
        }
        include '../views/edit_product.php';
    }

    public function delete($id)
    {
        $this->productModel->delete($id);
        header('Location: index.php');
        exit();
    }
}