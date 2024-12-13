<?php
require_once "config/database.php";

// Establecer la codificación de caracteres
mysqli_set_charset($conn, "utf8mb4");

// Consultar el contenido actual
$stmt = $conn->prepare("SELECT content FROM pages WHERE slug = 'index'");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Mostrar una parte específica del contenido para debug
$content = $row['content'];

// Buscar específicamente los enlaces del botón Acerca
preg_match_all('/<a href="([^"]*)" class="btn-get-started">Acerca<\/a>/', $content, $matches);

echo "<h2>Enlaces encontrados:</h2>";
echo "<pre>";
print_r($matches[1]); // Mostrará todos los href encontrados
echo "</pre>";

// También mostrar una parte del contenido alrededor de estos enlaces
echo "<h2>Contexto de los enlaces:</h2>";
$lines = explode("\n", $content);
foreach ($lines as $i => $line) {
    if (strpos($line, 'btn-get-started') !== false) {
        echo "<h3>Línea " . ($i + 1) . ":</h3>";
        echo "<pre>";
        // Mostrar 5 líneas antes y después para contexto
        for ($j = max(0, $i - 5); $j < min(count($lines), $i + 6); $j++) {
            echo htmlspecialchars($lines[$j]) . "\n";
        }
        echo "</pre>";
    }
}
?>
