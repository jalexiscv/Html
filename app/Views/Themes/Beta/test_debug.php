<?php

/**
 * Test de debug para verificar transferencia de datos del sidebar
 */

// Carga el autoloader
require_once __DIR__ . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'autoload.php';

echo "<h1>Test de Debug - Transferencia de Datos del Sidebar</h1>";

// Simular datos como los que enviarías desde tu aplicación
$testData = array(
    "title" => "Mi Aplicación de Prueba",
    "left" => array(
        "sidebar_title" => "Menú Principal",
        "sidebar_options" => array(
            "home" => array("text" => "Inicio", "href" => "/sogt/", "svg" => "home.svg"),
            "telemetry" => array("text" => "Telemetría", "href" => "/sogt/telemetry/list/", "icon" => "fas fa-chart-line", "permission" => "sogt-access"),
            "dashboard" => array("text" => "Dashboard", "href" => "/dashboard/", "icon" => "fa-tachometer-alt"),
            "users" => array("text" => "Usuarios", "href" => "/users/", "svg" => "users-icon.svg"),
            "settings" => array("text" => "Configuración", "href" => "/sogt/settings/home/", "icon" => "fas fa-cog", "permission" => "sogt-access"),
            "reports" => array("text" => "Reportes", "href" => "/reports/", "icon" => "far fa-file-alt"),
        )
    )
);

echo "<h2>1. Datos de Prueba</h2>";
echo "<pre>" . print_r($testData, true) . "</pre>";

echo "<h2>2. Probando render_beta() con estos datos</h2>";

// Activar logging de errores para ver los debug
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/debug.log');

try {
    $html = render_beta($testData);
    echo "✅ render_beta() ejecutado correctamente<br>";
    echo "<h3>HTML Generado (primeros 500 caracteres):</h3>";
    echo "<pre>" . htmlspecialchars(substr($html, 0, 500)) . "...</pre>";

    // Buscar si el sidebar se generó correctamente
    if (strpos($html, 'sidebar_menu_items') !== false) {
        echo "✅ Variable sidebar_menu_items encontrada en el HTML<br>";
    } else {
        echo "❌ Variable sidebar_menu_items NO encontrada en el HTML<br>";
    }

    // Buscar elementos del menú
    if (strpos($html, 'Telemetría') !== false) {
        echo "✅ Texto 'Telemetría' encontrado en el HTML<br>";
    } else {
        echo "❌ Texto 'Telemetría' NO encontrado en el HTML<br>";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "Archivo: " . $e->getFile() . " Línea: " . $e->getLine() . "<br>";
}

echo "<h2>3. Verificar log de debug</h2>";
$logFile = __DIR__ . '/debug.log';
if (file_exists($logFile)) {
    $logContent = file_get_contents($logFile);
    echo "<h3>Últimas líneas del log:</h3>";
    echo "<pre>" . htmlspecialchars(substr($logContent, -1000)) . "</pre>";
} else {
    echo "❌ Archivo de log no encontrado<br>";
}

echo "<h2>4. Test directo de generateSidebarMenu()</h2>";
if (function_exists('generateSidebarMenu')) {
    $menuHtml = generateSidebarMenu($testData['sidebar_options']);
    echo "<h3>HTML del menú generado:</h3>";
    echo "<pre>" . htmlspecialchars($menuHtml) . "</pre>";
    echo "<h3>Vista previa:</h3>";
    echo "<ul style='border: 1px solid #ccc; padding: 10px;'>" . $menuHtml . "</ul>";
} else {
    echo "❌ Función generateSidebarMenu no disponible<br>";
}
