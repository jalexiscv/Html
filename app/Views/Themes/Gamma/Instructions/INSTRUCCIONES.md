# PROMPT PARA CONSTRUCCIÓN DEL SISTEMA DE PLANTILLAS GAMMA PARA CODEIGNITER 4

Necesito que construyas un sistema completo de plantillas llamado "Gamma" para CodeIgniter 4. A continuación te
proporciono las especificaciones técnicas detalladas que debes seguir al pie de la letra.

## UBICACIÓN Y ESTRUCTURA BASE

**Ruta raíz del proyecto:**

```
C:\\xampp\\htdocs\\app\\Views\\Themes\\Gamma\\
```

TODO el sistema debe estar contenido exclusivamente dentro de este directorio. No crear archivos fuera de esta
ubicación.

**Estructura de directorios completa a crear:**

```
C:\\xampp\\htdocs\\app\\Views\\Themes\\Gamma\\
│
├── index.php                          # ⭐ PUNTO DE ENTRADA ÚNICO (CRÍTICO)
│
├── Libraries/
│   ├── TemplateEngine.php            # Motor de renderizado principal
│   ├── GammaRenderer.php             # Orquestador de renderizado
│   ├── GammaTheme.php                # Configuración del tema
│   └── SidebarGenerator.php          # Generador inteligente de sidebars
│
├── Config/
│   └── theme.php                     # Configuración general del tema
│
├── layouts/
│   ├── default.php                   # Layout por defecto
│   ├── auth.php                      # Layout para autenticación
│   └── admin.php                     # Layout para administración
│
├── pages/
│   ├── home.php                      # Página de inicio
│   ├── dashboard.php                 # Dashboard de usuario
│   └── profile.php                   # Perfil de usuario
│
├── partials/
│   ├── header.php                    # Encabezado del sitio
│   ├── footer.php                    # Pie de página
│   ├── navigation.php                # Menú de navegación
│   ├── sidebar_guest.php             # Sidebar para usuarios no autenticados
│   ├── sidebar_user.php              # Sidebar para usuarios autenticados
│   ├── sidebar_admin.php             # Sidebar para administradores
│   ├── styles.php                    # Inclusión de CSS
│   └── scripts.php                   # Inclusión de JS
│
├── public_html/
│   ├── css/
│   │   ├── gamma.css                 # Estilos principales del tema
│   │   └── components.css            # Estilos de componentes
│   ├── js/
│   │   ├── gamma.js                  # JavaScript principal
│   │   └── components.js             # Scripts de componentes
│   └── images/
│       └── logo.png                  # Logo del tema
│
└── cache/
    └── .gitkeep                      # Directorio para caché de templates
```

## PRINCIPIO ARQUITECTÓNICO FUNDAMENTAL

**CRÍTICO:** El archivo `index.php` en la raíz de Gamma es el ÚNICO punto de interacción entre CodeIgniter 4 y el
template.

**Flujo de datos:**

```
Controlador CI4 → view('Themes/Gamma/index', $data) → index.php → Sistema Gamma → HTML Renderizado
```

CodeIgniter 4 NUNCA accede directamente a ningún otro archivo dentro de Gamma. Todo pasa por `index.php`.

## ENRUTAMIENTO DE ASSETS (CRÍTICO)

A diferencia del renderizado de páginas, los assets (CSS, JS, imágenes) no pueden ser servidos a través del `index.php`
de Gamma. Requieren una ruta y un controlador dedicados en la aplicación principal de CodeIgniter.

**1. Controlador de Assets (`app/Controllers/ThemeController.php`)**

Es necesario tener un controlador como el que se ha depurado, que se encarga de localizar y servir los archivos desde la
carpeta `public_html` del tema.

**2. Ruta de Assets (`app/Config/Routes.php`)**

Se debe añadir una ruta específica para los assets en el archivo de rutas principal de CodeIgniter. Esta ruta debe
apuntar al controlador de assets.

**Ejemplo de ruta funcional:**

```php
// En app/Config/Routes.php
$routes->get('ui/themes/(:segment)/.*', 'ThemeController::serveAsset/$1');
```

Esta configuración es **esencial** para que el navegador pueda acceder a los archivos CSS y JavaScript.

## ESPECIFICACIONES TÉCNICAS DE CADA COMPONENTE

### 1. INDEX.PHP (Punto de Entrada Único)

**Ubicación:** `C:\\xampp\\htdocs\\app\\Views\\Themes\\Gamma\\index.php`

**Responsabilidades:**

- Recibir el array `$data` desde el controlador de CodeIgniter 4
- Cargar/autocargar todas las librerías necesarias de Gamma
- Inicializar el GammaRenderer con la ruta base del tema
- Transferir los datos recibidos al sistema de renderizado
- Devolver el HTML final renderizado

**Código completo a implementar:**

```php
<?php
/**
 * Gamma Template System - Punto de Entrada Único
 * Este archivo es la única interfaz entre CodeIgniter 4 y Gamma
 * 
 * Ubicación: C:\\xampp\\htdocs\\app\\Views\\Themes\\Gamma\\index.php
 * 
 * @package  Gamma
 * @version  1.0.0
 */

// Definir la ruta base de Gamma
define('GAMMA_PATH', __DIR__ . DIRECTORY_SEPARATOR);

// Autoloader para las clases de Gamma
spl_autoload_register(function ($class) {
    // Solo cargar clases del namespace Gamma
    if (strpos($class, 'Gamma\\\\') === 0) {
        $className = str_replace('Gamma\\\\', '', $class);
        $file = GAMMA_PATH . 'Libraries' . DIRECTORY_SEPARATOR . $className . '.php';
        
        if (file_exists($file)) {
            require_once $file;
        }
    }
});

// Cargar librerías principales
require_once GAMMA_PATH . 'Libraries/TemplateEngine.php';
require_once GAMMA_PATH . 'Libraries/GammaRenderer.php';
require_once GAMMA_PATH . 'Libraries/GammaTheme.php';
require_once GAMMA_PATH . 'Libraries/SidebarGenerator.php';

try {
    // Inicializar el renderizador con la ruta base
    $renderer = new \\Gamma\\GammaRenderer(GAMMA_PATH);
    
    // Renderizar con los datos recibidos desde el controlador
    echo $renderer->render($data ?? []);
    
} catch (\\Exception $e) {
    // Manejo de errores
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
        echo \'<div style="padding: 20px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px;">\';
        echo \'<h2>Error en Gamma Template</h2>\';
        echo \'<p><strong>Mensaje:</strong> \' . htmlspecialchars($e->getMessage()) . \'</p>\';
        echo \'<p><strong>Archivo:</strong> \' . htmlspecialchars($e->getFile()) . \'</p>\';
        echo \'<p><strong>Línea:</strong> \' . $e->getLine() . \'</p>\';
        echo \'<pre>\' . htmlspecialchars($e->getTraceAsString()) . \'</pre>\';
        echo \'</div>\';
    } else {
        echo \'<div style="padding: 20px; text-align: center;">\';
        echo \'<h2>Lo sentimos, ocurrió un error</h2>\';
        echo \'<p>Por favor, intente nuevamente más tarde.</p>\';
        echo \'</div>\';
    }
}
```

### 2. TEMPLATEENGINE.PHP

**Ubicación:** `Libraries/TemplateEngine.php`

**Namespace:** `Gamma`

**Código completo:**

