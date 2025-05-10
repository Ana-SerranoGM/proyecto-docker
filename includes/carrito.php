<?php
function agregarAlCarrito($producto_id, $cantidad = 1, $talla = null) {
    global $conn;
    
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }
    
    // Obtener información del producto
    $stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$producto_id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$producto) {
        return false;
    }
    
    // Si no hay talla, usamos solo el ID como clave
    $carrito_key = $talla ? $producto_id . '_' . $talla : $producto_id;
    
    if (isset($_SESSION['carrito'][$carrito_key])) {
        $_SESSION['carrito'][$carrito_key]['cantidad'] += $cantidad;
    } else {
        $_SESSION['carrito'][$carrito_key] = [
            'producto_id' => $producto_id,
            'nombre' => $producto['nombre'],
            'precio' => floatval($producto['precio']),
            'cantidad' => intval($cantidad),
            'talla' => $talla
        ];
    }
    
    return true;
}

function eliminarDelCarrito($carrito_key) {
    if (isset($_SESSION['carrito'][$carrito_key])) {
        unset($_SESSION['carrito'][$carrito_key]);
    }
}

function actualizarCantidad($carrito_key, $cantidad) {
    if ($cantidad > 0) {
        $_SESSION['carrito'][$carrito_key]['cantidad'] = intval($cantidad);
    } else {
        eliminarDelCarrito($carrito_key);
    }
}

function obtenerCarrito() {
    if (!isset($_SESSION['carrito']) || !is_array($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }
    return $_SESSION['carrito'];
}

function obtenerTotalCarrito() {
    $total = 0;
    $carrito = obtenerCarrito();
    
    foreach ($carrito as $key => $item) {
        if (is_array($item) && isset($item['precio']) && isset($item['cantidad'])) {
            $subtotal = floatval($item['precio']) * intval($item['cantidad']);
            $total += $subtotal;
        }
    }
    
    return $total;
}

function vaciarCarrito() {
    $_SESSION['carrito'] = array();
}
?> 