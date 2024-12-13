<?php
session_start();
require_once "config/database.php";

// Log de inicio
error_log("Iniciando save_page.php");

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    error_log("Usuario no autorizado");
    die(json_encode(['success' => false, 'message' => 'No autorizado']));
}

if (!isset($_POST['content']) || !isset($_POST['slug'])) {
    error_log("Faltan datos: content=" . isset($_POST['content']) . ", slug=" . isset($_POST['slug']));
    die(json_encode(['success' => false, 'message' => 'Datos incompletos']));
}

$content = $_POST['content'];
$slug = $_POST['slug'];

error_log("Intentando guardar para slug: " . $slug);

$stmt = $conn->prepare("UPDATE pages SET content = ? WHERE slug = ?");
$stmt->bind_param("ss", $content, $slug);

if ($stmt->execute()) {
    error_log("Guardado exitoso para slug: " . $slug);
    echo json_encode(['success' => true]);
} else {
    error_log("Error al guardar: " . $conn->error);
    echo json_encode(['success' => false, 'message' => 'Error al guardar: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>
