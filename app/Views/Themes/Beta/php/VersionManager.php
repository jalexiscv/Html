<?php

/**
 * VersionManager - Gestor de versiones para archivos estáticos
 *
 * Esta clase maneja el versionado automático de archivos CSS, JS e imágenes
 * para evitar problemas de caché del navegador cuando se actualiza el tema.
 */
class VersionManager
{
    /**
     * Directorio base del tema
     */
    private string $baseDir;

    /**
     * Ruta del archivo de versiones
     */
    private string $versionFile;

    /**
     * Datos de versión cargados
     */
    private array $versionData;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->baseDir = dirname(__DIR__);
        // Buscar version.json en múltiples ubicaciones
        $possiblePaths = [
            $this->baseDir . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'version.json',
            $this->baseDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'version.json'
        ];

        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $this->versionFile = $path;
                break;
            }
        }

        // Si no se encuentra, usar la ruta por defecto
        if (!isset($this->versionFile)) {
            $this->versionFile = $possiblePaths[0];
        }

        $this->loadVersionData();
    }

    /**
     * Carga los datos de versión desde el archivo JSON
     */
    private function loadVersionData(): void
    {
        if (file_exists($this->versionFile)) {
            $content = file_get_contents($this->versionFile);
            $this->versionData = json_decode($content, true) ?? [];
        } else {
            $this->versionData = [
                'build_timestamp' => 0,
                'version_hash' => '',
                'assets' => [
                    'css' => [],
                    'js' => [],
                    'images' => []
                ]
            ];
        }
    }

    /**
     * Escanea y actualiza las versiones de todos los archivos estáticos
     */
    public function updateAssetVersions(): void
    {
        $distDir = $this->baseDir . DIRECTORY_SEPARATOR . 'dist';

        if (!is_dir($distDir)) {
            return;
        }

        // Actualiza timestamp del build
        $this->versionData['build_timestamp'] = time();

        // Escanea archivos CSS
        $this->scanAssetDirectory($distDir . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'css', 'css', $distDir);

        // Escanea archivos JS
        $this->scanAssetDirectory($distDir . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'js', 'js', $distDir);

        // Escanea archivos de imágenes
        $this->scanAssetDirectory($distDir . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images', 'images', $distDir);

        // Genera hash general del build
        $this->versionData['version_hash'] = $this->generateBuildHash();

        // Guarda los datos actualizados
        $this->saveVersionData();
    }

    /**
     * Escanea un directorio de assets y actualiza sus versiones
     *
     * @param string $directory Directorio a escanear
     * @param string $type Tipo de asset (css, js, images)
     * @param string $baseScanDir Directorio base para calcular la ruta relativa
     */
    private function scanAssetDirectory(string $directory, string $type, string $baseScanDir): void
    {
        if (!is_dir($directory)) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $relativePath = str_replace($baseScanDir . DIRECTORY_SEPARATOR, '', $file->getPathname());
                $relativePath = str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);

                $hash = $this->generateFileHash($file->getPathname());
                $this->versionData['assets'][$type][$relativePath] = $hash;
            }
        }
    }

    /**
     * Genera un hash único basado en el contenido de un archivo
     *
     * @param string $filePath Ruta del archivo
     * @return string Hash del archivo
     */
    private function generateFileHash(string $filePath): string
    {
        if (!file_exists($filePath)) {
            return '';
        }

        $content = file_get_contents($filePath);
        $fileTime = filemtime($filePath);

        // Combina contenido y tiempo de modificación para generar hash único
        return substr(md5($content . $fileTime), 0, 8);
    }

    /**
     * Genera un hash general del build basado en todos los assets
     *
     * @return string Hash del build
     */
    private function generateBuildHash(): string
    {
        $allHashes = '';
        foreach ($this->versionData['assets'] as $type => $assets) {
            foreach ($assets as $file => $hash) {
                $allHashes .= $hash;
            }
        }

        return substr(md5($allHashes . $this->versionData['build_timestamp']), 0, 10);
    }

    /**
     * Guarda los datos de versión al archivo JSON
     */
    private function saveVersionData(): void
    {
        $dir = dirname($this->versionFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($this->versionFile, json_encode($this->versionData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Obtiene el hash de la versión actual del build
     *
     * @return string Hash de la versión
     */
    public function getBuildVersion(): string
    {
        return $this->versionData['version_hash'] ?? '';
    }

    /**
     * Obtiene el timestamp del último build
     *
     * @return int Timestamp del build
     */
    public function getBuildTimestamp(): int
    {
        return $this->versionData['build_timestamp'] ?? 0;
    }

    /**
     * Genera una etiqueta HTML para cargar un archivo CSS con versión
     *
     * @param string $cssPath Ruta del archivo CSS
     * @return string Etiqueta HTML <link>
     */
    public function getCssTag(string $cssPath): string
    {
        $versionedUrl = $this->getVersionedAssetUrl($cssPath);
        return '<link href="' . htmlspecialchars($versionedUrl) . '" rel="stylesheet">';
    }

    /**
     * Obtiene la URL versionada de un asset
     *
     * @param string $assetPath Ruta del asset (ej: "css/combined.css")
     * @return string URL con parámetro de versión
     */
    public function getVersionedAssetUrl(string $assetPath): string
    {
        // Determina el tipo de asset basado en la extensión
        $extension = pathinfo($assetPath, PATHINFO_EXTENSION);
        $type = $this->getAssetType($extension);

        // Obtiene el hash del archivo específico
        $hash = $this->versionData['assets'][$type][$assetPath] ?? $this->versionData['version_hash'];

        // Si no hay hash, usa el timestamp del build
        if (empty($hash)) {
            $hash = $this->versionData['build_timestamp'];
        }

        // Construye la URL con el parámetro de versión usando la ruta correcta para producción
        $baseUrl = '/themes/Beta/' . $assetPath;
        return $baseUrl . '?v=' . $hash;
    }

    /**
     * Determina el tipo de asset basado en la extensión del archivo
     *
     * @param string $extension Extensión del archivo
     * @return string Tipo de asset
     */
    private function getAssetType(string $extension): string
    {
        $cssExtensions = ['css'];
        $jsExtensions = ['js'];
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'ico'];

        if (in_array(strtolower($extension), $cssExtensions)) {
            return 'css';
        } elseif (in_array(strtolower($extension), $jsExtensions)) {
            return 'js';
        } elseif (in_array(strtolower($extension), $imageExtensions)) {
            return 'images';
        }

        return 'css'; // Default
    }

    /**
     * Genera una etiqueta HTML para cargar un archivo JS con versión
     *
     * @param string $jsPath Ruta del archivo JS
     * @return string Etiqueta HTML <script>
     */
    public function getJsTag(string $jsPath): string
    {
        $versionedUrl = $this->getVersionedAssetUrl($jsPath);
        return '<script src="' . htmlspecialchars($versionedUrl) . '"></script>';
    }

    /**
     * Obtiene la URL versionada de una imagen
     *
     * @param string $imagePath Ruta de la imagen
     * @return string URL versionada de la imagen
     */
    public function getImageUrl(string $imagePath): string
    {
        return $this->getVersionedAssetUrl($imagePath);
    }
}
