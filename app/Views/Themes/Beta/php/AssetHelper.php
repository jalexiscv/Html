<?php

/**
 * AssetHelper - Funciones helper para cargar assets con versionado
 *
 * Proporciona funciones globales para cargar CSS, JS e imágenes con versionado automático
 * compatible con el sistema de build de Python.
 */

require_once __DIR__ . '/VersionManager.php';

/**
 * Instancia global del VersionManager
 */
$GLOBALS['asset_version_manager'] = null;

/**
 * Obtiene la instancia del VersionManager
 *
 * @return VersionManager
 */
if (!function_exists('getVersionManager')) {
    function getVersionManager(): VersionManager
    {
        if ($GLOBALS['asset_version_manager'] === null) {
            $GLOBALS['asset_version_manager'] = new VersionManager();
        }
        return $GLOBALS['asset_version_manager'];
    }
}

/**
 * Genera etiqueta HTML para cargar archivo CSS con versionado
 *
 * @param string $cssPath Ruta del archivo CSS (ej: "css/combined.css")
 * @return string Etiqueta HTML <link>
 */
if (!function_exists('asset_css')) {
    function asset_css(string $cssPath): string
    {
        $vm = getVersionManager();
        return $vm->getCssTag($cssPath);
    }
}

/**
 * Genera etiqueta HTML para cargar archivo JS con versionado
 *
 * @param string $jsPath Ruta del archivo JS (ej: "js/dashboard.js")
 * @return string Etiqueta HTML <script>
 */
if (!function_exists('asset_js')) {
    function asset_js(string $jsPath): string
    {
        $vm = getVersionManager();
        return $vm->getJsTag($jsPath);
    }
}

/**
 * Obtiene URL versionada de cualquier asset
 *
 * @param string $assetPath Ruta del asset
 * @return string URL con parámetro de versión
 */
if (!function_exists('asset_url')) {
    function asset_url(string $assetPath): string
    {
        $vm = getVersionManager();
        return $vm->getVersionedAssetUrl($assetPath);
    }
}

/**
 * Obtiene URL versionada de una imagen
 *
 * @param string $imagePath Ruta de la imagen
 * @return string URL versionada de la imagen
 */
if (!function_exists('asset_img')) {
    function asset_img(string $imagePath): string
    {
        $vm = getVersionManager();
        return $vm->getImageUrl($imagePath);
    }
}

/**
 * Procesa un template HTML reemplazando las funciones asset_*() por HTML real
 *
 * @param string $content Contenido del template
 * @return string Contenido procesado con assets versionados
 */
if (!function_exists('process_asset_functions')) {
    function process_asset_functions(string $content): string
    {
        $vm = getVersionManager();

        // Reemplazar asset_css('ruta')
        $content = preg_replace_callback(
            "/asset_css\(['\"]([^'\"]+)['\"]\)/",
            function ($matches) use ($vm) {
                return $vm->getCssTag($matches[1]);
            },
            $content
        );

        // Reemplazar asset_js('ruta')
        $content = preg_replace_callback(
            "/asset_js\(['\"]([^'\"]+)['\"]\)/",
            function ($matches) use ($vm) {
                return $vm->getJsTag($matches[1]);
            },
            $content
        );

        // Reemplazar asset_url('ruta')
        $content = preg_replace_callback(
            "/asset_url\(['\"]([^'\"]+)['\"]\)/",
            function ($matches) use ($vm) {
                return $vm->getVersionedAssetUrl($matches[1]);
            },
            $content
        );

        // Reemplazar asset_img('ruta')
        $content = preg_replace_callback(
            "/asset_img\(['\"]([^'\"]+)['\"]\)/",
            function ($matches) use ($vm) {
                return $vm->getImageUrl($matches[1]);
            },
            $content
        );

        return $content;
    }
}
