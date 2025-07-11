<?php

/**
 * BetaRenderer - Sistema de plantillas para el tema Beta
 * 
 * Esta clase implementa un motor de plantillas que recibe datos y retorna
 * directamente el HTML generado, sin crear archivos intermedios.
 */
class BetaRenderer {
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
     */
    public function __construct() {
        $this->baseDir = __DIR__ . '/';
    }
    
    /**
     * Establece una variable de contexto
     * 
     * @param string $name Nombre de la variable
     * @param mixed $value Valor de la variable
     * @return self
     */
    public function setVar(string $name, $value): self {
        $this->context[$name] = $value;
        return $this;
    }
    
    /**
     * Renderiza una plantilla con los datos proporcionados
     *
     * @param string $templatePath Ruta relativa de la plantilla
     * @param array $data Datos para la plantilla
     * @return string HTML generado
     */
    public function render(string $templatePath, array $data = []): string {
        // Añade los datos al contexto
        if (!empty($data)) {
            $this->setVars($data);
        }

        // Lee el contenido de la plantilla
        $content = $this->readFile($templatePath);

        // Procesa includes
        $content = $this->processIncludes($content);

        // Extrae bloques
        $blocks = $this->extractBlocks($content);

        // Si la plantilla extiende otra, procesa la extensión
        if (preg_match('/{%\s*extends\s+"([^"]+)"\s*%}/', $content, $matches)) {
            $basePath = $matches[1];
            $baseContent = $this->readFile($basePath);

            // Procesa includes en la plantilla base
            $baseContent = $this->processIncludes($baseContent);

            // Reemplaza bloques en la plantilla base
            $content = $this->replaceBlocks($baseContent, $blocks);
        }

        // Reemplaza variables
        $content = $this->replaceVars($content);

        return $content;
    }
    
    /**
     * Establece múltiples variables de contexto
     *
     * @param array $vars Arreglo asociativo de variables
     * @return self
     */
    public function setVars(array $vars): self {
        $this->context = array_merge($this->context, $vars);
        return $this;
    }
    
