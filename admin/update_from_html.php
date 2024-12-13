<?php
require_once "config/database.php";

// Establecer la codificación de caracteres
mysqli_set_charset($conn, "utf8mb4");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Leer el contenido del archivo index.html
$htmlFile = '../index.html';
if (!file_exists($htmlFile)) {
    die("Error: No se encuentra el archivo index.html");
}

$htmlContent = file_get_contents($htmlFile);
if ($htmlContent === false) {
    die("Error: No se pudo leer el archivo index.html");
}

echo "Contenido leído del archivo HTML: " . strlen($htmlContent) . " bytes<br>";

// Extraer el contenido dentro del main
if (preg_match('/<main class="main">(.*?)<\/main>/s', $htmlContent, $matches)) {
    $mainContent = $matches[1];
    echo "Contenido extraído del main: " . strlen($mainContent) . " bytes<br>";
    
    // Verificar el contenido actual en la base de datos
    $checkStmt = $conn->prepare("SELECT content FROM pages WHERE slug = 'index'");
    if (!$checkStmt) {
        die("Error en la preparación de la consulta de verificación: " . $conn->error);
    }
    
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $currentRow = $result->fetch_assoc();
    
    if ($currentRow) {
        echo "Contenido actual en la base de datos: " . strlen($currentRow['content']) . " bytes<br>";
        
        // Buscar la línea roja en ambos contenidos
        echo "<br>Línea roja en el archivo index.html:<br>";
        if (preg_match('/<hr[^>]*class="red-line"[^>]*>/', $mainContent, $htmlMatch)) {
            echo htmlspecialchars($htmlMatch[0]) . "<br>";
        }
        
        echo "<br>Línea roja en la base de datos:<br>";
        if (preg_match('/<hr[^>]*class="red-line"[^>]*>/', $currentRow['content'], $dbMatch)) {
            echo htmlspecialchars($dbMatch[0]) . "<br>";
        }
        
        // Forzar la actualización independientemente del contenido
        $forceUpdate = $conn->prepare("UPDATE pages SET content = ? WHERE slug = 'index'");
        if (!$forceUpdate) {
            die("Error en la preparación de la consulta forzada: " . $conn->error);
        }
        
        $forceUpdate->bind_param("s", $mainContent);
        if ($forceUpdate->execute()) {
            echo "<br>Actualización forzada completada<br>";
        } else {
            echo "<br>Error en la actualización forzada: " . $forceUpdate->error . "<br>";
        }
        $forceUpdate->close();
        
    } else {
        echo "No hay contenido actual en la base de datos para 'index'<br>";
    }
    
    $checkStmt->close();
} else {
    echo "No se pudo encontrar el contenido del main en index.html<br>";
    echo "Contenido HTML completo:<br>";
    echo htmlspecialchars(substr($htmlContent, 0, 500)) . "...<br>";
}

$conn->close();
