<?php

namespace Gamma;

/**
 * Gamma Renderer
 * Orquestador principal del sistema de renderizado
 *
 * @package  Gamma
 * @version  1.0.0
 */
class GammaRenderer
{
    private $templateEngine;
    private $sidebarGenerator;
    private $theme;
    private $basePath;

    /**
     * Constructor
     *
     * @param string $basePath Ruta base del tema Gamma
     */
    public function __construct($basePath)
    {
        $this->basePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        // Inicializar componentes
        $this->templateEngine = new TemplateEngine($this->basePath);
        $this->theme = new GammaTheme($this->basePath);
        $this->sidebarGenerator = new SidebarGenerator($this->templateEngine, $this->basePath);
    }

    /**
     * Renderizar el tema completo
     *
     * @param array $data Datos del controlador
     * @return string HTML renderizado
     */
    public function render($data = [])
    {
        // 1. Preparar los datos globales básicos.
        $globalData = $this->prepareGlobalData($data);
        $layout = $this->determineLayout($data);

        // 2. Definir todas las secciones y sus plantillas por defecto.
        $sections = [
            'headerLeft' => 'partials/default_header_left',
            'headerCenter' => 'partials/default_header_center',
            'headerRight' => 'partials/default_header_right',
            'sidebar' => null, // Se maneja por separado.
            'main' => 'pages/' . $this->determinePage($data),
            'aside' => 'partials/default_aside'
        ];

        // Sobrescribir las plantillas por defecto con las proporcionadas por el controlador.
        if (isset($data['sections']) && is_array($data['sections'])) {
            $sections = array_merge($sections, $data['sections']);
        }

        // 3. Renderizar el contenido de cada sección y guardarlo en $globalData.
        //    Se prioriza el contenido pre-renderizado (ej. $data['main_content']).
        //    Si no existe, se renderiza desde la plantilla.
        foreach ($sections as $sectionName => $templatePath) {
            $contentKey = $sectionName . '_content';

            // Si el contenido ya fue pasado por el controlador (ej. main_content), usarlo directamente.
            if (isset($globalData[$contentKey]) && !empty($globalData[$contentKey])) {
                continue;
            }

            $sectionContent = ''; // Contenido por defecto es vacío.

            if ($sectionName === 'sidebar') {
                $sectionContent = $this->sidebarGenerator->generate($globalData);
            } elseif ($templatePath) {
                try {
                    // Renderizar la plantilla de la sección si existe.
                    $sectionContent = $this->templateEngine->render($templatePath, $globalData);
                } catch (\Exception $e) {
                    $sectionContent = "<!-- Error al renderizar la sección '{$sectionName}': {$e->getMessage()} -->";
                }
            }

            // Asignar el contenido generado o el vacío por defecto.
            $globalData[$contentKey] = $sectionContent;
        }

        // 4. Renderizar el layout principal UNA SOLA VEZ, con todos los datos y contenidos ya preparados.
        return $this->renderLayout($layout, $globalData);
    }

    /**
     * Preparar datos globales del tema
     *
     * @param array $data Datos del usuario
     * @return array Datos combinados
     */
    private function prepareGlobalData($data)
    {
        $themeData = [
            'theme_name' => $this->theme->get('theme_name'),
            'theme_version' => $this->theme->get('theme_version'),
            'theme_url' => '/themes/gamma',
            'current_year' => date('Y'),
            'charset' => 'UTF-8',
            'site_name' => '',
        ];

        // Verificar autenticación
        if (function_exists('get_LoggedIn')) {
            $themeData['is_logged_in'] = get_LoggedIn();
        } else {
            $themeData['is_logged_in'] = $data['is_logged_in'] ?? false;
        }

        // Combinar datos del usuario con datos del tema
        return array_merge($themeData, $data);
    }

    /**
     * Determinar qué layout usar
     *
     * @param array $data Datos del usuario
     * @return string Nombre del layout
     */
    private function determineLayout($data)
    {
        if (isset($data['layout'])) {
            return $data['layout'];
        }
        return $this->theme->get('default_layout', 'default');
    }

    /**
     * Determinar qué página cargar
     * Esto determina que pagina "pages/default.php" se usara para renderizar el contenido
     * @param array $data Datos del usuario
     * @return string Nombre de la página
     */
    private function determinePage($data)
    {
        if (isset($data['content_page'])) {
            return $data['content_page'];
        }
        return $this->theme->get('default_page', 'default');
    }

    /**
     * Renderizar layout
     *
     * @param string $layout Nombre del layout
     * @param array $data Datos completos
     * @return string HTML renderizado
     */
    private function renderLayout($layout, $data)
    {
        return $this->templateEngine->render('layouts/' . $layout, $data);
    }
}
