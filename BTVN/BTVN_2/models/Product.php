<?php

class Product
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        return $this->pdo->query("SELECT * FROM products")->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function add($name, $price)
    {
        $stmt = $this->pdo->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
        return $stmt->execute([$name, $price]);
    }

    public function update($id, $name, $price)
    {
        $stmt = $this->pdo->prepare("UPDATE products SET name = ?, price = ? WHERE id = ?");
        return $stmt->execute([$name, $price, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
        if ($stmt->execute([$id])) {
            $this->pdo->query("SET @num = 0");
            $this->pdo->query("UPDATE products SET id = @num := @num + 1");
            $this->pdo->query("ALTER TABLE products AUTO_INCREMENT = 1");
            return true;
        }
        return false;
    }
}