```php
<?php
namespace Gamma;

/**
 * Template Engine
 * Motor de plantillas con sintaxis personalizada
 * 
 * Sintaxis soportada:
 * - Variables: ${variable_name}
 * - Condicionales: {% if condition %}content{% endif %}
 * - Inclusiones: {% include 'path/to/file' %}
 * 
 * @package  Gamma
 * @version  1.0.0
 */
class TemplateEngine
{
    private $basePath;
    private $data = [];
    private $compiledCache = [];
    
    /**
     * Constructor
     * 
     * @param string $basePath Ruta base del tema Gamma
     */
    public function __construct($basePath)
    {
        $this->basePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }
    
    /**
     * Renderizar una plantilla
     * 
     * @param string $templatePath Ruta relativa de la plantilla
     * @param array $data Datos para la plantilla
     * @return string HTML renderizado
     */
    public function render($templatePath, $data = [])
    {
        $this->data = array_merge($this->data, $data);
        
        // Cargar el contenido de la plantilla
        $content = $this->loadTemplate($templatePath);
        
        // Procesar en orden: includes → conditionals → variables
        $content = $this->processIncludes($content);
        $content = $this->processConditionals($content, $this->data);
        $content = $this->processVariables($content, $this->data);
        
        return $content;
    }
    
    /**
     * Cargar archivo de plantilla
     * 
     * @param string $path Ruta relativa de la plantilla
     * @return string Contenido de la plantilla
     * @throws \\Exception Si el archivo no existe
     */
    private function loadTemplate($path)
    {
        // Normalizar la ruta (añadir .php si no lo tiene)
        if (substr($path, -4) !== \'.php\') {
            $path .= \'.php\';
        }
        
        $fullPath = $this->basePath . $path;
        
        if (!file_exists($fullPath)) {
            throw new \\Exception("Template no encontrado: {$fullPath}");
        }
        
        return file_get_contents($fullPath);
    }
    
    /**
     * Procesar inclusiones {% include 'path' %}
     * 
     * @param string $content Contenido de la plantilla
     * @return string Contenido con inclusiones procesadas
     */
    private function processIncludes($content)
    {
        $pattern = \'/{%\\s*include\\s+[\\\'"]([^\\\'"]+)[\\\'"]\\s*%}/\';
        
        return preg_replace_callback($pattern, function($matches) {
            $includePath = $matches[1];
            
            try {
                return $this->loadTemplate($includePath);
            } catch (\\Exception $e) {
                return "<!-- Error al incluir: {$includePath} -->";
            }
        }, $content);
    }
    
    /**
     * Procesar condicionales {% if condition %}
     * 
     * @param string $content Contenido de la plantilla
     * @param array $data Datos para evaluar condiciones
     * @return string Contenido con condicionales procesados
     */
    private function processConditionals($content, $data)
    {
        // Pattern para {% if condition %}content{% endif %}
        $pattern = \'/{%\\s*if\\s+([^%]+)\\s*%}(.*?){%\\s*endif\\s*%}/s\';
        
        return preg_replace_callback($pattern, function($matches) use ($data) {
            $condition = trim($matches[1]);
            $contentBlock = $matches[2];
            
            // Evaluar la condición
            if ($this->evaluateCondition($condition, $data)) {
                return $contentBlock;
            }
            
            return \'\';
        }, $content);
    }
    
    /**
     * Evaluar una condición
     * 
     * @param string $condition Condición a evaluar
     * @param array $data Datos disponibles
     * @return bool Resultado de la evaluación
     */
    private function evaluateCondition($condition, $data)
    {
        // Soporte para negación con !
        if (strpos($condition, \'!\') === 0) {
            $varName = trim(substr($condition, 1));
            return empty($data[$varName]);
        }
        
        // Soporte para comparaciones
        if (preg_match(\'/(.+?)\\s*(==|!=|>|<|>=|<=)\\s*(.+)/\', $condition, $parts)) {
            $left = $this->resolveValue(trim($parts[1]), $data);
            $operator = $parts[2];
            $right = $this->resolveValue(trim($parts[3]), $data);
            
            switch ($operator) {
                case \'==\': return $left == $right;
                case \'!=\': return $left != $right;
                case \'>\': return $left > $right;
                case \'<\': return $left < $right;
                case \'>=\': return $left >= $right;
                case \'<=\': return $left <= $right;
            }
        }
        
        // Condición simple: verificar si la variable existe y no está vacía
        return !empty($data[$condition]);
    }
    
    /**
     * Resolver el valor de una expresión
     * 
     * @param string $expression Expresión a resolver
     * @param array $data Datos disponibles
     * @return mixed Valor resuelto
     */
    private function resolveValue($expression, $data)
    {
        // Si es una cadena entre comillas
        if (preg_match(\'/^[\\\'"](.+)[\\\'"]$/\', $expression, $matches)) {
            return $matches[1];
        }
        
        // Si es un número
        if (is_numeric($expression)) {
            return $expression + 0; // Convertir a int o float
        }
        
        // Si es una variable
        return $data[$expression] ?? null;
    }
    
    /**
     * Procesar variables ${variable_name}
     * 
     * @param string $content Contenido de la plantilla
     * @param array $data Datos para las variables
     * @return string Contenido con variables reemplazadas
     */
    private function processVariables($content, $data)
    {
        $pattern = \'/\${([a-zA-Z0-9_]+)}/\';
        
        return preg_replace_callback($pattern, function($matches) use ($data) {
            $varName = $matches[1];
            
            if (isset($data[$varName])) {
                return htmlspecialchars($data[$varName], ENT_QUOTES, \'UTF-8\');
            }
            
            return \'\'; // Variable no definida
        }, $content);
    }
    
    /**
     * Establecer datos globales
     * 
     * @param array $data Datos globales
     */
    public function setData($data)
    {
        $this->data = array_merge($this->data, $data);
    }
}
```

### 3. GAMMARENDERER.PHP

**Ubicación:** `Libraries/GammaRenderer.php`

**Código completo:**

```php
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
        // Preparar datos globales
        $globalData = $this->prepareGlobalData($data);
        
        // Determinar layout y página
        $layout = $this->determineLayout($data);
        $page = $this->determinePage($data);
        
        // Generar sidebar
        $sidebarContent = $this->sidebarGenerator->generate($globalData);
        $globalData[\'sidebar_content\'] = $sidebarContent;
        
        // Renderizar página
        $pageContent = $this->templateEngine->render(\'pages/\' . $page, $globalData);
        $globalData[\'page_content\'] = $pageContent;
        
        // Renderizar layout completo
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
            \'theme_name\' => $this->theme->get(\'theme_name\'),
            \'theme_version\' => $this->theme->get(\'theme_version\'),
            \'current_year\' => date(\'Y\'),
            \'charset\' => \'UTF-8\',
            \'site_name\' => \'Gamma System\',
        ];
        
        // Verificar autenticación
        if (function_exists(\'get_LoggedIn\')) {
            $themeData[\'is_logged_in\'] = get_LoggedIn();
        } else {
            $themeData[\'is_logged_in\'] = $data[\'is_logged_in\'] ?? false;
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
        if (isset($data[\'layout\'])) {
            return $data[\'layout\'];
        }
        
        // Determinar layout por contexto
        if (isset($data[\'is_admin\']) && $data[\'is_admin\']) {
            return \'admin\';
        }
        
        if (isset($data[\'is_auth_page\']) && $data[\'is_auth_page\']) {
            return \'auth\';
        }
        
        return $this->theme->get(\'default_layout\', \'default\');
    }
    
    /**
     * Determinar qué página cargar
     * 
     * @param array $data Datos del usuario
     * @return string Nombre de la página
     */
    private function determinePage($data)
    {
        if (isset($data[\'content_page\'])) {
            return $data[\'content_page\'];
        }
        
        return $this->theme->get(\'default_page\', \'home\');
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
        return $this->templateEngine->render(\'layouts/\' . $layout, $data);
    }
}
```

### 4. GAMMATHEME.PHP

**Ubicación:** `Libraries/GammaTheme.php`

**Código completo:**

```php
<?php
namespace Gamma;

/**
 * Gamma Theme Configuration
 * Gestión de configuración del tema
 * 
 * @package  Gamma
 * @version  1.0.0
 */
class GammaTheme
{
    private $basePath;
    private $config = [];
    
    /**
     * Constructor
     * 
     * @param string $basePath Ruta base del tema
     */
    public function __construct($basePath)
    {
        $this->basePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->loadConfig();
    }
    
    /**
     * Cargar configuración del tema
     */
    private function loadConfig()
    {
        // Configuración por defecto
        $this->config = [
            \'theme_name\' => \'Gamma\',
            \'theme_version\' => \'1.0.0\',
            \'author\' => \'Gamma Development Team\',
            
            \'paths\' => [
                \'layouts\' => \'layouts\',
                \'pages\' => \'pages\',
                \'partials\' => \'partials\',
                \'public_html\' => \'public_html\',
                \'cache\' => \'cache\',
            ],
            
            \'assets\' => [
                \'css\' => [
                    \'gamma.css\',
                    \'components.css\',
                ],
                \'js\' => [
                    \'gamma.js\',
                    \'components.js\',
                ],
            ],
            
            \'default_layout\' => \'default\',
            \'default_page\' => \'home\',
            
            \'cache_enabled\' => false,
            \'cache_lifetime\' => 3600,
            \'debug_mode\' => true,
        ];
        
        // Cargar configuración personalizada si existe
        $configFile = $this->basePath . \'Config/theme.php\';
        if (file_exists($configFile)) {
            $customConfig = include $configFile;
            $this->config = array_merge($this->config, $customConfig);
        }
    }
    
    /**
     * Obtener valor de configuración
     * 
     * @param string $key Clave de configuración
     * @param mixed $default Valor por defecto
     * @return mixed Valor de configuración
     */
    public function get($key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }
    
    /**
     * Establecer valor de configuración
     * 
     * @param string $key Clave
     * @param mixed $value Valor
     */
    public function set($key, $value)
    {
        $this->config[$key] = $value;
    }
    
    /**
     * Obtener URL de asset (MÉTODO OBSOLETO)
     * 
     * NOTA: Este método ya no es funcional. La carga de assets se gestiona
     * a través de un helper global (ej. theme_asset()) y un controlador
     * dedicado (ThemeController) como se explica en la sección de 
     * "Enrutamiento de Assets".
     */
    public function getAssetUrl($type, $file)
    {
        // Implementación obsoleta, no usar.
        return '';
    }
    
    /**
     * Obtener ruta de directorio
     * 
     * @param string $type Tipo de ruta
     * @return string Ruta completa
     */
    public function getPath($type)
    {
        $relativePath = $this->config[\'paths\'][$type] ?? $type;
        return $this->basePath . $relativePath . DIRECTORY_SEPARATOR;
    }
}
```

### 5. SIDEBARGENERATOR.PHP

**Ubicación:** `Libraries/SidebarGenerator.php`

**Código completo:**

