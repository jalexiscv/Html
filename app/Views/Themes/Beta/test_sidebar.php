<?php

/**
 * Test del sistema de sidebar dinámico
 *
 * Este archivo prueba la funcionalidad del sidebar dinámico
 * para identificar problemas de carga o ejecución.
 */

echo "<h1>Test del Sistema de Sidebar Dinámico</h1>";

// Test 1: Verificar carga de autoload
echo "<h2>1. Verificando autoload.php</h2>";
$autoloadPath = __DIR__ . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($autoloadPath)) {
    echo "✅ autoload.php existe<br>";
    require_once $autoloadPath;
    echo "✅ autoload.php cargado<br>";
} else {
    echo "❌ autoload.php no encontrado en: " . $autoloadPath . "<br>";
}

// Test 2: Verificar función generateSidebarMenu
echo "<h2>2. Verificando función generateSidebarMenu</h2>";
if (function_exists('generateSidebarMenu')) {
    echo "✅ Función generateSidebarMenu disponible<br>";
} else {
    echo "❌ Función generateSidebarMenu NO disponible<br>";
}

// Test 3: Verificar SidebarGenerator.php
echo "<h2>3. Verificando SidebarGenerator.php</h2>";
$sidebarPath = __DIR__ . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'SidebarGenerator.php';
if (file_exists($sidebarPath)) {
    echo "✅ SidebarGenerator.php existe<br>";
} else {
    echo "❌ SidebarGenerator.php no encontrado<br>";
}

// Test 4: Probar la función con datos de ejemplo
echo "<h2>4. Probando función con datos de ejemplo</h2>";
if (function_exists('generateSidebarMenu')) {
    $testOptions = array(
        "home" => array("text" => "Inicio", "href" => "/", "icon" => "fas fa-home"),
        "settings" => array("text" => "Configuración", "href" => "/settings", "icon" => "fas fa-cog"),
        "users" => array("text" => "Usuarios", "href" => "/users", "svg" => "users.svg")
    );

    try {
        $menuHtml = generateSidebarMenu($testOptions);
        echo "✅ Función ejecutada correctamente<br>";
        echo "<h3>HTML Generado:</h3>";
        echo "<pre>" . htmlspecialchars($menuHtml) . "</pre>";
        echo "<h3>Vista Previa:</h3>";
        echo "<ul style='list-style: none; padding: 10px; border: 1px solid #ccc;'>";
        echo $menuHtml;
        echo "</ul>";
    } catch (Exception $e) {
        echo "❌ Error al ejecutar función: " . $e->getMessage() . "<br>";
        echo "Archivo: " . $e->getFile() . " Línea: " . $e->getLine() . "<br>";
    }
} else {
    echo "❌ No se puede probar - función no disponible<br>";
}

// Test 5: Verificar otras funciones helper
echo "<h2>5. Verificando otras funciones helper</h2>";
$functions = ['checkUserPermission', 'isMenuItemActive', 'generateMenuIcon', 'getDefaultSidebarMenu'];
foreach ($functions as $func) {
    if (function_exists($func)) {
        echo "✅ {$func} disponible<br>";
    } else {
        echo "❌ {$func} NO disponible<br>";
    }
}

echo "<h2>Diagnóstico Completo</h2>";
echo "Si ves errores arriba, revisa los archivos correspondientes.";
