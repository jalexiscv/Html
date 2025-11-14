<?php
/**
 * Gestor de temas para el sistema Beta
 * Maneja la detección y persistencia del tema del usuario
 */

class ThemeManager
{

    const THEME_LIGHT = 'light';
    const THEME_DARK = 'dark';
    const THEME_AUTO = 'auto';

    const COOKIE_NAME = 'beta_theme';
    const SESSION_KEY = 'beta_theme';

    /**
     * Obtiene información completa del tema actual
     *
     * @return array Información del tema
     */
    public static function getThemeInfo()
    {
        $currentTheme = self::getCurrentTheme();

        return [
            'current' => $currentTheme,
            'body_class' => self::getBodyClass(),
            'data_theme' => self::getDataTheme(),
            'is_dark' => $currentTheme === self::THEME_DARK,
            'is_light' => $currentTheme === self::THEME_LIGHT,
            'is_auto' => $currentTheme === self::THEME_AUTO
        ];
    }

    /**
     * Obtiene el tema actual del usuario
     * Prioridad: 1. Parámetro GET, 2. Sesión, 3. Cookie, 4. Auto (sistema)
     *
     * @return string El tema actual (light, dark, auto)
     */
    public static function getCurrentTheme()
    {
        // 1. Verificar si se está cambiando el tema via GET
        if (isset($_GET['theme']) && self::isValidTheme($_GET['theme'])) {
            $newTheme = $_GET['theme'];
            self::setTheme($newTheme);
            return $newTheme;
        }

        // 2. Verificar sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION[self::SESSION_KEY]) && self::isValidTheme($_SESSION[self::SESSION_KEY])) {
            return $_SESSION[self::SESSION_KEY];
        }

        // 3. Verificar cookie
        if (isset($_COOKIE[self::COOKIE_NAME]) && self::isValidTheme($_COOKIE[self::COOKIE_NAME])) {
            // Sincronizar con sesión
            $_SESSION[self::SESSION_KEY] = $_COOKIE[self::COOKIE_NAME];
            return $_COOKIE[self::COOKIE_NAME];
        }

        // 4. Por defecto: auto (detecta preferencias del sistema)
        return self::THEME_AUTO;
    }

    /**
     * Verifica si un tema es válido
     *
     * @param string $theme El tema a verificar
     * @return bool True si es válido
     */
    private static function isValidTheme($theme)
    {
        return in_array($theme, [self::THEME_LIGHT, self::THEME_DARK, self::THEME_AUTO]);
    }

    /**
     * Establece el tema del usuario
     *
     * @param string $theme El tema a establecer
     * @return bool True si se estableció correctamente
     */
    public static function setTheme($theme)
    {
        if (!self::isValidTheme($theme)) {
            return false;
        }

        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Guardar en sesión
        $_SESSION[self::SESSION_KEY] = $theme;

        // Guardar en cookie (30 días)
        $cookieExpire = time() + (30 * 24 * 60 * 60);
        setcookie(self::COOKIE_NAME, $theme, $cookieExpire, '/');

        return true;
    }

    /**
     * Obtiene la clase CSS que debe aplicarse al body
     *
     * @return string La clase CSS para el body (siempre dark-mode o light-mode)
     */
    public static function getBodyClass()
    {
        $theme = self::getCurrentTheme();

        switch ($theme) {
            case self::THEME_DARK:
                return 'dark-mode';
            case self::THEME_LIGHT:
                return 'light-mode';
            case self::THEME_AUTO:
            default:
                // Para auto, detectar preferencias del sistema desde headers HTTP
                return self::detectSystemTheme();
        }
    }

    /**
     * Detecta el tema del sistema desde headers HTTP o por defecto
     *
     * @return string Siempre retorna 'dark-mode' o 'light-mode'
     */
    private static function detectSystemTheme()
    {
        // Verificar header Sec-CH-Prefers-Color-Scheme si está disponible
        if (isset($_SERVER['HTTP_SEC_CH_PREFERS_COLOR_SCHEME'])) {
            return $_SERVER['HTTP_SEC_CH_PREFERS_COLOR_SCHEME'] === 'dark' ? 'dark-mode' : 'light-mode';
        }

        // Verificar User-Agent para detectar modo oscuro en algunos navegadores
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

        // Algunos navegadores incluyen información de tema en User-Agent
        if (strpos($userAgent, 'dark') !== false) {
            return 'dark-mode';
        }

        // Verificar hora del día como heurística (modo oscuro en horario nocturno)
        $hour = (int)date('H');
        if ($hour >= 20 || $hour <= 6) {
            return 'dark-mode';
        }

        // Por defecto: modo claro
        return 'light-mode';
    }

    /**
     * Obtiene el atributo data-theme para el HTML
     *
     * @return string El valor del atributo data-theme
     */
    public static function getDataTheme()
    {
        $theme = self::getCurrentTheme();
        return $theme === self::THEME_AUTO ? '' : $theme;
    }

    /**
     * Obtiene el script de sincronización para el cliente (DESHABILITADO)
     * @return string Script vacío - sin JavaScript para evitar parpadeo
     */
    public static function getClientSyncScript()
    {
        // ELIMINADO: No generar JavaScript para evitar parpadeo
        // El tema se gestiona 100% desde PHP/sesión
        return '';
    }
}

/**
 * Funciones helper globales para usar en templates
 */

/**
 * Obtiene la clase CSS para el body
 *
 * @return string
 */
function get_theme_body_class()
{
    return ThemeManager::getBodyClass();
}

/**
 * Obtiene el atributo data-theme
 *
 * @return string
 */
function get_theme_data_attribute()
{
    $dataTheme = ThemeManager::getDataTheme();
    return $dataTheme ? "data-theme=\"{$dataTheme}\"" : '';
}

/**
 * Obtiene el tema actual
 *
 * @return string
 */
function get_current_theme()
{
    return ThemeManager::getCurrentTheme();
}

/**
 * Verifica si el tema actual es oscuro
 *
 * @return bool
 */
function is_dark_theme()
{
    return ThemeManager::getCurrentTheme() === ThemeManager::THEME_DARK;
}

/**
 * Verifica si el tema actual es claro
 *
 * @return bool
 */
function is_light_theme()
{
    return ThemeManager::getCurrentTheme() === ThemeManager::THEME_LIGHT;
}

/**
 * Genera el script de sincronización con el cliente
 *
 * @return string
 */
function get_theme_sync_script()
{
    return ThemeManager::getClientSyncScript();
}
