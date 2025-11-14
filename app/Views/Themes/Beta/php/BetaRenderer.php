<?php

/**
 * BetaRenderer - Sistema de plantillas para el tema Beta
 *
 * Esta clase implementa un motor de plantillas que recibe datos y retorna
 * directamente el HTML generado, sin crear archivos intermedios.
 */
class BetaRenderer
{
    /**
     * Gestor de versiones para assets
     */
    public ?VersionManager $versionManager = null;
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
    public function __construct()
    {
        // Apunta al directorio padre (Beta) para acceder a php/pages/, php/layouts/, etc.
        $this->baseDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR;

        // Inicializa el gestor de versiones si la clase existe
        if (class_exists('VersionManager')) {
            $this->versionManager = new VersionManager();
        }
    }

    /**
     * Renderiza una plantilla completa
     *
     * @param string $templatePath Ruta relativa de la plantilla
     * @param array $data Datos para la plantilla
     * @return string HTML renderizado
     */
    public function render(string $templatePath, array $data = []): string
    {
        // Agregar variables de tema y datos proporcionados al contexto
        $this->addThemeVariables();
        if (!empty($data)) {
            $this->setVars($data);
        }

        $pageContent = $this->readFile($templatePath);

        // Comprueba si la plantilla extiende de otra
        $baseTemplatePath = null;
        if (preg_match('/{%\s*extends\s+"([^"]+)"\s*%}/', $pageContent, $matches)) {
            $baseTemplatePath = $matches[1];
        }

        // Si extiende, procesamos los bloques y usamos la plantilla base
        if ($baseTemplatePath) {
            // Extrae todos los bloques de la página (title, content, modals, etc.)
            $blocks = $this->extractBlocks($pageContent);

            // Añade el contenido de cada bloque como una variable al contexto.
            // Esto permite que la plantilla base use ${title}, ${content}, ${modals}.
            foreach ($blocks as $name => $content) {
                // Procesamos los includes que puedan estar DENTRO de un bloque
                $processedBlockContent = $this->processIncludes($content);
                $this->setVar($name, $processedBlockContent);
            }

            // La plantilla final a procesar es la base
            $finalContent = $this->readFile($baseTemplatePath);

        } else {
            // Si no extiende, la plantilla final es la página misma
            $finalContent = $pageContent;
        }

        // Procesa includes, condicionales, assets y variables en la plantilla final
        $finalContent = $this->processIncludes($finalContent);
        $finalContent = $this->processConditionals($finalContent);
        $finalContent = $this->processAssetFunctions($finalContent);
        $finalContent = $this->replaceVars($finalContent);

        return $finalContent;
    }

    /**
     * Agrega variables de tema y sistema al contexto
     */
    private function addThemeVariables(): void
    {
        // Generar pk único para todos los casos
        $this->context['pk'] = strtoupper(uniqid());
        $this->context['csrf_name'] = csrf_token();
        $this->context['csrf_value'] = csrf_hash();

        if (class_exists('ThemeManager')) {
            $bodyClass = ThemeManager::getBodyClass();
            $currentTheme = ThemeManager::getCurrentTheme();

            $this->context['theme_body_class'] = $bodyClass;
            $this->context['theme_data_attribute'] = ThemeManager::getDataTheme() ? 'data-theme="' . ThemeManager::getDataTheme() . '"' : '';
            $this->context['theme_sync_script'] = ThemeManager::getClientSyncScript();
            $this->context['current_theme'] = $currentTheme;
            $this->context['is_dark_theme'] = $bodyClass === 'dark-mode';
            $this->context['is_light_theme'] = $bodyClass === 'light-mode';
        } else {
            // Fallback si ThemeManager no está disponible - detectar por hora
            $hour = (int)date('H');
            $isDarkTime = ($hour >= 20 || $hour <= 6);

            $this->context['theme_body_class'] = $isDarkTime ? 'dark-mode' : 'light-mode';
            $this->context['theme_data_attribute'] = '';
            $this->context['theme_sync_script'] = '';
            $this->context['current_theme'] = $isDarkTime ? 'dark' : 'light';
            $this->context['is_dark_theme'] = $isDarkTime;
            $this->context['is_light_theme'] = !$isDarkTime;
        }
    }

    /**
     * Establece múltiples variables de contexto
     *
     * @param array $vars Arreglo asociativo de variables
     * @return self
     */
    public function setVars(array $vars): self
    {
        $this->context = array_merge($this->context, $vars);
        return $this;
    }

