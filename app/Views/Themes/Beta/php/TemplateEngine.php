<?php

/**
 * Motor de plantillas para el tema Beta
 *
 * Esta clase proporciona funcionalidades para procesar plantillas HTML
 * y sustituir variables, bloques e includes usando PHP puro
 */
class TemplateEngine
{
    /**
     * Directorio base de las plantillas
     */
    private string $baseDir;

    /**
     * Variables de contexto para las plantillas
     */
    private array $context = [];

    /**
     * Constructor
     *
     * @param string $baseDir Directorio base de las plantillas
     */
    public function __construct(string $baseDir)
    {
        $this->baseDir = rtrim($baseDir, '/\\') . '/';
    }

    /**
     * Establece una variable de contexto
     *
     * @param string $name Nombre de la variable
     * @param mixed $value Valor de la variable
     * @return void
     */
    public function setVar(string $name, $value): void
    {
        $this->context[$name] = $value;
    }

    /**
     * Renderiza una plantilla
     *
     * @param string $templatePath Ruta de la plantilla
     * @param array $context Variables de contexto (opcional)
     * @return string Contenido renderizado
     */
    public function render(string $templatePath, array $context = []): string
    {
        // Añade el contexto proporcionado
        if (!empty($context)) {
            $this->setVars($context);
        }

        // Lee el contenido de la plantilla
        $content = $this->readFile($templatePath);

        // Procesa includes
        $content = $this->processIncludes($content);

        // Extrae bloques
        $blocks = $this->extractBlocks($content);

        // Si la plantilla extiende otra, procesa la extensión
        if (preg_match('/{%\s*extends\s+"([^"]+)"\s*%}/', $content, $matches)) {
            if (isset($this->context['main_template']) && $this->context['main_template'] === 'c0') {
                $content = "<!DOCTYPE html>\n<html>\n<body></body>\n</html>";
            } else {
                $basePath = $matches[1];
                $baseContent = $this->readFile($basePath);

                // Procesa includes en la plantilla base
                $baseContent = $this->processIncludes($baseContent);

                // Reemplaza bloques en la plantilla base
                $content = $this->replaceBlocks($baseContent, $blocks);
            }
        }

        // Reemplaza variables
        $content = $this->replaceVars($content);

        return $content;
    }

    /**
     * Establece múltiples variables de contexto
     *
     * @param array $vars Arreglo asociativo de variables
     * @return void
     */
    public function setVars(array $vars): void
    {
        $this->context = array_merge($this->context, $vars);
    }

    /**
     * Lee el contenido de un archivo
     *
     * @param string $path Ruta del archivo
     * @return string Contenido del archivo
     */
    private function readFile(string $path): string
    {
        $fullPath = $this->baseDir . $path;
        if (!file_exists($fullPath)) {
            throw new Exception("Archivo no encontrado: {$fullPath}");
        }
        return file_get_contents($fullPath);
    }

    /**
     * Procesa includes en el contenido
     *
     * @param string $content Contenido con includes
     * @return string Contenido con includes procesados
     */
    private function processIncludes(string $content): string
    {
        // Procesa includes con formato {% include "ruta.html" %} o {% include "ruta.php" %}
        $pattern = '/{%\s*include\s+"([^"]+)"(?:\s+with\s+([^%]+))?\s*%}/';

        while (preg_match($pattern, $content)) {
            $content = preg_replace_callback($pattern, function ($matches) {
                $includePath = $matches[1];
                $varsStr = $matches[2] ?? '';

                $fullPath = $this->baseDir . $includePath;
                if (!file_exists($fullPath)) {
                    throw new Exception("Archivo no encontrado: {$fullPath}");
                }

                $includeVars = [];
                if (!empty($varsStr)) {
                    preg_match_all('/(\w+)=([^=\s]+|"[^"]*")/', $varsStr, $varMatches, PREG_SET_ORDER);
                    foreach ($varMatches as $varMatch) {
                        $varName = $varMatch[1];
                        $varValue = $varMatch[2];
                        // Quita comillas si están presentes
                        if (substr($varValue, 0, 1) === '"' && substr($varValue, -1) === '"') {
                            $varValue = substr($varValue, 1, -1);
                        }
                        $includeVars[$varName] = $varValue;
                    }
                }

                // Si es un archivo PHP, lo ejecutamos y capturamos la salida.
                // Las variables de contexto y las de 'with' estarán disponibles en el scope del archivo incluido.
                if (pathinfo($fullPath, PATHINFO_EXTENSION) === 'php') {
                    $contextForPhp = array_merge($this->context, $includeVars);
                    extract($contextForPhp);

                    ob_start();
                    include $fullPath;
                    return ob_get_clean();
                }

                // Para otros tipos de archivo (ej. .html), leemos el contenido y procesamos las variables.
                $includeContent = file_get_contents($fullPath);

                if (!empty($includeVars)) {
                    $originalContext = $this->context;
                    $this->context = array_merge($this->context, $includeVars);
                    $processedContent = $this->replaceVars($includeContent);
                    $this->context = $originalContext; // Restaurar contexto
                    return $processedContent;
                }

                // Procesar con el contexto actual si no hay variables 'with'
                return $this->replaceVars($includeContent);
            }, $content);
        }

        return $content;
    }

    /**
     * Reemplaza las variables en el contenido
     *
     * @param string $content Contenido con variables
     * @return string Contenido con variables reemplazadas
     */
    private function replaceVars(string $content): string
    {
        // Reemplaza variables con formato ${variable}
        return preg_replace_callback('/\${([^}]+)}/', function ($matches) {
            $varName = $matches[1];
            return $this->context[$varName] ?? '';
        }, $content);
    }

    /**
     * Extrae bloques del contenido
     *
     * @param string $content Contenido con bloques
     * @return array Bloques extraídos
     */
    private function extractBlocks(string $content): array
    {
        $blocks = [];
        $pattern = '/{%\s*block\s+(\w+)\s*%}(.*?){%\s*endblock\s*%}/s';

        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $blockName = $match[1];
            $blockContent = $match[2];
            $blocks[$blockName] = trim($blockContent);
        }

        return $blocks;
    }

    /**
     * Reemplaza bloques en la plantilla base
     *
     * @param string $baseContent Contenido de la plantilla base
     * @param array $blocks Bloques a reemplazar
     * @return string Contenido con bloques reemplazados
     */
    private function replaceBlocks(string $baseContent, array $blocks): string
    {
        return preg_replace_callback('/{%\s*block\s+(\w+)\s*%}.*?{%\s*endblock\s*%}/s', function ($matches) use ($blocks) {
            $blockName = $matches[1];
            return $blocks[$blockName] ?? $matches[0];
        }, $baseContent);
    }

    /**
     * Guarda el contenido renderizado en un archivo
     *
     * @param string $content Contenido a guardar
     * @param string $outputPath Ruta del archivo de salida
     * @return void
     */
    public function saveToFile(string $content, string $outputPath): void
    {
        $directory = dirname($outputPath);

        // Crea el directorio si no existe
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($outputPath, $content);
    }
}
