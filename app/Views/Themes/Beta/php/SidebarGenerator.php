<?php

/**
 * SidebarGenerator - Generador de menús dinámicos para sidebar
 *
 * Esta función procesa arrays de opciones y genera HTML para menús de navegación
 * con soporte para iconos SVG, Font Awesome, permisos y estados activos.
 */

/**
 * Genera el HTML del menú del sidebar basado en un array de opciones
 *
 * @param array $options Array de opciones del menú
 * @param string $currentUrl URL actual para determinar elemento activo
 * @return string HTML generado para el menú
 */
function generateSidebarMenu(array $options = [], string $currentUrl = ''): string
{
    // Debug: Log para verificar qué opciones llegan
    error_log("DEBUG - generateSidebarMenu recibió: " . print_r($options, true));
    error_log("DEBUG - Cantidad de opciones: " . count($options));

    if (empty($options)) {
        // Menú por defecto si no se proporcionan opciones
        error_log("DEBUG - Usando menú por defecto porque options está vacío");
        return getDefaultSidebarMenu();
    }

    $menuHtml = '';

    foreach ($options as $key => $option) {
        // Verificar permisos si están definidos
        if (isset($option['permission']) && !checkUserPermission($option['permission'])) {
            continue;
        }

        // Determinar si el elemento está activo
        $isActive = isMenuItemActive($option['href'] ?? '', $currentUrl);
        $activeClass = $isActive ? ' class="active"' : '';

        // Generar el icono
        $iconHtml = generateMenuIcon($option);

        // Generar el texto del enlace
        $text = htmlspecialchars($option['text'] ?? ucfirst($key));

        // Generar el href
        $href = htmlspecialchars($option['href'] ?? '#');

        // Construir el elemento del menú
        $menuHtml .= sprintf(
            '<li><a%s href="%s">%s<span>%s</span></a></li>',
            $activeClass,
            $href,
            $iconHtml,
            $text
        );
    }

    return $menuHtml;
}

/**
 * Genera el HTML del icono basado en la configuración del elemento
 *
 * @param array $option Configuración del elemento del menú
 * @return string HTML del icono
 */
function generateMenuIcon(array $option): string
{
    // Prioridad: SVG > icon (Font Awesome) > icono por defecto
    if (isset($option['svg'])) {
        return generateSvgIcon($option['svg']);
    } elseif (isset($option['icon'])) {
        return generateFontAwesomeIcon($option['icon']);
    } else {
        return '<i class="fas fa-circle"></i>';
    }
}

/**
 * Genera HTML para icono SVG desde /themes/assets/icons
 *
 * @param string $svgFile Nombre del archivo SVG
 * @return string HTML del icono SVG
 */
function generateSvgIcon(string $svgFile): string
{
    // Los archivos SVG están en /themes/assets/icons
    $svgUrl = "/themes/assets/icons/{$svgFile}";

    return sprintf('<img src="%s" alt="Icon" class="menu-icon-svg" style="width: 1em; height: 1em; vertical-align: -0.125em; margin-right: 0.5em; display: inline-block;">', htmlspecialchars($svgUrl));
}

/**
 * Genera HTML para icono Font Awesome
 *
 * @param string $iconClass Clase del icono Font Awesome
 * @return string HTML del icono
 */
function generateFontAwesomeIcon(string $iconClass): string
{
    // Si ya viene con las clases completas, usarlas directamente
    if (strpos($iconClass, 'fa-') !== false || strpos($iconClass, 'fas ') !== false || strpos($iconClass, 'far ') !== false || strpos($iconClass, 'fab ') !== false) {
        return sprintf('<i class="%s" style="margin-right: 0.5em; display: inline-block; width: 1em; text-align: center;"></i>', htmlspecialchars($iconClass));
    }

    // Si solo viene el nombre del icono, agregar el prefijo fas por defecto
    return sprintf('<i class="fas fa-%s" style="margin-right: 0.5em; display: inline-block; width: 1em; text-align: center;"></i>', htmlspecialchars($iconClass));
}

/**
 * Determina si un elemento del menú está activo
 *
 * @param string $menuHref URL del elemento del menú
 * @param string $currentUrl URL actual
 * @return bool True si el elemento está activo
 */
function isMenuItemActive(string $menuHref, string $currentUrl): bool
{
    if (empty($menuHref) || empty($currentUrl)) {
        return false;
    }

    // Normalizar URLs para comparación
    $menuPath = parse_url($menuHref, PHP_URL_PATH) ?? $menuHref;
    $currentPath = parse_url($currentUrl, PHP_URL_PATH) ?? $currentUrl;

    // Comparación exacta o si la URL actual comienza con la URL del menú
    return $menuPath === $currentPath ||
        (strlen($menuPath) > 1 && strpos($currentPath, $menuPath) === 0);
}

/**
 * Verifica permisos de usuario (función placeholder)
 *
 * @param string $permission Permiso requerido
 * @return bool True si el usuario tiene el permiso
 */
function checkUserPermission(string $permission): bool
{
    // Implementar lógica de permisos según el sistema utilizado
    // Por ahora retorna true para permitir todos los elementos

    // Ejemplo de implementación:
    // return user_has_permission($permission);
    // return in_array($permission, $_SESSION['user_permissions'] ?? []);

    return true;
}

/**
 * Retorna el menú por defecto del sidebar
 *
 * @return string HTML del menú por defecto
 */
function getDefaultSidebarMenu(): string
{
    return '
        <li>
            <a href="settings.html">
                <i class="fas fa-cog"></i>
                <span>Configuración</span>
            </a>
        </li>';
}

/**
 * Función helper para procesar opciones de menú con valores por defecto
 *
 * @param array $options Array de opciones del menú
 * @return array Opciones procesadas con valores por defecto
 */
function processSidebarOptions(array $options): array
{
    $processed = [];

    foreach ($options as $key => $option) {
        $processed[$key] = array_merge([
            'text' => ucfirst($key),
            'href' => '#',
            'icon' => 'circle',
            'permission' => null,
            'svg' => null
        ], $option);
    }

    return $processed;
}
