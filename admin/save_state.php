<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    die(json_encode(['success' => false, 'error' => 'No autenticado']));
}

require_once "config/database.php";

// Obtener los datos del POST
$data = json_decode(file_get_contents('php://input'), true);
$lastPage = $data['last_page'];
$userId = $_SESSION["id"];

// Actualizar o insertar el estado
$stmt = $conn->prepare("INSERT INTO user_state (user_id, last_page) VALUES (?, ?) ON DUPLICATE KEY UPDATE last_page = ?");
$stmt->bind_param("iss", $userId, $lastPage, $lastPage);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
?>
