<?php
/**
 * Test específico para verificar ${pk} en signin.html
 */

// Cargar el sistema
require_once 'php/autoload.php';

// Crear renderer
$renderer = new BetaRenderer();

try {
    // Renderizar el partial signin.html directamente
    $result = $renderer->render('partials/right/signin.html');

    echo "<h1>Test de ${pk} en signin.html</h1>";

    // Buscar el valor del input hidden
    if (preg_match('/name="submited" value="([^"]*)"/', $result, $matches)) {
        $pkValue = $matches[1];
        echo "<div style='background: #d4edda; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb;'>";
        echo "✅ <strong>Variable ${pk} funcionando correctamente</strong><br>";
        echo "Valor generado: <code>$pkValue</code>";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb;'>";
        echo "❌ <strong>Variable ${pk} NO se está reemplazando</strong>";
        echo "</div>";
    }

    echo "<h2>HTML Generado:</h2>";
    echo "<textarea style='width: 100%; height: 200px;'>" . htmlspecialchars($result) . "</textarea>";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    h1, h2 {
        color: #333;
    }

    textarea {
        font-family: monospace;
    }
</style>
