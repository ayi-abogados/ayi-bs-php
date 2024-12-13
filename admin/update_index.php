<?php
require_once "config/database.php";

// Establecer la codificación de caracteres
mysqli_set_charset($conn, "utf8mb4");

// Leer el contenido del archivo index.html
$content = file_get_contents('../index.html');

// Crear un nuevo DOMDocument
$doc = new DOMDocument();
$doc->encoding = 'UTF-8';
@$doc->loadHTML('<?xml encoding="UTF-8">' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

// Encontrar el contenedor principal (main)
$xpath = new DOMXPath($doc);
$mains = $xpath->query("//main[@class='main']");

if ($mains->length > 0) {
    $mainContent = $doc->saveHTML($mains->item(0));
    
    // Asegurarse de que el contenido está codificado correctamente
    $mainContent = preg_replace('~<?xml encoding="UTF-8">~', '', $mainContent);
    
    // Verificar si ya existe una entrada para index
    $stmt = $conn->prepare("SELECT id FROM pages WHERE slug = 'index'");
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Actualizar el contenido existente
        $stmt = $conn->prepare("UPDATE pages SET content = ? WHERE slug = 'index'");
        $stmt->bind_param("s", $mainContent);
    } else {
        // Insertar nuevo contenido
        $stmt = $conn->prepare("INSERT INTO pages (title, content, slug) VALUES ('Inicio', ?, 'index')");
        $stmt->bind_param("s", $mainContent);
    }
    
    if ($stmt->execute()) {
        echo "Contenido de index.html actualizado exitosamente en la base de datos.<br>";
        echo "Longitud del contenido guardado: " . strlen($mainContent) . " bytes<br>";
        echo "<a href='../index.php'>Ver página actualizada</a>";
    } else {
        echo "Error al actualizar el contenido: " . $conn->error;
    }
} else {
    echo "No se encontró el contenedor principal en index.html";
}
?>
