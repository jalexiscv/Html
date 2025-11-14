<?php

namespace Gamma;

/**
 * Gamma Theme Configuration
 * Gestión de configuración del tema
 *
 * @package  Gamma
 * @version  1.0.0
 */
class GammaTheme
{
    private $basePath;
    private $config = [];
    private $globalAssetVersion = null; // Property to cache the global version

    /**
     * Constructor
     *
     * @param string $basePath Ruta base del tema
     */
    public function __construct($basePath)
    {
        $this->basePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->loadConfig();
    }

    /**
     * Cargar configuración del tema
     */
    private function loadConfig()
    {
        // Configuración por defecto
        $this->config = [
            'theme_name' => 'Gamma',
            'theme_version' => '1.0.0',
            'author' => 'Gamma Development Team',

            'paths' => [
                'layouts' => 'layouts',
                'pages' => 'pages',
                'partials' => 'partials',
                'assets' => 'assets',
                'cache' => 'cache',
            ],

            'assets' => [
                'css' => [
                    'gamma.css',
                    'components.css',
                ],
                'js' => [
                    'gamma.js',
                    'components.js',
                ],
            ],
            'default_layout' => 'default',
            'default_page' => 'default',
            'cache_enabled' => false,
            'cache_lifetime' => 3600,
            'debug_mode' => true,
        ];

        // Cargar configuración personalizada si existe
        $configFile = $this->basePath . 'Config/theme.php';
        if (file_exists($configFile)) {
            $customConfig = include $configFile;
            $this->config = array_merge($this->config, $customConfig);
        }
    }

    /**
     * Obtener valor de configuración
     *
     * @param string $key Clave de configuración
     * @param mixed $default Valor por defecto
     * @return mixed Valor de configuración
     */
    public function get($key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    /**
     * Establecer valor de configuración
     *
     * @param string $key Clave
     * @param mixed $value Valor
     */
    public function set($key, $value)
    {
        $this->config[$key] = $value;
    }

    /**
     * Obtener URL de asset
     *
     * @param string $type Tipo de asset (css, js, images)
     * @param string $file Nombre del archivo
     * @return string URL del asset
     */
    /**
     * Scans the entire public_html directory to find the latest modification time.
     * This is used as a global cache-busting version number.
     * The result is cached for the duration of the request.
     */
    private function calculateGlobalAssetVersion()
    {
        // Default to current time if no files are found or directory doesn't exist
        $this->globalAssetVersion = "none";
        $path = APPPATH . 'Views/Themes/Gamma/public_html/';
        //echo("Debug:{$path}");
        if (!is_dir($path)) {
            //echo("Debug:No found {$path}");
            return ("Directory not found: " . $path);
        }
        $latestModTime = 0;
        $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        foreach ($rii as $file) {
            if ($file->isDir()) {
                continue;
            }
            if ($file->getMTime() > $latestModTime) {
                $latestModTime = $file->getMTime();
            }
        }

        if ($latestModTime > 0) {
            $this->globalAssetVersion = $latestModTime;
        }
    }

    public function getAssetUrl($type, $file)
    {
        // Calculate the version only once per request
        if ($this->globalAssetVersion === null) {
            $this->calculateGlobalAssetVersion();
        }

        $version = '?v=' . $this->globalAssetVersion;
        // Correct base path for the final URL, as per user requirement.
        $themeName = $this->get('theme_name', 'gamma'); // Get theme name from config
        $assetPath = "ui/themes/{$themeName}/{$type}/{$file}";
        $assetPath = strtolower($assetPath);
        return base_url($assetPath) . $version;
    }

    /**
     * Obtener ruta de directorio
     *
     * @param string $type Tipo de ruta
     * @return string Ruta completa
     */
    public function getPath($type)
    {
        $relativePath = $this->config['paths'][$type] ?? $type;
        return $this->basePath . $relativePath . DIRECTORY_SEPARATOR;
    }
}
