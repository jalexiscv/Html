<?php

declare(strict_types=1);

/**
 * Higgs HTML Library Autoloader
 * 
 * Este archivo permite cargar la librería de dos formas:
 * 1. Si se instaló via Composer, carga el autoloader de vendor.
 * 2. Si se copió manualmente, registra un autoloader PSR-4 personalizado.
 */

// 1. Intentar cargar autoloader de Composer si existe
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
    return;
}

// 2. Fallback: Autoloader manual para entornos sin Composer
spl_autoload_register(function ($class) {
    // Prefijo del proyecto
    $prefix = 'Higgs\\Html\\';

    // Directorio base para el prefijo (carpeta src/)
    $base_dir = __DIR__ . '/src/';

    // ¿La clase usa este prefijo?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // No, mover a la siguiente clase registrada
        return;
    }

    // Obtener el nombre relativo de la clase
    $relative_class = substr($class, $len);

    // Reemplazar prefijo namespace con base_dir, reemplazar separadores
    // de namespace con separadores de directorio y agregar .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // Si el archivo existe, requerirlo
    if (file_exists($file)) {
        require $file;
    }
});
