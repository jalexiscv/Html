<?php

/**
 * Clase principal del tema Beta
 *
 * Esta clase actúa como punto de entrada para el tema Beta y proporciona
 * métodos para renderizar plantillas y generar páginas HTML.
 */
class BetaTheme
{
    /**
     * Ruta base del tema
     */
    private string $basePath;

    /**
     * Generador de temas
     */
    private ThemeGenerator $generator;

    /**
     * Motor de plantillas
     */
    private TemplateEngine $engine;

    /**
     * Variables globales para todas las plantillas
     */
    private array $globalVars = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        // Obtiene la ruta base del tema
        $this->basePath = __DIR__ . '/';

        // Carga las clases necesarias
        require_once $this->basePath . 'TemplateEngine.php';
        require_once $this->basePath . 'ThemeGenerator.php';

        // Inicializa el motor de plantillas y el generador
        $this->engine = new TemplateEngine($this->basePath);
        $this->generator = new ThemeGenerator($this->basePath);
    }

    /**
     * Establece una variable global para todas las plantillas
     *
     * @param string $name Nombre de la variable
     * @param mixed $value Valor de la variable
     * @return self
     */
    public function setVar(string $name, $value): self
    {
        $this->globalVars[$name] = $value;
        return $this;
    }

    /**
     * Establece múltiples variables globales
     *
     * @param array $vars Arreglo asociativo de variables
     * @return self
     */
    public function setVars(array $vars): self
    {
        $this->globalVars = array_merge($this->globalVars, $vars);
        return $this;
    }

    /**
     * Renderiza una plantilla con las variables proporcionadas
     *
     * @param string $template Nombre de la plantilla (ruta relativa)
     * @param array $vars Variables específicas para esta plantilla
     * @return string Contenido HTML generado
     */
    public function render(string $template, array $vars = []): string
    {
        // Combina las variables globales con las específicas de la plantilla
        $allVars = array_merge($this->globalVars, $vars);

        // Renderiza la plantilla
        return $this->generator->renderTemplate($template, $allVars);
    }

    /**
     * Renderiza una página completa
     *
     * @param string $page Nombre de la página (sin extensión)
     * @param array $vars Variables específicas para esta página
     * @return string Contenido HTML de la página
     */
    public function renderPage(string $page, array $vars = []): string
    {
        // Construye la ruta de la plantilla de la página
        $templatePath = 'pages/' . $page . '.html';

        // Combina las variables globales con las específicas de la página
        $allVars = array_merge($this->globalVars, $vars);

        // Renderiza la plantilla
        return $this->generator->renderTemplate($templatePath, $allVars);
    }

    /**
     * Renderiza una plantilla parcial
     *
     * @param string $partial Nombre del parcial (sin extensión)
     * @param array $vars Variables específicas para este parcial
     * @return string Contenido HTML del parcial
     */
    public function renderPartial(string $partial, array $vars = []): string
    {
        // Construye la ruta de la plantilla parcial
        $templatePath = 'partials/' . $partial . '.html';

        // Combina las variables globales con las específicas del parcial
        $allVars = array_merge($this->globalVars, $vars);

        // Renderiza la plantilla
        return $this->generator->renderTemplate($templatePath, $allVars);
    }

    /**
     * Genera todas las páginas configuradas en el directorio de salida
     *
     * @param array $vars Variables adicionales para todas las páginas
     * @return void
     */
    public function buildAll(array $vars = []): void
    {
        // Combina las variables globales con las proporcionadas
        $allVars = array_merge($this->globalVars, $vars);

        // Construye todas las páginas
        $this->generator->build($allVars);
    }

    /**
     * Integra el tema con el sistema de plantillas de CodeIgniter
     *
     * @param string $view Nombre de la vista
     * @param array $data Datos para la vista
     * @param bool $return Si se debe devolver el contenido o imprimirlo directamente
     * @return mixed String si $return es true, de lo contrario void
     */
    public function view(string $view, array $data = [], bool $return = false)
    {
        // Determina el tipo de vista (page, partial, etc.)
        $viewParts = explode('/', $view);
        $viewType = count($viewParts) > 1 ? $viewParts[0] : 'pages';
        $viewName = count($viewParts) > 1 ? $viewParts[1] : $viewParts[0];

        // Construye la ruta de la plantilla
        $templatePath = '' . $viewType . '/' . $viewName . '.html';

        // Combina las variables globales con los datos proporcionados
        $allVars = array_merge($this->globalVars, $data);

        // Renderiza la plantilla
        $content = $this->generator->renderTemplate($templatePath, $allVars);

        // Devuelve o imprime el contenido
        if ($return) {
            return $content;
        } else {
            echo $content;
        }
    }
}
