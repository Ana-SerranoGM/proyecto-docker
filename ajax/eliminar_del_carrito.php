<?php
session_start();
require_once '../config/database.php';
require_once '../includes/carrito.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['carrito_key'])) {
    $carrito_key = $_POST['carrito_key'];
    
    if (isset($_SESSION['carrito'][$carrito_key])) {
        unset($_SESSION['carrito'][$carrito_key]);
        
        echo json_encode([
            'success' => true,
            'cart_count' => array_sum($_SESSION['carrito']),
            'message' => 'Producto eliminado correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Producto no encontrado en el carrito'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Solicitud inválida'
    ]);
}
?> 