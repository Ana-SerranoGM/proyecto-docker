<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acerca de - Seen the Label</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/about.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Cabecera -->
    <nav class="nav-container">
        <div class="nav-left">
            <a href="index.php">Tienda</a>
            <a href="about.php">Acerca de</a>
            <a href="contacto.php">Contacto</a>
        </div>
        <div class="nav-center">
            <a href="/" class="logo">Seen the Label</a>
        </div>
        <div class="nav-right">
            <a href="login.php">Login</a>
            <a href="registro.php">Registro</a>
            <a href="carrito.php" class="cart-icon">
                <span>🛒</span>
                <span class="cart-count">0</span>
            </a>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="about-container">
        <section class="about-section">
            <h1 class="about-title">FUNDADA en SILVERLAKE, CA. 2016.</h1>
            <p class="about-description">
                SEEN es una compañía estadounidense de moda que se especializa en la fabricación y el diseño de alta calidad.
            </p>
            <p class="about-description">
                Nos inspiramos en la estética de la ropa deportiva y en los deportistas que admirábamos cuando éramos niños para crear nuestros productos. El resultado es una interpretación única de las prendas masculinas esenciales con una mezcla de toques técnicos y exclusivas combinaciones de telas.
            </p>
        </section>

        <section class="about-section">
            <h2 class="about-subtitle">SEENTHELABEL</h2>
            <p class="about-description">
                Todos los artículos están hechos en la ciudad de Los Ángeles e inspirados en ella.
            </p>
        </section>

        <section class="social-section">
            <h3 class="social-title">SÍGUENOS EN INSTAGRAM</h3>
            <div class="social-links">
                <a href="https://instagram.com/seenthelabel" target="_blank" class="social-link">Instagram</a>
                <a href="https://twitter.com/seenthelabel" target="_blank" class="social-link">Twitter</a>
                <a href="https://youtube.com/seenthelabel" target="_blank" class="social-link">Youtube</a>
            </div>
        </section>

        <section class="newsletter-section">
            <h3 class="newsletter-title">Regístrate para recibir noticias y actualizaciones.</h3>
            <form class="newsletter-form">
                <input type="email" placeholder="Email Address" class="newsletter-input">
                <button type="submit" class="newsletter-button">Registrarse</button>
            </form>
        </section>
    </main>

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
                </div>
                <div class="footer-links">
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
            <div class="footer-copyright">
                SEEN THE LABEL 2024
            </div>
        </div>
    </footer>
</body>
</html> 