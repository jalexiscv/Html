<?php
/**
 * Punto de entrada principal para el tema Beta
 * 
 * Este archivo recibe datos y retorna directamente el HTML generado
 * integrando la plantilla base con los parciales y la información recibida.
 */

// Cargamos el motor de renderizado
require_once __DIR__ . '/BetaRenderer.php';

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
        'right_sidebar' => ''
    ];
    
    // Cargamos los parciales según los datos proporcionados
    if (isset($data['left'])) {
        $contentBlocks['left_sidebar'] = $data['left'];
    }
    
    if (isset($data['right'])) {
        $contentBlocks['right_sidebar'] = $data['right'];
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
        // Por defecto, usamos la plantilla de dashboard pero solo extraemos el contenido
        $contentBlocks['content'] = $renderer->renderContentOnly('pages\index.html', $data);
    }
    
    // Establecemos todas las variables
    $renderer->setVars($data);
    $renderer->setVars($contentBlocks);
    
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
    );
    
    // Generamos y mostramos el HTML
    echo(render_beta($data));
} else {
    // Este archivo está siendo incluido, no mostramos nada
    return;
}
