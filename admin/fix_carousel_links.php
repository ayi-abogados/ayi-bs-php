<?php
require_once "config/database.php";

// Establecer la codificación de caracteres
mysqli_set_charset($conn, "utf8mb4");

// Obtener el contenido actual
$stmt = $conn->prepare("SELECT content FROM pages WHERE slug = 'index'");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Error: No se encontró el contenido en la base de datos");
}

$content = $row['content'];

// Reemplazar los enlaces en el carrusel
$content = preg_replace(
    '/<a href="#[^"]*" class="btn-get-started">.*?<\/a>/',
    '<a href="#services-divider" class="btn-get-started">Conocer Más</a>',
    $content
);

// Actualizar el contenido en la base de datos
$stmt = $conn->prepare("UPDATE pages SET content = ? WHERE slug = 'index'");
$stmt->bind_param("s", $content);

if ($stmt->execute()) {
    echo "Enlaces actualizados correctamente";
} else {
    echo "Error al actualizar los enlaces: " . $conn->error;
}
