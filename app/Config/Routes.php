<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();
// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Configuración del enrutador
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Main');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Definiciones de las rutas
 * --------------------------------------------------------------------
 */

// --- Rutas para servir assets del tema (PÚBLICAS) ---
// Esta ruta debe ir ANTES de la carga de rutas de los módulos para evitar filtros de autenticación.
// (:any) captura todos los segmentos restantes, incluyendo slashes, y los pasa al controlador.
$routes->get('ui/themes/(:segment)/(:any)', 'ThemeController::serveAsset/$1/$2');

// Obtenemos un aumento de rendimiento al especificar el valor 
// predeterminado en la ruta ya que no tenemos que escanear directorios.
$routes->get('/', 'Main::index');
$routes->get('/ai', 'Ai::index');
$routes->get('/ai/get/(:any)', 'Ai::get/$1');
$routes->get('/migrate', 'Migrate::index');
$routes->get('/robots.txt', 'Main::robots');
$routes->get('/sitemap.xml', 'Main::sitemap');
$routes->get('/api/theme/(:any)/(:any)/(:any)', 'Api::theme/$1/$2/$3');
$routes->get('/hook', 'Main::hook');
$routes->get('/debug', 'Debug::index');
$routes->get('/debug/session', 'Debug::session');
$routes->get('/debug/telesign', 'Debug::telesign');
$routes->get('/debug/minify', 'Debug::minify');
$routes->get('/debug/phpinfo', 'Debug::phpinfo');
$routes->get('/debug/logs', 'Debug::logs');
//$routes->get('/arc-widget', 'Arc::index');
//$routes->get('/arc-sw', 'Arc::sw');
$routes->get('/bootstrap5', 'Bootstrap5::index');
$routes->get('/styles/hello', 'Styles::hello');
$routes->get('/styles/css/(:any)', 'Styles::index/$1');
$routes->addRedirect('/sedux/(:any)/(:any)/(:any)', '/edux/$1/$2/$3');

//https://intranet.ita.edu.co/sedux/documents/view/65135745E2544
/**
 * --------------------------------------------------------------------
 * HMVC Routing
 * --------------------------------------------------------------------
 */
foreach (glob(APPPATH . 'Modules/*', GLOB_ONLYDIR) as $item_dir) {
    if (file_exists($item_dir . '/Config/Config.php')) {
        require_once($item_dir . '/Config/Config.php');
    } else {
        if (file_exists($item_dir . '/Config/Routes.php')) {
            try {
                require_once($item_dir . '/Config/Routes.php');
            } catch (\Throwable $e) {
                log_message('error', "Error cargando rutas del módulo {$item_dir}: " . $e->getMessage());
                // Continuar con otros módulos en lugar de fallar completamente
            }
        }
        if (file_exists($item_dir . '/Config/Constants.php')) {
            require_once($item_dir . '/Config/Constants.php');
        }
    }
}

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing, and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
