<?php

/**
 * Punto de entrada principal para el tema Beta
 * 
 * Este archivo recibe datos y retorna directamente el HTML generado
 * integrando la plantilla base con los parciales y la información recibida.
 */

// Carga el autoloader del tema
require_once __DIR__ . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'autoload.php';

// Cargamos el motor de renderizado
require_once __DIR__ . '/php/BetaRenderer.php';

/**
 * Procesa una solicitud AJAX para actualizar preferencias de la sesión
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['javascript'])) {
    if (isset($_POST['leftSidebar'])) {
        $_SESSION['leftSidebar'] = $_POST['leftSidebar'];
    }
    if (isset($_POST['rightSidebar'])) {
        $_SESSION['rightSidebar'] = $_POST['rightSidebar'];
    }
    exit;
}

/**
 * Función principal que genera el HTML del tema Beta
 * 
 * @param array $data Datos para las plantillas
 * @return string HTML generado
 */
function render_beta(array $data = []): string {
    // Inicializamos el motor de renderizado
    $renderer = new BetaRenderer();

    // Preparamos los datos para la renderización
    $s = service('strings');

    // Procesamos las variables que requieren decodificación
    if (isset($data['title'])) {
        $data['title'] = $s->get_URLDecode($data['title']);
    }

    if (isset($data['description'])) {
        $data['description'] = $s->get_URLDecode($data['description']);
    }

    // Definimos el contenido de los bloques principales
    $contentBlocks = [
        'title' => $data['title'] ?? 'Beta Dashboard',
        'navbar' => '',
        'content' => '',
        'left_sidebar' => '',
        'right' => '',
        'right_sidebar_header' => '',
        'right_sidebar_content' => '',
        'modals' => '',
        'main_template' => '',
    ];

    // Cargamos los parciales según los datos proporcionados
    if (isset($data['left'])) {
        $contentBlocks['left_sidebar'] = $data['left'];
    }

    // Procesamos los datos del sidebar derecho
    if (isset($data['right-sidebar-header'])) {
        $contentBlocks['right_sidebar_header'] = $data['right-sidebar-header'];
    }

    if (isset($data['right-sidebar-content'])) {
        $contentBlocks['right_sidebar_content'] = $data['right-sidebar-content'];
    }

    // Mantenemos compatibilidad con el formato anterior
    if (isset($data['right'])) {
        $contentBlocks['right'] = $data['right'];
    }

    if (isset($data['modals'])) {
        $contentBlocks['modals'] = $data['modals'];
    }


    // Determinamos el contenido principal
    if (isset($data['main_template'])) {
        // Si se proporciona una plantilla específica, la renderizamos pero solo extraemos el contenido
        $templatePath = "pages\\{$data['main_template']}.html";
        // Usamos false para indicar que no queremos incluir DOCTYPE, HTML, HEAD, etc.
        $contentBlocks['content'] = $renderer->renderContentOnly($templatePath, $data);
    } elseif (isset($data['main'])) {
        // Si se proporciona contenido directo, lo usamos
        $contentBlocks['content'] = $data['main'];
    } else {
        // Por defecto, usamos la plantilla de index.html pero solo extraemos el contenido
        $contentBlocks['content'] = $renderer->renderContentOnly('pages\index.html', $data);
    }

    // Procesamos la URL del logo con versionado
    $logoPath = $data['logo_landscape'] ?? $data['logo_portrait'] ?? 'img/logo.png';

    // Si es una ruta relativa, aplicamos versionado
    if (!filter_var($logoPath, FILTER_VALIDATE_URL)) {
        // Usamos el VersionManager si está disponible
        if ($renderer->versionManager) {
            $data['logo_url'] = $renderer->versionManager->getVersionedAssetUrl($logoPath);
        } else {
            $data['logo_url'] = 'assets/' . $logoPath;
        }
    } else {
        // Es una URL absoluta, la usamos tal como está
        $data['logo_url'] = $logoPath;
    }

    // Debug: Verificar qué datos llegan para el sidebar
    error_log("DEBUG - Parámetro \$left recibido: " . print_r($data['left'] ?? 'NO DEFINIDO', true));
    error_log("DEBUG - right-sidebar-header: " . print_r($data['right-sidebar-header'] ?? 'NO DEFINIDO', true));
    error_log("DEBUG - right-sidebar-content: " . print_r($data['right-sidebar-content'] ?? 'NO DEFINIDO', true));
    error_log("DEBUG - contentBlocks right_sidebar_header: " . print_r($contentBlocks['right_sidebar_header'], true));
    error_log("DEBUG - contentBlocks right_sidebar_content: " . print_r($contentBlocks['right_sidebar_content'], true));

    // Procesamos el menú del sidebar izquierdo extrayendo sidebar_options de $left
    $data['sidebar_title'] = $data['sidebar_title'] ?? 'Navegación';

    // Extraer sidebar_menu_items del vector $left
    $sidebarOptions = [];
    if (isset($data['left']) && !empty($data['left'])) {
        if (is_array($data['left'])) {
            // Compatibilidad con 'sidebar_menu_items' (nuevo) y 'sidebar_options' (antiguo)
            if (isset($data['left']['sidebar_menu_items'])) {
                $sidebarOptions = $data['left']['sidebar_menu_items'];
                // También extraemos el título si está disponible
                if (isset($data['left']['sidebar_title'])) {
                    $data['sidebar_title'] = $data['left']['sidebar_title'];
                }
                error_log("DEBUG - Extraído sidebar_menu_items de \$left: " . print_r($sidebarOptions, true));
            } elseif (isset($data['left']['sidebar_options'])) {
                $sidebarOptions = $data['left']['sidebar_options'];
                error_log("DEBUG - Extraído sidebar_options (legacy) de \$left: " . print_r($sidebarOptions, true));
            } else {
                error_log("DEBUG - \$left no contiene 'sidebar_menu_items' ni 'sidebar_options'. Estructura: " . print_r(array_keys($data['left']), true));
            }
        } elseif (is_string($data['left'])) {
            // Si $left es un string JSON, decodificarlo
            $decoded = json_decode($data['left'], true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                if (isset($decoded['sidebar_menu_items'])) {
                    $sidebarOptions = $decoded['sidebar_menu_items'];
                    if (isset($decoded['sidebar_title'])) {
                        $data['sidebar_title'] = $decoded['sidebar_title'];
                    }
                    error_log("DEBUG - Extraído sidebar_menu_items de \$left JSON: " . print_r($sidebarOptions, true));
                } elseif (isset($decoded['sidebar_options'])) {
                    $sidebarOptions = $decoded['sidebar_options'];
                    error_log("DEBUG - Extraído sidebar_options (legacy) de \$left JSON: " . print_r($sidebarOptions, true));
                }
            } else {
                error_log("DEBUG - \$left no es un JSON válido o no contiene 'sidebar_menu_items'/'sidebar_options'");
            }
        }
    } else {
        // Fallback a sidebar_options o sidebar_menu_items directo si $left no está disponible
        $sidebarOptions = $data['sidebar_menu_items'] ?? $data['sidebar_options'] ?? [];
        error_log("DEBUG - Usando fallback a sidebar_menu_items/sidebar_options directo");
    }

    error_log("DEBUG - Procesando sidebar con " . count($sidebarOptions) . " opciones finales");
    $data['sidebar_menu_items'] = generateSidebarMenu($sidebarOptions);

    // Agregamos variables del sistema
    $systemVars = [
        'is_logged_in' => get_LoggedIn(),
        'right' => $contentBlocks['right'],
        'right_sidebar_header' => $contentBlocks['right_sidebar_header'],
        'right_sidebar_content' => $contentBlocks['right_sidebar_content'],
        'modals' => $contentBlocks['modals'],
        'client' => safe_get_instance(),
        'user' => safe_get_user(),
        'userfullname' => safe_get_user_fullname(),
        'alias' => safe_get_user_alias(),
        'avatar' => safe_get_user_avatar(),
    ];

    // Debug: Verificar variables del sistema
    error_log("DEBUG - systemVars right_sidebar_header: " . print_r($systemVars['right_sidebar_header'], true));
    error_log("DEBUG - systemVars right_sidebar_content: " . print_r($systemVars['right_sidebar_content'], true));

    // Establecemos todas las variables
    $renderer->setVars($data);
    $renderer->setVars($contentBlocks);
    $renderer->setVars($systemVars);

    // Renderizamos la plantilla base
    return $renderer->render('layouts/base.html');
}