    /**
     * Lee el contenido de un archivo
     *
     * @param string $path Ruta del archivo
     * @return string Contenido del archivo
     */
    private function readFile(string $path): string
    {
        // Normaliza los separadores de directorio
        $normalizedPath = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $path);
        $fullPath = $this->baseDir . $normalizedPath;

        if (!file_exists($fullPath)) {
            throw new Exception("Archivo no encontrado: {$fullPath}");
        }
        return file_get_contents($fullPath);
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
     * Procesa includes en el contenido
     *
     * @param string $content Contenido con includes
     * @return string Contenido con includes procesados
     */
    private function processIncludes(string $content): string
    {
        // Procesa includes con formato {% include "ruta.html" %}
        $pattern = '/{%\s*include\s+"([^"]+)"(?:\s+with\s+([^%]+))?\s*%}/';

        while (preg_match($pattern, $content)) {
            $content = preg_replace_callback($pattern, function ($matches) {
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

                // Procesar el contenido final
                $finalContent = $this->replaceVars($includeContent);

                // Procesar funciones de assets para versionado
                if (function_exists('process_asset_functions')) {
                    $finalContent = process_asset_functions($finalContent);
                }

                return $finalContent;
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
        $content = preg_replace_callback('/\${([^}]+)}/', function ($matches) {
            $varName = $matches[1];
            return $this->context[$varName] ?? '';
        }, $content);

        // Procesa funciones de versionado de assets
        $content = $this->processAssetFunctions($content);

        return $content;
    }

    /**
     * Procesa funciones especiales para assets versionados
     *
     * @param string $content Contenido con funciones de assets
     * @return string Contenido con assets versionados
     */
    private function processAssetFunctions(string $content): string
    {
        if (!$this->versionManager) {
            return $content;
        }

        // Procesa asset_css('ruta/archivo.css')
        $content = preg_replace_callback('/asset_css\([\'"]([^\'"]+)[\'"]\)/', function ($matches) {
            $cssPath = $matches[1];
            return $this->versionManager->getCssTag($cssPath);
        }, $content);

        // Procesa asset_js('ruta/archivo.js')
        $content = preg_replace_callback('/asset_js\([\'"]([^\'"]+)[\'"]\)/', function ($matches) {
            $jsPath = $matches[1];
            return $this->versionManager->getJsTag($jsPath);
        }, $content);

        // Procesa asset_url('ruta/archivo')
        $content = preg_replace_callback('/asset_url\([\'"]([^\'"]+)[\'"]\)/', function ($matches) {
            $assetPath = $matches[1];
            return $this->versionManager->getVersionedAssetUrl($assetPath);
        }, $content);

        // Procesa asset_img('ruta/imagen')
        $content = preg_replace_callback('/asset_img\([\'"]([^\'"]+)[\'"]\)/', function ($matches) {
            $imagePath = $matches[1];
            return $this->versionManager->getImageUrl($imagePath);
        }, $content);

        return $content;
    }

    /**
     * Establece una variable de contexto
     *
     * @param string $name Nombre de la variable
     * @param mixed $value Valor de la variable
     * @return self
     */
    public function setVar(string $name, $value): self
    {
        $this->context[$name] = $value;
        return $this;
    }

    /**
     * Procesa condicionales en el contenido
     *
     * @param string $content Contenido con condicionales
     * @return string Contenido procesado
     */
    private function processConditionals(string $content): string
    {
        // Procesa condicionales con formato {% if condición %}...{% endif %}
        $pattern = '/{%\s*if\s+([^%]+)\s*%}(.*?)(?:{%\s*else\s*%}(.*?))?{%\s*endif\s*%}/s';

        return preg_replace_callback($pattern, function ($matches) {
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
    private function parseCondition(string $condition): string
    {
        // Reemplaza variables en la condición
        return preg_replace_callback('/\b([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)\b/', function ($matches) {
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

    /**
     * Renderiza solo el contenido principal de una plantilla
     * Esta función extrae únicamente el contenido dentro del bloque "content"
     * sin incluir el DOCTYPE, HTML, HEAD y otras etiquetas estructurales
     *
     * @param string $templatePath Ruta relativa de la plantilla
     * @param array $data Datos para la plantilla
     * @return string HTML del contenido extraído
     */
    public function renderContentOnly(string $templatePath, array $data = []): string
    {
        //echo("RenderContentOnly");
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
    private function processBlocks(string $content): array
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
}
