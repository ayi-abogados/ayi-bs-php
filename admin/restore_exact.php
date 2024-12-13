<?php
require_once "config/database.php";

// Establecer la codificación de caracteres
mysqli_set_charset($conn, "utf8mb4");

// Leer el archivo index.html original
$htmlContent = file_get_contents('../index.html');

// Extraer el contenido entre las etiquetas main de manera más precisa
if (!preg_match('/<main class="main">\s*(.*?)\s*<\/main>/s', $htmlContent, $matches)) {
    die("Error: No se pudo encontrar el contenido main en index.html");
}

// Obtener el contenido exacto, preservando espacios y estructura
$mainContent = $matches[1];

// Limpiar la tabla primero
$conn->query("DELETE FROM pages WHERE slug = 'index'");

// Insertar el contenido original en la base de datos
$stmt = $conn->prepare("INSERT INTO pages (slug, content) VALUES ('index', ?)");
$stmt->bind_param("s", $mainContent);

if ($stmt->execute()) {
    echo "Contenido original restaurado exitosamente.<br>";
    
    // Verificar el contenido restaurado
    $stmt = $conn->prepare("SELECT content FROM pages WHERE slug = 'index'");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {
        echo "<h3>Contenido restaurado correctamente</h3>";
        echo "<p>Longitud del contenido: " . strlen($row['content']) . " caracteres</p>";
        
        // Verificar la estructura
        echo "<h4>Primeras 200 caracteres del contenido:</h4>";
        echo "<pre>" . htmlspecialchars(substr($row['content'], 0, 200)) . "...</pre>";
    }
} else {
    echo "Error al restaurar el contenido: " . $conn->error;
}
?>
