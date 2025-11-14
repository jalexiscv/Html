<?php
/**
 * Configuración central de la aplicación (sin .env)
 *
 * - Define todos los parámetros en PHP puro para evitar dependencias del archivo .env.
 * - Se organiza en secciones: app, scraper y wordpress.
 * - No usa librerías de terceros.
 */

return [
    // Configuración de la aplicación
    'app' => [
        // Nombre del entorno (solo informativo)
        'env' => 'development',
        // Habilita salida de errores y bloques de diagnóstico (details)
        'debug' => true,
    ],

    // Parámetros del scrapper (HTTP)
    'scraper' => [
        // User-Agent por defecto para cURL
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, como Gecko) Chrome/124.0 Safari/537.36',
        // Timeout total de la petición (segundos)
        'timeout' => 25,
        // Timeout de conexión (segundos)
        'connect_timeout' => 10,
        // Referer por defecto
        'referer' => 'http://www.bing.com/',
        // Palabras clave en las URLs de imágenes para ser ignoradas.
        // Si la URL de una imagen contiene alguna de estas palabras, no se publicará.
        'ignore_image_keywords' => [
            'escudo-policia',
            'radio-policia-azul',
        ],
    ],

    // Credenciales y opciones de WordPress REST API
    'wordpress' => [
        // Base URL del sitio WordPress (sin barra final)
        'base_url' => 'https://buga.com.co',
        // Usuario con Application Password habilitado
        'user' => 'jorge@gmail.com',
        // Application Password (nunca lo subas a repos público)
        'app_password' => 'gZhTKu91Rg',
        // Verificar o no el SSL en la conexión
        'verify_ssl' => true,
    ],

    // Configuración del plugin Scrapper (publicación vía endpoint propio)
    'scrapper_plugin' => [
        // Si es true y hay token, se usará el endpoint /wp-json/scrapper/v1/posts
        'enabled' => true,
        // Token generado al activar el plugin (WP-Admin > Plugins). Rellena este valor.
        'token' => 'iHj3r0wcxNqgVpS7tkf6MNE8EatktqLP',
    ],

    // Configuración de Gemini (Google Generative Language API)
    // Uso opcional: si está habilitado, el scrapper enviará el HTML a Gemini para
    // obtener un JSON con title, content_html, featured_image, category, tags, meta_title y meta_description.
    'gemini' => [
        'enabled' => false, // poner true para activar
        'api_key' => '',    // coloca aquí tu API Key segura (no subir a repos públicos)
        'model' => 'gemini-1.5-flash',
        'endpoint_base' => 'https://generativelanguage.googleapis.com/v1beta/models'
    ],

    // Presets por dominio para extracción específica (sin librerías externas)
    // Cada clave es un host (sin esquema). Se aplican al limpiar la vista y extraer imagen destacada.
    'presets' => [
        // Ejemplo: Policía Nacional de Colombia
        'policia.gov.co' => [
            // Prefijo de ruta por defecto para filtrar enlaces internos si no se especifica ?path=
            'default_path_prefix' => '/noticias/',
            // XPath del contenedor principal del artículo
            'content_xpath' => '//*[contains(@class,"field--name-body")] | //article[contains(@class,"node")]//div[contains(@class,"body")] | //div[@id="contenido"]',
            // XPath del título (opcional)
            'title_xpath' => '//h1[1]',
            // XPaths relativos al contenedor que se deben remover (redes, breadcrumbs, etc.)
            'remove_xpaths' => [
                './/div[contains(@class,"shared")] | .//ul[contains(@class,"social")] | .//div[contains(@class,"breadcrumbs")]'
            ],
            // XPath para imagen destacada (usa og:image si existe)
            'featured_xpath' => '//meta[@property="og:image"]',
            // Atributos a absolutizar dentro del contenido
            'absolutize_attrs' => ['href', 'src'],
        ],
    ],

    // Configuración de Blogger API
    'blogger' => [
        // Habilitar publicación en Blogger
        'enabled' => true,
        // Ruta al archivo JSON de credenciales de Google Cloud
        'credentials_json' => __DIR__ . '/secret.json',
        // URL del blog de Blogger (sin barra final)
        'blog_url' => 'https://jalexiscv.blogspot.com',
        // URI de redirección para el flujo OAuth2. Debe coincidir con la configurada en Google Cloud.
        'redirect_uri' => 'https://' . $_SERVER['HTTP_HOST'] . '/blogger/scrapper/publish_blogger.php',
    ],
];
