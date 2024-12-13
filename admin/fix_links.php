<?php
require_once "config/database.php";

// Establecer la codificación de caracteres
mysqli_set_charset($conn, "utf8mb4");

// Obtener el contenido actual
$stmt = $conn->prepare("SELECT content FROM pages WHERE slug = 'index'");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$content = $row['content'];

// Reemplazar los enlaces directamente
$content = preg_replace(
    '/<a href="#featured-services" class="btn-get-started">Acerca<\/a>/',
    '<a href="#services" class="btn-get-started">Acerca</a>',
    $content
);

// Actualizar en la base de datos
$stmt = $conn->prepare("UPDATE pages SET content = ? WHERE slug = 'index'");
$stmt->bind_param("s", $content);

if ($stmt->execute()) {
    echo "Enlaces actualizados exitosamente";
} else {
    echo "Error al actualizar los enlaces: " . $conn->error;
}

// Mostrar los enlaces actualizados
preg_match_all('/<a href="([^"]*)" class="btn-get-started">Acerca<\/a>/', $content, $matches);
echo "<pre>";
print_r($matches[1]);
echo "</pre>";
?>
