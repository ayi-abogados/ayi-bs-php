<?php
require_once "config/database.php";

// Establecer la codificación de caracteres
mysqli_set_charset($conn, "utf8mb4");

// Obtener el contenido de la base de datos
$stmt = $conn->prepare("SELECT content FROM pages WHERE slug = 'index'");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$dynamicContent = $row['content'];

// Obtener el template
$htmlTemplate = file_get_contents('../index.html');

echo "<h2>1. Enlaces en el contenido de la base de datos (sin procesar):</h2>";
preg_match_all('/<a href="([^"]*)" class="btn-get-started">Acerca<\/a>/', $dynamicContent, $matches);
echo "<pre>";
print_r($matches[1]);
echo "</pre>";

// Simular el proceso de index.php
$doc = new DOMDocument();
$doc->encoding = 'UTF-8';
@$doc->loadHTML('<?xml encoding="UTF-8">' . $htmlTemplate, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

// Encontrar el contenedor main
$xpath = new DOMXPath($doc);
$mains = $xpath->query("//main[@class='main']");

if ($mains->length > 0) {
    $mainElement = $mains->item(0);
    
    // Crear un DOM temporal para el nuevo contenido
    $tempDoc = new DOMDocument();
    $tempDoc->encoding = 'UTF-8';
    @$tempDoc->loadHTML('<?xml encoding="UTF-8">' . $dynamicContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    
    // Importar el nuevo contenido al documento principal
    $newNode = $doc->importNode($tempDoc->getElementsByTagName('main')->item(0), true);
    
    // Reemplazar el contenido
    $mainElement->parentNode->replaceChild($newNode, $mainElement);
    
    // Obtener el HTML resultante
    $finalHtml = $doc->saveHTML();
    
    echo "<h2>2. Enlaces después del proceso DOM:</h2>";
    preg_match_all('/<a href="([^"]*)" class="btn-get-started">Acerca<\/a>/', $finalHtml, $matches);
    echo "<pre>";
    print_r($matches[1]);
    echo "</pre>";
}

?>
