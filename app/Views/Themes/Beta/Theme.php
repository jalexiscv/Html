<?php

/**
 * Tema Beta - Implementación principal
 * 
 * Este archivo integra el sistema de plantillas con CodeIgniter y proporciona
 * una forma sencilla de generar HTML a partir de plantillas y datos.
 * 
 * El sistema está diseñado para replicar la funcionalidad del generador Python
 * pero utilizando PHP puro, sin dependencias externas.
 */

// Cargamos los componentes necesarios
require_once __DIR__ . '/TemplateEngine.php';
require_once __DIR__ . '/ThemeGenerator.php';
require_once __DIR__ . '/BetaTheme.php';

/**
 * Función principal para renderizar una vista utilizando el tema Beta
 * 
 * @param string $view Nombre de la vista a renderizar
 * @param array $data Datos para la vista
 * @param bool $return Si se debe devolver el contenido o imprimirlo directamente
 * @return mixed String si $return es true, de lo contrario void
 */
function render_beta_theme(string $view, array $data = [], bool $return = false) {
    // Creamos una instancia del tema Beta
    $theme = new BetaTheme();
    
    // Configuramos las variables globales
    $theme->setVars($data);
    
    // Renderizamos la vista
    return $theme->view($view, [], $return);
}

/**
 * Clase que implementa el tema Beta para CodeIgniter
 * 
 * Esta clase actúa como punto de entrada para el sistema de vistas
 * y proporciona métodos para generar HTML a partir de plantillas.
 */
class Theme {
    /**
     * Instancia del tema Beta
     */
    private BetaTheme $betaTheme;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->betaTheme = new BetaTheme();
    }
    
    /**
     * Renderiza la plantilla principal con todos los datos proporcionados
     * 
     * @param array $data Datos para la plantilla
     * @return string Contenido HTML generado
     */
    public function render(array $data = []): string {
        // Configuramos las variables globales
        $this->betaTheme->setVars($data);
        
        // Construimos los datos de bloques para la plantilla principal
        $blocks = [
            'title' => $data['title'] ?? 'Dashboard',
            'navbar' => isset($data['main_template']) ? $this->renderPartial('header', $data) : '',
            'sidebar' => isset($data['left']) ? $this->renderPartial('left-sidebar', $data) : '',
            'right_sidebar' => isset($data['right']) ? $this->renderPartial('right-sidebar', $data) : '',
            'content' => isset($data['main']) ? $this->renderContent($data) : ''
        ];
        
        // Renderizamos la plantilla base
        return $this->betaTheme->render('layouts/base.html', $blocks);
    }
    
    /**
     * Renderiza el contenido principal basado en el template proporcionado
     * 
     * @param array $data Datos para el contenido
     * @return string Contenido HTML generado
     */
    private function renderContent(array $data): string {
        // Si existe un template principal, lo renderizamos
        if (isset($data['main_template'])) {
            $templatePath = 'pages/' . $data['main_template'] . '.html';
            return $this->betaTheme->render($templatePath, $data);
        }
        
        // Si existe contenido principal, lo devolvemos directamente
        if (isset($data['main'])) {
            return $data['main'];
        }
        
        // Por defecto, devolvemos una página de dashboard
        return $this->betaTheme->renderPage('dashboard', $data);
    }
    
    /**
     * Renderiza una plantilla parcial
     * 
     * @param string $partial Nombre del parcial
     * @param array $data Datos para el parcial
     * @return string Contenido HTML generado
     */
    public function renderPartial(string $partial, array $data = []): string {
        return $this->betaTheme->renderPartial($partial, $data);
    }
    
    /**
     * Renderiza una página completa
     * 
     * @param string $page Nombre de la página
     * @param array $data Datos para la página
     * @return string Contenido HTML generado
     */
    public function renderPage(string $page, array $data = []): string {
        return $this->betaTheme->renderPage($page, $data);
    }
    
    /**
     * Método estático para iniciar la renderización de un tema
     * 
     * @param array $data Datos para la renderización
     * @return string Contenido HTML generado
     */
    public static function display(array $data = []): string {
        $theme = new self();
        return $theme->render($data);
    }
}
