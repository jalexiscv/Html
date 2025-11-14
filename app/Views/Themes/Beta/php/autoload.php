<?php

/**
 * Autoload para el tema Beta
 *
 * Este archivo carga automáticamente las clases necesarias para el funcionamiento
 * del sistema de plantillas y versionado del tema Beta.
 */

// Incluir BetaRenderer
require_once __DIR__ . '/BetaRenderer.php';

// Incluir SidebarGenerator
require_once __DIR__ . '/SidebarGenerator.php';

// Incluir VersionManager
require_once __DIR__ . '/VersionManager.php';

// Incluir ThemeManager
require_once __DIR__ . '/ThemeManager.php';

// Cargar AssetHelper para funciones de versionado
$assetHelperPath = __DIR__ . DIRECTORY_SEPARATOR . 'AssetHelper.php';
if (file_exists($assetHelperPath)) {
    require_once $assetHelperPath;
}

// Carga el BetaRenderer si existe
$rendererPath = __DIR__ . DIRECTORY_SEPARATOR . 'BetaRenderer.php';
if (file_exists($rendererPath)) {
    require_once $rendererPath;
}

// Carga el SidebarGenerator si existe (solo si la función no está ya definida)
$sidebarPath = __DIR__ . DIRECTORY_SEPARATOR . 'SidebarGenerator.php';
if (file_exists($sidebarPath) && !function_exists('generateSidebarMenu')) {
    require_once $sidebarPath;
}

// Función helper para crear una instancia del renderer con versionado
function createBetaRenderer(): BetaRenderer
{
    return new BetaRenderer();
}

// Función helper para obtener el gestor de versiones
function getVersionManager(): ?VersionManager
{
    return class_exists('VersionManager') ? new VersionManager() : null;
}

// Funciones helper para assets versionados (uso directo en PHP)
function asset_css(string $cssPath): string
{
    $vm = getVersionManager();
    return $vm ? $vm->getCssTag($cssPath) : '<link href="assets/' . $cssPath . '" rel="stylesheet">';
}

function asset_js(string $jsPath): string
{
    $vm = getVersionManager();
    return $vm ? $vm->getJsTag($jsPath) : '<script src="assets/' . $jsPath . '"></script>';
}

function asset_url(string $assetPath): string
{
    $vm = getVersionManager();
    return $vm ? $vm->getVersionedAssetUrl($assetPath) : 'assets/' . $assetPath;
}

function asset_img(string $imagePath): string
{
    $vm = getVersionManager();
    return $vm ? $vm->getImageUrl($imagePath) : 'assets/' . $imagePath;
}

function get_build_version(): string
{
    $vm = getVersionManager();
    return $vm ? $vm->getBuildVersion() : '';
}


?>