```php
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
        } catch (\\Exception $e) {
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
        
        if (function_exists(\'get_LoggedIn\')) {
            $isLoggedIn = get_LoggedIn();
        } elseif (isset($data[\'is_logged_in\'])) {
            $isLoggedIn = $data[\'is_logged_in\'];
        }
        
        // Si no está logueado, es guest
        if (!$isLoggedIn) {
            return \'guest\';
        }
        
        // Verificar si es admin
        if (isset($data[\'is_admin\']) && $data[\'is_admin\']) {
            return \'admin\';
        }
        
        if (isset($data[\'user_role\']) && $data[\'user_role\'] === \'admin\') {
            return \'admin\';
        }
        
        // Usuario autenticado normal
        return \'user\';
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
            \'guest\' => \'partials/sidebar_guest\',
            \'user\' => \'partials/sidebar_user\',
            \'admin\' => \'partials/sidebar_admin\',
        ];
        
        return $sidebarMap[$role] ?? \'partials/sidebar_guest\';
    }
    
    /**
     * Obtener sidebar por defecto en caso de error
     * 
     * @param array $data Datos del contexto
     * @return string HTML básico de sidebar
     */
    private function getDefaultSidebar($data)
    {
        return \'<div class="sidebar sidebar-default">
            <div class="sidebar-section">
                <h3>Navegación</h3>
                <ul>
                    <li><a href="/">Inicio</a></li>
                    <li><a href="/about">Acerca de</a></li>
                    <li><a href="/contact">Contacto</a></li>
                </ul>
            </div>
        </div>\';
    }
}
```

### 6. CONFIG/THEME.PHP

**Ubicación:** `Config/theme.php`

```php
<?php
/**
 * Configuración del Tema Gamma
 * 
 * @package  Gamma
 * @version  1.0.0
 */

return [
    \'name\' => \'Gamma\',
    \'version\' => \'1.0.0\',
    \'description\' => \'Sistema de plantillas modular para CodeIgniter 4\',
    \'author\' => \'Gamma Development Team\',
    
    \'settings\' => [
        \'cache_enabled\' => false,
        \'debug_mode\' => true,
        \'auto_escape\' => true,
    ],
    
    \'meta\' => [
        \'charset\' => \'UTF-8\',
        \'viewport\' => \'width=device-width, initial-scale=1.0\',
        \'description\' => \'Plantilla Gamma para CodeIgniter 4\',
        \'keywords\' => \'gamma, template, codeigniter\',
    ],
    
    \'social\' => [
        \'facebook\' => \'\',
        \'twitter\' => \'\',
        \'instagram\' => \'\',
        \'linkedin\' => \'\',
    ],
];
```

## PLANTILLAS HTML A CREAR

### LAYOUTS

