<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    die(json_encode(['success' => false, 'error' => 'No autenticado']));
}

require_once "config/database.php";

if (!isset($_GET['slug'])) {
    die(json_encode(['success' => false, 'error' => 'No se especificó la página']));
}

$slug = $_GET['slug'];

// Definir los títulos exactamente como aparecen en el menú lateral
$titles = [
    'index' => 'Inicio',
    'about' => 'Acerca',
    'services' => 'Servicios',
    'testimonials' => 'Testimonios',
    'faqs' => 'FAQs',
    'contact' => 'Contacto'
];

$stmt = $conn->prepare("SELECT content FROM pages WHERE slug = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'success' => true,
        'title' => $titles[$slug] ?? ucfirst($slug),
        'content' => $row['content']
    ]);
} else {
    // Si la página no existe en la base de datos, intentar leer el archivo directamente
    $filename = "../" . $slug . ".html";
    if (file_exists($filename)) {
        $content = file_get_contents($filename);
        
        // Extraer el contenido principal usando DOMDocument
        $doc = new DOMDocument();
        @$doc->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        // Buscar el contenedor principal según la página
        $mainContent = '';
        
        // Diferentes selectores según la página
        $containers = [
            'main',                  // Intentar primero con la etiqueta main
            'div[class*="main"]',    // Divs que contengan "main" en su clase
            '#main-content',         // ID main-content
            '.main-content',         // Clase main-content
            '#content',              // ID content
            '.content'               // Clase content
        ];
        
        foreach ($containers as $selector) {
            $xpath = new DOMXPath($doc);
            $elements = $xpath->query("//{$selector}");
            if ($elements->length > 0) {
                $mainContent = $doc->saveHTML($elements->item(0));
                break;
            }
        }
        
        if (empty($mainContent)) {
            $mainContent = $content; // Si no se encuentra un contenedor específico, usar todo el contenido
        }
        
        echo json_encode([
            'success' => true,
            'title' => $titles[$slug] ?? ucfirst($slug),
            'content' => $mainContent
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Página no encontrada'
        ]);
    }
}
?>
