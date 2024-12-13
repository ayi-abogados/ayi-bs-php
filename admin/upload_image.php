<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    die(json_encode(['success' => false, 'error' => 'No autenticado']));
}

// Verificar si se subió un archivo
if (!isset($_FILES['upload']) || $_FILES['upload']['error'] !== UPLOAD_ERR_OK) {
    die(json_encode(['uploaded' => 0, 'error' => ['message' => 'Error al subir el archivo']]));
}

$file = $_FILES['upload'];
$fileName = $file['name'];
$fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

// Verificar que sea una imagen
$allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($fileType, $allowedTypes)) {
    die(json_encode(['uploaded' => 0, 'error' => ['message' => 'Tipo de archivo no permitido']]));
}

// Generar nombre único para el archivo
$newFileName = uniqid() . '.' . $fileType;
$uploadDir = '../assets/img/uploads/';

// Crear directorio si no existe
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$targetPath = $uploadDir . $newFileName;

// Mover el archivo
if (move_uploaded_file($file['tmp_name'], $targetPath)) {
    // Devolver la URL de la imagen para CKEditor
    $imageUrl = '/ayi-bs/assets/img/uploads/' . $newFileName;
    echo json_encode([
        'uploaded' => 1,
        'fileName' => $newFileName,
        'url' => $imageUrl
    ]);
} else {
    echo json_encode([
        'uploaded' => 0,
        'error' => ['message' => 'Error al guardar el archivo']
    ]);
}
?>
