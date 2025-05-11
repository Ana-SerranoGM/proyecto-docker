<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config/database.php';

// Obtener información del usuario
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Por ahora, no obtenemos pedidos hasta que se creen las tablas
$pedidos = [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Seen the Label</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .profile-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .profile-section {
            background: #fff;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .profile-section h2 {
            margin-bottom: 1rem;
            color: #333;
            font-size: 1.2rem;
        }

        .user-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .info-item {
            margin-bottom: 0.5rem;
        }

        .info-label {
            font-weight: 500;
            color: #666;
            font-size: 0.9rem;
        }

        .info-value {
            color: #333;
        }

        .btn-edit {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #000;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9rem;
            transition: background 0.3s ease;
        }

        .btn-edit:hover {
            background: #333;
        }

        @media (max-width: 600px) {
            .user-info {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="profile-container">
        <div class="profile-header">
            <h1>Mi Perfil</h1>
        </div>

        <div class="profile-section">
            <h2>Información Personal</h2>
            <div class="user-info">
                <div class="info-item">
                    <div class="info-label">Nombre</div>
                    <div class="info-value"><?php echo htmlspecialchars($usuario['nombre']); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value"><?php echo htmlspecialchars($usuario['email']); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Teléfono</div>
                    <div class="info-value"><?php echo htmlspecialchars($usuario['telefono'] ?? 'No especificado'); ?></div>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <h2>Pedidos Recientes</h2>
            <div class="tab-pane fade" id="pedidos" role="tabpanel" aria-labelledby="pedidos-tab">
                <h3 class="mb-4">Mis Pedidos</h3>
                <?php
                // Obtener los pedidos del usuario
                $stmt = $conn->prepare("
                    SELECT p.*, 
                           COUNT(dp.id) as total_items,
                           DATE_FORMAT(p.fecha_creacion, '%d/%m/%Y %H:%i') as fecha_formateada
                    FROM pedidos p
                    LEFT JOIN detalles_pedido dp ON p.id = dp.pedido_id
                    WHERE p.usuario_id = :usuario_id
                    GROUP BY p.id
                    ORDER BY p.fecha_creacion DESC
                ");
                $stmt->execute(['usuario_id' => $_SESSION['usuario_id']]);
                $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($pedidos) > 0) {
                    foreach ($pedidos as $pedido) {
                        ?>
                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Pedido #<?php echo $pedido['id']; ?></strong>
                                    <span class="badge bg-<?php 
                                        switch($pedido['estado']) {
                                            case 'pendiente':
                                                echo 'warning';
                                                break;
                                            case 'procesando':
                                                echo 'info';
                                                break;
                                            case 'enviado':
                                                echo 'primary';
                                                break;
                                            case 'entregado':
                                                echo 'success';
                                                break;
                                            default:
                                                echo 'secondary';
                                        }
                                    ?> ms-2">
                                        <?php echo ucfirst($pedido['estado']); ?>
                                    </span>
                                </div>
                                <small class="text-muted"><?php echo $pedido['fecha_formateada']; ?></small>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Total:</strong> <?php echo number_format($pedido['total'], 2); ?>€</p>
                                        <p><strong>Items:</strong> <?php echo $pedido['total_items']; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Método de pago:</strong> <?php echo $pedido['metodo_pago']; ?></p>
                                        <p><strong>Dirección de envío:</strong> <?php echo $pedido['direccion_envio']; ?></p>
                                    </div>
                                </div>
                                <button class="btn btn-outline-primary btn-sm" type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#detalles-<?php echo $pedido['id']; ?>">
                                    Ver detalles
                                </button>
                                <div class="collapse mt-3" id="detalles-<?php echo $pedido['id']; ?>">
                                    <div class="card card-body">
                                        <h6>Productos del pedido:</h6>
                                        <?php
                                        $stmt_detalles = $conn->prepare("
                                            SELECT dp.*, pr.nombre as nombre_producto
                                            FROM detalles_pedido dp
                                            JOIN productos pr ON dp.producto_id = pr.id
                                            WHERE dp.pedido_id = :pedido_id
                                        ");
                                        $stmt_detalles->execute(['pedido_id' => $pedido['id']]);
                                        $detalles = $stmt_detalles->fetchAll(PDO::FETCH_ASSOC);
                                        
                                        foreach ($detalles as $detalle) {
                                            echo "<div class='d-flex justify-content-between align-items-center mb-2'>";
                                            echo "<span>{$detalle['nombre_producto']}";
                                            if ($detalle['talla']) {
                                                echo " (Talla: {$detalle['talla']})";
                                            }
                                            echo "</span>";
                                            echo "<span>{$detalle['cantidad']} x " . number_format($detalle['precio'], 2) . "€</span>";
                                            echo "</div>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div class="alert alert-info">No tienes pedidos realizados.</div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html> 