// Si este archivo se está llamando directamente (no siendo incluido)
if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {
    // Variables de entrada para la plantilla
    /** @var string $theme */
    /** @var string $main_template */
    /** @var string $breadcrumb */
    /** @var string $main */
    /** @var string $right */
    /** @var string $left */
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
    /** @var string $version */

    // Servicio de strings para decodificación
    $s = service('strings');
    $theme = 'App\\Views\\Themes\\' . $theme;

    // Preparamos los datos para la renderización
    $data = array(
        "theme" => $theme,
        "main_template" => $main_template ?? null,
        "breadcrumb" => $breadcrumb ?? null,
        "main" => $main ?? null,
        "right" => $right ?? null,
        "left" => $left ?? null,
        "modals" => $modals ?? null,
        "logo_portrait" => $logo_portrait ?? null,
        "logo_landscape" => $logo_landscape ?? null,
        "logo_portrait_light" => $logo_portrait_light ?? null,
        "logo_landscape_light" => $logo_landscape_light ?? null,
        "canonical" => $canonical ?? null,
        "type" => $type ?? null,
        "title" => isset($title) ? $s->get_URLDecode($title) : 'Beta Dashboard',
        "description" => isset($description) ? $s->get_URLDecode($description) : null,
        "messenger" => $messenger ?? null,
        "messenger_users" => $messenger_users ?? null,
        "benchmark" => $benchmark ?? null,
        "version" => $version ?? null,
        "client" => safe_get_instance(),
    );

    // Agregamos datos de prueba temporalmente para verificar funcionamiento
    if (!isset($data['sidebar_options']) || empty($data['sidebar_options'])) {
        $data['sidebar_options'] = array(
            "home" => array("text" => "Inicio", "href" => "/", "icon" => "fas fa-home"),
            "dashboard" => array("text" => "Dashboard", "href" => "/dashboard", "icon" => "fas fa-tachometer-alt"),
            "users" => array("text" => "Usuarios", "href" => "/users", "icon" => "fas fa-users"),
            "settings" => array("text" => "Configuración", "href" => "/settings", "icon" => "fas fa-cog")
        );
    }

    // Agregamos datos de prueba para el sidebar derecho
    if (!isset($data['right-sidebar-header']) || empty($data['right-sidebar-header'])) {
        $data['right-sidebar-header'] = 'Panel de Usuario';
    }

    if (!isset($data['right-sidebar-content']) || empty($data['right-sidebar-content'])) {
        $data['right-sidebar-content'] = '
            <div class="user-info mb-3">
                <h6 class="mb-2">Información del Usuario</h6>
                <p class="text-muted small">Usuario: admin@example.com</p>
                <p class="text-muted small">Último acceso: Hoy 10:30 AM</p>
            </div>
            <div class="quick-actions">
                <h6 class="mb-2">Acciones Rápidas</h6>
                <div class="d-grid gap-2">
                    <button class="btn btn-sm btn-primary">Mi Perfil</button>
                    <button class="btn btn-sm btn-outline-secondary">Configuración</button>
                    <button class="btn btn-sm btn-outline-danger">Cerrar Sesión</button>
                </div>
            </div>
        ';
    }

    // Generamos y mostramos el HTML
    echo(render_beta($data));
} else {
    // Este archivo está siendo incluido, no mostramos nada
    return ("");
}
?>