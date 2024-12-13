<?php
// Capturar la salida de index.php
ob_start();
include('../index.php');
$output = ob_get_clean();

// Buscar los enlaces en la salida final
echo "<h2>Enlaces en la salida final:</h2>";
preg_match_all('/<a href="([^"]*)" class="btn-get-started">Acerca<\/a>/', $output, $matches);
echo "<pre>";
print_r($matches[1]);
echo "</pre>";

// Mostrar el contexto alrededor de los enlaces
echo "<h2>Contexto de los enlaces:</h2>";
$lines = explode("\n", $output);
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

// También vamos a verificar si hay algún JavaScript que podría estar modificando los enlaces
echo "<h2>Scripts que podrían afectar los enlaces:</h2>";
preg_match_all('/<script[^>]*>(.*?)<\/script>/s', $output, $scripts);
foreach ($scripts[1] as $script) {
    if (strpos($script, 'btn-get-started') !== false || strpos($script, '#featured-services') !== false) {
        echo "<pre>";
        echo htmlspecialchars($script);
        echo "</pre>";
    }
}
?>
