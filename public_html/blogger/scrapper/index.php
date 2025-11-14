<?php
/**
 * Scrapper minimalista basado en el plugin WP del directorio `plugin/` sin modificarlo.
 *
 * - Muestra un formulario para indicar la URL a scrapear.
 * - Realiza la descarga con cURL (UA, timeouts, referer), siguiendo el patrón del plugin `core.php`.
 * - Extrae título, meta descripción, headings, párrafos más largos, imágenes y enlaces.
 * - No usa librerías de terceros. Todo es PHP nativo (DOMDocument, cURL).
 * - Cada función está documentada en español.
 */

// --- Carga de configuración PHP (sin .env) ---------------------------------
// Tomamos toda la configuración desde un archivo PHP local `config.php`
// para evitar depender de variables de entorno.
$__APP_CFG = require __DIR__ . '/config.php';
$__APP = $__APP_CFG['app'] ?? ['env' => 'production', 'debug' => false];
$__SCRAPER = $__APP_CFG['scraper'] ?? [];
$__WP = $__APP_CFG['wordpress'] ?? [];
// Configuración del plugin Scrapper (token y switch enabled)
$__SCRPR_PLUGIN = $__APP_CFG['scrapper_plugin'] ?? ['enabled' => false, 'token' => ''];
// Presets por dominio para extracción específica
$__PRESETS = $__APP_CFG['presets'] ?? [];
// Configuración de Gemini (opcional)
$__GEMINI = $__APP_CFG['gemini'] ?? ['enabled' => false, 'api_key' => 'AIzaSyCuZ3WixBDQpl8R6uVPzI1GOvDWFICDDPI', 'model' => 'gemini-1.5-flash', 'endpoint_base' => 'https://generativelanguage.googleapis.com/v1beta/models'];

