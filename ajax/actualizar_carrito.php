<?php
require_once '../config/database.php';
require_once '../includes/carrito.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['carrito_key']) && isset($_POST['cantidad'])) {
    $carrito_key = $_POST['carrito_key'];
    $cantidad = (int)$_POST['cantidad'];
    
    if ($cantidad > 0) {
        actualizarCantidad($carrito_key, $cantidad);
        echo json_encode([
            'success' => true,
            'cart_count' => array_sum($_SESSION['carrito'])
        ]);
    } else {
        eliminarDelCarrito($carrito_key);
        echo json_encode([
            'success' => true,
            'cart_count' => array_sum($_SESSION['carrito'])
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Solicitud inválida'
    ]);
}
?> 