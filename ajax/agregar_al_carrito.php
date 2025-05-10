<?php
session_start();
require_once '../config/database.php';
require_once '../includes/carrito.php';

header('Content-Type: application/json');

// Depuración
error_log("POST data: " . print_r($_POST, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'])) {
    $producto_id = (int)$_POST['producto_id'];
    $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;
    $talla = isset($_POST['talla']) ? $_POST['talla'] : null;
    
    error_log("Producto ID: $producto_id, Cantidad: $cantidad, Talla: $talla");
    
    if ($cantidad <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'La cantidad debe ser mayor a 0'
        ]);
        exit;
    }
    
    // Verificar que el producto existe
    $stmt = $conn->prepare("SELECT id, nombre FROM productos WHERE id = ?");
    $stmt->execute([$producto_id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($producto) {
        error_log("Producto encontrado: " . $producto['nombre']);
        
        // Crear una clave única para el producto con su talla
        $carrito_key = $producto_id . '_' . $talla;
        
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }
        
        if (isset($_SESSION['carrito'][$carrito_key])) {
            $_SESSION['carrito'][$carrito_key] += $cantidad;
        } else {
            $_SESSION['carrito'][$carrito_key] = $cantidad;
        }
        
        error_log("Carrito actualizado: " . print_r($_SESSION['carrito'], true));
        
        echo json_encode([
            'success' => true,
            'cart_count' => array_sum($_SESSION['carrito']),
            'message' => 'Producto añadido correctamente'
        ]);
    } else {
        error_log("Producto no encontrado con ID: $producto_id");
        echo json_encode([
            'success' => false,
            'message' => 'Producto no encontrado'
        ]);
    }
} else {
    error_log("Solicitud inválida: " . print_r($_POST, true));
    echo json_encode([
        'success' => false,
        'message' => 'Solicitud inválida'
    ]);
}
?> 