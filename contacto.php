<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Seen the Label</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/contacto.css">
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
            <a href="index.html" class="logo">Seen the Label</a>
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
    <main class="contact-container">
        <section class="contact-section">
            <h1 class="contact-title">Contáctanos</h1>
            
            <div class="contact-form-container">
                <form class="contact-form">
                    <div class="form-group">
                        <label for="nombre">Nombre completo</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="asunto">Asunto</label>
                        <select id="asunto" name="asunto" required>
                            <option value="">Selecciona un asunto</option>
                            <option value="consulta">Consulta general</option>
                            <option value="ventas">Ventas</option>
                            <option value="prensa">Prensa</option>
                            <option value="devolucion">Devolución</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" rows="5" required></textarea>
                    </div>
                    
                    <button type="submit" class="submit-button">Enviar mensaje</button>
                </form>
            </div>

            <div class="contact-info">
                <div class="contact-group">
                    <h2 class="contact-subtitle">Consultas generales</h2>
                    <a href="mailto:info@seenthelabel.com" class="contact-email">info@seenthelabel.com</a>
                </div>

                <div class="contact-group">
                    <h2 class="contact-subtitle">Ventas</h2>
                    <a href="mailto:ventas@seenthelabel.com" class="contact-email">ventas@seenthelabel.com</a>
                </div>

                <div class="contact-group">
                    <h2 class="contact-subtitle">Prensa</h2>
                    <a href="mailto:prensa@seenthelabel.com" class="contact-email">prensa@seenthelabel.com</a>
                </div>
            </div>
        </section>

        <section class="social-section">
            <h3 class="social-title">SÍGUENOS EN REDES SOCIALES</h3>
            <div class="social-links">
                <a href="https://instagram.com/seenthelabel" target="_blank" class="social-link">
                    <i class="fab fa-instagram"></i>
                    <span>Instagram</span>
                </a>
                <a href="https://twitter.com/seenthelabel" target="_blank" class="social-link">
                    <i class="fab fa-twitter"></i>
                    <span>Twitter</span>
                </a>
                <a href="https://youtube.com/seenthelabel" target="_blank" class="social-link">
                    <i class="fab fa-youtube"></i>
                    <span>Youtube</span>
                </a>
            </div>
        </section>

        <section class="newsletter-section">
            <h3 class="newsletter-title">Regístrate para recibir noticias y actualizaciones</h3>
            <form class="newsletter-form">
                <input type="email" placeholder="Correo electrónico" class="newsletter-input" required>
                <button type="submit" class="newsletter-button">Registrarse</button>
            </form>
        </section>
    </main>

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

    <script src="js/contacto.js"></script>
</body>
</html> 