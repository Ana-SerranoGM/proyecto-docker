<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sean the Label</title>
    <link rel="icon" type="image/x-icon" href="img/icon.jpeg">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="nav-container">
        <div class="nav-left">
            <a href="index.html">Tienda</a>
            <a href="about.html">Acerca de</a>
            <a href="contacto.html">Contacto</a>
        </div>
        <div class="nav-center">
            <a href="/" class="logo">Sean the Label</a>
        </div>
        <div class="nav-right">
            <a href="/login">Login</a>
            <a href="/registro">Registro</a>
            <a href="/carrito" class="cart-icon">
                <span>🛒</span>
                <span class="cart-count">0</span>
            </a>
        </div>
    </nav>

    <div class="split-container">
        <div class="left-image">
            <img src="img/2067601.jpg" alt="Modelo con jeans">
        </div>
        <a href="productos.php" class="ver-productos">Ver Productos</a>
        <div class="right-image">
            <img src="img/1823873.jpg" alt="Textura de jean">
        </div>
    </div>

    <script>
        // Script para el efecto hover de las imágenes
        document.querySelectorAll('.product-image').forEach(image => {
            const mainImg = image.querySelector('.image-main');
            const hoverImg = image.querySelector('.image-hover');
            
            image.addEventListener('mouseenter', () => {
                mainImg.style.opacity = '0';
                hoverImg.style.opacity = '1';
            });
            
            image.addEventListener('mouseleave', () => {
                mainImg.style.opacity = '1';
                hoverImg.style.opacity = '0';
            });
        });
    </script>

    <!-- Pie de página -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <div class="footer-links">
                    <a href="envio-devoluciones.html">Envío y devoluciones</a>
                    <a href="guia-tallas.html">Guía de tallas</a>
                    <a href="faq.html">Preguntas frecuentes</a>
                    <a href="about.html">Acerca de</a>
                    <a href="contacto.html">Contacto</a>
                    <a href="privacidad.html">Política de Privacidad</a>
                </div>
                <div class="social-links">
                    <a href="https://instagram.com/seenthelabel" target="_blank">Instagram</a>
                    <a href="https://twitter.com/seenthelabel" target="_blank">Twitter</a>
                    <a href="https://youtube.com/seenthelabel" target="_blank">Youtube</a>
                </div>
            </div>
            <div class="footer-section">
                <div class="newsletter">
                    <h3>Regístrate para recibir noticias y actualizaciones.</h3>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Email Address">
                        <button type="submit">Registrarse</button>
                    </form>
                </div>
            </div>
            <div class="footer-copyright">
                SEEN THE LABEL 2024
            </div>
        </div>
    </footer>
</body>
</html>
    
    