**layouts/default.php:**

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="${charset}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>${page_title} - ${site_name}</title>
    <meta name="description" content="${meta_description}">
    {% include \'partials/styles\' %}
</head>
<body>
    {% include \'partials/header\' %}
    
    <div class="container">
        <div class="sidebar">
            ${sidebar_content}
        </div>
        
        <main class="content">
            ${page_content}
        </main>
    </div>
    
    {% include \'partials/footer\' %}
    {% include \'partials/scripts\' %}
</body>
</html>
```

**layouts/auth.php:**

```php
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="${charset}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>${page_title} - Autenticación</title>
    {% include \'partials/styles\' %}
</head>
<body class="auth-layout">
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-logo">
                <img src="<?php echo theme_asset('gamma', 'images/logo.png'); ?>" alt="Logo">
                <h2>${site_name}</h2>
            </div>
            
            ${page_content}
            
            <div class="auth-footer">
                <p>&copy; ${current_year} ${site_name}</p>
            </div>
        </div>
    </div>
    {% include \'partials/scripts\' %}
</body>
</html>
```

**layouts/admin.php:**

```php
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="${charset}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>${page_title} - Panel de Administración</title>
    {% include \'partials/styles\' %}
</head>
<body class="admin-layout">
    <header class="admin-header">
        <div class="admin-header-left">
            <button class="sidebar-toggle" id="sidebarToggle">☰</button>
            <div class="logo">
                <img src="<?php echo theme_asset('gamma', 'images/logo.png'); ?>" alt="Logo">
                <span>${site_name} Admin</span>
            </div>
        </div>
        
        <div class="admin-header-right">
            <div class="user-info">
                <span>${username}</span>
                <img src="${user_avatar}" alt="${username}">
            </div>
        </div>
    </header>
    
    <div class="admin-container">
        <aside class="admin-sidebar" id="adminSidebar">
            ${sidebar_content}
        </aside>
        
        <main class="admin-content">
            <div class="breadcrumb">
                <a href="/admin">Inicio</a> / ${page_title}
            </div>
            
            ${page_content}
        </main>
    </div>
    
    {% include \'partials/footer\' %}
    {% include \'partials/scripts\' %}
</body>
</html>
```

### PAGES

**pages/home.php:**

```html
<section class="hero">
    <h1>Bienvenido a ${site_name}</h1>
    <p>Sistema de plantillas Gamma para CodeIgniter 4</p>
    
    {% if is_logged_in %}
        <div class="hero-actions">
            <a href="/dashboard" class="btn btn-primary">Ir al Dashboard</a>
            <a href="/profile" class="btn btn-secondary">Mi Perfil</a>
        </div>
    {% endif %}
    
    {% if !is_logged_in %}
        <div class="hero-actions">
            <a href="/login" class="btn btn-primary">Iniciar Sesión</a>
            <a href="/register" class="btn btn-secondary">Registrarse</a>
        </div>
    {% endif %}
</section>

<section class="features">
    <h2>Características Principales</h2>
    
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🎨</div>
            <h3>Diseño Moderno</h3>
            <p>Interfaz limpia y profesional con componentes reutilizables</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">⚡</div>
            <h3>Alto Rendimiento</h3>
            <p>Motor de plantillas optimizado para máxima velocidad</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">🔧</div>
            <h3>Fácil Personalización</h3>
            <p>Sistema modular completamente configurable</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">📱</div>
            <h3>Responsive</h3>
            <p>Adaptable a cualquier dispositivo y tamaño de pantalla</p>
        </div>
    </div>
</section>

<section class="cta-section">
    <h2>¿Listo para comenzar?</h2>
    <p>Únete a nuestra plataforma hoy mismo</p>
    
    {% if !is_logged_in %}
        <a href="/register" class="btn btn-large btn-primary">Crear Cuenta Gratis</a>
    {% endif %}
</section>
```

**pages/dashboard.php:**

```html
<div class="dashboard">
    <div class="dashboard-header">
        <h1>Dashboard</h1>
        <p>Bienvenido de nuevo, <strong>${username}</strong></p>
    </div>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-info">
                <h3>Total Usuarios</h3>
                <p class="stat-number">${total_users}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-info">
                <h3>Actividad</h3>
                <p class="stat-number">${activity_count}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">💼</div>
            <div class="stat-info">
                <h3>Proyectos</h3>
                <p class="stat-number">${projects_count}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">✉️</div>
            <div class="stat-info">
                <h3>Mensajes</h3>
                <p class="stat-number">${messages_count}</p>
            </div>
        </div>
    </div>
    
    <div class="dashboard-content">
        <div class="dashboard-section">
            <h2>Actividad Reciente</h2>
            <div class="activity-list">
                ${recent_activity_content}
            </div>
        </div>
        
        <div class="dashboard-section">
            <h2>Accesos Rápidos</h2>
            <div class="quick-links">
                <a href="/profile" class="quick-link-card">
                    <span class="icon">👤</span>
                    <span class="text">Mi Perfil</span>
                </a>
                <a href="/settings" class="quick-link-card">
                    <span class="icon">⚙️</span>
                    <span class="text">Configuración</span>
                </a>
                <a href="/notifications" class="quick-link-card">
                    <span class="icon">🔔</span>
                    <span class="text">Notificaciones</span>
                </a>
                <a href="/help" class="quick-link-card">
                    <span class="icon">❓</span>
                    <span class="text">Ayuda</span>
                </a>
            </div>
        </div>
    </div>
</div>
```

**pages/profile.php:**

```html
<div class="profile-page">
    <div class="profile-header">
        <div class="profile-cover"></div>
        
        <div class="profile-info">
            <div class="profile-avatar">
                <img src="${user_avatar}" alt="${username}">
                <button class="avatar-edit-btn">📷</button>
            </div>
            
            <div class="profile-details">
                <h1>${username}</h1>
                <p class="profile-email">${user_email}</p>
                <span class="profile-role">${user_role}</span>
            </div>
        </div>
    </div>
    
    <div class="profile-content">
        <div class="profile-tabs">
            <button class="tab-btn active" data-tab="info">Información Personal</button>
            <button class="tab-btn" data-tab="security">Seguridad</button>
            <button class="tab-btn" data-tab="preferences">Preferencias</button>
        </div>
        
        <div class="tab-content active" id="tab-info">
            <form class="profile-form">
                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text" name="full_name" value="${full_name}" class="form-control">
                </div>
                
                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" value="${user_email}" class="form-control">
                </div>
                
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="tel" name="phone" value="${phone}" class="form-control">
                </div>
                
                <div class="form-group">
                    <label>Biografía</label>
                    <textarea name="bio" class="form-control" rows="4">${bio}</textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        </div>
        
        <div class="tab-content" id="tab-security">
            <h3>Cambiar Contraseña</h3>
            <form class="profile-form">
                <div class="form-group">
                    <label>Contraseña Actual</label>
                    <input type="password" name="current_password" class="form-control">
                </div>
                
                <div class="form-group">
                    <label>Nueva Contraseña</label>
                    <input type="password" name="new_password" class="form-control">
                </div>
                
                <div class="form-group">
                    <label>Confirmar Contraseña</label>
                    <input type="password" name="confirm_password" class="form-control">
                </div>
                
                <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
            </form>
        </div>
        
        <div class="tab-content" id="tab-preferences">
            <form class="profile-form">
                <div class="form-group">
                    <label>Idioma</label>
                    <select name="language" class="form-control">
                        <option value="es">Español</option>
                        <option value="en">English</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Tema</label>
                    <select name="theme" class="form-control">
                        <option value="light">Claro</option>
                        <option value="dark">Oscuro</option>
                        <option value="auto">Automático</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="email_notifications">
                        Recibir notificaciones por correo
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary">Guardar Preferencias</button>
            </form>
        </div>
    </div>
</div>
```

### PARTIALS

**partials/header.php:**

```php
<header class="site-header">
    <div class="header-container">
        <div class="logo">
            <a href="/">
                <img src="<?php echo theme_asset('gamma', 'images/logo.png'); ?>" alt="${site_name}">
                <span class="logo-text">${site_name}</span>
            </a>
        </div>
        
        <nav class="main-nav">
            {% include \'partials/navigation\' %}
        </nav>
        
        <div class="header-actions">
            {% if is_logged_in %}
                <div class="user-menu">
                    <button class="user-menu-toggle">
                        <img src="${user_avatar}" alt="${username}" class="user-avatar-small">
                        <span>${username}</span>
                        <span class="dropdown-arrow">▼</span>
                    </button>
                    
                    <div class="user-dropdown">
                        <a href="/profile" class="dropdown-item">
                            <span class="icon">👤</span> Mi Perfil
                        </a>
                        <a href="/settings" class="dropdown-item">
                            <span class="icon">⚙️</span> Configuración
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="/logout" class="dropdown-item">
                            <span class="icon">🚪</span> Cerrar Sesión
                        </a>
                    </div>
                </div>
            {% endif %}
            
            {% if !is_logged_in %}
                <a href="/login" class="btn btn-outline">Iniciar Sesión</a>
                <a href="/register" class="btn btn-primary">Registrarse</a>
            {% endif %}
        </div>
        
        <button class="mobile-menu-toggle" id="mobileMenuToggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>
```

**partials/footer.php:**

```html
<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-section">
                <h4>Acerca de ${site_name}</h4>
                <p>Sistema de plantillas Gamma v${theme_version} para CodeIgniter 4</p>
                <div class="social-links">
                    <a href="#" class="social-icon">📘</a>
                    <a href="#" class="social-icon">🐦</a>
                    <a href="#" class="social-icon">📷</a>
                    <a href="#" class="social-icon">💼</a>
                </div>
            </div>
            
            <div class="footer-section">
                <h4>Enlaces Rápidos</h4>
                <ul class="footer-links">
                    <li><a href="/">Inicio</a></li>
                    <li><a href="/about">Acerca de</a></li>
                    <li><a href="/services">Servicios</a></li>
                    <li><a href="/contact">Contacto</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Recursos</h4>
                <ul class="footer-links">
                    <li><a href="/documentation">Documentación</a></li>
                    <li><a href="/faq">Preguntas Frecuentes</a></li>
                    <li><a href="/support">Soporte</a></li>
                    <li><a href="/api">API</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Legal</h4>
                <ul class="footer-links">
                    <li><a href="/privacy">Política de Privacidad</a></li>
                    <li><a href="/terms">Términos de Servicio</a></li>
                    <li><a href="/cookies">Política de Cookies</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; ${current_year} ${site_name}. Todos los derechos reservados.</p>
            <p>Desarrollado con <span class="heart">❤️</span> usando Gamma Template System</p>
        </div>
    </div>
</footer>
```

**partials/navigation.php:**

```html
<ul class="nav-menu">
    <li><a href="/" class="nav-link">Inicio</a></li>
    
    {% if is_logged_in %}
        <li><a href="/dashboard" class="nav-link">Dashboard</a></li>
        <li><a href="/profile" class="nav-link">Perfil</a></li>
        
        {% if is_admin %}
            <li><a href="/admin" class="nav-link nav-admin">Administración</a></li>
        {% endif %}
    {% endif %}
    
    <li><a href="/about" class="nav-link">Acerca de</a></li>
    <li><a href="/services" class="nav-link">Servicios</a></li>
    <li><a href="/contact" class="nav-link">Contacto</a></li>
</ul>
```

**partials/sidebar_guest.php:**

```html
<div class="sidebar sidebar-guest">
    <div class="sidebar-section welcome-section">
        <div class="welcome-icon">👋</div>
        <h3>Bienvenido</h3>
        <p>Únete a nuestra comunidad y descubre todas las funcionalidades</p>
        <a href="/register" class="btn btn-primary btn-block">Crear Cuenta</a>
        <a href="/login" class="btn btn-secondary btn-block">Iniciar Sesión</a>
    </div>
    
    <div class="sidebar-section">
        <h3>¿Por qué registrarse?</h3>
        <ul class="benefits-list">
            <li>✅ Acceso completo a la plataforma</li>
            <li>✅ Dashboard personalizado</li>
            <li>✅ Gestión de proyectos</li>
            <li>✅ Soporte prioritario</li>
        </ul>
    </div>
    
    <div class="sidebar-section">
        <h3>Información</h3>
        <ul class="sidebar-links">
            <li><a href="/features">Características</a></li>
            <li><a href="/pricing">Planes y Precios</a></li>
            <li><a href="/faq">Preguntas Frecuentes</a></li>
            <li><a href="/help">Centro de Ayuda</a></li>
        </ul>
    </div>
    
    <div class="sidebar-section">
        <h3>Últimas Noticias</h3>
        <div class="news-item">
            <span class="news-date">18 Oct 2025</span>
            <p>Nueva versión de Gamma disponible</p>
        </div>
        <div class="news-item">
            <span class="news-date">15 Oct 2025</span>
            <p>Mejoras en el rendimiento del sistema</p>
        </div>
    </div>
</div>
```

**partials/sidebar_user.php:**

```html
<div class="sidebar sidebar-user">
    <div class="user-profile-card">
        <img src="${user_avatar}" alt="${username}" class="user-avatar-large">
        <h3>${username}</h3>
        <p class="user-email">${user_email}</p>
        <span class="user-badge">${user_role}</span>
        <a href="/profile" class="btn btn-sm btn-outline btn-block">Editar Perfil</a>
    </div>
    
    <nav class="sidebar-nav">
        <h4>Mi Cuenta</h4>
        <ul class="sidebar-menu">
            <li>
                <a href="/dashboard" class="sidebar-link">
                    <span class="icon">📊</span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/profile" class="sidebar-link">
                    <span class="icon">👤</span>
                    <span class="text">Mi Perfil</span>
                </a>
            </li>
            <li>
                <a href="/settings" class="sidebar-link">
                    <span class="icon">⚙️</span>
                    <span class="text">Configuración</span>
                </a>
            </li>
            <li>
                <a href="/notifications" class="sidebar-link">
                    <span class="icon">🔔</span>
                    <span class="text">Notificaciones</span>
                    {% if notification_count %}
                        <span class="badge">${notification_count}</span>
                    {% endif %}
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="sidebar-section">
        <h4>Actividad Reciente</h4>
        <div class="activity-feed">
            <div class="activity-item">
                <span class="activity-icon">📝</span>
                <div class="activity-content">
                    <p>Actualización de perfil</p>
                    <span class="activity-time">Hace 2 horas</span>
                </div>
            </div>
            <div class="activity-item">
                <span class="activity-icon">📂</span>
                <div class="activity-content">
                    <p>Nuevo proyecto creado</p>
                    <span class="activity-time">Hace 1 día</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="sidebar-section">
        <h4>Enlaces Rápidos</h4>
        <ul class="sidebar-links">
            <li><a href="/help">Centro de Ayuda</a></li>
            <li><a href="/support">Soporte Técnico</a></li>
            <li><a href="/documentation">Documentación</a></li>
        </ul>
    </div>
</div>
```

**partials/sidebar_admin.php:**

```html
<div class="sidebar sidebar-admin">
    <div class="admin-profile-card">
        <img src="${user_avatar}" alt="${username}" class="admin-avatar">
        <h3>${username}</h3>
        <span class="badge badge-admin">Administrador</span>
    </div>
    
    <nav class="admin-nav">
        <div class="nav-section">
            <h4>Panel de Control</h4>
            <ul class="admin-menu">
                <li>
                    <a href="/admin/dashboard" class="admin-link">
                        <span class="icon">📊</span>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/users" class="admin-link">
                        <span class="icon">👥</span>
                        <span class="text">Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/content" class="admin-link">
                        <span class="icon">📄</span>
                        <span class="text">Contenido</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/settings" class="admin-link">
                        <span class="icon">⚙️</span>
                        <span class="text">Configuración</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/reports" class="admin-link">
                        <span class="icon">📈</span>
                        <span class="text">Reportes</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="nav-section">
            <h4>Gestión</h4>
            <ul class="admin-menu">
                <li>
                    <a href="/admin/permissions" class="admin-link">
                        <span class="icon">🔐</span>
                        <span class="text">Permisos</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/logs" class="admin-link">
                        <span class="icon">📋</span>
                        <span class="text">Registros</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/backup" class="admin-link">
                        <span class="icon">💾</span>
                        <span class="text">Respaldo</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/maintenance" class="admin-link">
                        <span class="icon">🔧</span>
                        <span class="text">Mantenimiento</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="admin-stats-widget">
        <h4>Estadísticas Rápidas</h4>
        <div class="stat-item">
            <span class="stat-label">Usuarios Totales</span>
            <span class="stat-value">${total_users}</span>
        </div>
        <div class="stat-item">
            <span class="stat-label">Sesiones Activas</span>
            <span class="stat-value">${active_sessions}</span>
        </div>
        <div class="stat-item">
            <span class="stat-label">Solicitudes Hoy</span>
            <span class="stat-value">${requests_today}</span>
        </div>
    </div>
    
    <div class="sidebar-section">
        <a href="/" class="btn btn-outline btn-block">Ver Sitio Público</a>
    </div>
</div>
```

**partials/styles.php:**

```php
<!-- 
NOTA: Para que los assets funcionen, se asume la existencia de un helper global 'theme_asset()'.
Este helper es invocado con PHP nativo, ya que el motor de plantillas no lo procesa.
-->
<link rel="stylesheet" href="<?php echo theme_asset('gamma', 'css/gamma.css'); ?>">
<link rel="stylesheet" href="<?php echo theme_asset('gamma', 'css/components.css'); ?>">
```

**partials/scripts.php:**

```php
<!-- NOTA: Se utiliza el helper global 'theme_asset()' para generar la URL correcta. -->
<script src="<?php echo theme_asset('gamma', 'js/gamma.js'); ?>"></script>
<script src="<?php echo theme_asset('gamma', 'js/components.js'); ?>"></script>
```

## ASSETS - CSS

**public_html/css/gamma.css:**

```css
/* ====================================\n   Gamma Template System - Estilos Base\n   ==================================== */

:root {
    --primary-color: #3498db;
    --secondary-color: #2ecc71;
    --success-color: #27ae60;
    --danger-color: #e74c3c;
    --warning-color: #f39c12;
    --info-color: #3498db;
    --dark-color: #34495e;
    --light-color: #ecf0f1;
    --text-color: #2c3e50;
    --text-secondary: #7f8c8d;
    --border-color: #bdc3c7;
    --bg-color: #f8f9fa;
    --white: #ffffff;
    --shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.2);
    --radius: 8px;
    --transition: all 0.3s ease;
}

/* Reset y Base */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    font-size: 16px;
    scroll-behavior: smooth;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif;
    line-height: 1.6;
    color: var(--text-color);
    background-color: var(--bg-color);
}

a {
    text-decoration: none;
    color: var(--primary-color);
    transition: var(--transition);
}

a:hover {
    color: #2980b9;
}

img {
    max-width: 100%;
    height: auto;
}

/* Container */
.container {
    display: flex;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    gap: 20px;
}

/* Sidebar */
.sidebar {
    width: 300px;
    min-width: 300px;
    background: var(--white);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 20px;
}

.sidebar-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--border-color);
}

.sidebar-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.sidebar-section h3,
.sidebar-section h4 {
    margin-bottom: 1rem;
    color: var(--dark-color);
    font-size: 1.1rem;
}

/* Content */
.content {
    flex: 1;
    background: var(--white);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 30px;
}

/* Header */
.site-header {
    background: var(--dark-color);
    color: var(--white);
    box-shadow: var(--shadow);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.header-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo a {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--white);
    font-size: 1.5rem;
    font-weight: bold;
}

.logo img {
    width: 40px;
    height: 40px;
}

/* Navigation */
.nav-menu {
    list-style: none;
    display: flex;
    gap: 2rem;
    align-items: center;
}

.nav-link {
    color: var(--white);
    padding: 0.5rem 1rem;
    border-radius: 5px;
    transition: var(--transition);
}

.nav-link:hover {
    background: rgba(255, 255, 255, 0.1);
    color: var(--white);
}

.nav-admin {
    background: var(--danger-color);
}

.nav-admin:hover {
    background: #c0392b;
}

/* Buttons */
.btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 1rem;
    font-weight: 500;
    text-align: center;
    cursor: pointer;
    border: none;
    transition: var(--transition);
}

.btn-primary {
    background: var(--primary-color);
    color: var(--white);
}

.btn-primary:hover {
    background: #2980b9;
    color: var(--white);
}

.btn-secondary {
    background: var(--secondary-color);
    color: var(--white);
}

.btn-secondary:hover {
    background: #27ae60;
    color: var(--white);
}

.btn-outline {
    background: transparent;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
}

.btn-outline:hover {
    background: var(--primary-color);
    color: var(--white);
}

.btn-block {
    display: block;
    width: 100%;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 0.9rem;
}

.btn-large {
    padding: 15px 30px;
    font-size: 1.1rem;
}

/* User Menu */
.header-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.user-menu {
    position: relative;
}

.user-menu-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    background: transparent;
    border: none;
    color: var(--white);
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 5px;
    transition: var(--transition);
}

.user-menu-toggle:hover {
    background: rgba(255, 255, 255, 0.1);
}

.user-avatar-small {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 2px solid var(--white);
}

.user-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 10px;
    background: var(--white);
    border-radius: var(--radius);
    box-shadow: var(--shadow-lg);
    min-width: 200px;
    display: none;
}

.user-menu:hover .user-dropdown {
    display: block;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    color: var(--text-color);
    transition: var(--transition);
}

.dropdown-item:hover {
    background: var(--bg-color);
}

.dropdown-divider {
    height: 1px;
    background: var(--border-color);
    margin: 8px 0;
}

/* Mobile Menu */
.mobile-menu-toggle {
    display: none;
    flex-direction: column;
    gap: 4px;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 8px;
}

.mobile-menu-toggle span {
    display: block;
    width: 25px;
    height: 3px;
    background: var(--white);
    border-radius: 2px;
}

/* Footer */
.site-footer {
    background: var(--dark-color);
    color: var(--white);
    padding: 3rem 0 1rem;
    margin-top: 3rem;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.footer-section h4 {
    margin-bottom: 1rem;
    color: var(--white);
}

.footer-links {
    list-style: none;
}

.footer-links li {
    margin-bottom: 0.5rem;
}

.footer-links a {
    color: rgba(255, 255, 255, 0.8);
}

.footer-links a:hover {
    color: var(--white);
}

.social-links {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    font-size: 1.2rem;
}

.social-icon:hover {
    background: rgba(255, 255, 255, 0.2);
}

.footer-bottom {
    text-align: center;
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.heart {
    color: var(--danger-color);
}

/* Hero Section */
.hero {
    text-align: center;
    padding: 4rem 2rem;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: var(--white);
    border-radius: var(--radius);
    margin-bottom: 2rem;
}

.hero h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.hero p {
    font-size: 1.3rem;
    margin-bottom: 2rem;
}

.hero-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Features Grid */
.features {
    margin: 3rem 0;
}

.features h2 {
    text-align: center;
    margin-bottom: 2rem;
    font-size: 2rem;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.feature-card {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--radius);
    text-align: center;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.feature-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.feature-card h3 {
    margin-bottom: 1rem;
    color: var(--dark-color);
}

/* CTA Section */
.cta-section {
    text-align: center;
    padding: 3rem;
    background: var(--light-color);
    border-radius: var(--radius);
    margin: 3rem 0;
}

.cta-section h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

/* Forms */
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--dark-color);
}

.form-control {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid var(--border-color);
    border-radius: 5px;
    font-size: 1rem;
    transition: var(--transition);
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
}

/* Auth Layout */
.auth-layout {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.auth-container {
    width: 100%;
    max-width: 450px;
    padding: 20px;
}

.auth-box {
    background: var(--white);
    padding: 2.5rem;
    border-radius: 10px;
    box-shadow: var(--shadow-lg);
}

.auth-logo {
    text-align: center;
    margin-bottom: 2rem;
}

.auth-logo img {
    width: 60px;
    height: 60px;
    margin-bottom: 1rem;
}

.auth-footer {
    text-align: center;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border-color);
    color: var(--text-secondary);
}

/* Admin Layout */
.admin-layout {
    background: #f0f2f5;
}

.admin-header {
    background: var(--dark-color);
    color: var(--white);
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: var(--shadow);
}

.admin-header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.sidebar-toggle {
    background: transparent;
    border: none;
    color: var(--white);
    font-size: 1.5rem;
    cursor: pointer;
    padding: 8px;
}

.admin-container {
    display: flex;
    min-height: calc(100vh - 60px);
}

.admin-sidebar {
    width: 280px;
    min-width: 280px;
    background: var(--white);
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    padding: 1rem;
}

.admin-content {
    flex: 1;
    padding: 2rem;
}

.breadcrumb {
    background: var(--white);
    padding: 1rem;
    border-radius: var(--radius);
    margin-bottom: 2rem;
    box-shadow: var(--shadow);
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        flex-direction: column;
    }
    
    .sidebar {
        width: 100%;
        min-width: 100%;
    }
    
    .main-nav {
        display: none;
    }
    
    .mobile-menu-toggle {
        display: flex;
    }
    
    .hero h1 {
        font-size: 2rem;
    }
    
    .admin-sidebar {
        position: fixed;
        left: -280px;
        height: 100vh;
        z-index: 1000;
        transition: left 0.3s;
    }
    
    .admin-sidebar.active {
        left: 0;
    }
}
```

**public_html/css/components.css:**

```css
/* ====================================\n   Gamma Template - Componentes\n   ==================================== */

/* Sidebar Components */
.sidebar-links {
    list-style: none;
}

.sidebar-links li {
    margin-bottom: 0.5rem;
}

.sidebar-links a {
    color: var(--text-color);
    display: block;
    padding: 0.5rem;
    border-radius: 5px;
    transition: var(--transition);
}

.sidebar-links a:hover {
    background: var(--light-color);
}

/* Welcome Section */
.welcome-section {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: var(--white);
    text-align: center;
    padding: 2rem !important;
    border-radius: var(--radius);
}

.welcome-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.welcome-section h3 {
    color: var(--white);
}

.welcome-section p {
    margin-bottom: 1.5rem;
    opacity: 0.95;
}

/* Benefits List */
.benefits-list {
    list-style: none;
}

.benefits-list li {
    padding: 0.5rem 0;
    color: var(--text-color);
}

/* News Item */
.news-item {
    padding: 1rem;
    background: var(--light-color);
    border-radius: 5px;
    margin-bottom: 0.5rem;
}

.news-date {
    display: block;
    font-size: 0.85rem;
    color: var(--text-secondary);
    margin-bottom: 0.25rem;
}

/* User Profile Card */
.user-profile-card {
    text-align: center;
    padding: 1.5rem;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: var(--white);
    border-radius: var(--radius);
    margin-bottom: 1.5rem;
}

.user-avatar-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid var(--white);
    margin-bottom: 1rem;
}

.user-profile-card h3 {
    color: var(--white);
    margin-bottom: 0.5rem;
}

.user-email {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 0.5rem;
}

.user-badge {
    display: inline-block;
    padding: 4px 12px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    font-size: 0.85rem;
    margin-bottom: 1rem;
}

/* Sidebar Navigation */
.sidebar-nav h4 {
    color: var(--dark-color);
    margin-bottom: 1rem;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.sidebar-menu {
    list-style: none;
}

.sidebar-menu li {
    margin-bottom: 0.25rem;
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0.75rem 1rem;
    color: var(--text-color);
    border-radius: 5px;
    transition: var(--transition);
}

.sidebar-link:hover {
    background: var(--light-color);
    color: var(--primary-color);
}

.sidebar-link .icon {
    font-size: 1.2rem;
}

.sidebar-link .badge {
    margin-left: auto;
    background: var(--danger-color);
    color: var(--white);
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 0.75rem;
}

/* Activity Feed */
.activity-feed {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    gap: 12px;
    padding: 1rem;
    background: var(--light-color);
    border-radius: 5px;
}

.activity-icon {
    font-size: 1.5rem;
}

.activity-content p {
    margin: 0;
    color: var(--text-color);
}

.activity-time {
    font-size: 0.85rem;
    color: var(--text-secondary);
}

/* Admin Components */
.admin-profile-card {
    text-align: center;
    padding: 1.5rem;
    background: var(--dark-color);
    color: var(--white);
    border-radius: var(--radius);
    margin-bottom: 1.5rem;
}

.admin-avatar {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    border: 3px solid var(--white);
    margin-bottom: 1rem;
}

.badge-admin {
    display: inline-block;
    padding: 4px 12px;
    background: var(--danger-color);
    color: var(--white);
    border-radius: 12px;
    font-size: 0.85rem;
    margin-top: 0.5rem;
}

/* Admin Navigation */
.admin-nav {
    margin-bottom: 2rem;
}

.nav-section {
    margin-bottom: 2rem;
}

.nav-section h4 {
    color: var(--text-secondary);
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 1rem;
}

.admin-menu {
    list-style: none;
}

.admin-menu li {
    margin-bottom: 0.25rem;
}

.admin-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0.75rem 1rem;
    color: var(--text-color);
    border-radius: 5px;
    transition: var(--transition);
}

.admin-link:hover {
    background: var(--primary-color);
    color: var(--white);
}

/* Admin Stats Widget */
.admin-stats-widget {
    background: var(--light-color);
    padding: 1.5rem;
    border-radius: var(--radius);
    margin-bottom: 1.5rem;
}

.admin-stats-widget h4 {
    margin-bottom: 1rem;
    color: var(--dark-color);
}

.stat-item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-color);
}

