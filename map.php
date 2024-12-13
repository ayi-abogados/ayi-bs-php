<?php
session_start();
require_once "admin/config/database.php";

// Establecer la codificación de caracteres
mysqli_set_charset($conn, "utf8mb4");

// Obtener el contenido de la base de datos
$stmt = $conn->prepare("SELECT content FROM pages WHERE slug = 'map'");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Error: No se encontró el contenido en la base de datos");
}

$dynamicContent = $row['content'];

// Verificar que el contenido no esté vacío
if (empty($dynamicContent)) {
    die("Error: El contenido está vacío");
}

// Obtener el template HTML
$htmlTemplate = file_get_contents('map.html');

// Incluir el código del enlace admin
require_once 'includes/admin_link.php';

// Agregar los estilos
$htmlTemplate = str_replace('</head>', $style . '</head>', $htmlTemplate);

// Insertar el enlace después de Contacto
$htmlTemplate = preg_replace(
    '/(<li><a href="contact\.php">Contacto<\/a><\/li>)/',
    '$1' . "\n              " . $dashboardLink,
    $htmlTemplate
);

// Insertar los modales antes del cierre del body
$htmlTemplate = str_replace('</body>', $modalHtml . '</body>', $htmlTemplate);

// Buscar el contenedor main y reemplazar su contenido
if (preg_match('/<main class="main">(.*?)<\/main>/s', $htmlTemplate, $matches)) {
    $newContent = '<main class="main">' . $dynamicContent . '</main>';
    $htmlTemplate = str_replace($matches[0], $newContent, $htmlTemplate);
}

// Imprimir el HTML final
echo $htmlTemplate;
?>
