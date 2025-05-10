<?php
session_start();
require_once '../config/database.php';

// Verificar que la petición sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener y decodificar los datos JSON
$datos = json_decode(file_get_contents('php://input'), true);

// Validar datos requeridos
if (!isset($datos['producto_id']) || !isset($datos['cantidad'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

$producto_id = (int)$datos['producto_id'];
$cantidad = (int)$datos['cantidad'];
$talla = isset($datos['talla']) ? $datos['talla'] : null;

// Validar cantidad
if ($cantidad < 1 || $cantidad > 99) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Cantidad no válida']);
    exit;
}

// Obtener información del producto
$stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->execute([$producto_id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
    exit;
}

// Si el producto tiene tallas, validar stock
if ($producto['tiene_tallas']) {
    if (!$talla) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Se requiere seleccionar una talla']);
        exit;
    }

    $stmt = $conn->prepare("SELECT stock FROM tallas_producto WHERE producto_id = ? AND talla = ?");
    $stmt->execute([$producto_id, $talla]);
    $stock = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$stock || $stock['stock'] < $cantidad) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Stock insuficiente']);
        exit;
    }
}

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Crear clave única para el producto (incluye talla si existe)
$clave = $producto_id . ($talla ? '_' . $talla : '');

// Añadir o actualizar producto en el carrito
if (isset($_SESSION['carrito'][$clave])) {
    $_SESSION['carrito'][$clave]['cantidad'] += $cantidad;
} else {
    $_SESSION['carrito'][$clave] = [
        'producto_id' => $producto_id,
        'nombre' => $producto['nombre'],
        'precio' => $producto['precio'],
        'cantidad' => $cantidad,
        'talla' => $talla
    ];
}

// Devolver respuesta exitosa
echo json_encode([
    'success' => true,
    'message' => 'Producto añadido al carrito',
    'cart_count' => count($_SESSION['carrito'])
]); 