.stat-item:last-child {
    border-bottom: none;
}

.stat-label {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.stat-value {
    font-weight: bold;
    color: var(--primary-color);
}

/* Dashboard Components */
.dashboard-header {
    margin-bottom: 2rem;
}

.dashboard-header h1 {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--white);
    padding: 1.5rem;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: var(--transition);
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.stat-icon {
    font-size: 2.5rem;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--light-color);
    border-radius: 50%;
}

.stat-info h3 {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-bottom: 0.25rem;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: var(--primary-color);
}

/* Dashboard Content */
.dashboard-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
}

.dashboard-section {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
}

.dashboard-section h2 {
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
}

/* Activity List */
.activity-list {
    max-height: 400px;
    overflow-y: auto;
}

/* Quick Links */
.quick-links {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.quick-link-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1.5rem;
    background: var(--light-color);
    border-radius: var(--radius);
    transition: var(--transition);
    color: var(--text-color);
}

.quick-link-card:hover {
    background: var(--primary-color);
    color: var(--white);
    transform: translateY(-3px);
}

.quick-link-card .icon {
    font-size: 2rem;
}

/* Profile Page */
.profile-page {
    background: var(--white);
}

.profile-header {
    position: relative;
    margin-bottom: 2rem;
}

.profile-cover {
    height: 200px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: var(--radius) var(--radius) 0 0;
}

