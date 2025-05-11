<?php
require_once 'config/database.php';

// Verificar la codificación actual
$stmt = $conn->query("SHOW VARIABLES LIKE 'character_set%'");
echo "Configuración actual de caracteres:\n";
while ($row = $stmt->fetch()) {
    echo $row['Variable_name'] . ": " . $row['Value'] . "\n";
}

// Corregir la codificación de la base de datos
$conn->exec("ALTER DATABASE seendb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

// Corregir la codificación de las tablas
$tables = $conn->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
foreach ($tables as $table) {
    $conn->exec("ALTER TABLE $table CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
}

// Verificar los datos
$stmt = $conn->query("SELECT * FROM productos");
echo "\nDatos de productos:\n";
while ($row = $stmt->fetch()) {
    echo $row['nombre'] . "\n";
}

echo "\nProceso completado.\n"; 