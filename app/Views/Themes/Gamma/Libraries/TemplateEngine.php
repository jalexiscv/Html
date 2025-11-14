<?php

namespace Gamma;

/**
 * Template Engine
 * Motor de plantillas con sintaxis personalizada
 *
 * Sintaxis soportada:
 * - Variables: ${variable_name}
 * - Condicionales: {% if condition %}content{% endif %}
 * - Inclusiones: {% include 'path/to/file' %}
 *
 * @package  Gamma
 * @version  1.0.0
 */
class TemplateEngine
{
    private $basePath;
    private $data = [];
    private $compiledCache = [];

    /**
     * Constructor
     *
     * @param string $basePath Ruta base del tema Gamma
     */
    public function __construct($basePath)
    {
        $this->basePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    /**
     * Renderizar una plantilla
     *
     * @param string $templatePath Ruta relativa de la plantilla
     * @param array $data Datos para la plantilla
     * @return string HTML renderizado
     */
    public function render($templatePath, $data = [])
    {
        $this->data = array_merge($this->data, $data);

        // Cargar el contenido de la plantilla
        $content = $this->loadTemplate($templatePath);

        // Procesar en orden: includes → conditionals → variables
        $content = $this->processIncludes($content);
        $content = $this->processConditionals($content, $this->data);
        $content = $this->processVariables($content, $this->data);

        return $content;
    }

    /**
     * Cargar archivo de plantilla
     *
     * @param string $path Ruta relativa de la plantilla
     * @return string Contenido de la plantilla
     * @throws \Exception Si el archivo no existe
     */
    private function loadTemplate($path)
    {
        // Normalizar la ruta (añadir .php si no lo tiene)
        if (substr($path, -4) !== '.php') {
            $path .= '.php';
        }

        $fullPath = $this->basePath . $path;

        if (!file_exists($fullPath)) {
            throw new \Exception("Template no encontrado: {$fullPath}");
        }

        // Hacer que los datos globales (como 'username', 'page_title') estén disponibles como variables
        // dentro del archivo de la plantilla que se va a incluir.
        extract($this->data);

        // Iniciar el búfer de salida para capturar todo el contenido renderizado.
        ob_start();

        // Incluir el archivo de la plantilla. Esto es CRUCIAL, ya que 'include'
        // ejecuta el código PHP, mientras que 'file_get_contents' no lo hace.
        include $fullPath;

        // Obtener el contenido del búfer (HTML + PHP ejecutado) y limpiarlo.
        return ob_get_clean();
    }

    /**
     * Procesar inclusiones {% include 'path' %}
     *
     * @param string $content Contenido de la plantilla
     * @return string Contenido con inclusiones procesadas
     */
    private function processIncludes($content)
    {
        $pattern = '/\{%\s*include\s+[\'"]([^\'"]+)[\'"]\s*%\}/';

        return preg_replace_callback($pattern, function ($matches) {
            $includePath = $matches[1];

            try {
                return $this->loadTemplate($includePath);
            } catch (\Exception $e) {
                return "<!-- Error al incluir: {$includePath} -->";
            }
        }, $content);
    }

    /**
     * Procesar condicionales {% if condition %}
     *
     * @param string $content Contenido de la plantilla
     * @param array $data Datos para evaluar condiciones
     * @return string Contenido con condicionales procesados
     */
    private function processConditionals($content, $data)
    {
        // Pattern para {% if condition %}content{% endif %}
        $pattern = '/\{%\s*if\s+([^%]+)\s*%\}(.*?)\{%\s*endif\s*%\}/s';

        return preg_replace_callback($pattern, function ($matches) use ($data) {
            $condition = trim($matches[1]);
            $contentBlock = $matches[2];

            // Evaluar la condición
            if ($this->evaluateCondition($condition, $data)) {
                return $contentBlock;
            }

            return '';
        }, $content);
    }

    /**
     * Evaluar una condición
     *
     * @param string $condition Condición a evaluar
     * @param array $data Datos disponibles
     * @return bool Resultado de la evaluación
     */
    private function evaluateCondition($condition, $data)
    {
        // Soporte para negación con !
        if (strpos($condition, '!') === 0) {
            $varName = trim(substr($condition, 1));
            return empty($data[$varName]);
        }

        // Soporte para comparaciones
        if (preg_match('/(.+?)\s*(==|!=|>|<|>=|<=)\s*(.+)/', $condition, $parts)) {
            $left = $this->resolveValue(trim($parts[1]), $data);
            $operator = $parts[2];
            $right = $this->resolveValue(trim($parts[3]), $data);

            switch ($operator) {
                case '==':
                    return $left == $right;
                case '!=':
                    return $left != $right;
                case '>':
                    return $left > $right;
                case '<':
                    return $left < $right;
                case '>=':
                    return $left >= $right;
                case '<=':
                    return $left <= $right;
            }
        }

        // Condición simple: verificar si la variable existe y no está vacía
        return !empty($data[$condition]);
    }

    /**
     * Resolver el valor de una expresión
     *
     * @param string $expression Expresión a resolver
     * @param array $data Datos disponibles
     * @return mixed Valor resuelto
     */
    private function resolveValue($expression, $data)
    {
        // Si es una cadena entre comillas
        if (preg_match('/^[\'"](.+)[\'"]$/', $expression, $matches)) {
            return $matches[1];
        }

        // Si es un número
        if (is_numeric($expression)) {
            return $expression + 0; // Convertir a int o float
        }

        // Si es una variable
        return $data[$expression] ?? null;
    }

    /**
     * Procesar variables ${variable_name}
     *
     * @param string $content Contenido de la plantilla
     * @param array $data Datos para las variables
     * @return string Contenido con variables reemplazadas
     */
    private function processVariables($content, $data)
    {
        $pattern = '/\$\{([a-zA-Z0-9_]+)\}/';

        return preg_replace_callback($pattern, function ($matches) use ($data) {
            $varName = $matches[1];

            if (isset($data[$varName])) {
                // Devolver siempre el contenido directamente sin escapar.
                return $data[$varName];
            }

            return ''; // Variable no definida
        }, $content);
    }

    /**
     * Establecer datos globales
     *
     * @param array $data Datos globales
     */
    public function setData($data)
    {
        $this->data = array_merge($this->data, $data);
    }
}
