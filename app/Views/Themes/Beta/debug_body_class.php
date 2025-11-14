<?php
/**
 * Debug específico para investigar class="light-mode dark-mode"
 */

echo "<h1>Debug: Análisis de class=\"light-mode dark-mode\"</h1>";

// Cargar sistema
require_once 'php/autoload.php';

echo "<h2>1. Verificación de ThemeManager</h2>";

// Test directo de ThemeManager
$currentTheme = ThemeManager::getCurrentTheme();
$bodyClass = ThemeManager::getBodyClass();

echo "Tema actual: <strong>$currentTheme</strong><br>";
echo "Clase del body: <strong>$bodyClass</strong><br>";

// Verificar si hay algún problema en la lógica
echo "<h2>2. Análisis Paso a Paso</h2>";

echo "GET theme: " . ($_GET['theme'] ?? 'NO DEFINIDO') . "<br>";
echo "SESSION theme: " . ($_SESSION['theme'] ?? 'NO DEFINIDA') . "<br>";
echo "COOKIE theme: " . ($_COOKIE['beta_theme'] ?? 'NO DEFINIDA') . "<br>";

// Test de detectSystemTheme
echo "<h2>3. Test de detectSystemTheme()</h2>";
$reflection = new ReflectionClass('ThemeManager');
$method = $reflection->getMethod('detectSystemTheme');
$method->setAccessible(true);
$systemTheme = $method->invoke(null);
echo "Sistema detectado: <strong>$systemTheme</strong><br>";

echo "<h2>4. Test de BetaRenderer</h2>";

// Crear renderer y verificar variables
$renderer = new BetaRenderer();

// Simular addThemeVariables
$reflection = new ReflectionClass($renderer);
$method = $reflection->getMethod('addThemeVariables');
$method->setAccessible(true);
$method->invoke($renderer);

// Obtener contexto
$contextProperty = $reflection->getProperty('context');
$contextProperty->setAccessible(true);
$context = $contextProperty->getValue($renderer);

echo "Variables en contexto:<br>";
echo "- theme_body_class: <strong>" . ($context['theme_body_class'] ?? 'NO DEFINIDA') . "</strong><br>";
echo "- current_theme: <strong>" . ($context['current_theme'] ?? 'NO DEFINIDA') . "</strong><br>";
echo "- is_dark_theme: <strong>" . ($context['is_dark_theme'] ?? 'NO DEFINIDA') . "</strong><br>";
echo "- is_light_theme: <strong>" . ($context['is_light_theme'] ?? 'NO DEFINIDA') . "</strong><br>";

echo "<h2>5. Test de Renderizado Real</h2>";

// Template simple para probar
$testTemplate = '<body class="${theme_body_class}">Test</body>';
file_put_contents('php/layouts/debug_body.html', $testTemplate);

try {
    $result = $renderer->render('layouts/debug_body.html');
    echo "Template: <code>" . htmlspecialchars($testTemplate) . "</code><br>";
    echo "Resultado: <code>" . htmlspecialchars($result) . "</code><br>";

    // Analizar el resultado
    if (preg_match('/class="([^"]*)"/', $result, $matches)) {
        $classes = $matches[1];
        echo "Clases extraídas: <strong>$classes</strong><br>";

        $classArray = explode(' ', trim($classes));
        echo "Array de clases: " . print_r($classArray, true) . "<br>";

        if (count($classArray) > 1) {
            echo "<div style='background: #f8d7da; padding: 10px; border: 1px solid #f5c6cb;'>";
            echo "❌ <strong>PROBLEMA DETECTADO: Múltiples clases</strong><br>";
            echo "Se encontraron " . count($classArray) . " clases: " . implode(', ', $classArray);
            echo "</div>";
        } else {
            echo "<div style='background: #d4edda; padding: 10px; border: 1px solid #c3e6cb;'>";
            echo "✅ <strong>Una sola clase detectada</strong>";
            echo "</div>";
        }
    }

    unlink('php/layouts/debug_body.html');

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}

echo "<h2>6. Verificación de Variables Duplicadas</h2>";

// Buscar si hay variables duplicadas en el contexto
$allVars = array_keys($context);
$themeVars = array_filter($allVars, function ($key) {
    return strpos($key, 'theme') !== false || strpos($key, 'body') !== false || strpos($key, 'class') !== false;
});

echo "Variables relacionadas con tema:<br>";
foreach ($themeVars as $var) {
    echo "- $var: " . $context[$var] . "<br>";
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

    code {
        background: #f5f5f5;
        padding: 2px 4px;
    }
</style>
