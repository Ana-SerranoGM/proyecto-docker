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
<!-- Barra de navegación -->
<nav class="nav-container">
    <div class="nav-left">
        <a href="/proyecto-docker/index.php">Tienda</a>
        <a href="/proyecto-docker/about.php">Acerca de</a>
        <a href="/proyecto-docker/contacto.php">Contacto</a>
    </div>
    <div class="nav-center">
        <a href="/proyecto-docker/index.php" class="logo">SEEN THE LABEL</a>
    </div>
    <div class="nav-right">
        <a href="/proyecto-docker/login.php">Iniciar sesión</a>
        <a href="/proyecto-docker/registro.php">Registrarse</a>
        <a href="/proyecto-docker/carrito.php" class="cart-icon">
            🛒
            <span class="cart-count"><?php echo $total_items; ?></span>
        </a>
    </div>
</nav> 