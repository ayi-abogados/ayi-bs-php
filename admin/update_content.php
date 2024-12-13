<?php
require_once "config/database.php";

// Establecer la codificación de caracteres
mysqli_set_charset($conn, "utf8mb4");

// Verificar que se recibieron los datos
if (!isset($_POST['content']) || !isset($_POST['slug'])) {
    die(json_encode([
        'success' => false,
        'message' => 'No se recibieron los datos necesarios'
    ]));
}

$content = $_POST['content'];
$slug = $_POST['slug'];

// Preparar la consulta de actualización
$stmt = $conn->prepare("UPDATE pages SET content = ? WHERE slug = ?");
$stmt->bind_param("ss", $content, $slug);

// Ejecutar la actualización
if ($stmt->execute()) {
    // Verificar que se actualizó el registro
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Contenido actualizado exitosamente',
            'content' => $content
        ]);
    } else {
        // Si no existe, lo insertamos
        $stmt = $conn->prepare("INSERT INTO pages (slug, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $slug, $content);
        
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Contenido creado exitosamente',
                'content' => $content
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al crear el contenido: ' . $conn->error
            ]);
        }
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al actualizar el contenido: ' . $conn->error
    ]);
}
?>
