<?php
$files = glob('productos/*.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Replace session_start with requires
    $content = preg_replace('/<\?php\s*session_start\(\);\s*\?>/', 
        "<?php\nrequire_once '../config/database.php';\nrequire_once '../includes/carrito.php';\n?>", 
        $content);
    
    // Replace SEEN THE LABEL with Seen the Label in title
    $content = preg_replace('/<title>.*?SEEN THE LABEL<\/title>/', 
        '<title>' . basename($file, '.php') . ' - Seen the Label</title>', 
        $content);
    
    // Replace productos.css with producto.css
    $content = str_replace('productos.css', 'producto.css', $content);
    
    // Replace navigation bar with header include
    $content = preg_replace('/<!-- Barra de navegación -->.*?<\/nav>/s', 
        "    <?php include '../includes/header.php'; ?>\n", 
        $content);
    
    // Update links from .html to .php
    $content = str_replace('.html', '.php', $content);
    
    file_put_contents($file, $content);
    echo "Updated $file\n";
} 