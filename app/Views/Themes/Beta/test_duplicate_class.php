<?php
/**
 * Test para detectar duplicación de theme_body_class
 */

session_start();

// Cargar sistema
require_once 'php/autoload.php';

echo "<h1>Test: Duplicación de theme_body_class</h1>";

// Simular datos que podrían tener theme_body_class
$testData = [
        'title' => 'Test Page',
        'theme_body_class' => 'light-mode',  // POSIBLE DUPLICACIÓN
        'content' => 'Test content'
];

echo "<h2>1. Datos de entrada:</h2>";
echo "<pre>" . print_r($testData, true) . "</pre>";

// Crear renderer
$renderer = new BetaRenderer();

// Establecer datos ANTES de addThemeVariables
$renderer->setVars($testData);

echo "<h2>2. Contexto ANTES de addThemeVariables:</h2>";
$reflection = new ReflectionClass($renderer);
$contextProperty = $reflection->getProperty('context');
$contextProperty->setAccessible(true);
$contextBefore = $contextProperty->getValue($renderer);

echo "theme_body_class ANTES: <strong>" . ($contextBefore['theme_body_class'] ?? 'NO DEFINIDA') . "</strong><br>";

// Llamar addThemeVariables manualmente
$method = $reflection->getMethod('addThemeVariables');
$method->setAccessible(true);
$method->invoke($renderer);

echo "<h2>3. Contexto DESPUÉS de addThemeVariables:</h2>";
$contextAfter = $contextProperty->getValue($renderer);

echo "theme_body_class DESPUÉS: <strong>" . ($contextAfter['theme_body_class'] ?? 'NO DEFINIDA') . "</strong><br>";

// Verificar si hay cambio
if (isset($contextBefore['theme_body_class']) && isset($contextAfter['theme_body_class'])) {
    if ($contextBefore['theme_body_class'] !== $contextAfter['theme_body_class']) {
        echo "<div style='background: #f8d7da; padding: 10px; border: 1px solid #f5c6cb;'>";
        echo "❌ <strong>SOBRESCRITURA DETECTADA</strong><br>";
        echo "Antes: {$contextBefore['theme_body_class']}<br>";
        echo "Después: {$contextAfter['theme_body_class']}";
        echo "</div>";
    } else {
        echo "<div style='background: #fff3cd; padding: 10px; border: 1px solid #ffeaa7;'>";
        echo "⚠️ <strong>MISMO VALOR</strong> - No hay sobrescritura";
        echo "</div>";
    }
}

echo "<h2>4. Test de Renderizado:</h2>";

// Template que usa theme_body_class
$testTemplate = '<body class="${theme_body_class}">Content</body>';
file_put_contents('php/layouts/test_dup.html', $testTemplate);

try {
    $result = $renderer->render('layouts/test_dup.html');
    echo "Resultado: <code>" . htmlspecialchars($result) . "</code><br>";

    // Extraer clase del body
    if (preg_match('/class="([^"]*)"/', $result, $matches)) {
        $classes = trim($matches[1]);
        $classArray = array_filter(explode(' ', $classes));

        echo "Clases encontradas: " . count($classArray) . "<br>";
        echo "Lista: " . implode(', ', $classArray) . "<br>";

        if (count($classArray) > 1) {
            echo "<div style='background: #f8d7da; padding: 10px; border: 1px solid #f5c6cb;'>";
            echo "❌ <strong>MÚLTIPLES CLASES DETECTADAS</strong>";
            echo "</div>";
        }
    }

    unlink('php/layouts/test_dup.html');

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}

echo "<h2>5. Variables completas del contexto:</h2>";
echo "<pre>";
foreach ($contextAfter as $key => $value) {
    if (strpos($key, 'theme') !== false || strpos($key, 'body') !== false) {
        echo "$key: $value\n";
    }
}
echo "</pre>";

?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    h1, h2 {
        color: #333;
    }

    code {
        background: #f5f5f5;
        padding: 2px 4px;
    }

    pre {
        background: #f8f9fa;
        padding: 10px;
        overflow-x: auto;
    }
</style>
