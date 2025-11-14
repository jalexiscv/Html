<?php

namespace Gamma;

/**
 * Sidebar Generator
 * Generador inteligente de barras laterales según contexto
 *
 * @package  Gamma
 * @version  1.0.0
 */
class SidebarGenerator
{
    private $templateEngine;
    private $basePath;

    /**
     * Constructor
     *
     * @param TemplateEngine $templateEngine Motor de plantillas
     * @param string $basePath Ruta base del tema
     */
    public function __construct($templateEngine, $basePath)
    {
        $this->templateEngine = $templateEngine;
        $this->basePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    /**
     * Generar sidebar apropiado según contexto
     *
     * @param array $data Datos del contexto
     * @return string HTML del sidebar
     */
    public function generate($data = [])
    {
        $role = $this->determineUserRole($data);
        $sidebarPath = $this->getSidebarPath($role);

        try {
            return $this->templateEngine->render($sidebarPath, $data);
        } catch (\Exception $e) {
            // Fallback a sidebar por defecto
            return $this->getDefaultSidebar($data);
        }
    }

    /**
     * Determinar rol del usuario
     *
     * @param array $data Datos del contexto
     * @return string Rol del usuario (guest, user, admin)
     */
    private function determineUserRole($data)
    {
        // Verificar si hay función global de autenticación
        $isLoggedIn = false;

        if (function_exists('get_LoggedIn')) {
            $isLoggedIn = get_LoggedIn();
        } elseif (isset($data['is_logged_in'])) {
            $isLoggedIn = $data['is_logged_in'];
        }

        // Si no está logueado, es guest
        if (!$isLoggedIn) {
            return 'guest';
        }

        // Verificar si es admin
        if (isset($data['is_admin']) && $data['is_admin']) {
            return 'admin';
        }

        if (isset($data['user_role']) && $data['user_role'] === 'admin') {
            return 'admin';
        }

        // Usuario autenticado normal
        return 'user';
    }

    /**
     * Obtener ruta del sidebar según rol
     *
     * @param string $role Rol del usuario
     * @return string Ruta del partial de sidebar
     */
    private function getSidebarPath($role)
    {
        $sidebarMap = [
            'guest' => 'partials/default_sidebar',
        ];

        return $sidebarMap[$role] ?? 'partials/default_sidebar';
    }

    /**
     * Obtener sidebar por defecto en caso de error
     *
     * @param array $data Datos del contexto
     * @return string HTML básico de sidebar
     */
    private function getDefaultSidebar($data)
    {
        return '<div class="sidebar sidebar-default">
            <div class="sidebar-section">
                <h3>Navegación</h3>
                <ul>
                    <li><a href="/">Inicio</a></li>
                    <li><a href="/about">Acerca de</a></li>
                    <li><a href="/contact">Contacto</a></li>
                </ul>
            </div>
        </div>';
    }
}
