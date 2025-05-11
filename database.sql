DROP DATABASE IF EXISTS tienda_ropa;
CREATE DATABASE IF NOT EXISTS tienda_ropa;
USE tienda_ropa;

CREATE TABLE productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    tiene_tallas BOOLEAN DEFAULT FALSE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE carrito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

CREATE TABLE imagenes_producto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    producto_id INT NOT NULL,
    url VARCHAR(255) NOT NULL,
    orden INT NOT NULL DEFAULT 0,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

CREATE TABLE tallas_producto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    producto_id INT NOT NULL,
    talla VARCHAR(10) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE,
    UNIQUE KEY unique_producto_talla (producto_id, talla)
);

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    direccion TEXT,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    rol ENUM('usuario', 'admin') DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de categorías
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT,
    slug VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    categoria_id INT,
    slug VARCHAR(100) NOT NULL UNIQUE,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de imágenes de productos
CREATE TABLE IF NOT EXISTS imagenes_producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    url VARCHAR(255) NOT NULL,
    orden INT NOT NULL DEFAULT 0,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de tallas
CREATE TABLE IF NOT EXISTS tallas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(10) NOT NULL,
    descripcion VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de relación productos-tallas
CREATE TABLE IF NOT EXISTS producto_tallas (
    producto_id INT NOT NULL,
    talla_id INT NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    PRIMARY KEY (producto_id, talla_id),
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE,
    FOREIGN KEY (talla_id) REFERENCES tallas(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de pedidos
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente', 'procesando', 'enviado', 'entregado') DEFAULT 'pendiente',
    total DECIMAL(10,2) NOT NULL,
    direccion_envio TEXT NOT NULL,
    metodo_pago VARCHAR(50) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de detalles de pedido
CREATE TABLE IF NOT EXISTS detalles_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    talla VARCHAR(10),
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar productos de ejemplo
INSERT INTO productos (nombre, descripcion, precio, tiene_tallas) VALUES
('Camisa Ron', 'Camisa de diseño clásico perfecta para ocasiones formales y casuales.', 59.99, TRUE),
('Camiseta Towne', 'Camiseta casual con un diseño minimalista y cómodo.', 29.99, TRUE),
('Pantalón Patrick', 'Pantalón de corte recto con un diseño versátil y moderno.', 89.99, TRUE),
('Pantalón Guy', 'Pantalón de diseño clásico con un toque contemporáneo.', 79.99, TRUE),
('Chaqueta Barry', 'Chaqueta de diseño elegante con detalles en los bordes.', 149.99, TRUE),
('Chaqueta Heaton', 'Chaqueta de diseño moderno con múltiples bolsillos.', 139.99, TRUE),
('Chaqueta Lloyd', 'Chaqueta versátil perfecta para cualquier ocasión.', 129.99, TRUE),
('Bolso Ryan', 'Bolso de diseño moderno con múltiples compartimentos.', 79.99, FALSE),
('Bufanda Charlie', 'Bufanda de diseño clásico con detalles en los bordes.', 42.99, FALSE),
('Bufanda Dan', 'Bufanda de diseño minimalista con acabados de calidad.', 39.99, FALSE),
('Sombrero Snow', 'Sombrero de diseño clásico con detalles en los bordes.', 49.99, FALSE),
('Sombrero Merv', 'Sombrero de diseño minimalista con acabados de calidad.', 45.99, FALSE),
('Camisa Jude', 'Camisa de diseño moderno con detalles únicos.', 54.99, TRUE),
('Camisa Matthew', 'Camisa casual con un toque elegante.', 49.99, TRUE),
('Camisa Kurt', 'Camisa versátil para cualquier ocasión.', 44.99, TRUE),
('Pantalón Mantis', 'Pantalón de diseño contemporáneo con corte recto.', 84.99, TRUE),
('Pantalón Bob', 'Pantalón casual con un diseño cómodo y moderno.', 74.99, TRUE),
('Pantalón Bailey', 'Pantalón de diseño clásico con un toque moderno.', 69.99, TRUE),
('Chaqueta Ryan', 'Chaqueta de diseño elegante con múltiples detalles.', 159.99, TRUE),
('Zapatillas Dash', 'Zapatillas deportivas con un diseño moderno y cómodo.', 89.99, TRUE),
('Zapatillas Lafayette', 'Zapatillas casuales con un diseño versátil.', 79.99, TRUE),
('Zapatillas Riley', 'Zapatillas deportivas con un diseño minimalista.', 84.99, TRUE),
('Sandalias Chris', 'Sandalias casuales perfectas para el verano.', 49.99, TRUE),
('Cartera Christophe', 'Cartera de diseño elegante con múltiples compartimentos.', 69.99, FALSE),
('Gafas de sol Levon', 'Gafas de sol con un diseño moderno y protección UV.', 89.99, FALSE);

-- Insertar tallas para productos que las tienen
INSERT INTO tallas_producto (producto_id, talla, stock) VALUES
(1, 'S', 10), (1, 'M', 15), (1, 'L', 10), (1, 'XL', 5),
(2, 'S', 10), (2, 'M', 15), (2, 'L', 10), (2, 'XL', 5),
(3, 'S', 10), (3, 'M', 15), (3, 'L', 10), (3, 'XL', 5),
(4, 'S', 10), (4, 'M', 15), (4, 'L', 10), (4, 'XL', 5),
(5, 'S', 10), (5, 'M', 15), (5, 'L', 10), (5, 'XL', 5),
(6, 'S', 10), (6, 'M', 15), (6, 'L', 10), (6, 'XL', 5),
(7, 'S', 10), (7, 'M', 15), (7, 'L', 10), (7, 'XL', 5),
(13, 'S', 10), (13, 'M', 15), (13, 'L', 10), (13, 'XL', 5),
(14, 'S', 10), (14, 'M', 15), (14, 'L', 10), (14, 'XL', 5),
(15, 'S', 10), (15, 'M', 15), (15, 'L', 10), (15, 'XL', 5),
(16, 'S', 10), (16, 'M', 15), (16, 'L', 10), (16, 'XL', 5),
(17, 'S', 10), (17, 'M', 15), (17, 'L', 10), (17, 'XL', 5),
(18, 'S', 10), (18, 'M', 15), (18, 'L', 10), (18, 'XL', 5),
(19, 'S', 10), (19, 'M', 15), (19, 'L', 10), (19, 'XL', 5),
(20, '38', 10), (20, '39', 15), (20, '40', 10), (20, '41', 5), (20, '42', 5), (20, '43', 5),
(21, '38', 10), (21, '39', 15), (21, '40', 10), (21, '41', 5), (21, '42', 5), (21, '43', 5),
(22, '38', 10), (22, '39', 15), (22, '40', 10), (22, '41', 5), (22, '42', 5), (22, '43', 5),
(23, '38', 10), (23, '39', 15), (23, '40', 10), (23, '41', 5), (23, '42', 5), (23, '43', 5);

-- Insertar imágenes de ejemplo
INSERT INTO imagenes_producto (producto_id, url, orden) VALUES
(1, 'img/Ron-Shirt_front.jpg', 1), (1, 'img/Ron-Shirt_back.jpg', 2), (1, 'img/Ron-Shirt_side.jpg', 3), (1, 'img/Ron-Shirt_detail.jpg', 4),
(2, 'img/Towne-Shirt_front.jpg', 1), (2, 'img/Towne-Shirt_back.jpg', 2), (2, 'img/Towne-Shirt_side.jpg', 3), (2, 'img/Towne-Shirt_detail.jpg', 4),
(3, 'img/Patrick-Pant_full.jpg', 1), (3, 'img/Patrick-Pant_back.jpg', 2), (3, 'img/Patrick-Pant_side.jpg', 3), (3, 'img/Patrick-Pant_detail.jpg', 4),
(4, 'img/Guy-Pant_full.jpg', 1), (4, 'img/Guy-Pant_back.jpg', 2), (4, 'img/Guy-Pant_side.jpg', 3), (4, 'img/Guy-Pant_detail.jpg', 4),
(5, 'img/Barry-Jacket_front.jpg', 1), (5, 'img/Barry-Jacket_back.jpg', 2), (5, 'img/Barry-Jacket_side.jpg', 3), (5, 'img/Barry-Jacket_detail.jpg', 4),
(6, 'img/Heaton-Jacket_front.jpg', 1), (6, 'img/Heaton-Jacket_back.jpg', 2), (6, 'img/Heaton-Jacket_side.jpg', 3), (6, 'img/Heaton-Jacket_detail.jpg', 4),
(7, 'img/Lloyd-Jean_front.jpg', 1), (7, 'img/Lloyd-Jean_side.jpg', 2), (7, 'img/Lloyd-Jean_detail.jpg', 3),
(8, 'img/Ryan-Bag_1.jpg', 1), (8, 'img/Ryan-Bag_2.jpg', 2), (8, 'img/Ryan-Bag_3.jpg', 3), (8, 'img/Ryan-Bag_4.jpg', 4),
(9, 'img/Charlie-Scarf_1.jpg', 1), (9, 'img/Charlie-Scarf_2.jpg', 2), (9, 'img/Charlie-Scarf_3.jpg', 3), (9, 'img/Charlie-Scarf_4.jpg', 4),
(10, 'img/Dan-Scarf_1.jpg', 1), (10, 'img/Dan-Scarf_2.jpg', 2), (10, 'img/Dan-Scarf_3.jpg', 3), (10, 'img/Dan-Scarf_4.jpg', 4),
(11, 'img/Snow-Hat_1.jpg', 1), (11, 'img/Snow-Hat_2.jpg', 2), (11, 'img/Snow-Hat_3.jpg', 3), (11, 'img/Snow-Hat_4.jpg', 4),
(12, 'img/Merv-Hat_1.jpg', 1), (12, 'img/Merv-Hat_2.jpg', 2), (12, 'img/Merv-Hat_3.jpg', 3), (12, 'img/Merv-Hat_4.jpg', 4),
(13, 'img/Jude-Shirt_front.jpg', 1), (13, 'img/Jude-Shirt_back.jpg', 2), (13, 'img/Jude-Shirt_side.jpg', 3), (13, 'img/Jude-Shirt_detail.jpg', 4),
(14, 'img/Matthew-Shirt_front.jpg', 1), (14, 'img/Matthew-Shirt_back.jpg', 2), (14, 'img/Matthew-Shirt_side.jpg', 3), (14, 'img/Matthew-Shirt_detail.jpg', 4),
(15, 'img/Kurt-Shirt_front.jpg', 1), (15, 'img/Kurt-Shirt_back.jpg', 2), (15, 'img/Kurt-Shirt_side.jpg', 3), (15, 'img/Kurt-Shirt_detail.jpg', 4),
(16, 'img/Mantis-Pant_full.jpg', 1), (16, 'img/Mantis-Pant_back.jpg', 2), (16, 'img/Mantis-Pant_side.jpg', 3), (16, 'img/Mantis-Pant_detail.jpg', 4),
(17, 'img/Bob-Short_full.jpg', 1), (17, 'img/Bob-Short_back.jpg', 2), (17, 'img/Bob-Short_side.jpg', 3), (17, 'img/Bob-Short_detail.jpg', 4),
(18, 'img/Bailey-Short_full.jpg', 1), (18, 'img/Bailey-Short_back.jpg', 2), (18, 'img/Bailey-Short_side.jpg', 3), (18, 'img/Bailey-Short_detail.jpg', 4),
(19, 'img/Ryan-Jacket_front.jpg', 1), (19, 'img/Ryan-Jacket_back.jpg', 2), (19, 'img/Ryan-Jacket_side.jpg', 3), (19, 'img/Ryan-Jacket_detail.jpg', 4),
(20, 'img/Dash-Sneaker_1.jpg', 1), (20, 'img/Dash-Sneaker_2.jpg', 2), (20, 'img/Dash-Sneaker_3.jpg', 3), (20, 'img/Dash-Sneaker_4.jpg', 4),
(21, 'img/Lafayette-Sneaker_1.jpg', 1), (21, 'img/Lafayette-Sneaker_2.jpg', 2), (21, 'img/Lafayette-Sneaker_3.jpg', 3), (21, 'img/Lafayette-Sneaker_4.jpg', 4),
(22, 'img/Riley-Sneaker_1.jpg', 1), (22, 'img/Riley-Sneaker_2.jpg', 2), (22, 'img/Riley-Sneaker_3.jpg', 3), (22, 'img/Riley-Sneaker_4.jpg', 4),
(23, 'img/Chris-Sandal_1.jpg', 1), (23, 'img/Chris-Sandal_2.jpg', 2), (23, 'img/Chris-Sandal_3.jpg', 3), (23, 'img/Chris-Sandal_4.jpg', 4),
(24, 'img/Christophe-Wallet_1.jpg', 1), (24, 'img/Christophe-Wallet_2.jpg', 2), (24, 'img/Christophe-Wallet_3.jpg', 3), (24, 'img/Christophe-Wallet_4.jpg', 4),
(25, 'img/Levon-Sunglasses_1.jpg', 1), (25, 'img/Levon-Sunglasses_2.jpg', 2), (25, 'img/Levon-Sunglasses_3.jpg', 3), (25, 'img/Levon-Sunglasses_4.jpg', 4);

-- Insertar usuarios de prueba
INSERT INTO usuarios (email, password, nombre, apellidos, rol) VALUES
('admin@iesgrancapitan.org', '$2y$10$o93vMf5fyHaPKE1kByyzwOrGcqzC6/pfRwI5t3lgk.qPsyV6CfOhm', 'Admin', 'Principal', 'admin'),
('ana@iesgrancapitan.org', '$2y$10$o93vMf5fyHaPKE1kByyzwOrGcqzC6/pfRwI5t3lgk.qPsyV6CfOhm', 'Ana', 'Serrano', 'usuario'),
('gonzalo@iesgrancapitan.org', '$2y$10$o93vMf5fyHaPKE1kByyzwOrGcqzC6/pfRwI5t3lgk.qPsyV6CfOhm', 'Gonzalo', 'García', 'usuario'),
('alberto@iesgrancapitan.org', '$2y$10$o93vMf5fyHaPKE1kByyzwOrGcqzC6/pfRwI5t3lgk.qPsyV6CfOhm', 'Alberto', 'García', 'usuario');

-- Insertar pedidos de ejemplo
INSERT INTO pedidos (usuario_id, fecha_creacion, estado, total, direccion_envio, metodo_pago) VALUES
(2, '2024-03-15 10:30:00', 'entregado', 189.98, 'Calle Mayor 123, Córdoba', 'tarjeta'),
(2, '2024-03-20 15:45:00', 'enviado', 149.99, 'Calle Mayor 123, Córdoba', 'paypal'),
(3, '2024-03-18 09:15:00', 'procesando', 79.99, 'Avenida del Río 45, Córdoba', 'tarjeta'),
(4, '2024-03-22 11:20:00', 'pendiente', 129.99, 'Plaza de las Tendillas 7, Córdoba', 'paypal');

-- Insertar detalles de pedidos
INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio, talla) VALUES
-- Pedido 1 (Ana)
(1, 1, 1, 59.99, 'M'),  -- Camisa Ron
(1, 2, 1, 29.99, 'L'),  -- Camiseta Towne
(1, 3, 1, 89.99, 'S'),  -- Pantalón Patrick

-- Pedido 2 (Ana)
(2, 5, 1, 149.99, 'M'), -- Chaqueta Barry

-- Pedido 3 (Gonzalo)
(3, 8, 1, 79.99, NULL), -- Bolso Ryan

-- Pedido 4 (Alberto)
(4, 7, 1, 129.99, 'L'); -- Chaqueta Lloyd

-- Nota: La contraseña para todos los usuarios es '123abcABC' 