.profile-info {
    display: flex;
    align-items: flex-end;
    gap: 2rem;
    padding: 0 2rem;
    margin-top: -50px;
}

.profile-avatar {
    position: relative;
}

.profile-avatar img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 5px solid var(--white);
}

.avatar-edit-btn {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: var(--primary-color);
    color: var(--white);
    border: 2px solid var(--white);
    cursor: pointer;
    font-size: 1rem;
}

.profile-details {
    flex: 1;
    padding-bottom: 1rem;
}

.profile-details h1 {
    margin-bottom: 0.5rem;
}

.profile-email {
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.profile-role {
    display: inline-block;
    padding: 4px 12px;
    background: var(--primary-color);
    color: var(--white);
    border-radius: 12px;
    font-size: 0.85rem;
}

/* Profile Tabs */
.profile-tabs {
    display: flex;
    gap: 1rem;
    border-bottom: 2px solid var(--border-color);
    padding: 0 2rem;
    margin-bottom: 2rem;
}

.tab-btn {
    background: transparent;
    border: none;
    padding: 1rem 1.5rem;
    cursor: pointer;
    color: var(--text-secondary);
    font-size: 1rem;
    font-weight: 500;
    border-bottom: 3px solid transparent;
    transition: var(--transition);
}

.tab-btn:hover {
    color: var(--primary-color);
}

.tab-btn.active {
    color: var(--primary-color);
    border-bottom-color: var(--primary-color);
}

.tab-content {
    display: none;
    padding: 0 2rem 2rem;
}

.tab-content.active {
    display: block;
}

/* Profile Form */
.profile-form {
    max-width: 600px;
}

.profile-form h3 {
    margin-bottom: 1.5rem;
}

/* Badge Component */
.badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 500;
}

/* Utility Classes */
.text-center {
    text-align: center;
}

.mt-1 { margin-top: 0.5rem; }
.mt-2 { margin-top: 1rem; }
.mt-3 { margin-top: 1.5rem; }

.mb-1 { margin-bottom: 0.5rem; }
.mb-2 { margin-bottom: 1rem; }
.mb-3 { margin-bottom: 1.5rem; }

.p-1 { padding: 0.5rem; }
.p-2 { padding: 1rem; }
.p-3 { padding: 1.5rem; }
```

## ASSETS - JAVASCRIPT

**public_html/js/gamma.js:**

```javascript
/**
 * Gamma Theme - Main JavaScript
 * @version 1.0.0
 */

