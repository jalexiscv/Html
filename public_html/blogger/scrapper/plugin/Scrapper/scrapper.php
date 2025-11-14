<?php
/**
 * Plugin Name: Scrapper
 * Description: API mínima para crear publicaciones vía REST (título, contenido, imagen destacada y categorías) sin librerías externas.
 * Version: 1.0.0
 * Author: Equipo
 * License: GPLv2 or later
 * Text Domain: scrapper
 */

// Salir si se accede directamente
use Scrapper\ApiController;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Carga automática simple para clases del plugin.
 * Convención: clases bajo el namespace \Scrapper\ ubicadas en /includes.
 */
spl_autoload_register(function ($class) {
    if (strpos($class, 'Scrapper\\') !== 0) return;
    $rel = str_replace('Scrapper\\', '', $class);
    $rel = str_replace('\\', DIRECTORY_SEPARATOR, $rel);
    $path = plugin_dir_path(__FILE__) . 'includes' . DIRECTORY_SEPARATOR . $rel . '.php';
    if (is_readable($path)) require_once $path;
});

/**
 * Definiciones básicas del plugin.
 */
define('SCRAPPER_PLUGIN_FILE', __FILE__);
define('SCRAPPER_PLUGIN_DIR', plugin_dir_path(__FILE__));

define('SCRAPPER_REST_NAMESPACE', 'scrapper/v1');

/**
 * Hook principal: registro de rutas REST al inicializar la API.
 */
add_action('rest_api_init', function () {
    ApiController::register_routes();
});

/**
 * Admin: Registrar página de configuración para mostrar/rotar el token.
 * - Muestra el token actual en un campo de solo lectura con botón "Copiar" (JS nativo).
 * - Permite rotar el token con un botón que envía un formulario con nonce.
 * - Solo accesible por administradores (capability manage_options).
 */
add_action('admin_menu', function () {
    add_menu_page(
        __('Scrapper', 'scrapper'),
        __('Scrapper', 'scrapper'),
        'manage_options',
        'scrapper-settings',
        'scrapper_render_settings_page',
        'dashicons-admin-links',
        81
    );
});

/**
 * Maneja acciones POST seguras (rotar token) desde la página de ajustes.
 */
add_action('admin_init', function () {
    if (!is_admin() || !current_user_can('manage_options')) return;
    if (!isset($_POST['scrapper_action'])) return;
    $action = sanitize_text_field($_POST['scrapper_action']);
    if ($action === 'rotate_token') {
        check_admin_referer('scrapper_rotate_token', 'scrapper_nonce');
        $new = wp_generate_password(32, false, false);
        update_option('scrapper_api_token', $new, false);
        add_settings_error('scrapper_messages', 'scrapper_rotated', __('Token rotado correctamente.', 'scrapper'), 'updated');
        // Redirigir para evitar re-envío de formularios
        wp_redirect(add_query_arg(['page' => 'scrapper-settings', 'settings-updated' => 'true'], admin_url('admin.php')));
        exit;
    }
});

/**
 * Renderiza la página de configuración del plugin.
 * - Muestra el token actual y un botón para copiarlo.
 * - Provee botón para rotar el token.
 */
function scrapper_render_settings_page()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('No tienes permisos suficientes para acceder.', 'scrapper'));
    }

    $token = (string)get_option('scrapper_api_token');

    echo '<div class="wrap">';
    echo '<h1>Scrapper</h1>';

    settings_errors('scrapper_messages');

    echo '<p class="description">' . esc_html__('Usa este token en tu sistema externo para autenticar las llamadas al endpoint REST del plugin sin iniciar sesión.', 'scrapper') . '</p>';

    echo '<table class="form-table" role="presentation">';
    echo '  <tr>';
    echo '    <th scope="row">' . esc_html__('Token actual', 'scrapper') . '</th>';
    echo '    <td>';
    echo '      <input type="text" id="scrapper-token" class="regular-text" readonly value="' . esc_attr($token) . '"> ';
    echo '      <button type="button" class="button" id="scrapper-copy">' . esc_html__('Copiar', 'scrapper') . '</button>';
    echo '      <p class="description">' . esc_html__('Encabezado: X-Scrapper-Token', 'scrapper') . '</p>';
    echo '    </td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <th scope="row">' . esc_html__('Rotar token', 'scrapper') . '</th>';
    echo '    <td>';
    echo '      <form method="post" action="">';
    echo '        <input type="hidden" name="scrapper_action" value="rotate_token">';
    wp_nonce_field('scrapper_rotate_token', 'scrapper_nonce');
    echo '        <button type="submit" class="button button-secondary" onclick="return confirm(\'' . esc_js(__('Esto invalidará el token actual. ¿Continuar?', 'scrapper')) . '\')">' . esc_html__('Rotar token', 'scrapper') . '</button>';
    echo '      </form>';
    echo '    </td>';
    echo '  </tr>';
    echo '</table>';

    echo '<h2 class="title" style="margin-top:24px">' . esc_html__('Endpoint REST', 'scrapper') . '</h2>';
    $site = rtrim(get_site_url(), '/');
    $endpoint = $site . '/wp-json/' . SCRAPPER_REST_NAMESPACE . '/posts';
    echo '<p><code>' . esc_html($endpoint) . '</code></p>';

    echo '<script>(function(){
      var btn=document.getElementById("scrapper-copy");
      if(!btn) return;
      btn.addEventListener("click", function(){
        var inp=document.getElementById("scrapper-token");
        if(!inp) return;
        inp.select(); inp.setSelectionRange(0, 99999);
        try{ document.execCommand("copy"); btn.textContent="' . esc_js(__('Copiado', 'scrapper')) . '"; setTimeout(function(){ btn.textContent="' . esc_js(__('Copiar', 'scrapper')) . '"; }, 1500);}catch(e){}
      });
    })();</script>';

    echo '</div>';
}

/**
 * Enlace rápido "Configuración" en la lista de plugins.
 */
add_filter('plugin_action_links_' . plugin_basename(__FILE__), function ($links) {
    $url = admin_url('admin.php?page=scrapper-settings');
    $links[] = '<a href="' . esc_url($url) . '">' . esc_html__('Configuración', 'scrapper') . '</a>';
    return $links;
});

/**
 * Activación del plugin.
 * - Prepara opciones por defecto.
 */
register_activation_hook(__FILE__, function () {
    // Opción: token estático para autenticación simple via header 'X-Scrapper-Token'
    if (!get_option('scrapper_api_token')) {
        // Genera un token pseudo-aleatorio legible
        $token = wp_generate_password(32, false, false);
        add_option('scrapper_api_token', $token, '', false);
    }
});

/**
 * Desactivación del plugin.
 * (No eliminamos opciones automáticamente.)
 */
register_deactivation_hook(__FILE__, function () {
    // No-op por ahora
});
