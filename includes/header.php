<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/carrito.php';

// Obtener el número de elementos en el carrito
$carrito = obtenerCarrito();
$total_items = array_sum(array_column($carrito, 'cantidad'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/header.css">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="nav-container">
        <div class="nav-left">
            <a href="productos.php">Tienda</a>
            <a href="about.php">Acerca de</a>
            <a href="contacto.php">Contacto</a>
        </div>
        <div class="nav-center">
            <a href="productos.php" class="logo">SEEN THE LABEL</a>
        </div>
        <div class="nav-right">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="perfil.php"><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></a>
                <a href="logout.php">Cerrar sesión</a>
            <?php else: ?>
                <a href="login.php">Iniciar sesión</a>
                <a href="registro.php">Registrarse</a>
            <?php endif; ?>
            <a href="carrito.php" class="cart-icon">
                🛒
                <span class="cart-count"><?php echo $total_items; ?></span>
            </a>
        </div>
    </nav>
</body>
</html> 