const Gamma = {
    /**
     * Initialize the Gamma theme
     */
    init() {
        console.log(\'🎨 Gamma Theme System v1.0.0 initialized\');
        this.setupEventListeners();
        this.initComponents();
        this.initMobileMenu();
        this.initUserMenu();
    },
    
    /**
     * Setup global event listeners
     */
    setupEventListeners() {
        // Smooth scroll for anchor links
        document.querySelectorAll(\'a[href^="#"]\').forEach(anchor => {
            anchor.addEventListener(\'click\', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute(\'href\'));
                if (target) {
                    target.scrollIntoView({ 
                        behavior: \'smooth\',
                        block: \'start\'
                    });
                }
            });
        });
        
        // Form validation
        document.querySelectorAll(\'form\').forEach(form => {
            form.addEventListener(\'submit\', function(e) {
                if (!Gamma.validateForm(this)) {
                    e.preventDefault();
                }
            });
        });
    },
    
    /**
     * Initialize mobile menu
     */
    initMobileMenu() {
        const toggle = document.getElementById(\'mobileMenuToggle\');
        const nav = document.querySelector(\'.main-nav\');
        
        if (toggle && nav) {
            toggle.addEventListener(\'click\', () => {
                nav.classList.toggle(\'active\');
                toggle.classList.toggle(\'active\');
            });
        }
    },
    
    /**
     * Initialize user menu dropdown
     */
    initUserMenu() {
        const userMenu = document.querySelector(\'.user-menu\');
        
        if (userMenu) {
            const toggle = userMenu.querySelector(\'.user-menu-toggle\');
            const dropdown = userMenu.querySelector(\'.user-dropdown\');
            
            if (toggle && dropdown) {
                toggle.addEventListener(\'click\', (e) => {
                    e.stopPropagation();
                    dropdown.style.display = dropdown.style.display === \'block\' ? \'none\' : \'block\';
                });
                
                // Close dropdown when clicking outside
                document.addEventListener(\'click\', () => {
                    dropdown.style.display = \'none\';
                });
            }
        }
    },
    
    /**
     * Initialize components
     */
    initComponents() {
        this.initTabs();
        this.initSidebarToggle();
        this.initTooltips();
        this.initModals();
    },
    
    /**
     * Initialize tab navigation
     */
    initTabs() {
        const tabButtons = document.querySelectorAll(\'.tab-btn\');
        
        tabButtons.forEach(button => {
            button.addEventListener(\'click\', function() {
                const tabName = this.getAttribute(\'data-tab\');
                
                // Remove active class from all tabs
                document.querySelectorAll(\'.tab-btn\').forEach(btn => {
                    btn.classList.remove(\'active\');
                });
                
                document.querySelectorAll(\'.tab-content\').forEach(content => {
                    content.classList.remove(\'active\');
                });
                
                // Add active class to clicked tab
                this.classList.add(\'active\');
                const tabContent = document.getElementById(\'tab-\' + tabName);
                if (tabContent) {
                    tabContent.classList.add(\'active\');
                }
            });
        });
    },
    
    /**
     * Initialize sidebar toggle for admin layout
     */
    initSidebarToggle() {
        const toggle = document.getElementById(\'sidebarToggle\');
        const sidebar = document.getElementById(\'adminSidebar\');
        
        if (toggle && sidebar) {
            toggle.addEventListener(\'click\', () => {
                sidebar.classList.toggle(\'active\');
            });
        }
    },
    
    /**
     * Initialize tooltips
     */
    initTooltips() {
        const tooltips = document.querySelectorAll(\'[data-tooltip]\');
        
        tooltips.forEach(element => {
            element.addEventListener(\'mouseenter\', function() {
                const text = this.getAttribute(\'data-tooltip\');
                const tooltip = document.createElement(\'div\');
                tooltip.className = \'tooltip\';
                tooltip.textContent = text;
                document.body.appendChild(tooltip);
                
                const rect = this.getBoundingClientRect();
                tooltip.style.top = (rect.top - tooltip.offsetHeight - 10) + \'px\';
                tooltip.style.left = (rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2)) + \'px\';
            });
            
            element.addEventListener(\'mouseleave\', function() {
                document.querySelectorAll(\'.tooltip\').forEach(t => t.remove());
            });
        });
    },
    
    /**
     * Initialize modals
     */
    initModals() {
        const modalTriggers = document.querySelectorAll(\'[data-modal]\');
        
        modalTriggers.forEach(trigger => {
            trigger.addEventListener(\'click\', function(e) {
                e.preventDefault();
                const modalId = this.getAttribute(\'data-modal\');
                const modal = document.getElementById(modalId);
                
                if (modal) {
                    modal.style.display = \'block\';
                }
            });
        });
        
        // Close modal buttons
        document.querySelectorAll(\'.modal-close\').forEach(btn => {
            btn.addEventListener(\'click\', function() {
                const modal = this.closest(\'.modal\');
                if (modal) {
                    modal.style.display = \'none\';
                }
            });
        });
        
        // Close modal when clicking outside
        window.addEventListener(\'click\', function(e) {
            if (e.target.classList.contains(\'modal\')) {
                e.target.style.display = \'none\';
            }
        });
    },
    
    /**
     * Validate form
     */
    validateForm(form) {
        let isValid = true;
        const inputs = form.querySelectorAll(\'[required]\');
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add(\'error\');
                this.showFieldError(input, \'Este campo es requerido\');
            } else {
                input.classList.remove(\'error\');
                this.hideFieldError(input);
            }
        });
        
        return isValid;
    },
    
    /**
     * Show field error
     */
    showFieldError(input, message) {
        let error = input.parentElement.querySelector(\'.field-error\');
        if (!error) {
            error = document.createElement(\'span\');
            error.className = \'field-error\';
            input.parentElement.appendChild(error);
        }
        error.textContent = message;
    },
    
    /**
     * Hide field error
     */
    hideFieldError(input) {
        const error = input.parentElement.querySelector(\'.field-error\');
        if (error) {
            error.remove();
        }
    },
    
    /**
     * Show notification
     */
    showNotification(message, type = \'info\') {
        const notification = document.createElement(\'div\');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add(\'show\');
        }, 10);
        
        setTimeout(() => {
            notification.classList.remove(\'show\');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    },
    
    /**
     * AJAX helper
     */
    ajax(url, options = {}) {
        const defaults = {
            method: \'GET\',
            headers: {
                \'Content-Type\': \'application/json\',
                \'X-Requested-With\': \'XMLHttpRequest\'
            }
        };
        
        const config = { ...defaults, ...options };
        
        return fetch(url, config)
            .then(response => {
                if (!response.ok) {
                    throw new Error(\'Network response was not ok\');
                }
                return response.json();
            })
            .catch(error => {
                console.error(\'AJAX Error:\', error);
                this.showNotification(\'Error en la solicitud\', \'error\');
            });
    }
};

// Initialize Gamma when DOM is ready
if (document.readyState === \'loading\') {
    document.addEventListener(\'DOMContentLoaded\', () => Gamma.init());
} else {
    Gamma.init();
}

// Export Gamma to global scope
window.Gamma = Gamma;
```

**public_html/js/components.js:**

```javascript
/**
 * Gamma Theme - Component Scripts
 * Additional interactive components
 * @version 1.0.0
 */

const GammaComponents = {
    /**
     * Initialize all components
     */
    init() {
        console.log(\'🔧 Gamma Components initialized\');
        this.initDropdowns();
        this.initAccordions();
        this.initCarousel();
        this.initDataTables();
        this.initCharts();
    },
    
    /**
     * Initialize dropdown components
     */
    initDropdowns() {
        const dropdowns = document.querySelectorAll(\'.dropdown\');
        
        dropdowns.forEach(dropdown => {
            const toggle = dropdown.querySelector(\'.dropdown-toggle\');
            const menu = dropdown.querySelector(\'.dropdown-menu\');
            
            if (toggle && menu) {
                toggle.addEventListener(\'click\', (e) => {
                    e.stopPropagation();
                    
                    // Close other dropdowns
                    document.querySelectorAll(\'.dropdown-menu\').forEach(m => {
                        if (m !== menu) m.classList.remove(\'show\');
                    });
                    
                    menu.classList.toggle(\'show\');
                });
            }
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener(\'click\', () => {
            document.querySelectorAll(\'.dropdown-menu\').forEach(menu => {
                menu.classList.remove(\'show\');
            });
        });
    },
    
    /**
     * Initialize accordion components
     */
    initAccordions() {
        const accordions = document.querySelectorAll(\'.accordion-item\');
        
        accordions.forEach(item => {
            const header = item.querySelector(\'.accordion-header\');
            const content = item.querySelector(\'.accordion-content\');
            
            if (header && content) {
                header.addEventListener(\'click\', () => {
                    const isOpen = item.classList.contains(\'open\');
                    
                    // Close all accordions in the same group
                    const parent = item.closest(\'.accordion\');
                    if (parent) {
                        parent.querySelectorAll(\'.accordion-item\').forEach(i => {
                            i.classList.remove(\'open\');
                        });
                    }
                    
                    // Toggle current accordion
                    if (!isOpen) {
                        item.classList.add(\'open\');
                    }
                });
            }
        });
    },
    
    /**
     * Initialize carousel/slider
     */
    initCarousel() {
        const carousels = document.querySelectorAll(\'.carousel\');
        
        carousels.forEach(carousel => {
            let currentSlide = 0;
            const slides = carousel.querySelectorAll(\'.carousel-item\');
            const prevBtn = carousel.querySelector(\'.carousel-prev\');
            const nextBtn = carousel.querySelector(\'.carousel-next\');
            
            const showSlide = (index) => {
                slides.forEach((slide, i) => {
                    slide.style.display = i === index ? \'block\' : \'none\';
                });
            };
            
            if (prevBtn) {
                prevBtn.addEventListener(\'click\', () => {
                    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                    showSlide(currentSlide);
                });
            }
            
            if (nextBtn) {
                nextBtn.addEventListener(\'click\', () => {
                    currentSlide = (currentSlide + 1) % slides.length;
                    showSlide(currentSlide);
                });
            }
            
            // Auto-advance
            if (carousel.dataset.autoplay === \'true\') {
                const interval = parseInt(carousel.dataset.interval) || 5000;
                setInterval(() => {
                    currentSlide = (currentSlide + 1) % slides.length;
                    showSlide(currentSlide);
                }, interval);
            }
            
            showSlide(0);
        });
    },
    
    /**
     * Initialize data tables with sorting/filtering
     */
    initDataTables() {
        const tables = document.querySelectorAll(\'.data-table\');
        
        tables.forEach(table => {
            const headers = table.querySelectorAll(\'th[data-sortable]\');
            
            headers.forEach(header => {
                header.style.cursor = \'pointer\';
                header.addEventListener(\'click\', () => {
                    const column = header.cellIndex;
                    const rows = Array.from(table.querySelectorAll(\'tbody tr\'));
                    const isAscending = header.classList.contains(\'sort-asc\');
                    
                    rows.sort((a, b) => {
                        const aValue = a.cells[column].textContent.trim();
                        const bValue = b.cells[column].textContent.trim();
                        
                        if (isAscending) {
                            return bValue.localeCompare(aValue);
                        } else {
                            return aValue.localeCompare(bValue);
                        }
                    });
                    
                    // Remove sort classes from all headers
                    headers.forEach(h => h.classList.remove(\'sort-asc\', \'sort-desc\'));
                    
                    // Add sort class to current header
                    header.classList.add(isAscending ? \'sort-desc\' : \'sort-asc\');
                    
                    // Reorder rows
                    const tbody = table.querySelector(\'tbody\');
                    rows.forEach(row => tbody.appendChild(row));
                });
            });
        });
    },
    
    /**
     * Initialize charts (placeholder - requires chart library)
     */
    initCharts() {
        const charts = document.querySelectorAll(\'.chart\');
        
        charts.forEach(chart => {
            const type = chart.dataset.type;
            const data = JSON.parse(chart.dataset.data || \'{}\');
            
            // This would integrate with a charting library like Chart.js
            console.log(`Chart initialized: ${type}`, data);
        });
    },
    
    /**
     * Copy to clipboard utility
     */
    copyToClipboard(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                Gamma.showNotification(\'Copiado al portapapeles\', \'success\');
            }).catch(() => {
                Gamma.showNotification(\'Error al copiar\', \'error\');
            });
        } else {
            // Fallback for older browsers
            const textarea = document.createElement(\'textarea\');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand(\'copy\');
            document.body.removeChild(textarea);
            Gamma.showNotification(\'Copiado al portapapeles\', \'success\');
        }
    },
    
    /**
     * Format date
     */
    formatDate(date, format = \'YYYY-MM-DD\') {
        const d = new Date(date);
        const year = d.getFullYear();
        const month = String(d.getMonth() + 1).padStart(2, \'0\');
        const day = String(d.getDate()).padStart(2, \'0\');
        
        return format
            .replace(\'YYYY\', year)
            .replace(\'MM\', month)
            .replace(\'DD\', day);
    },
    
    /**
     * Debounce function
     */
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },
    
    /**
     * Local storage helper
     */
    storage: {
        set(key, value) {
            try {
                localStorage.setItem(`gamma_${key}`, JSON.stringify(value));
            } catch (e) {
                console.error(\'Error saving to localStorage\', e);
            }
        },
        
        get(key, defaultValue = null) {
            try {
                const item = localStorage.getItem(`gamma_${key}`);
                return item ? JSON.parse(item) : defaultValue;
            } catch (e) {
                console.error(\'Error reading from localStorage\', e);
                return defaultValue;
            }
        },
        
        remove(key) {
            try {
                localStorage.removeItem(`gamma_${key}`);
            } catch (e) {
                console.error(\'Error removing from localStorage\', e);
            }
        }
    }
};

// Initialize components when DOM is ready
if (document.readyState === \'loading\') {
    document.addEventListener(\'DOMContentLoaded\', () => GammaComponents.init());
} else {
    GammaComponents.init();
}

// Export to global scope
window.GammaComponents = GammaComponents;
```

## EJEMPLO DE USO DESDE CONTROLADOR

Crea también un archivo de ejemplo que muestre cómo usar Gamma desde un controlador de CodeIgniter 4:

**EJEMPLO: app/Controllers/Home.php**

```php
<?php
namespace App\\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            \'page_title\' => \'Bienvenido a Gamma\',
            \'meta_description\' => \'Sistema de plantillas modular para CodeIgniter 4\',
            \'content_page\' => \'home\',
            \'layout\' => \'default\',
            
            // Datos para el hero
            \'welcome_message\' => \'Bienvenido a Gamma Template System\',
            \'site_description\' => \'El mejor sistema de plantillas para CodeIgniter 4\',
        ];
        
        return view(\'Themes/Gamma/index\', $data);
    }
    
    public function dashboard()
    {
        // Verificar autenticación
        if (!session()->get(\'logged_in\')) {
            return redirect()->to(\'/login\');
        }
        
        $data = [
            \'page_title\' => \'Dashboard\',
            \'content_page\' => \'dashboard\',
            \'layout\' => \'default\',
            
            // Datos del usuario
            \'username\' => session()->get(\'username\'),
            \'user_email\' => session()->get(\'email\'),
            \'user_avatar\' => session()->get(\'avatar\') ?? \'/default-avatar.png\',
            \'user_role\' => session()->get(\'role\'),
            \'is_logged_in\' => true,
            \'is_admin\' => session()->get(\'role\') === \'admin\',
            
            // Estadísticas
            \'total_users\' => \'1,234\',
            \'activity_count\' => \'567\',
            \'projects_count\' => \'89\',
            \'messages_count\' => \'42\',
            \'notification_count\' => 3,
            
            // Contenido dinámico
            \'recent_activity_content\' => $this->getRecentActivity(),
        ];
        
        return view(\'Themes/Gamma/index\', $data);
    }
    
    public function profile()
    {
        if (!session()->get(\'logged_in\')) {
            return redirect()->to(\'/login\');
        }
        
        $data = [
            \'page_title\' => \'Mi Perfil\',
            \'content_page\' => \'profile\',
            \'layout\' => \'default\',
            
            \'username\' => session()->get(\'username\'),
            \'user_email\' => session()->get(\'email\'),
            \'user_avatar\' => session()->get(\'avatar\') ?? \'/default-avatar.png\',
            \'user_role\' => session()->get(\'role\'),
            \'is_logged_in\' => true,
            \'is_admin\' => session()->get(\'role\') === \'admin\',
            
            // Datos del perfil
            \'full_name\' => session()->get(\'full_name\') ?? \'\',
            \'phone\' => session()->get(\'phone\') ?? \'\',
            \'bio\' => session()->get(\'bio\') ?? \'\',
        ];
        
        return view(\'Themes/Gamma/index\', $data);
    }
    
    public function admin()
    {
        if (!session()->get(\'logged_in\') || session()->get(\'role\') !== \'admin\') {
            return redirect()->to(\'/\');
        }
        
        $data = [
            \'page_title\' => \'Panel de Administración\',
            \'content_page\' => \'dashboard\',
            \'layout\' => \'admin\',
            
            \'username\' => session()->get(\'username\'),
            \'user_avatar\' => session()->get(\'avatar\') ?? \'/default-avatar.png\',
            \'is_logged_in\' => true,
            \'is_admin\' => true,
            
            // Estadísticas de admin
            \'total_users\' => 1234,
            \'active_sessions\' => 45,
            \'requests_today\' => 8976,
        ];
        
        return view(\'Themes/Gamma/index\', $data);
    }
    
    private function getRecentActivity()
    {
        return \'<div class="activity-item">
            <span class="activity-icon">📝</span>
            <div class="activity-content">
                <p>Perfil actualizado</p>
                <span class="activity-time">Hace 2 horas</span>
            </div>
        </div>
        <div class="activity-item">
            <span class="activity-icon">📂</span>
            <div class="activity-content">
                <p>Nuevo proyecto creado</p>
                <span class="activity-time">Hace 1 día</span>
            </div>
        </div>\';
    }
}
```

**EJEMPLO: app/Config/Routes.php**

```php
<?php
$routes->get(\'/\', \'Home::index\');
$routes->get(\'/dashboard\', \'Home::dashboard\');
$routes->get(\'/profile\', \'Home::profile\');
$routes->get(\'/admin\', \'Home::admin\');
```

**EJEMPLO: Función Helper Global (app/Helpers/auth_helper.php)**

```php
<?php

if (!function_exists(\'get_LoggedIn\')) {
    /**
     * Verificar si el usuario está autenticado
     * Esta función es usada por SidebarGenerator
     * 
     * @return bool
     */
    function get_LoggedIn()
    {
        $session = session();
        return $session->has(\'logged_in\') && $session->get(\'logged_in\') === true;
    }
}

if (!function_exists(\'get_UserRole\')) {
    /**
     * Obtener el rol del usuario actual
     * 
     * @return string|null
     */
    function get_UserRole()
    {
        $session = session();
        return $session->get(\'role\');
    }
}
```

## INSTRUCCIONES FINALES

1. **Crear todos los archivos** exactamente como se especifica en la estructura de directorios
2. **Implementar todas las clases PHP** con el código completo proporcionado
3. **Crear todas las plantillas HTML** en sus respectivos directorios
4. **Implementar los archivos CSS** con todos los estilos
5. **Implementar los archivos JavaScript** con toda la funcionalidad
6. **Crear el archivo .gitkeep** en el directorio cache/
7. **Crear una imagen de logo** placeholder en public_html/images/logo.png (puede ser un PNG simple de 200x200px)

## VERIFICACIÓN DEL SISTEMA

Después de crear todos los archivos, verifica que:

✅ El archivo `index.php` existe en la raíz de Gamma  
✅ Todas las clases en `Libraries/` tienen el namespace `Gamma`  
✅ Todas las rutas de inclusión usan la sintaxis `{% include \'ruta\' %}`  
✅ Todas las variables usan la sintaxis `${variable}`  
✅ Los condicionales usan la sintaxis `{% if condicion %}`  
✅ Los archivos CSS están correctamente referenciados  
✅ Los archivos JavaScript están correctamente referenciados  
✅ La estructura de directorios coincide exactamente con la especificada

## NOTAS IMPORTANTES

- **NO** uses `localStorage` o `sessionStorage` en los archivos JavaScript de artifacts
- **TODAS** las rutas de archivos deben ser relativas a la carpeta Gamma
- **TODAS** las clases PHP deben usar el namespace `\\Gamma`
- El archivo `index.php` es el **ÚNICO PUNTO DE ENTRADA** desde CodeIgniter 4
- El sistema debe funcionar completamente autocontenido dentro de su directorio

## TESTING

Para probar el sistema:

1. Crear un controlador en CodeIgniter 4
2. Llamar a `view(\'Themes/Gamma/index\', $data)`
3. Verificar que el HTML se renderiza correctamente
4. Probar con diferentes usuarios (guest, user, admin)
5. Verificar que los sidebars cambian según el rol

Este prompt contiene TODAS las especificaciones necesarias para construir el sistema Gamma completo y funcional.
