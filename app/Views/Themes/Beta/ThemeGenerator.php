<?php

/**
 * Generador de temas para Beta
 * 
 * Esta clase se encarga de generar el HTML final para el tema Beta
 * utilizando el motor de plantillas personalizado.
 */
class ThemeGenerator {
    /**
     * Ruta base del tema
     */
    private string $basePath;
    
    /**
     * Ruta de salida para los archivos generados
     */
    private string $outputPath;
    
    /**
     * Motor de plantillas
     */
    private TemplateEngine $templateEngine;
    
    /**
     * Configuración del tema
     */
    private array $config;
    
    /**
     * Constructor
     * 
     * @param string $basePath Ruta base del tema
     * @param string $outputPath Ruta de salida (opcional)
     */
    public function __construct(string $basePath, string $outputPath = null) {
        $this->basePath = rtrim($basePath, '/\\') . '/';
        $this->outputPath = $outputPath ?? $this->basePath . 'dist/';
        
        // Inicializa el motor de plantillas
        $this->templateEngine = new TemplateEngine($this->basePath);
        
        // Carga la configuración
        $this->loadConfig();
    }
    
    /**
     * Carga la configuración del tema
     * 
     * @return void
     */
    private function loadConfig(): void {
        $configPath = $this->basePath . 'config/theme.json';
        
        if (file_exists($configPath)) {
            $configJson = file_get_contents($configPath);
            $this->config = json_decode($configJson, true);
        } else {
            // Configuración por defecto si no existe el archivo
            $this->config = [
                'name' => 'Beta Dashboard',
                'version' => '1.0.0',
                'colors' => [
                    'primary' => '#0d6efd',
                    'secondary' => '#6c757d',
                    'success' => '#198754'
                ],
                'fonts' => [
                    'base' => 'Inter, sans-serif',
                    'sizes' => [
                        'small' => '0.875rem',
                        'base' => '1rem',
                        'large' => '1.25rem'
                    ]
                ],
                'components' => [
                    'navbar_height' => '60px',
                    'sidebar_width' => '250px',
                    'border_radius' => '0.375rem'
                ]
            ];
        }
    }
    
    /**
     * Limpia el directorio de salida
     * 
     * @return void
     */
    private function cleanOutputDir(): void {
        if (is_dir($this->outputPath)) {
            $files = glob($this->outputPath . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                } elseif (is_dir($file)) {
                    $this->removeDir($file);
                }
            }
        } else {
            mkdir($this->outputPath, 0777, true);
        }
    }
    
    /**
     * Elimina un directorio y su contenido recursivamente
     * 
     * @param string $dir Directorio a eliminar
     * @return void
     */
    private function removeDir(string $dir): void {
        $files = array_diff(scandir($dir), ['.', '..']);
        
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                $this->removeDir($path);
            } else {
                unlink($path);
            }
        }
        
        rmdir($dir);
    }
    
    /**
     * Copia los archivos de assets al directorio de salida
     * 
     * @return void
     */
    private function copyAssets(): void {
        $assetsDir = $this->basePath . 'assets/';
        $outputAssetsDir = $this->outputPath . 'assets/';
        
        if (!is_dir($outputAssetsDir)) {
            mkdir($outputAssetsDir, 0777, true);
        }
        
        $this->copyDirectory($assetsDir, $outputAssetsDir);
    }
    
    /**
     * Copia un directorio y su contenido recursivamente
     * 
     * @param string $source Directorio fuente
     * @param string $destination Directorio destino
     * @return void
     */
    private function copyDirectory(string $source, string $destination): void {
        if (!is_dir($destination)) {
            mkdir($destination, 0777, true);
        }
        
        $files = array_diff(scandir($source), ['.', '..']);
        
        foreach ($files as $file) {
            $sourcePath = $source . '/' . $file;
            $destPath = $destination . '/' . $file;
            
            if (is_dir($sourcePath)) {
                $this->copyDirectory($sourcePath, $destPath);
            } else {
                copy($sourcePath, $destPath);
            }
        }
    }
    
    /**
     * Construye una página a partir de una plantilla
     * 
     * @param string $page Nombre de la página (sin extensión)
     * @param array $data Datos adicionales para la plantilla
     * @return void
     */
    public function buildPage(string $page, array $data = []): void {
        // Ruta de la plantilla de página
        $templatePath = 'pages/' . $page . '.html';
        
        // Combina los datos proporcionados con la configuración
        $context = array_merge($this->config, $data);
        
        // Renderiza la plantilla
        $content = $this->templateEngine->render($templatePath, $context);
        
        // Guarda el contenido en el archivo de salida
        $this->templateEngine->saveToFile($content, $this->outputPath . $page . '.html');
    }
    
    /**
     * Genera todas las páginas configuradas
     * 
     * @param array $data Datos adicionales para las plantillas
     * @return void
     */
    public function buildAllPages(array $data = []): void {
        // Limpia el directorio de salida
        $this->cleanOutputDir();
        
        // Copia los assets
        $this->copyAssets();
        
        // Ruta del archivo de configuración de páginas
        $pagesConfigPath = $this->basePath . 'config/pages.json';
        
        if (file_exists($pagesConfigPath)) {
            // Si existe un archivo de configuración de páginas, genera todas las páginas configuradas
            $pagesJson = file_get_contents($pagesConfigPath);
            $pages = json_decode($pagesJson, true);
            
            foreach ($pages as $page => $pageData) {
                // Combina los datos de la página con los datos proporcionados
                $pageContext = array_merge($data, $pageData);
                $this->buildPage($page, $pageContext);
            }
        } else {
            // Si no existe un archivo de configuración, genera solo la página de dashboard
            $this->buildPage('dashboard', $data);
        }
    }
    
    /**
     * Método principal para construir el tema
     * 
     * @param array $data Datos adicionales para las plantillas
     * @return void
     */
    public function build(array $data = []): void {
        $this->buildAllPages($data);
    }
    
    /**
     * Genera el HTML para una plantilla específica
     * 
     * @param string $templatePath Ruta de la plantilla
     * @param array $data Datos para la plantilla
     * @return string HTML generado
     */
    public function renderTemplate(string $templatePath, array $data = []): string {
        // Combina los datos proporcionados con la configuración
        $context = array_merge($this->config, $data);
        
        // Renderiza la plantilla y devuelve el contenido
        return $this->templateEngine->render($templatePath, $context);
    }
}
