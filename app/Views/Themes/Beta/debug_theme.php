<?php
/**
 * Debug del sistema de temas - verificar qué está pasando
 */

echo "<h1>Debug del Sistema de Temas</h1>";

// 1. Verificar si ThemeManager se carga
echo "<h2>1. Verificación de ThemeManager</h2>";
require_once 'php/autoload.php';

if (class_exists('ThemeManager')) {
    echo "✅ ThemeManager cargado correctamente<br>";

    // Probar métodos
    $currentTheme = ThemeManager::getCurrentTheme();
    $bodyClass = ThemeManager::getBodyClass();
    $dataTheme = ThemeManager::getDataTheme();

    echo "Tema actual: <strong>$currentTheme</strong><br>";
    echo "Clase del body: <strong>$bodyClass</strong><br>";
    echo "Data theme: <strong>$dataTheme</strong><br>";

} else {
    echo "❌ ThemeManager NO se cargó<br>";
}

// 2. Verificar funciones helper
echo "<h2>2. Verificación de Funciones Helper</h2>";
if (function_exists('get_theme_body_class')) {
    echo "✅ get_theme_body_class(): " . get_theme_body_class() . "<br>";
} else {
    echo "❌ get_theme_body_class() no existe<br>";
}

if (function_exists('get_current_theme')) {
    echo "✅ get_current_theme(): " . get_current_theme() . "<br>";
} else {
    echo "❌ get_current_theme() no existe<br>";
}

// 3. Probar BetaRenderer
echo "<h2>3. Verificación de BetaRenderer</h2>";
try {
    $renderer = new BetaRenderer();
    echo "✅ BetaRenderer creado<br>";

    // Verificar que se agreguen variables de tema
    $testData = ['title' => 'Test'];
    $renderer->setVars($testData);

    // Simular el proceso de addThemeVariables
    $reflection = new ReflectionClass($renderer);
    $method = $reflection->getMethod('addThemeVariables');
    $method->setAccessible(true);
    $method->invoke($renderer);

    // Obtener contexto para verificar variables
    $contextProperty = $reflection->getProperty('context');
    $contextProperty->setAccessible(true);
    $context = $contextProperty->getValue($renderer);

    echo "Variables de tema en contexto:<br>";
    echo "- theme_body_class: " . ($context['theme_body_class'] ?? 'NO DEFINIDA') . "<br>";
    echo "- theme_data_attribute: " . ($context['theme_data_attribute'] ?? 'NO DEFINIDA') . "<br>";
    echo "- current_theme: " . ($context['current_theme'] ?? 'NO DEFINIDA') . "<br>";

} catch (Exception $e) {
    echo "❌ Error con BetaRenderer: " . $e->getMessage() . "<br>";
}

// 4. Probar renderizado simple
echo "<h2>4. Prueba de Renderizado Simple</h2>";
try {
    $simpleTemplate = '<body class="${theme_body_class}">Contenido de prueba</body>';

    // Crear archivo temporal
    file_put_contents('php/layouts/test_simple.html', $simpleTemplate);

    $renderer = new BetaRenderer();
    $result = $renderer->render('layouts/test_simple.html');

    echo "Template: <code>" . htmlspecialchars($simpleTemplate) . "</code><br>";
    echo "Resultado: <code>" . htmlspecialchars($result) . "</code><br>";

    // Limpiar archivo temporal
    unlink('php/layouts/test_simple.html');

} catch (Exception $e) {
    echo "❌ Error en renderizado: " . $e->getMessage() . "<br>";
}

// 5. Verificar parámetros GET
echo "<h2>5. Verificación de Parámetros</h2>";
echo "GET theme: " . ($_GET['theme'] ?? 'NO DEFINIDO') . "<br>";
echo "SESSION: " . print_r($_SESSION ?? [], true) . "<br>";
echo "COOKIE: " . ($_COOKIE['beta_theme'] ?? 'NO DEFINIDO') . "<br>";

?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    h1 {
        color: #333;
    }

    h2 {
        color: #666;
        margin-top: 30px;
    }

    code {
        background: #f5f5f5;
        padding: 2px 4px;
    }
</style>
