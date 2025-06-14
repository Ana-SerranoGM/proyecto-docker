<?php
$host = getenv('MYSQL_HOST') ?: 'localhost:8889';
$dbname = getenv('MYSQL_DATABASE') ?: 'seendb';
$username = getenv('MYSQL_USER') ?: 'seenuser';
$password = getenv('MYSQL_PASSWORD') ?: 'seenpass';

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        )
    );
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die();
}
?> 