// Control de debug según config.php
if (!empty($__APP['debug'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
    ini_set('display_errors', '0');
}

// Carga helpers propios de este scrapper
require_once __DIR__ . '/inc/helpers.php';
require_once __DIR__ . '/inc/HttpClient.php';
require_once __DIR__ . '/inc/HtmlExtractor.php';
require_once __DIR__ . '/inc/DataStore.php';
require_once __DIR__ . '/inc/GeminiClient.php';

// Configuración básica (lee de config.php)
$CONFIG = [
    'user_agent' => $__SCRAPER['user_agent'] ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0 Safari/537.36',
    'timeout' => (int)($__SCRAPER['timeout'] ?? 25),
    'connect_timeout' => (int)($__SCRAPER['connect_timeout'] ?? 10),
    'referer' => $__SCRAPER['referer'] ?? 'http://www.bing.com/',
];

// Render simple con estilos
function view_header()
{
    echo '<!doctype html><html lang="es"><head><meta charset="utf-8">'
        . '<meta name="viewport" content="width=device-width, initial-scale=1">'
        . '<title>Scrapper</title>'
        . '<link rel="stylesheet" href="./assets/style.css">'
        . '</head><body><div class="container">';
}

/**
 * __handle_scrape_rss__
 * Genera un RSS 2.0 con los enlaces internos encontrados en la página origen.
 * Para cada enlace, descarga el contenido, produce una vista limpia, extrae fecha (YYYY-MM-DD) y tags.
 * El feed incluye: title, link (original), guid (md5 de URL canónica), pubDate, description y content:encoded.
 * NOTA: Se limita a los primeros N enlaces para evitar tiempos excesivos.
 */
function handle_scrape_rss(array $config, $incomingUrl)
{
    // Hacer disponible la tabla de presets por dominio
    global $__PRESETS;
    $url = trim($incomingUrl ?? '');
    if ($url === '' || !filter_var($url, FILTER_VALIDATE_URL)) {
        header('Content-Type: text/plain; charset=utf-8');
        echo "URL inválida";
        return;
    }

    // Descargar página origen y extraer enlaces
    // Permitir overrides desde GET para UA, referer y timeouts
    $ua = isset($_GET['ua']) ? (string)$_GET['ua'] : $config['user_agent'];
    $ref = isset($_GET['referer']) ? (string)$_GET['referer'] : $config['referer'];
    $to = isset($_GET['timeout']) ? (int)$_GET['timeout'] : (int)$config['timeout'];
    $cto = isset($_GET['connect_timeout']) ? (int)$_GET['connect_timeout'] : (int)$config['connect_timeout'];
    $http = new HttpClient($ua, $ref, $to, $cto);
    $resp = $http->get($url, ['follow_redirects' => true, 'max_redirects' => 5]);
    if ($resp['error']) {
        header('Content-Type: text/plain; charset=utf-8');
        echo 'Error de descarga: ' . $resp['error_message'];
        return;
    }

    $extractor = new HtmlExtractor();
    $info = $extractor->extract($resp['body'], $resp['final_url']);
    $links = $info['links'] ?? [];

    // Prefijo de ruta configurable (?path=/noticias/). Si no viene, usar el del preset del host si existe; si no, "/noticias/".
    $pathPrefix = isset($_GET['path']) ? (string)$_GET['path'] : '';
    $pathPrefix = trim($pathPrefix);
    // Obtener host origen para preset
    $srcHost = parse_url($resp['final_url'], PHP_URL_HOST);
    if ($pathPrefix === '') {
        $pathPrefix = isset($__PRESETS[$srcHost]['default_path_prefix']) ? (string)$__PRESETS[$srcHost]['default_path_prefix'] : '/noticias/';
    }
    // Asegurar que inicia con '/'
    if ($pathPrefix[0] !== '/') {
        $pathPrefix = '/' . $pathPrefix;
    }
    // Normalizar múltiples barras
    $pathPrefix = preg_replace('#/{2,}#', '/', $pathPrefix);

    // Filtrar: solo URLs del mismo host y cuyo path comience con el prefijo indicado
    $links = array_values(array_filter($links, function ($u) use ($srcHost, $pathPrefix) {
        $host = parse_url($u, PHP_URL_HOST);
        if (!$host || strcasecmp($host, $srcHost) !== 0) return false;
        $path = parse_url($u, PHP_URL_PATH) ?: '/';
        // Normalizar múltiples barras
        $path = preg_replace('#/{2,}#', '/', $path);
        return strpos($path, $pathPrefix) === 0; // debe iniciar con el prefijo
    }));

    // Limitar número de items (configurable por ?limit=)
    $limitRaw = isset($_GET['limit']) ? $_GET['limit'] : '';
    $maxItems = 20; // por defecto
    if ($limitRaw !== '' && is_numeric($limitRaw)) {
        $maxItems = max(1, min(100, (int)$limitRaw)); // tope de seguridad 100
    }
    if (count($links) > $maxItems) {
        $links = array_slice($links, 0, $maxItems);
    }

    // Preparar base para enlaces internos absolutos
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
    $selfBase = $scheme . '://' . $host . ($basePath !== '' ? $basePath : '');

    // Construir items
    $items = [];
    foreach ($links as $lnk) {
        // Generar ID y guardar en DataStore para asegurar consistencia con vista interna
        $canon = normalize_url_canonical($lnk);
        $id = md5($canon);
        static $store = null;
        if ($store === null) {
            $store = new DataStore(__DIR__);
        }
        $store->setUrl($id, $canon);

        // Descargar cada enlace y construir contenido limpio
        $r = $http->get($lnk, ['follow_redirects' => true, 'max_redirects' => 5]);
        if ($r['error']) {
            continue;
        }
        // Aplicar preset por dominio si existe
        $preset = null;
        $h = parse_url($r['final_url'], PHP_URL_HOST);
        if ($h && isset($__PRESETS[$h])) {
            $preset = $__PRESETS[$h];
        }
        $clean = $extractor->cleanView($r['body'], $r['final_url'], $preset);
        $title = $clean['title'] ?: $r['final_url'];
        // Featured preferente desde cleanView
        $featured = $clean['featured'] ?? null;
        $pubYmd = $extractor->extractPublishedDate($r['body']);
        $pubDateRfc = '';
        if ($pubYmd !== '') {
            $ts = strtotime($pubYmd . ' 00:00:00');
            if ($ts) {
                $pubDateRfc = gmdate('r', $ts);
            }
        }
        $tags = $extractor->extractTagsFromHtml($clean['content_html'], 12);

        // Link interno absoluto para este item
        $internalRel = render_internal_link($lnk, $url); // ?u=...&r=...
        $internalAbs = $selfBase . '/' . ltrim($internalRel, '/');

        // Descripción corta como texto
        $plain = strip_tags($clean['content_html']);
        $plain = normalize_whitespace($plain);
        $desc = mb_substr($plain, 0, 300, 'UTF-8');

        $items[] = [
            'title' => $title,
            'link' => $r['final_url'],
            'guid' => $id,
            'pubDate' => $pubDateRfc,
            'description' => $desc,
            'content_html' => $clean['content_html'] . '<p style="margin-top:12px"><a href="' . htmlspecialchars($internalAbs, ENT_QUOTES, 'UTF-8') . '">Ver interno</a></p>',
            'categories' => $tags,
        ];
    }

    // Construir URL self del feed (estilo WP)
    $selfUrl = $selfBase . '/' . ltrim(basename($_SERVER['SCRIPT_NAME'] ?? 'index.php'), '/');
    $selfUrl .= '?url=' . rawurlencode($url) . '&rss=1';
    if (!empty($pathPrefix)) {
        $selfUrl .= '&path=' . rawurlencode($pathPrefix);
    }
    if ($limitRaw !== '' && is_numeric($limitRaw)) {
        $selfUrl .= '&limit=' . (int)$limitRaw;
    }

    // Salida RSS 2.0 (formato similar a WordPress)
    header('Content-Type: application/rss+xml; charset=utf-8');
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo '<rss version="2.0"'
        . ' xmlns:content="http://purl.org/rss/1.0/modules/content/"'
        . ' xmlns:wfw="http://wellformedweb.org/CommentAPI/"'
        . ' xmlns:dc="http://purl.org/dc/elements/1.1/"'
        . ' xmlns:atom="http://www.w3.org/2005/Atom"'
        . ' xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"'
        . ' xmlns:slash="http://purl.org/rss/1.0/modules/slash/"'
        . '>';
    echo '<channel>';
    echo '<title><![CDATA[' . 'Scrapper - ' . $url . ']]></title>';
    echo '<atom:link href="' . htmlspecialchars($selfUrl, ENT_QUOTES, 'UTF-8') . '" rel="self" type="application/rss+xml" />';
    echo '<link>' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '</link>';
    echo '<description><![CDATA[' . 'Resultados de enlaces internos con contenido limpio' . ']]></description>';
    echo '<lastBuildDate>' . gmdate('r') . '</lastBuildDate>';
    echo '<language>es-ES</language>';
    echo '<sy:updatePeriod>hourly</sy:updatePeriod>';
    echo '<sy:updateFrequency>1</sy:updateFrequency>';
    echo '<generator><![CDATA[Scrapper RSS Generator]]></generator>';

    foreach ($items as $it) {
        echo '<item>';
        echo '<title><![CDATA[' . $it['title'] . ']]></title>';
        echo '<link>' . htmlspecialchars($it['link'], ENT_QUOTES, 'UTF-8') . '</link>';
        echo '<guid isPermaLink="false">' . htmlspecialchars($it['guid'], ENT_QUOTES, 'UTF-8') . '</guid>';
        if ($it['pubDate'] !== '') {
            echo '<pubDate>' . $it['pubDate'] . '</pubDate>';
        }
        echo '<dc:creator><![CDATA[Scrapper]]></dc:creator>';
        echo '<description><![CDATA[' . $it['description'] . ']]></description>';
        echo '<content:encoded><![CDATA[' . $it['content_html'] . ']]></content:encoded>';
        if (!empty($it['categories'])) {
            foreach ($it['categories'] as $cat) {
                echo '<category><![CDATA[' . $cat . ']]></category>';
            }
        }
        echo '</item>';
    }

    echo '</channel></rss>';
}

/**
 * __handle_scrape__
 * Procesa la URL recibida por formulario (POST) y muestra únicamente el listado de enlaces internos.
 */
function handle_scrape(array $config)
{
    $url = isset($_POST['url']) ? trim($_POST['url']) : '';
    $follow = isset($_POST['follow_redirects']);
    $normalize = isset($_POST['normalize_space']);

    view_header();

    if ($url === '' || !filter_var($url, FILTER_VALIDATE_URL)) {
        echo '<div class="alert alert-error">Por favor, ingresa una URL válida.</div>';
        render_form($url);
        view_footer();
        return;
    }

    // Permitir overrides vía GET (útil si usamos el formulario en modo GET)
    $ua = isset($_GET['ua']) ? (string)$_GET['ua'] : $config['user_agent'];
    $ref = isset($_GET['referer']) ? (string)$_GET['referer'] : $config['referer'];
    $to = isset($_GET['timeout']) ? (int)$_GET['timeout'] : (int)$config['timeout'];
    $cto = isset($_GET['connect_timeout']) ? (int)$_GET['connect_timeout'] : (int)$config['connect_timeout'];
    $http = new HttpClient($ua, $ref, $to, $cto);
    // Diagnóstico (solo si APP_DEBUG=true)
    if (!empty($__APP['debug'])) {
        echo '<details open class="card"><summary>Debug: solicitud de scraping (POST)</summary><pre>'
            . esc_html("URL=" . $url . "\nfollow_redirects=" . var_export($follow, true) . "\nnormalize_space=" . var_export($normalize, true)
                . "\nua=" . $ua . "\nreferer=" . $ref . "\ntimeout=" . $to . "\nconnect_timeout=" . $cto . "\n\n_POST=" . var_export($_POST, true) . "\n_GET=" . var_export($_GET, true))
            . '</pre></details>';
    }
    $resp = $http->get($url, ['follow_redirects' => $follow, 'max_redirects' => 5]);

    if ($resp['error']) {
        echo '<div class="alert alert-error"><strong>Error de descarga:</strong> ' . esc_html($resp['error_message']) . '</div>';
        if (!empty($__APP['debug'])) {
            echo '<details class="card"><summary>Debug: respuesta de error</summary><pre>'
                . esc_html(json_encode($resp, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE))
                . '</pre></details>';
        }
        render_form($url);
        view_footer();
        return;
    }

    $extractor = new HtmlExtractor();
    $info = $extractor->extract($resp['body'], $resp['final_url']);
    if ($normalize) {
        $info['paragraphs'] = array_map('normalize_whitespace', $info['paragraphs']);
    }

    // Filtro por path (y mismo host) opcional vía ?path= de GET (por defecto /noticias/)
    $links = $info['links'] ?? [];
    $pathPrefix = isset($_GET['path']) ? (string)$_GET['path'] : '/noticias/';
    $pathPrefix = trim($pathPrefix);
    if ($pathPrefix === '') {
        $pathPrefix = '/noticias/';
    }
    if ($pathPrefix[0] !== '/') {
        $pathPrefix = '/' . $pathPrefix;
    }
    $pathPrefix = preg_replace('#/{2,}#', '/', $pathPrefix);
    $srcHost = parse_url($resp['final_url'], PHP_URL_HOST);
    $links = array_values(array_filter($links, function ($u) use ($srcHost, $pathPrefix) {
        $host = parse_url($u, PHP_URL_HOST);
        if (!$host || strcasecmp($host, $srcHost) !== 0) return false;
        $path = parse_url($u, PHP_URL_PATH) ?: '/';
        $path = preg_replace('#/{2,}#', '/', $path);
        return strpos($path, $pathPrefix) === 0;
    }));

    // Solo listado/tabulado de enlaces internos escaneables, conservando el contexto
    render_links_listing($links, $url);

    view_footer();
}

/**
 * __handle_publish__
 * Publica en WordPress el contenido de la URL asociada a ?u=...
 * - Resuelve el ID a URL con `DataStore`.
 * - Descarga y limpia el HTML con `HtmlExtractor`.
 * - Extrae título, contenido HTML, tags (como etiquetas WP) e intenta detectar una imagen para destacada.
 * - Usa `WpPublisher` (módulo propio) con credenciales desde config.php.
 */
function handle_publish(array $config)
{
    // Siempre renderizar HTML para evitar páginas en blanco y facilitar diagnóstico
    view_header();

    $token = $_GET['u'] ?? '';
    if (!is_md5_id($token)) {
        echo '<div class="alert alert-error">Parámetro <code>u</code> inválido.</div>';
        view_footer();
        return;
    }

    // Resolver URL desde datastore
    $store = new DataStore(__DIR__);
    $url = $store->getUrl($token);
    if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
        echo '<div class="alert alert-error">No se encontró la URL asociada al identificador.</div>';
        view_footer();
        return;
    }

    // Descargar y extraer
    $http = new HttpClient($config['user_agent'], $config['referer'], (int)$config['timeout'], (int)$config['connect_timeout']);
    $resp = $http->get($url, ['follow_redirects' => true, 'max_redirects' => 5]);
    if ($resp['error']) {
        echo '<div class="alert alert-error"><strong>Error de descarga:</strong> ' . esc_html($resp['error_message']) . '</div>';
        view_footer();
        return;
    }
    // Aplicar preset por dominio si existe
    global $__PRESETS;
    $extractor = new HtmlExtractor();
    $preset = null;
    $h = parse_url($resp['final_url'], PHP_URL_HOST);
    if ($h && isset($__PRESETS[$h])) {
        $preset = $__PRESETS[$h];
    }
    $clean = $extractor->cleanView($resp['body'], $resp['final_url'], $preset);
    $title = $clean['title'] ?: $resp['final_url'];
    $contentHtml = $clean['content_html'];
    $tags = $extractor->extractTagsFromHtml($contentHtml, 12);

    // Imagen destacada: preferir la detectada por el preset/cleanView; si no, buscar primera <img> del contenido limpio
    $featured = $clean['featured'] ?? null;
    if (!$featured) {
        if (preg_match('/<img[^>]+src\s*=\s*"([^"]+)"/i', $contentHtml, $m)) {
            $featured = $m[1];
            if (!filter_var($featured, FILTER_VALIDATE_URL)) {
                $featured = null;
            }
        }
    }

    // Si Gemini está habilitado, solicitar enriquecimiento del artículo y sobreescribir
    global $__GEMINI;
    $useGemini = !empty($__GEMINI['enabled']) && is_string($__GEMINI['api_key']) && $__GEMINI['api_key'] !== '';
    if ($useGemini) {
        $debugAi = isset($_GET['debug_ai']) && $_GET['debug_ai'] !== '0';
        if ($debugAi) {
            echo '<details class="card" open><summary>Gemini: análisis de contenido</summary>';
        }
        $gclient = new GeminiClient($__GEMINI['api_key'], (string)($__GEMINI['model'] ?? 'gemini-1.5-flash'), (string)($__GEMINI['endpoint_base'] ?? 'https://generativelanguage.googleapis.com/v1beta/models'), $http);
        $gres = $gclient->analyzeArticle($resp['body'], $resp['final_url']);
        if ($gres['error']) {
            if ($debugAi) {
                echo '<div class="alert alert-error">Gemini error: ' . esc_html($gres['error_message']) . '</div>';
            }
        } else {
            $gd = $gres['data'];
            if (is_array($gd)) {
                // Título
                if (!empty($gd['title'])) {
                    $title = (string)$gd['title'];
                }
                // Contenido HTML
                if (!empty($gd['content_html'])) {
                    $contentHtml = (string)$gd['content_html'];
                }
                // Imagen destacada
                if (isset($gd['featured_image']) && is_string($gd['featured_image']) && filter_var($gd['featured_image'], FILTER_VALIDATE_URL)) {
                    $featured = $gd['featured_image'];
                }
                // Tags: usar los de Gemini si viene arreglo válido
                if (isset($gd['tags']) && is_array($gd['tags'])) {
                    $tags = array_values(array_filter(array_map('strval', $gd['tags'])));
                }
                // Categoría: si viene, añadirla como categoría preferente (usada como categories en payload)
                $geminiCategory = null;
                if (isset($gd['category']) && is_string($gd['category']) && $gd['category'] !== '') {
                    $geminiCategory = $gd['category'];
                }
                if ($debugAi) {
                    echo '<pre style="white-space:pre-wrap">' . esc_html(json_encode($gd, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) . '</pre>';
                }
            }
        }
        if ($debugAi) {
            echo '</details>';
        }
    }

    // Si el usuario pide diagnóstico IA y hay respuesta válida de Gemini, mostramos SOLO el panel IA
    $aiOnly = isset($_GET['debug_ai']) && $_GET['debug_ai'] !== '0' && $geminiOk;

    // Cargar configuración (WordPress y plugin Scrapper)
    global $__WP, $__APP, $__SCRPR_PLUGIN;
    $WP_BASE_URL = $__WP['base_url'] ?? '';
    $WP_USER = $__WP['user'] ?? '';
    $WP_APP_PASS = $__WP['app_password'] ?? '';
    $WP_VERIFY_SSL = (bool)($__WP['verify_ssl'] ?? true);
    $PL_ENABLED = !empty($__SCRPR_PLUGIN['enabled']);
    $PL_TOKEN = (string)($__SCRPR_PLUGIN['token'] ?? '');

    // Bloque diagnóstico: parámetros de publicación
    echo '<div class="card">';
    echo '<h2>Publicación en WordPress</h2>';
    echo '<ul class="muted" style="font-size:13px">'
        . '<li><strong>WP_BASE_URL:</strong> ' . esc_html($WP_BASE_URL ?: '(no definido)') . '</li>'
        . '<li><strong>WP_USER:</strong> ' . esc_html($WP_USER !== '' ? preg_replace('/^(.).*(.)$/', '$1***$2', $WP_USER) : '(no definido)') . '</li>'
        . '<li><strong>SSL verificación:</strong> ' . ($WP_VERIFY_SSL ? 'sí' : 'no') . '</li>'
        . '<li><strong>Plugin Scrapper:</strong> ' . ($PL_ENABLED ? 'habilitado' : 'deshabilitado') . '</li>'
        . '<li><strong>Token presente:</strong> ' . ($PL_TOKEN !== '' ? 'sí' : 'no') . '</li>'
        . '<li><strong>URL fuente:</strong> <a href="' . esc_attr($resp['final_url']) . '" target="_blank" rel="noopener">' . esc_html($resp['final_url']) . '</a></li>'
        . '<li><strong>Longitud contenido HTML:</strong> ' . strlen($contentHtml) . ' bytes</li>'
        . '<li><strong>Imagen destacada detectada:</strong> ' . esc_html($featured ?: 'N/D') . '</li>'
        . '</ul>';
    // Botón para probar credenciales (sin publicar aún)
    $testLink = 'publish.php?u=' . esc_attr($token) . '&test_creds=1';
    if (isset($_GET['r']) && is_string($_GET['r']) && $_GET['r'] !== '' && filter_var($_GET['r'], FILTER_VALIDATE_URL)) {
        $testLink .= '&r=' . rawurlencode($_GET['r']);
    }
    if (isset($_GET['debug_ai']) && $_GET['debug_ai'] !== '0') {
        $testLink .= '&debug_ai=1';
    }
    echo '<p><a href="' . $testLink . '" class="btn" style="display:inline-block; background:#0ea5e9; color:#0b0e13; padding:8px 12px; border-radius:6px; text-decoration:none; font-weight:600">Probar credenciales</a></p>';

    if ($WP_BASE_URL === '') {
        echo '<div class="alert alert-error">Configura WordPress en <code>scrapper/config.php</code> (base_url).</div>';
        if (!empty($__APP['debug'])) {
            echo '<details open class="card"><summary>Diagnóstico config.php</summary><pre>'
                . esc_html(
                    'WP base_url=' . var_export($WP_BASE_URL, true) . "\n"
                    . 'WP verify_ssl=' . var_export($WP_VERIFY_SSL, true)
                )
                . '</pre></details>';
        }
        echo '<p><a href="./">← Volver</a></p></div>';
        view_footer();
        return;
    }

    // Si el plugin Scrapper está habilitado y hay token, publicar vía su endpoint
    if ($PL_ENABLED && $PL_TOKEN !== '') {
        $endpoint = rtrim($WP_BASE_URL, '/') . '/wp-json/scrapper/v1/posts';
        // Construir categorías: si Gemini devolvió una categoría, la priorizamos
        $categories = array_values(array_unique(array_filter(array_map('strval', $tags))));
        if (isset($geminiCategory) && is_string($geminiCategory) && $geminiCategory !== '') {
            array_unshift($categories, $geminiCategory);
            $categories = array_values(array_unique($categories));
        }

        $payload = [
            // Título del post
            'title' => (string)$title,
            // Contenido HTML tal cual lo extrajimos/limpiamos
            'content' => (string)$contentHtml,
            // Imagen destacada (URL absoluta) si se detectó
            'featured_image' => $featured ?: null,
            // Usamos las etiquetas extraídas como categorías por simplicidad
            'categories' => $categories,
            // Estado del post
            'status' => 'publish',
        ];

        // Enviar POST JSON con header de autenticación del plugin
        $respPub = $http->postJson($endpoint, $payload, ['X-Scrapper-Token' => $PL_TOKEN]);

        // Mostrar resultado
        if ($respPub['status'] >= 200 && $respPub['status'] < 300 && empty($respPub['error'])) {
            echo '<p style="color:#22c55e"><strong>✔ Publicado correctamente (Plugin Scrapper)</strong></p>';
        } else {
            echo '<p style="color:#ef4444"><strong>✖ Error al publicar (Plugin Scrapper)</strong></p>';
        }

        echo '<details open class="card"><summary>Respuesta Plugin (status: ' . (int)$respPub['status'] . ')</summary><pre>'
            . htmlspecialchars(json_encode($respPub['json'] ?? $respPub, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8')
            . '</pre></details>';
        if (!empty($respPub['error'])) {
            echo '<div class="alert alert-error"><strong>cURL:</strong> ' . esc_html($respPub['error']) . '</div>';
        }
        if (!empty($respPub['headers'])) {
            echo '<details class="card"><summary>Cabeceras de respuesta</summary><pre>'
                . esc_html($respPub['headers'])
                . '</pre></details>';
        }

        // Enlace de retorno
        $back = './';
        if (isset($_GET['r']) && is_string($_GET['r']) && $_GET['r'] !== '' && filter_var($_GET['r'], FILTER_VALIDATE_URL)) {
            $back = './?url=' . rawurlencode($_GET['r']);
        }
        if (isset($_GET['debug_ai']) && $_GET['debug_ai'] !== '0') {
            $back .= (strpos($back, '?') === false ? '?' : '&') . 'debug_ai=1';
        }
        echo '<p><a href="' . $back . '">← Volver</a></p>';
        echo '</div>';
        view_footer();
        return;
    }

    // Fallback: usar WpPublisher (Application Passwords)
    require_once __DIR__ . '/modules/wordpress/WpPublisher.php';
    $pub = new WpPublisher($WP_BASE_URL, $WP_USER, $WP_APP_PASS, $WP_VERIFY_SSL);

    // Si solo queremos probar credenciales (?test_creds=1) mostramos el resultado y salimos sin publicar
    if (isset($_GET['test_creds'])) {
        $me = $pub->getMe();
        echo '<details open class="card"><summary>Resultado de /wp/v2/users/me (status: ' . (int)$me['status'] . ')</summary><pre>'
            . htmlspecialchars(json_encode($me['json'] ?? $me, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8')
            . '</pre></details>';
        if (!empty($me['error'])) {
            echo '<div class="alert alert-error"><strong>cURL:</strong> ' . esc_html($me['error']) . '</div>';
        }
        if (!empty($me['headers'])) {
            echo '<details class="card"><summary>Cabeceras</summary><pre>'
                . esc_html(json_encode($me['headers'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE))
                . '</pre></details>';
        }
        $back = 'publish.php?u=' . esc_attr($token);
        if (isset($_GET['r']) && is_string($_GET['r']) && $_GET['r'] !== '' && filter_var($_GET['r'], FILTER_VALIDATE_URL)) {
            $back .= '&r=' . rawurlencode($_GET['r']);
        }
        if (isset($_GET['debug_ai']) && $_GET['debug_ai'] !== '0') {
            $back .= '&debug_ai=1';
        }
        echo '<p><a href="' . $back . '">← Volver</a></p>';
        echo '</div>';
        view_footer();
        return;
    }

    // Publicar
    $respPub = $pub->publishPost($title, $contentHtml, /*categorías*/ [], /*tags*/ $tags, $featured, 'publish');

    // Resultado
    if ($respPub['status'] >= 200 && $respPub['status'] < 300 && empty($respPub['error'])) {
        echo '<p style="color:#22c55e"><strong>✔ Publicado correctamente</strong></p>';
    } else {
        echo '<p style="color:#ef4444"><strong>✖ Error al publicar</strong></p>';
    }

    // Detalles de respuesta y payload (útil para debug)
    echo '<details open class="card"><summary>Respuesta WP (status: ' . (int)$respPub['status'] . ')</summary><pre>'
        . htmlspecialchars(json_encode($respPub['json'] ?? $respPub, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8')
        . '</pre></details>';
    if (!empty($respPub['error'])) {
        echo '<div class="alert alert-error"><strong>cURL:</strong> ' . esc_html($respPub['error']) . '</div>';
    }
    if (!empty($respPub['headers'])) {
        echo '<details class="card"><summary>Cabeceras de respuesta</summary><pre>'
            . esc_html(json_encode($respPub['headers'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE))
            . '</pre></details>';
    }
    if (!isset($respPub['json']) && !empty($respPub['body'])) {
        echo '<details class="card"><summary>Cuerpo (texto)</summary><pre>'
            . esc_html($respPub['body'])
            . '</pre></details>';
    }

    // Enlace de retorno
    $back = './';
    if (isset($_GET['r']) && is_string($_GET['r']) && $_GET['r'] !== '' && filter_var($_GET['r'], FILTER_VALIDATE_URL)) {
        $back = './?url=' . rawurlencode($_GET['r']);
    }
    if (isset($_GET['debug_ai']) && $_GET['debug_ai'] !== '0') {
        $back .= (strpos($back, '?') === false ? '?' : '&') . 'debug_ai=1';
    }
    echo '<p><a href="' . $back . '">← Volver</a></p>';
    echo '</div>';
    view_footer();
}

/**
 * __render_links_listing__
 * Muestra únicamente un listado/tabulado de enlaces escaneables internos con conteo total.
 */
function render_links_listing(array $links, $sourceUrl = '')
{
    $count = count($links);
    echo '<div class="results">';
    echo '<h2>Enlaces encontrados: ' . (int)$count . '</h2>';
    if ($count === 0) {
        echo '<p class="muted">No se detectaron enlaces en la página.</p>';
        echo '</div>';
        return;
    }
    echo '<table class="panel" style="width:100%; border-collapse:collapse">';
    echo '<thead><tr>'
        . '<th style="text-align:left; padding:8px; border-bottom:1px solid #444">#</th>'
        . '<th style="text-align:left; padding:8px; border-bottom:1px solid #444">Enlace interno</th>'
        . '<th style="text-align:left; padding:8px; border-bottom:1px solid #444">Acciones</th>'
        . '<th style="text-align:left; padding:8px; border-bottom:1px solid #444">URL</th>'
        . '</tr></thead><tbody>';
    $i = 1;
    foreach ($links as $lnk) {
        $internal = render_internal_link($lnk, $sourceUrl);
        // Generar ID (u=...) para accionar publicación directa
        $canon = normalize_url_canonical($lnk);
        $id = md5($canon);
        $pub = 'publish.php?u=' . esc_attr($id);
        if (is_string($sourceUrl) && $sourceUrl !== '' && filter_var($sourceUrl, FILTER_VALIDATE_URL)) {
            $pub .= '&r=' . rawurlencode($sourceUrl);
        }
        if (isset($_GET['debug_ai']) && $_GET['debug_ai'] !== '0') {
            $pub .= '&debug_ai=1';
        }
        echo '<tr>'
            . '<td style="padding:8px; border-bottom:1px solid #333">' . $i++ . '</td>'
            . '<td style="padding:8px; border-bottom:1px solid #333">'
            . '<a href="' . esc_attr($internal) . '">Ver interno</a>'
            . '</td>'
            . '<td style="padding:8px; border-bottom:1px solid #333">'
            . '<a href="' . $pub . '" style="color:#22c55e">Publicar en WP</a>'
            . ' | <a href="publish_blogger.php?u=' . esc_attr($id) . '&r=' . rawurlencode($sourceUrl) . '" style="color:#ff9900">Publicar en Blogger</a>'
            . '</td>'
            . '<td style="padding:8px; border-bottom:1px solid #333; font-size:12px" class="muted">' . esc_html($lnk) . '</td>'
            . '</tr>';
    }
    echo '</tbody></table>';
    echo '</div>';
}

/**
 * __handle_scrape_direct__
 * Ejecuta el scraping directamente cuando se recibe ?url=... por GET/HEAD.
 * No muestra formulario, solo resultados.
 */
function handle_scrape_direct(array $config, $incomingUrl)
{
    $url = trim($incomingUrl ?? '');
    // Flags desde GET con defaults (compatibilidad)
    $follow = isset($_GET['follow_redirects']);     // por defecto true si el checkbox está presente
    if (!isset($_GET['follow_redirects'])) {
        $follow = true;
    }
    $normalize = isset($_GET['normalize_space']);   // por defecto true si el checkbox está presente
    if (!isset($_GET['normalize_space'])) {
        $normalize = true;
    }

    view_header();

    // Validación
    if ($url === '' || !filter_var($url, FILTER_VALIDATE_URL)) {
        echo '<div class="alert alert-error">URL inválida.</div>';
        view_footer();
        return;
    }

    // Descarga (con overrides desde GET)
    $ua = isset($_GET['ua']) ? (string)$_GET['ua'] : $config['user_agent'];
    $ref = isset($_GET['referer']) ? (string)$_GET['referer'] : $config['referer'];
    $to = isset($_GET['timeout']) ? (int)$_GET['timeout'] : (int)$config['timeout'];
    $cto = isset($_GET['connect_timeout']) ? (int)$_GET['connect_timeout'] : (int)$config['connect_timeout'];
    $http = new HttpClient($ua, $ref, $to, $cto);
    // Diagnóstico (solo si APP_DEBUG=true)
    if (!empty($__APP['debug'])) {
        echo '<details open class="card"><summary>Debug: solicitud de scraping (GET directo)</summary><pre>'
            . esc_html("URL=" . $url . "\nfollow_redirects=" . var_export($follow, true) . "\nnormalize_space=" . var_export($normalize, true)
                . "\nua=" . $ua . "\nreferer=" . $ref . "\ntimeout=" . $to . "\nconnect_timeout=" . $cto . "\n\n_GET=" . var_export($_GET, true))
            . '</pre></details>';
    }
    $resp = $http->get($url, ['follow_redirects' => $follow, 'max_redirects' => 5]);

    if ($resp['error']) {
        echo '<div class="alert alert-error"><strong>Error de descarga:</strong> ' . esc_html($resp['error_message']) . '</div>';
        if (!empty($__APP['debug'])) {
            echo '<details class="card"><summary>Debug: respuesta de error</summary><pre>'
                . esc_html(json_encode($resp, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE))
                . '</pre></details>';
        }
        view_footer();
        return;
    }

    // Extracción
    $extractor = new HtmlExtractor();
    $info = $extractor->extract($resp['body'], $resp['final_url']);
    if ($normalize) {
        $info['paragraphs'] = array_map('normalize_whitespace', $info['paragraphs']);
    }

    // Filtro por path (y mismo host) opcional vía ?path= (por defecto /noticias/)
    $links = $info['links'] ?? [];
    $pathPrefix = isset($_GET['path']) ? (string)$_GET['path'] : '/noticias/';
    $pathPrefix = trim($pathPrefix);
    if ($pathPrefix === '') {
        $pathPrefix = '/noticias/';
    }
    if ($pathPrefix[0] !== '/') {
        $pathPrefix = '/' . $pathPrefix;
    }
    $pathPrefix = preg_replace('#/{2,}#', '/', $pathPrefix);
    $srcHost = parse_url($resp['final_url'], PHP_URL_HOST);
    $links = array_values(array_filter($links, function ($u) use ($srcHost, $pathPrefix) {
        $host = parse_url($u, PHP_URL_HOST);
        if (!$host || strcasecmp($host, $srcHost) !== 0) return false;
        $path = parse_url($u, PHP_URL_PATH) ?: '/';
        $path = preg_replace('#/{2,}#', '/', $path);
        return strpos($path, $pathPrefix) === 0;
    }));

    // Render: solo tabla/listado de enlaces internos escaneables, conservando contexto de retorno
    render_links_listing($links, $url);
    view_footer();
}

function view_footer()
{
    echo '</div></body></html>';
}

/**
 * __render_internal_link__
 * Genera un enlace interno seguro a la vista limpia usando un ID MD5 estable.
 * Permite incluir un contexto de retorno (URL de origen) para volver al listado.
 * @param string $url URL destino a ver internamente
 * @param string $sourceUrl URL origen que generó el listado (para volver)
 */
function render_internal_link($url, $sourceUrl = '')
{
    // Normaliza URL y genera ID estable MD5. Guarda el mapeo en datastore.
    $canon = normalize_url_canonical($url);
    $id = md5($canon);
    static $store = null;
    if ($store === null) {
        $store = new DataStore(__DIR__);
    }
    $store->setUrl($id, $canon);

    $q = 'u=' . $id;
    if (is_string($sourceUrl) && $sourceUrl !== '' && filter_var($sourceUrl, FILTER_VALIDATE_URL)) {
        $q .= '&r=' . rawurlencode($sourceUrl);
    }
    // Propagar flag global de diagnóstico IA si viene activo en la página principal
    if (isset($_GET['debug_ai']) && $_GET['debug_ai'] !== '0') {
        $q .= '&debug_ai=1';
    }
    return 'beaver.php?' . $q;
}

/**
 * __render_form__
 * Muestra un formulario para ingresar una URL y opciones simples.
 */
function render_form($url = '')
{
    // Usar configuración global para prefills (sin .env)
    global $CONFIG, $__APP;
    // Valores actuales desde GET para prellenar
    $g = $_GET;
    $v_url = htmlspecialchars(($g['url'] ?? $url ?? ''), ENT_QUOTES, 'UTF-8');
    $v_path = htmlspecialchars(($g['path'] ?? '/noticias/'), ENT_QUOTES, 'UTF-8');
    $v_rss = isset($g['rss']) && $g['rss'] !== '0';
    $v_limit = isset($g['limit']) ? (int)$g['limit'] : 20;
    $v_debugai = isset($g['debug_ai']) && $g['debug_ai'] !== '0';
    $v_ua = htmlspecialchars(($g['ua'] ?? ($CONFIG['user_agent'] ?? 'Mozilla/5.0')), ENT_QUOTES, 'UTF-8');
    $v_ref = htmlspecialchars(($g['referer'] ?? ($CONFIG['referer'] ?? 'http://www.bing.com/')), ENT_QUOTES, 'UTF-8');
    $v_to = isset($g['timeout']) ? (int)$g['timeout'] : (int)($CONFIG['timeout'] ?? 25);
    $v_cto = isset($g['connect_timeout']) ? (int)$g['connect_timeout'] : (int)($CONFIG['connect_timeout'] ?? 10);
    $v_follow = isset($g['follow_redirects']);
    $v_norm = isset($g['normalize_space']);

    echo '<h1>Scrapper</h1>';
    echo '<p class="muted">Basado en los patrones del plugin de <code>plugin/</code> pero implementado de forma independiente.</p>';
    // Usamos GET para que el enrutado caiga en handle_scrape_direct (?url=...)
    echo '<form method="get" class="card">'
        . '<label for="url">URL a scrapear</label>'
        . '<input type="url" id="url" name="url" placeholder="https://ejemplo.com" required value="' . $v_url . '">'
        . '<div class="row">'
        . '  <label><input type="checkbox" name="follow_redirects" value="1"' . ($v_follow ? ' checked' : '') . '> Seguir redirecciones</label>'
        . '  <label><input type="checkbox" name="normalize_space" value="1"' . ($v_norm ? ' checked' : '') . '> Normalizar espacios</label>'
        . '</div>'
        . '<div class="row">'
        . '  <label for="path">Prefijo de path (filtro enlaces internos)</label>'
        . '  <input type="text" id="path" name="path" placeholder="/noticias/" value="' . $v_path . '" style="max-width:260px">'
        . '</div>'
        . '<div class="row">'
        . '  <label><input type="checkbox" name="rss" value="1"' . ($v_rss ? ' checked' : '') . '> Generar RSS</label>'
        . '  <label for="limit">Límite (RSS)</label>'
        . '  <input type="number" id="limit" name="limit" min="1" max="100" value="' . (int)$v_limit . '" style="width:90px">'
        . '</div>'
        . '<div class="row">'
        . '  <label><input type="checkbox" name="debug_ai" value="1"' . ($v_debugai ? ' checked' : '') . '> Diagnóstico IA (mostrar JSON de Gemini)</label>'
        . '</div>'
        . '<details class="card"><summary>Avanzado (UA, Referer, Timeouts)</summary>'
        . '  <div class="row">'
        . '    <label for="ua">User-Agent</label>'
        . '    <input type="text" id="ua" name="ua" value="' . $v_ua . '" placeholder="Mozilla/5.0" style="width:100%">'
        . '  </div>'
        . '  <div class="row">'
        . '    <label for="referer">Referer</label>'
        . '    <input type="url" id="referer" name="referer" value="' . $v_ref . '" placeholder="http://www.bing.com/" style="width:100%">'
        . '  </div>'
        . '  <div class="row">'
        . '    <label for="timeout">Timeout (s)</label>'
        . '    <input type="number" id="timeout" name="timeout" min="1" max="120" value="' . (int)$v_to . '" style="width:120px">'
        . '    <label for="connect_timeout" style="margin-left:16px">Connect Timeout (s)</label>'
        . '    <input type="number" id="connect_timeout" name="connect_timeout" min="1" max="60" value="' . (int)$v_cto . '" style="width:120px">'
        . '  </div>'
        . '</details>'
        . '<button type="submit">Scrapear</button>'
        . '</form>';
}

/**
 * __handle_view__
 * Vista interna: recibe ?u= (base64 de URL), descarga y muestra versión limpia.
 */
function handle_view(array $config)
{
    $token = $_GET['u'] ?? '';
    $raw = '';

    // Resolver MD5 -> URL canónica o compatibilidad base64
    if (is_md5_id($token)) {
        $store = new DataStore(__DIR__);
        $raw = $store->getUrl($token);
    } else {
        $raw = base64_decode($token, true);
    }

    view_header();

    // Enlace de retorno: si viene r (URL origen), regresa al listado con ?url=...
    $ret = isset($_GET['r']) ? $_GET['r'] : '';
    if (is_string($ret) && $ret !== '' && filter_var($ret, FILTER_VALIDATE_URL)) {
        $back = './?url=' . esc_attr($ret);
    } else {
        $back = './';
    }
    if (isset($_GET['debug_ai']) && $_GET['debug_ai'] !== '0') {
        $back .= (strpos($back, '?') === false ? '?' : '&') . 'debug_ai=1';
    }
    echo '<p class="muted"><a href="' . $back . '">← Volver</a></p>';

    if (!$raw || !filter_var($raw, FILTER_VALIDATE_URL)) {
        echo '<div class="alert alert-error">Parámetro de enlace inválido.</div>';
        view_footer();
        return;
    }

    $http = new HttpClient($config['user_agent'], $config['referer'], (int)$config['timeout'], (int)$config['connect_timeout']);
    $resp = $http->get($raw, ['follow_redirects' => true, 'max_redirects' => 5]);

    if ($resp['error']) {
        echo '<div class="alert alert-error"><strong>Error de descarga:</strong> ' . esc_html($resp['error_message']) . '</div>';
        view_footer();
        return;
    }

    $extractor = new HtmlExtractor();
    $clean = $extractor->cleanView($resp['body'], $resp['final_url']);

    // Variables base desde extractor local (fallback)
    $title = $clean['title'] ?: $resp['final_url'];
    $contentHtml = $clean['content_html'];
    // Imagen destacada si viene en cleanView; si no, primera <img> válida del contenido limpio
    $featured = $clean['featured'] ?? null;
    if (!$featured) {
        if (preg_match('/<img[^>]+src\s*=\s*"([^"]+)"/i', $contentHtml, $m)) {
            $featured = $m[1];
            if (!filter_var($featured, FILTER_VALIDATE_URL)) {
                $featured = null;
            }
        }
    }
    $tags = $extractor->extractTagsFromHtml($contentHtml, 15);

    // Si Gemini está habilitado, solicitar la versión organizada para visualizarla como principal
    global $__GEMINI;
    $useGemini = !empty($__GEMINI['enabled']) && is_string($__GEMINI['api_key']) && $__GEMINI['api_key'] !== '';
    $geminiOk = false; // Indica si hubo respuesta válida de Gemini
    if ($useGemini) {
        $gclient = new GeminiClient($__GEMINI['api_key'], (string)($__GEMINI['model'] ?? 'gemini-1.5-flash'), (string)($__GEMINI['endpoint_base'] ?? 'https://generativelanguage.googleapis.com/v1beta/models'), $http);
        $gres = $gclient->analyzeArticle($resp['body'], $resp['final_url']);
        $debugAi = isset($_GET['debug_ai']) && $_GET['debug_ai'] !== '0';
        if ($debugAi) {
            echo '<details class="card" open><summary>Gemini: análisis (vista)</summary>';
        }
        if ($gres['error']) {
            if ($debugAi) {
                echo '<div class="alert alert-error">Gemini error: ' . esc_html($gres['error_message']) . '</div>';
            }
        } else {
            $gd = $gres['data'];
            if (is_array($gd)) {
                $geminiOk = true;
                if (!empty($gd['title'])) {
                    $title = (string)$gd['title'];
                }
                if (!empty($gd['content_html'])) {
                    $contentHtml = (string)$gd['content_html'];
                }
                if (isset($gd['featured_image']) && is_string($gd['featured_image']) && filter_var($gd['featured_image'], FILTER_VALIDATE_URL)) {
                    $featured = $gd['featured_image'];
                }
                if (isset($gd['tags']) && is_array($gd['tags'])) {
                    $tags = array_values(array_filter(array_map('strval', $gd['tags'])));
                }
                // Panel visual del diagnóstico IA
                if ($debugAi) {
                    echo '<div class="card" style="border:1px solid #333; padding:12px; border-radius:8px; margin:10px 0">';
                    echo '<h3 style="margin:0 0 8px 0">Diagnóstico IA (Gemini)</h3>';
                    // Fila: Título y Categoría
                    echo '<div class="row" style="display:flex; gap:16px; flex-wrap:wrap">';
                    if (!empty($gd['title'])) {
                        echo '<div style="flex:1 1 280px"><strong>Título:</strong> ' . esc_html((string)$gd['title']) . '</div>';
                    }
                    if (!empty($gd['category'])) {
                        echo '<div style="flex:1 1 160px"><strong>Categoría:</strong> ' . esc_html((string)$gd['category']) . '</div>';
                    }
                    echo '</div>';
                    // Imagen destacada
                    if (!empty($gd['featured_image']) && is_string($gd['featured_image']) && filter_var($gd['featured_image'], FILTER_VALIDATE_URL)) {
                        $fi = (string)$gd['featured_image'];
                        echo '<div style="margin:8px 0"><strong>Imagen destacada:</strong><br>'
                            . '<img src="' . esc_attr($fi) . '" alt="featured" style="max-width:360px; width:100%; height:auto; border:1px solid #333; border-radius:6px"></div>';
                    }
                    // Tags
                    if (!empty($gd['tags']) && is_array($gd['tags'])) {
                        echo '<div style="margin:6px 0"><strong>Tags:</strong> ';
                        foreach ($gd['tags'] as $tg) {
                            $tg = (string)$tg;
                            if ($tg === '') continue;
                            echo '<span style="display:inline-block; background:#222; color:#bbb; border:1px solid #444; padding:2px 6px; margin:2px; border-radius:4px; font-size:12px">' . esc_html($tg) . '</span>';
                        }
                        echo '</div>';
                    }
                    // Listas opcionales: outline / key_points / sections
                    $lists = [];
                    if (!empty($gd['outline']) && is_array($gd['outline'])) {
                        $lists['Esquema'] = $gd['outline'];
                    }
                    if (!empty($gd['key_points']) && is_array($gd['key_points'])) {
                        $lists['Puntos clave'] = $gd['key_points'];
                    }
                    if (!empty($gd['sections']) && is_array($gd['sections'])) {
                        $lists['Secciones'] = $gd['sections'];
                    }
                    foreach ($lists as $label => $arr) {
                        echo '<details style="margin:6px 0"><summary>' . esc_html($label) . '</summary>';
                        echo '<ul style="margin:6px 0 0 16px">';
                        $i = 0;
                        foreach ($arr as $item) {
                            if ($i++ > 50) {
                                echo '<li class="muted">…</li>';
                                break;
                            }
                            if (is_array($item)) {
                                $txt = isset($item['title']) ? (string)$item['title'] : json_encode($item);
                            } else {
                                $txt = (string)$item;
                            }
                            echo '<li>' . esc_html($txt) . '</li>';
                        }
                        echo '</ul></details>';
                    }
                    echo '</div>';
                }
                if ($debugAi) {
                    echo '<pre style="white-space:pre-wrap">' . esc_html(json_encode($gd, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) . '</pre>';
                }
            }
        }
        if ($debugAi) {
            echo '</details>';
        }
    }

    // Determinar modo de visualización (solo IA si debug_ai=1 y Gemini respondió bien)
    $aiOnly = (isset($_GET['debug_ai']) && $_GET['debug_ai'] !== '0' && $geminiOk);

    // Botón de publicación directa a WordPress (disponible en ambos modos)
    $idForPublish = md5(normalize_url_canonical($resp['final_url']));
    $pubLink = 'publish.php?u=' . esc_attr($idForPublish);
    if (isset($_GET['r']) && is_string($_GET['r']) && $_GET['r'] !== '' && filter_var($_GET['r'], FILTER_VALIDATE_URL)) {
        $pubLink .= '&r=' . rawurlencode($_GET['r']);
    }
    if (isset($_GET['debug_ai']) && $_GET['debug_ai'] !== '0') {
        $pubLink .= '&debug_ai=1';
    }

    if (!$aiOnly) {
        echo '<div class="card">';
        echo '<h2>' . esc_html($title ?: 'Vista limpia') . '</h2>';
        echo '<p class="muted" style="margin-top:-6px">Fuente: <a href="' . esc_attr($resp['final_url']) . '" target="_blank" rel="noopener noreferrer">' . esc_html($resp['final_url']) . '</a></p>';
        // Si hay imagen destacada, la mostramos antes del contenido
        if (is_string($featured) && $featured !== '') {
            echo '<p><img src="' . esc_attr($featured) . '" alt="" style="max-width:100%; height:auto; border:1px solid #333; border-radius:6px"></p>';
        }
        echo '<p><a href="' . $pubLink . '" class="btn" style="display:inline-block; background:#22c55e; color:#0b0e13; padding:8px 12px; border-radius:6px; text-decoration:none; font-weight:600">Publicar en WP</a></p>';
        echo '<div class="clean">' . $contentHtml . '</div>';
    } else {
        // Modo solo IA: mostrar botón Publicar y el contenido enriquecido por Gemini únicamente
        echo '<p><a href="' . $pubLink . '" class="btn" style="display:inline-block; background:#22c55e; color:#0b0e13; padding:8px 12px; border-radius:6px; text-decoration:none; font-weight:600">Publicar en WP</a></p>';
        echo '<div class="card">';
        echo '<h2>' . esc_html($title ?: 'Contenido (IA)') . '</h2>';
        echo '<div class="clean">' . $contentHtml . '</div>';
        echo '</div>';
    }

    if (!$aiOnly) {
        // Pie con cita de fuente, fecha de publicación y tags (solo en modo normal)
        $pubDate = $extractor->extractPublishedDate($resp['body']);
        echo '<hr style="border:none; border-top:1px solid #333; margin:16px 0">';
        echo '<div class="meta-bottom">';
        echo '<p><strong>Fuente:</strong> <a href="' . esc_attr($resp['final_url']) . '" target="_blank" rel="noopener noreferrer">' . esc_html($resp['final_url']) . '</a></p>';
        echo '<p><strong>Fecha de publicación:</strong> ' . ($pubDate !== '' ? esc_html($pubDate) : '<span class="muted">N/D</span>') . '</p>';
        echo '<div><strong>Tags:</strong> ';
        if (!empty($tags)) {
            foreach ($tags as $tg) {
                echo '<span style="display:inline-block; background:#222; color:#bbb; border:1px solid #444; padding:2px 6px; margin:2px; border-radius:4px; font-size:12px">' . esc_html($tg) . '</span>';
            }
        } else {
            echo '<span class="muted" style="font-size:12px">No se detectaron tags relevantes.</span>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    view_footer();
}

// Routing mínimo (solo cuando este archivo es ejecutado directamente)
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    if (isset($_GET['url'])) {
        // Soporte RSS: si viene ?rss=1 devolvemos feed RSS; si no, flujo HTML normal
        if (isset($_GET['rss']) && $_GET['rss'] !== '' && $_GET['rss'] !== '0') {
            handle_scrape_rss($CONFIG, $_GET['url']);
        } else {
            // Permitir GET/HEAD con ?url=
            handle_scrape_direct($CONFIG, $_GET['url']);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        handle_scrape($CONFIG);
    } else {
        view_header();
        render_form();
        view_footer();
    }
}

?>