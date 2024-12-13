<?php
require_once "config/database.php";

// Establecer la codificación de caracteres
mysqli_set_charset($conn, "utf8mb4");

// Leer el archivo index.html
$htmlContent = file_get_contents('../index.html');

// Extraer el contenido entre las etiquetas main
if (!preg_match('/<main class="main">(.*?)<\/main>/s', $htmlContent, $matches)) {
    die("Error: No se pudo encontrar el contenido main en index.html");
}

// Obtener el contenido exacto
$mainContent = $matches[1];

// Limpiar la tabla primero
$conn->query("DELETE FROM pages WHERE slug = 'index'");

// Insertar el contenido en la base de datos
$stmt = $conn->prepare("INSERT INTO pages (slug, content) VALUES ('index', ?)");
$stmt->bind_param("s", $mainContent);

if ($stmt->execute()) {
    echo "<h3>Contenido restaurado exitosamente</h3>";
    
    // Verificar el contenido
    $stmt = $conn->prepare("SELECT content FROM pages WHERE slug = 'index'");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {
        // Verificar las secciones principales
        preg_match_all('/<section id="([^"]+)"/', $row['content'], $matches);
        
        echo "<h4>Secciones encontradas:</h4>";
        echo "<ul>";
        foreach ($matches[1] as $section) {
            echo "<li>" . htmlspecialchars($section) . "</li>";
        }
        echo "</ul>";
        
        // Verificar los enlaces
        preg_match_all('/<a href="([^"]*)"[^>]*class="btn-get-started"[^>]*>/', $row['content'], $linkMatches);
        echo "<h4>Enlaces de botones encontrados:</h4>";
        echo "<ul>";
        foreach ($linkMatches[1] as $link) {
            echo "<li>" . htmlspecialchars($link) . "</li>";
        }
        echo "</ul>";
        
        echo "<p>Tamaño del contenido: " . strlen($row['content']) . " bytes</p>";
    }
} else {
    echo "Error al restaurar el contenido: " . $conn->error;
}
?>
