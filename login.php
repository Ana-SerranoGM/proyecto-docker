<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - SEEN THE LABEL</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 40px;
            background: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .login-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-group label {
            font-size: 14px;
            color: #666;
        }

        .form-group input {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #000;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .forgot-password {
            color: #666;
            text-decoration: none;
        }

        .forgot-password:hover {
            color: #000;
        }

        .login-button {
            padding: 12px;
            background: #000;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .login-button:hover {
            background: #333;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .register-link a {
            color: #000;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .social-login {
            margin-top: 30px;
            text-align: center;
        }

        .social-login p {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }

        .social-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .social-button {
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .social-button:hover {
            border-color: #000;
            background: #f5f5f5;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="nav-container">
        <div class="nav-left">
            <a href="index.php">Tienda</a>
            <a href="about.php">Acerca de</a>
            <a href="contacto.php">Contacto</a>
        </div>
        <div class="nav-center">
            <a href="index.php" class="logo">SEEN THE LABEL</a>
        </div>
        <div class="nav-right">
            <a href="login.php">Iniciar sesión</a>
            <a href="registro.php">Registrarse</a>
            <a href="carrito.php" class="cart-icon">
                🛒
                <span class="cart-count">0</span>
            </a>
        </div>
    </nav>

    <!-- Formulario de login -->
    <div class="login-container">
        <h1 class="login-title">Iniciar sesión</h1>
        <form class="login-form">
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="remember-forgot">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Recordarme</label>
                </div>
                <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
            </div>
            <button type="submit" class="login-button">Iniciar sesión</button>
        </form>
        <div class="register-link">
            ¿No tienes una cuenta? <a href="registro.html">Regístrate</a>
        </div>
        <div class="social-login">
            <p>O inicia sesión con</p>
            <div class="social-buttons">
                <button class="social-button">Google</button>
                <button class="social-button">Facebook</button>
            </div>
        </div>
    </div>

    <!-- Pie de página -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <div class="footer-links">
                    <a href="/envio-devoluciones">Envío y devoluciones</a>
                    <a href="/guia-tallas">Guía de tallas</a>
                    <a href="/faq">Preguntas frecuentes</a>
                    <a href="about.php">Acerca de</a>
                    <a href="contacto.php">Contacto</a>
                    <a href="/privacidad">Política de Privacidad</a>
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

    <script>
        // Validación del formulario
        const loginForm = document.querySelector('.login-form');
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            // Aquí iría la lógica de autenticación
            console.log('Email:', email);
            console.log('Password:', password);
            
            // Redirección temporal (simulada)
            alert('Inicio de sesión exitoso');
            window.location.href = 'index.php';
        });
    </script>
</body>
</html> 