    /**
     * Lee el contenido de un archivo
     *
     * @param string $path Ruta del archivo
     * @return string Contenido del archivo
     */
    private function readFile(string $path): string {
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
    private function processIncludes(string $content): string {
        // Procesa includes con formato {% include "ruta.html" %}
        $pattern = '/{%\s*include\s+"([^"]+)"(?:\s+with\s+([^%]+))?\s*%}/';
        
        while (preg_match($pattern, $content)) {
            $content = preg_replace_callback($pattern, function($matches) {
                $includePath = $matches[1];
                $varsStr = isset($matches[2]) ? $matches[2] : '';
                
                // Lee el archivo a incluir
                $includeContent = $this->readFile($includePath);
                
                // Procesa variables específicas del include
                if (!empty($varsStr)) {
                    $vars = [];
                    preg_match_all('/(\w+)=([^=\s]+|"[^"]*")/', $varsStr, $varMatches, PREG_SET_ORDER);
                    
                    foreach ($varMatches as $varMatch) {
                        $varName = $varMatch[1];
                        $varValue = $varMatch[2];
                        // Quita comillas si están presentes
                        if (substr($varValue, 0, 1) === '"' && substr($varValue, -1) === '"') {
                            $varValue = substr($varValue, 1, -1);
                        }
                        $vars[$varName] = $varValue;
                    }
                    
                    // Crea una copia del contexto actual y añade las variables específicas
                    $tempContext = $this->context;
                    $this->context = array_merge($this->context, $vars);
                    
                    // Reemplaza variables en el contenido incluido
                    $includeContent = $this->replaceVars($includeContent);
                    
                    // Restaura el contexto original
                    $this->context = $tempContext;
                } else {
                    // Reemplaza variables en el contenido incluido usando el contexto actual
                    $includeContent = $this->replaceVars($includeContent);
                }
                
                // Procesa includes anidados
                $includeContent = $this->processIncludes($includeContent);
                
                return $includeContent;
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
    private function replaceVars(string $content): string {
        // Reemplaza variables con formato ${variable}
        return preg_replace_callback('/\${([^}]+)}/', function($matches) {
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
    private function extractBlocks(string $content): array {
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
    private function replaceBlocks(string $baseContent, array $blocks): string {
        return preg_replace_callback('/{%\s*block\s+(\w+)\s*%}.*?{%\s*endblock\s*%}/s', function($matches) use ($blocks) {
            $blockName = $matches[1];
            return $blocks[$blockName] ?? $matches[0];
        }, $baseContent);
    }
    
    /**
     * Renderiza solo el contenido principal de una plantilla
     * Esta función extrae únicamente el contenido dentro del bloque "content"
     * sin incluir el DOCTYPE, HTML, HEAD y otras etiquetas estructurales
     *
     * @param string $templatePath Ruta relativa de la plantilla
     * @param array $data Datos para la plantilla
     * @return string HTML del contenido extraído
     */
    public function renderContentOnly(string $templatePath, array $data = []): string {
        // Añade los datos al contexto
        if (!empty($data)) {
            $this->setVars($data);
        }

        // Lee el contenido de la plantilla
        $content = $this->readFile($templatePath);

        // Procesa includes dentro del contenido
        $content = $this->processIncludes($content);

        // Extrae el bloque de contenido
        $blocks = $this->processBlocks($content);

        // Si existe un bloque de contenido, lo usamos
        if (isset($blocks['content'])) {
            $contentHtml = $blocks['content'];
        } else {
            // Si no hay bloque de contenido, eliminamos todo lo que no necesitamos
            // Eliminamos DOCTYPE, html, head, body tags
            $contentHtml = preg_replace('/<\!DOCTYPE.*?>/is', '', $content);
            $contentHtml = preg_replace('/<html.*?>/is', '', $contentHtml);
            $contentHtml = preg_replace('/<\/html>/is', '', $contentHtml);
            $contentHtml = preg_replace('/<head>.*?<\/head>/is', '', $contentHtml);
            $contentHtml = preg_replace('/<body.*?>/is', '', $contentHtml);
            $contentHtml = preg_replace('/<\/body>/is', '', $contentHtml);
        }

        // Reemplazamos las variables en el contenido extraído
        $contentHtml = $this->replaceVars($contentHtml);

        return $contentHtml;
    }
    
    /**
     * Procesa los bloques de contenido en la plantilla
     *
     * @param string $content Contenido con bloques
     * @return array Bloques extraídos
     */
    private function processBlocks(string $content): array {
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
     * Procesa condicionales en el contenido
     *
     * @param string $content Contenido con condicionales
     * @return string Contenido procesado
     */
    private function processConditionals(string $content): string {
        // Procesa condicionales con formato {% if condición %}...{% endif %}
        $pattern = '/{%\s*if\s+([^%]+)\s*%}(.*?)(?:{%\s*else\s*%}(.*?))?{%\s*endif\s*%}/s';

        return preg_replace_callback($pattern, function($matches) {
            $condition = $matches[1];
            $ifContent = $matches[2];
            $elseContent = isset($matches[3]) ? $matches[3] : '';

            // Evalúa la condición
            $result = false;

            // Si la condición es una variable, verifica si existe y es verdadera
            if (preg_match('/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $condition)) {
                $result = isset($this->context[$condition]) && $this->context[$condition];
            } else {
                // Condición más compleja
                $code = 'return ' . $this->parseCondition($condition) . ';';
                $result = eval($code);
            }

            // Devuelve el contenido correspondiente
            return $result ? $ifContent : $elseContent;
        }, $content);
    }
    
    /**
     * Parsea una condición para evaluación segura
     *
     * @param string $condition Condición a parsear
     * @return string Condición parseada
     */
    private function parseCondition(string $condition): string {
        // Reemplaza variables en la condición
        return preg_replace_callback('/\b([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)\b/', function($matches) {
            $varName = $matches[1];
            // Verifica si la variable existe en el contexto
            if (isset($this->context[$varName])) {
                // Si es un string, devuelve la representación segura
                if (is_string($this->context[$varName])) {
                    return "'" . addslashes($this->context[$varName]) . "'";
                }
                // Si es un valor booleano, numérico, etc.
                return var_export($this->context[$varName], true);
            }
            // Si la variable no existe, devuelve false
            return 'false';
        }, $condition);
    }
}
