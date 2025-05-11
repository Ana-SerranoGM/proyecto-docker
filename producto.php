<?php
require_once 'config/database.php';
require_once 'includes/carrito.php';

// Obtener el ID del producto de la URL
$producto_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($producto_id <= 0) {
    header('Location: index.php');
    exit;
}

// Obtener la información del producto
$stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->execute([$producto_id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    header('Location: index.php');
    exit;
}

// Obtener las imágenes del producto
$stmt = $conn->prepare("SELECT * FROM imagenes_producto WHERE producto_id = ? ORDER BY orden");
$stmt->execute([$producto_id]);
$imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener las tallas disponibles si el producto las tiene
$tiene_tallas = false;
$tallas = [];
if ($producto['tiene_tallas']) {
    $tiene_tallas = true;
    $stmt = $conn->prepare("SELECT * FROM tallas_producto WHERE producto_id = ? AND stock > 0");
    $stmt->execute([$producto_id]);
    $tallas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener el número de elementos en el carrito
$carrito = obtenerCarrito();
$total_items = array_sum(array_column($carrito, 'cantidad'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($producto['nombre']); ?> - Seen the Label</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/producto.css">
    <style>
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .toast {
            background: #333;
            color: white;
            padding: 1rem 2rem;
            border-radius: 4px;
            margin-top: 10px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Contenedor para los toast messages -->
    <div class="toast-container" id="toastContainer"></div>

    <div style="max-width:1200px;margin:2rem auto 0 auto;padding:0 1rem;">
        <a href="productos.php" class="btn-secondary" style="display:inline-block;margin-bottom:2rem;">← Volver al listado de productos</a>
    </div>

    <div class="product-container">
        <div class="product-gallery">
            <img src="<?php echo htmlspecialchars($imagenes[0]['url']); ?>" 
                 alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                 id="main-image" 
                 class="main-image">
            <div class="thumbnails">
                <?php foreach ($imagenes as $index => $imagen): ?>
                <img src="<?php echo htmlspecialchars($imagen['url']); ?>" 
                     alt="<?php echo htmlspecialchars($producto['nombre'] . ' ' . ($index + 1)); ?>" 
                     class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>">
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="product-info">
            <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>
            <p class="price"><?php echo number_format($producto['precio'], 2, ',', '.'); ?> €</p>
            <p class="description">
                <?php echo htmlspecialchars($producto['descripcion']); ?>
            </p>
            
            <?php if ($tiene_tallas): ?>
            <div class="size-selector">
                <label for="talla">Talla:</label>
                <select id="talla" name="talla" required>
                    <option value="">Selecciona una talla</option>
                    <?php foreach ($tallas as $talla): ?>
                    <option value="<?php echo htmlspecialchars($talla['talla']); ?>">
                        <?php echo htmlspecialchars($talla['talla']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            
            <div class="quantity-selector">
                <label for="cantidad">Cantidad:</label>
                <input type="number" id="cantidad" name="cantidad" value="1" min="1" max="99">
            </div>
            
            <button class="add-to-cart" onclick="agregarAlCarrito(<?php echo $producto_id; ?><?php echo $tiene_tallas ? ', document.getElementById(\'talla\').value' : ''; ?>)">
                Añadir al carrito
            </button>
            
            <div id="loader" class="loader" style="display: none;">
                <div class="spinner"></div>
            </div>
        </div>
    </div>

    <script src="js/carrito.js"></script>
    <script>
        // Galería de imágenes
        const thumbnails = document.querySelectorAll('.thumbnail');
        const mainImage = document.getElementById('main-image');

        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', () => {
                thumbnails.forEach(t => t.classList.remove('active'));
                thumbnail.classList.add('active');
                mainImage.src = thumbnail.src;
                mainImage.alt = thumbnail.alt;
            });
        });

        // Actualizar el contador del carrito
        document.addEventListener('DOMContentLoaded', function() {
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                cartCount.textContent = '<?php echo $total_items; ?>';
            }
        });

        function mostrarToast(mensaje) {
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.textContent = mensaje;
            document.getElementById('toastContainer').appendChild(toast);
            
            // Forzar un reflow para que la animación funcione
            toast.offsetHeight;
            
            // Mostrar el toast
            toast.classList.add('show');
            
            // Ocultar y eliminar después de 3 segundos
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html> 