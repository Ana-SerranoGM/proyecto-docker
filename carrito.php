<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/database.php';
require_once 'includes/carrito.php';

$carrito = obtenerCarrito();
$total = obtenerTotalCarrito();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Seen the Label</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/carrito.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Contenido principal -->
    <div class="cart-container">
        <h1>Tu Carrito</h1>
        
        <?php if (empty($carrito)): ?>
            <div class="empty-cart">
                <p>Tu carrito está vacío</p>
                <a href="productos.php" class="continue-shopping">Continuar comprando</a>
            </div>
        <?php else: ?>
            <div class="cart-items">
                <?php foreach ($carrito as $carrito_key => $item): ?>
                    <?php if (is_array($item)): ?>
                    <div class="cart-item" data-carrito-key="<?php echo $carrito_key; ?>">
                        <div class="item-image">
                            <?php
                            // Obtener la imagen principal del producto
                            $stmt = $conn->prepare("SELECT url FROM imagenes_producto WHERE producto_id = ? AND orden = 1");
                            $stmt->execute([$item['producto_id']]);
                            $imagen = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <img src="<?php echo htmlspecialchars($imagen['url'] ?? ''); ?>" alt="<?php echo htmlspecialchars($item['nombre'] ?? ''); ?>">
                        </div>
                        <div class="item-details">
                            <h3><?php echo htmlspecialchars($item['nombre'] ?? ''); ?></h3>
                            <?php if (!empty($item['talla'])): ?>
                            <div class="item-size">
                                <span>Talla: <?php echo htmlspecialchars($item['talla']); ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="item-price">
                                <span class="price"><?php echo number_format($item['precio'] ?? 0, 2, ',', '.'); ?> €</span>
                            </div>
                        </div>
                        <div class="item-quantity">
                            <button class="quantity-btn minus" onclick="actualizarCantidad('<?php echo $carrito_key; ?>', <?php echo ($item['cantidad'] ?? 1) - 1; ?>)">-</button>
                            <input type="number" value="<?php echo $item['cantidad'] ?? 1; ?>" min="1" max="99" onchange="actualizarCantidad('<?php echo $carrito_key; ?>', this.value)">
                            <button class="quantity-btn plus" onclick="actualizarCantidad('<?php echo $carrito_key; ?>', <?php echo ($item['cantidad'] ?? 1) + 1; ?>)">+</button>
                        </div>
                        <div class="item-total">
                            <?php echo number_format(($item['precio'] ?? 0) * ($item['cantidad'] ?? 1), 2, ',', '.'); ?> €
                        </div>
                        <button class="remove-item" onclick="eliminarDelCarrito('<?php echo $carrito_key; ?>')">×</button>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span><?php echo number_format($total, 2, ',', '.'); ?> €</span>
                </div>
                <div class="summary-row">
                    <span>Envío:</span>
                    <span>Gratis</span>
                </div>
                <div class="summary-row total">
                    <span>Total:</span>
                    <span><?php echo number_format($total, 2, ',', '.'); ?> €</span>
                </div>
                <a href="checkout.php" class="checkout-btn">Proceder al pago</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
    function actualizarCantidad(carritoKey, cantidad) {
        fetch('ajax/actualizar_carrito.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'carrito_key=' + carritoKey + '&cantidad=' + cantidad
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al actualizar el carrito');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al actualizar el carrito');
        });
    }

    function eliminarDelCarrito(carritoKey) {
        if (confirm('¿Estás seguro de que quieres eliminar este producto del carrito?')) {
            fetch('ajax/eliminar_del_carrito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'carrito_key=' + carritoKey
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al eliminar el producto del carrito');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar el producto del carrito');
            });
        }
    }
    </script>
</body>
</html> 