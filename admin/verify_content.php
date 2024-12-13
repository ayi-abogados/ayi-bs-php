<?php
require_once "config/database.php";

// Establecer la codificación de caracteres
mysqli_set_charset($conn, "utf8mb4");

// 1. Verificar el contenido en la base de datos
$stmt = $conn->prepare("SELECT content FROM pages WHERE slug = 'index'");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo "<h2>1. Contenido en la base de datos:</h2>";
echo "<pre>";
// Mostrar solo la parte relevante del contenido
preg_match_all('/<a href="([^"]*)" class="btn-get-started">Acerca<\/a>/', $row['content'], $matches);
print_r($matches[1]);
echo "</pre>";

// 2. Simular el proceso de index.php
$htmlTemplate = file_get_contents('../index.html');
$pattern = '/<main class="main">.*?<\/main>/s';
$newTemplate = preg_replace($pattern, $row['content'], $htmlTemplate);

echo "<h2>2. Contenido después del reemplazo:</h2>";
echo "<pre>";
preg_match_all('/<a href="([^"]*)" class="btn-get-started">Acerca<\/a>/', $newTemplate, $matches);
print_r($matches[1]);
echo "</pre>";

// 3. Verificar la codificación
echo "<h2>3. Información de codificación:</h2>";
echo "Codificación de la conexión: " . $conn->character_set_name() . "<br>";
echo "Collation de la conexión: " . $conn->get_charset()->collation . "<br>";

// 4. Mostrar la consulta SQL directa
echo "<h2>4. Consulta SQL directa:</h2>";
$result = $conn->query("SELECT HEX(content) as hex_content FROM pages WHERE slug = 'index'");
$row = $result->fetch_assoc();
echo "<pre>";
// Mostrar solo una parte del contenido hexadecimal para no saturar la pantalla
echo substr($row['hex_content'], 0, 200) . "...";
echo "</pre>";

// 5. Verificar si hay múltiples registros
echo "<h2>5. Número de registros en la tabla:</h2>";
$result = $conn->query("SELECT COUNT(*) as count, slug FROM pages GROUP BY slug");
echo "<pre>";
while ($row = $result->fetch_assoc()) {
    print_r($row);
}
echo "</pre>";
?>
