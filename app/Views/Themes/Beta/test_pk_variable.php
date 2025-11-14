<?php
/**
 * Test para verificar que la variable ${pk} funciona correctamente
 */

// Cargar el sistema
require_once 'php/autoload.php';

// Crear renderer
$renderer = new BetaRenderer();

// Template de prueba que usa ${pk}
$testTemplate = '
<h3>Test de Variable PK</h3>
<p>Valor de pk: <strong>${pk}</strong></p>
<form>
    <input type="hidden" name="submited" value="${pk}">
    <p>Input hidden value: <code>${pk}</code></p>
</form>
';

// Crear archivo temporal
file_put_contents('php/layouts/test_pk.html', $testTemplate);

try {
    // Renderizar
    $result = $renderer->render('layouts/test_pk.html');

    echo "<h1>Resultado del Test PK</h1>";
    echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
    echo $result;
    echo "</div>";

    echo "<h2>HTML Generado:</h2>";
    echo "<pre>" . htmlspecialchars($result) . "</pre>";

    // Limpiar archivo temporal
    unlink('php/layouts/test_pk.html');

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

    pre {
        background: #f5f5f5;
        padding: 10px;
        overflow-x: auto;
    }
</style>
