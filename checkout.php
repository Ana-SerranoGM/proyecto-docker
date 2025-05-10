<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/database.php';
require_once 'includes/carrito.php';

$carrito = obtenerCarrito();
$total = obtenerTotalCarrito();

// Solo redirigir si el carrito está vacío
if (empty($carrito)) {
    header('Location: carrito.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Seen the Label</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/checkout.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="checkout-container">
        <h1>Finalizar Compra</h1>
        
        <div class="checkout-content">
            <!-- Resumen del pedido -->
            <div class="order-summary">
                <h2>Resumen del Pedido</h2>
                <div class="order-items">
                    <?php foreach ($carrito as $item): ?>
                        <div class="order-item">
                            <div class="item-info">
                                <span class="item-name"><?php echo htmlspecialchars($item['nombre']); ?></span>
                                <?php if (!empty($item['talla'])): ?>
                                    <span class="item-size">Talla: <?php echo htmlspecialchars($item['talla']); ?></span>
                                <?php endif; ?>
                                <span class="item-quantity">Cantidad: <?php echo $item['cantidad']; ?></span>
                            </div>
                            <span class="item-price"><?php echo number_format($item['precio'] * $item['cantidad'], 2, ',', '.'); ?> €</span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="order-totals">
                    <div class="total-row">
                        <span>Subtotal:</span>
                        <span><?php echo number_format($total, 2, ',', '.'); ?> €</span>
                    </div>
                    <div class="total-row">
                        <span>Envío:</span>
                        <span>Gratis</span>
                    </div>
                    <div class="total-row final">
                        <span>Total:</span>
                        <span><?php echo number_format($total, 2, ',', '.'); ?> €</span>
                    </div>
                </div>
            </div>

            <!-- Formulario de checkout -->
            <form id="checkout-form" class="checkout-form" action="procesar_pedido.php" method="POST">
                <!-- Información de contacto -->
                <div class="form-section">
                    <h2>Información de Contacto</h2>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono *</label>
                        <input type="tel" id="telefono" name="telefono" required>
                    </div>
                </div>

                <!-- Dirección de envío -->
                <div class="form-section">
                    <h2>Dirección de Envío</h2>
                    <div class="form-group">
                        <label for="nombre">Nombre *</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos *</label>
                        <input type="text" id="apellidos" name="apellidos" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección *</label>
                        <input type="text" id="direccion" name="direccion" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="codigo_postal">Código Postal *</label>
                            <input type="text" id="codigo_postal" name="codigo_postal" required>
                        </div>
                        <div class="form-group">
                            <label for="ciudad">Ciudad *</label>
                            <input type="text" id="ciudad" name="ciudad" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="provincia">Provincia *</label>
                        <input type="text" id="provincia" name="provincia" required>
                    </div>
                </div>

                <!-- Método de pago -->
                <div class="form-section">
                    <h2>Método de Pago</h2>
                    <div class="payment-methods">
                        <div class="payment-method">
                            <input type="radio" id="tarjeta" name="metodo_pago" value="tarjeta" checked>
                            <label for="tarjeta">Tarjeta de Crédito/Débito</label>
                        </div>
                        <div class="payment-method">
                            <input type="radio" id="paypal" name="metodo_pago" value="paypal">
                            <label for="paypal">PayPal</label>
                        </div>
                    </div>

                    <!-- Campos de tarjeta (mostrados por defecto) -->
                    <div id="tarjeta-fields" class="payment-fields">
                        <div class="form-group">
                            <label for="numero_tarjeta">Número de Tarjeta *</label>
                            <input type="text" id="numero_tarjeta" name="numero_tarjeta" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fecha_expiracion">Fecha de Expiración *</label>
                                <input type="text" id="fecha_expiracion" name="fecha_expiracion" placeholder="MM/AA" required>
                            </div>
                            <div class="form-group">
                                <label for="cvv">CVV *</label>
                                <input type="text" id="cvv" name="cvv" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="carrito.php" class="btn-secondary">Volver al Carrito</a>
                    <button type="submit" class="btn-primary">Realizar Pedido</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tarjetaFields = document.getElementById('tarjeta-fields');
        const metodoPagoInputs = document.querySelectorAll('input[name="metodo_pago"]');
        const tarjetaInputs = tarjetaFields.querySelectorAll('input');

        // Función para mostrar/ocultar campos de tarjeta
        function toggleTarjetaFields(show) {
            tarjetaFields.style.display = show ? 'block' : 'none';
            tarjetaInputs.forEach(input => {
                input.required = show;
            });
        }

        // Escuchar cambios en el método de pago
        metodoPagoInputs.forEach(input => {
            input.addEventListener('change', function() {
                toggleTarjetaFields(this.value === 'tarjeta');
            });
        });

        // Formatear número de tarjeta
        const numeroTarjeta = document.getElementById('numero_tarjeta');
        numeroTarjeta.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{4})/g, '$1 ').trim();
            e.target.value = value;
        });

        // Formatear fecha de expiración
        const fechaExpiracion = document.getElementById('fecha_expiracion');
        fechaExpiracion.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.slice(0,2) + '/' + value.slice(2,4);
            }
            e.target.value = value;
        });

        // Formatear CVV
        const cvv = document.getElementById('cvv');
        cvv.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').slice(0,3);
        });
    });
    </script>
</body>
</html> 