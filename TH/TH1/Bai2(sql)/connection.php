<?php
$dsn = 'mysql:host=localhost;dbname=bai2';
$username = 'root';
$password = '';

try {
    $conn = new PDO($dsn, $username, $password);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>
