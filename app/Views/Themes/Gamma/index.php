<?php
/**
 * Gamma Template System - Punto de Entrada Único
 * Este archivo es la única interfaz entre CodeIgniter 4 y Gamma
 *
 * Ubicación: C:\xampp\htdocs\app\Views\Themes\Gamma\index.php
 *
 * @package  Gamma
 * @version  1.0.0
 */

// Variables de entrada para la plantilla
/** @var string $theme */
/** @var string $main_template */
/** @var string $breadcrumb */
/** @var string $main */
/** @var string $right */
/** @var string $left */
/** @var string $aside */
/** @var string $logo_portrait */
/** @var string $logo_landscape */
/** @var string $logo_portrait_light */
/** @var string $logo_landscape_light */
/** @var string $canonical */
/** @var string $type */
/** @var string $title */
/** @var string $description */
/** @var string $messenger */
/** @var string $messenger_users */
/** @var string $benchmark */
/** @var string $modals */
/** @var string $version */


// Definir la ruta base de Gamma
define('GAMMA_PATH', __DIR__ . DIRECTORY_SEPARATOR);

// Autoloader para las clases de Gamma
spl_autoload_register(function ($class) {
    // Solo cargar clases del namespace Gamma
    if (strpos($class, 'Gamma\\') === 0) {
        $className = str_replace('Gamma\\', '', $class);
        $file = GAMMA_PATH . 'Libraries' . DIRECTORY_SEPARATOR . $className . '.php';

        if (file_exists($file)) {
            require_once $file;
        }
    }
});

// Cargar librerías principales explícitamente para asegurar que existan.
require_once GAMMA_PATH . 'Libraries/ThemeHelper.php'; // Cargar el nuevo helper
require_once GAMMA_PATH . 'Libraries/TemplateEngine.php';
require_once GAMMA_PATH . 'Libraries/GammaTheme.php';
require_once GAMMA_PATH . 'Libraries/SidebarGenerator.php';
require_once GAMMA_PATH . 'Libraries/GammaRenderer.php';

// --- INICIO: Definición del Helper de Assets de Gamma ---
if (!function_exists('gamma_asset')) {
    /**
     * Genera una URL para un asset del tema Gamma con versionado automático.
     */
    function gamma_asset(string $type, string $file): string
    {
        static $gammaTheme = null;
        if ($gammaTheme === null) {
            if (!class_exists('Gamma\GammaTheme')) {
                require_once GAMMA_PATH . 'Libraries/GammaTheme.php';
            }
            $gammaTheme = new \Gamma\GammaTheme(GAMMA_PATH);
        }
        return $gammaTheme->getAssetUrl($type, $file);
    }
}
// --- FIN: Definición del Helper de Assets de Gamma ---

try {
    $data = array(
        "pk" => pk(),
        'user' => safe_get_user(),
        'client' => safe_get_instance(),
        'userfullname' => safe_get_user_fullname(),
        'alias' => safe_get_user_alias(),
        'avatar' => safe_get_user_avatar(),
        "theme" => $theme,
        "page" => @$page,
        "layout" => $main_template,
        "breadcrumb" => @$breadcrumb,
        "main_content" => @$main,
        "main_content_right" => @$right,
        "aside_content" => @$aside,
        "sidebar_content" => $left,
        "logo_portrait" => $logo_portrait,
        "logo_landscape" => $logo_landscape,
        "logo_portrait_light" => $logo_portrait_light,
        "logo_landscape_light" => $logo_landscape_light,
        "canonical" => $canonical,
        "type" => $type,
        "title" => $title,
        "description" => $description,
        "messenger" => $messenger,
        "messenger_users" => $messenger_users,
        "benchmark" => $benchmark,
        "modals" => $modals,
        "version" => $version,
    );
    //echo($data["main_content"]); // Se verifico manualmente si llegan los datos
    // Inicializar el renderizador con la ruta base
    $renderer = new \Gamma\GammaRenderer(GAMMA_PATH);
    // Renderizar con los datos recibidos desde el controlador
    echo $renderer->render($data ?? []);

} catch (\Exception $e) {
    // Manejo de errores
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
        echo '<div style="padding: 20px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px;">';
        echo '<h2>Error en Gamma Template</h2>';
        echo '<p><strong>Mensaje:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '<p><strong>Archivo:</strong> ' . htmlspecialchars($e->getFile()) . '</p>';
        echo '<p><strong>Línea:</strong> ' . $e->getLine() . '</p>';
        echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
        echo '</div>';
    } else {
        echo '<div style="padding: 20px; text-align: center;">';
        echo '<h2>Lo sentimos, ocurrió un error</h2>';
        echo '<p>Por favor, intente nuevamente más tarde.</p>';
        echo '</div>';
    }
}
