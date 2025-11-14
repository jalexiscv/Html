<?php
namespace App\Controllers;

class ThemeController extends BaseController
{
    /**
     * Sirve assets estáticos o dinámicos (PHP) de un tema de forma robusta y directa.
     * Esta función es llamada por la ruta en app/Config/Routes.php.
     * Versión final: Utiliza argumentos variádicos para capturar rutas de assets con subdirectorios.
     *
     * @param string $themeName El nombre del tema (ej. 'gamma').
     * @param mixed ...$segments Segmentos de la URL que componen la ruta del asset.
     */
    public function serveAsset(string $themeName, ...$segments)
    {
        // Reconstruir la ruta del asset a partir de los segmentos capturados por el enrutador.
        $assetPath = implode('/', $segments);

        // --- Construcción y validación de la ruta ---
        $themeName = preg_replace('/[^a-zA-Z0-9_-]/', '', $themeName);
        $assetPath = str_replace('../', '', $assetPath); // Previene directory traversal básico.

        $filePath = APPPATH . 'Views/Themes/' . ucfirst(strtolower($themeName)) . '/public_html/' . $assetPath;

        // Validaciones de seguridad y existencia del archivo.
        if (!file_exists($filePath) || !is_file($filePath) || !is_readable($filePath)) {
            header("HTTP/1.1 404 Not Found");
            echo "Asset not found or not readable: {$filePath}";
            exit();
        }

        // Verificación de seguridad más robusta para prevenir directory traversal.
        $realPath = realpath($filePath);
        $basePath = realpath(APPPATH . 'Views/Themes/' . ucfirst(strtolower($themeName)) . '/public_html/');

        if ($realPath === false || $basePath === false || strpos($realPath, $basePath) !== 0) {
            header("HTTP/1.1 403 Forbidden");
            echo "Access Denied.";
            exit();
        }

        // --- Servir el archivo ---
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        // Limpiar cualquier búfer de salida previo.
        if (ob_get_level()) {
            ob_end_clean();
        }
        // Toco xcss por que el servidor no deja tocar un archivo con extension .php
        // Si es un archivo PHP, lo ejecutamos para que genere su propio contenido y cabeceras.
        if ($extension === 'xcss') {
            include $filePath;
            exit();
        }

        // Para todos los demás tipos de archivos, los servimos estáticamente.
        $mimeType = $this->getMimeType($filePath);
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: public, max-age=31536000');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');

        readfile($filePath);
        exit();
    }

    /**
     * Determina el tipo MIME del archivo.
     */
    private function getMimeType(string $filePath): string
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $mimeTypes = [
            'css' => 'text/css',
            'xcss' => 'text/css',
            'js' => 'application/javascript',
            'xjs' => 'application/javascript',
            'mjs' => 'application/javascript',
            'json' => 'application/json',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'webp' => 'image/webp',
            'ico' => 'image/x-icon',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'otf' => 'font/otf',
            'eot' => 'application/vnd.ms-fontobject',
            'xml' => 'application/xml',
            'pdf' => 'application/pdf',
        ];

        if (isset($mimeTypes[$extension])) {
            return $mimeTypes[$extension];
        }

        if (function_exists('mime_content_type')) {
            return mime_content_type($filePath);
        }

        return 'application/octet-stream';
    }
}

?>
