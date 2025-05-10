<?php
require_once 'config/database.php';

// Obtener todos los productos con sus imágenes principal y secundaria
$stmt = $conn->query("SELECT p.*, 
                     i1.url as imagen_principal,
                     i2.url as imagen_secundaria
                     FROM productos p 
                     LEFT JOIN imagenes_producto i1 ON p.id = i1.producto_id AND i1.orden = 1
                     LEFT JOIN imagenes_producto i2 ON p.id = i2.producto_id AND i2.orden = 2
                     ORDER BY p.fecha_creacion DESC");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Seen the Label</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/productos.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Contenido principal -->
    <div class="products-grid">
        <?php foreach ($productos as $producto): ?>
        <article class="product">
            <a href="producto.php?id=<?php echo $producto['id']; ?>" class="product-link">
                <div class="product-image">
                    <img src="<?php echo htmlspecialchars($producto['imagen_principal']); ?>" 
                         alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                         class="image-main">
                    <?php if ($producto['imagen_secundaria']): ?>
                    <img src="<?php echo htmlspecialchars($producto['imagen_secundaria']); ?>" 
                         alt="<?php echo htmlspecialchars($producto['nombre']); ?> - Vista trasera" 
                         class="image-hover">
                    <?php endif; ?>
                </div>
                <div class="product-info">
                    <h2 class="product-title"><?php echo htmlspecialchars($producto['nombre']); ?></h2>
                    <div class="price-container">
                        <span class="current-price"><?php echo number_format($producto['precio'], 2, ',', '.'); ?> €</span>
                    </div>
                </div>
            </a>
        </article>
        <?php endforeach; ?>
    </div>

    <script src="js/carrito.js"></script>
</body>
</html> 