<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/database.php';
require_once 'includes/carrito.php';

// Verificar si hay productos en el carrito
$carrito = obtenerCarrito();
if (empty($carrito)) {
    header('Location: carrito.php');
    exit;
}

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: checkout.php');
    exit;
}

// Obtener datos del formulario
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$telefono = htmlspecialchars($_POST['telefono'] ?? '', ENT_QUOTES, 'UTF-8');
$nombre = htmlspecialchars($_POST['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
$apellidos = htmlspecialchars($_POST['apellidos'] ?? '', ENT_QUOTES, 'UTF-8');
$direccion = htmlspecialchars($_POST['direccion'] ?? '', ENT_QUOTES, 'UTF-8');
$codigo_postal = htmlspecialchars($_POST['codigo_postal'] ?? '', ENT_QUOTES, 'UTF-8');
$ciudad = htmlspecialchars($_POST['ciudad'] ?? '', ENT_QUOTES, 'UTF-8');
$provincia = htmlspecialchars($_POST['provincia'] ?? '', ENT_QUOTES, 'UTF-8');
$metodo_pago = htmlspecialchars($_POST['metodo_pago'] ?? '', ENT_QUOTES, 'UTF-8');

// Validar datos requeridos
if (!$email || !$telefono || !$nombre || !$apellidos || !$direccion || !$codigo_postal || !$ciudad || !$provincia || !$metodo_pago) {
    header('Location: checkout.php?error=datos_incompletos');
    exit;
}

// Simular procesamiento del pago
$pago_exitoso = true;
$numero_pedido = 'PED-' . strtoupper(uniqid());
$total = obtenerTotalCarrito();

// Si el pago es exitoso, vaciar el carrito
if ($pago_exitoso) {
    vaciarCarrito();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado - Seen the Label</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .confirmation-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }

        .confirmation-icon {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 1rem;
        }

        .confirmation-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .confirmation-message {
            color: #666;
            margin-bottom: 2rem;
        }

        .order-details {
            text-align: left;
            margin: 2rem 0;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 4px;
        }

        .order-number {
            font-size: 1.2rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .order-info {
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="confirmation-container">
        <div class="confirmation-icon">✓</div>
        <h1 class="confirmation-title">¡Pedido Confirmado!</h1>
        <p class="confirmation-message">
            Gracias por tu compra. Hemos recibido tu pedido y lo estamos procesando.
        </p>

        <div class="order-details">
            <div class="order-number">
                Número de Pedido: <?php echo htmlspecialchars($numero_pedido); ?>
            </div>
            <div class="order-info">
                <strong>Método de Pago:</strong> 
                <?php echo $metodo_pago === 'tarjeta' ? 'Tarjeta de Crédito/Débito' : 'PayPal'; ?>
            </div>
            <div class="order-info">
                <strong>Total:</strong> 
                <?php echo number_format($total, 2, ',', '.'); ?> €
            </div>
            <div class="order-info">
                <strong>Dirección de Envío:</strong><br>
                <?php echo htmlspecialchars($nombre . ' ' . $apellidos); ?><br>
                <?php echo htmlspecialchars($direccion); ?><br>
                <?php echo htmlspecialchars($codigo_postal . ', ' . $ciudad); ?><br>
                <?php echo htmlspecialchars($provincia); ?>
            </div>
        </div>

        <p class="confirmation-message">
            Te enviaremos un correo electrónico con los detalles de tu pedido y el seguimiento cuando esté disponible.
        </p>

        <a href="index.php" class="btn-primary">Volver a la Tienda</a>
    </div>
</body>
</html> 