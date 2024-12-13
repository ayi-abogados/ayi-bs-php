<?php
require_once "config/database.php";

// Verificar la estructura de la tabla
$result = $conn->query("DESCRIBE pages");
if ($result) {
    echo "Estructura de la tabla 'pages':\n";
    while ($row = $result->fetch_assoc()) {
        print_r($row);
        echo "\n";
    }
} else {
    echo "Error al obtener la estructura de la tabla: " . $conn->error;
}

// Verificar los registros existentes
$result = $conn->query("SELECT * FROM pages");
if ($result) {
    echo "\nRegistros en la tabla 'pages':\n";
    while ($row = $result->fetch_assoc()) {
        print_r($row);
        echo "\n";
    }
} else {
    echo "Error al obtener los registros: " . $conn->error;
}

$conn->close();
?>
