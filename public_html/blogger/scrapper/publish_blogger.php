<?php
session_start();

// Cargar configuración y clases necesarias
$__APP_CFG = require __DIR__ . '/config.php';
require_once __DIR__ . '/inc/helpers.php';
require_once __DIR__ . '/inc/HttpClient.php';
require_once __DIR__ . '/inc/HtmlExtractor.php';
require_once __DIR__ . '/inc/DataStore.php';
require_once __DIR__ . '/inc/BloggerPublisher.php';

// Configuración de la aplicación
$__APP = $__APP_CFG['app'] ?? ['debug' => false];
$__BLOGGER = $__APP_CFG['blogger'] ?? [];

// Control de errores
if (!empty($__APP['debug'])) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Vista simple para la salida
function view_header($title = 'Publicar en Blogger')
{
    echo '<!doctype html><html lang="es"><head><meta charset="utf-8">'
        . '<meta name="viewport" content="width=device-width, initial-scale=1">'
        . "<title>$title</title>"
        . '<link rel="stylesheet" href="./assets/style.css">'
        . '</head><body><div class="container">';
}

function view_footer()
{
    echo '</div></body></html>';
}

// Inicializar el publicador de Blogger
$publisher = new BloggerPublisher($__BLOGGER);

// --- Lógica de publicación ---

// Paso 1: Manejar el callback de OAuth2
if (isset($_GET['code'])) {
    if ($publisher->handleCallback($_GET['code'])) {
        // Redirigir para limpiar la URL y continuar con la publicación
        $redirectUrl = $_SESSION['blogger_redirect_after_auth'] ?? './';
        unset($_SESSION['blogger_redirect_after_auth']);
        header('Location: ' . $redirectUrl);
        exit;
    } else {
        view_header();
        echo '<div class="alert alert-error">Error al obtener el token de acceso de Google.</div>';
        view_footer();
        exit;
    }
}

// Guardar la URL actual para redirigir después de la autenticación
$_SESSION['blogger_redirect_after_auth'] = $_SERVER['REQUEST_URI'];

// Paso 2: Verificar si el usuario está autenticado
if (!$publisher->isAuthenticated()) {
    $publisher->authenticate();
    exit;
}

// Paso 3: Obtener el contenido a publicar
$token = $_GET['u'] ?? '';
if (!is_md5_id($token)) {
    view_header();
    echo '<div class="alert alert-error">Parámetro <code>u</code> inválido.</div>';
    view_footer();
    exit;
}

// Resolver URL desde el datastore
$store = new DataStore(__DIR__);
$url = $store->getUrl($token);
if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
    view_header();
    echo '<div class="alert alert-error">No se encontró la URL asociada al identificador.</div>';
    view_footer();
    exit;
}

// Descargar y extraer el contenido
$config = $__APP_CFG['scraper'] ?? [];
$http = new HttpClient($config['user_agent'] ?? '', $config['referer'] ?? '', (int)($config['timeout'] ?? 25), (int)($config['connect_timeout'] ?? 10));
$resp = $http->get($url, ['follow_redirects' => true, 'max_redirects' => 5]);
if ($resp['error']) {
    view_header();
    echo '<div class="alert alert-error"><strong>Error de descarga:</strong> ' . esc_html($resp['error_message']) . '</div>';
    view_footer();
    exit;
}

// Extraer contenido y las imágenes que están DENTRO de ese contenido
$extractor = new HtmlExtractor();
$clean = $extractor->cleanView($resp['body'], $resp['final_url']);
$originalContentHtml = $clean['content_html'];
$contentImages = $clean['images'] ?? []; // Usar el nuevo array de imágenes

// --- Filtrar imágenes ignoradas desde la configuración ---
$ignoreKeywords = $__APP_CFG['scraper']['ignore_image_keywords'] ?? [];
if (!empty($contentImages) && !empty($ignoreKeywords)) {
    $contentImages = array_filter($contentImages, function ($imageUrl) use ($ignoreKeywords) {
        foreach ($ignoreKeywords as $keyword) {
            if (strpos($imageUrl, $keyword) !== false) {
                return false; // Ignorar esta imagen
            }
        }
        return true; // Conservar esta imagen
    });
    // Re-indexar el array para asegurar que las claves son secuenciales (0, 1, 2...)
    $contentImages = array_values($contentImages);
}
// --- Fin del filtrado ---

// --- Integración con la IA para reescritura (Paso Obligatorio) ---
$iaEndpoint = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/ia/analisis.php';
$textContentToRewrite = strip_tags($originalContentHtml); // Enviar solo texto plano a la IA

$iaResponse = $http->post($iaEndpoint, ['content' => $textContentToRewrite]);

if ($iaResponse['error'] || $iaResponse['status'] !== 200) {
    view_header('Error de IA');
    echo '<div class="alert alert-error"><strong>Error de comunicación con la IA.</strong> No se pudo contactar el servicio de reescritura.</div>';
    echo '<pre>Detalles: ' . esc_html($iaResponse['error'] ?: 'HTTP Status: ' . $iaResponse['status']) . '</pre>';
    view_footer();
    exit;
}

$iaResult = json_decode($iaResponse['body'], true);
if (!isset($iaResult['success']) || !$iaResult['success'] || !isset($iaResult['result']['title']) || !isset($iaResult['result']['content_html'])) {
    view_header('Error de IA');
    echo '<div class="alert alert-error"><strong>La respuesta de la IA no es válida.</strong> El formato del contenido generado no es el esperado.</div>';
    echo '<pre>Respuesta recibida: ' . esc_html($iaResponse['body']) . '</pre>';
    view_footer();
    exit;
}

$title = $iaResult['result']['title'];
$rewrittenHtml = $iaResult['result']['content_html'];
// --- Fin de la integración con la IA ---

// --- Lógica para intercalar imágenes en el contenido de la IA ---
if (!empty($contentImages)) {
    $dom = new DOMDocument();
    // Usamos un wrapper para asegurar que el HTML se parsee correctamente
    @$dom->loadHTML('<div>' . $rewrittenHtml . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $xpath = new DOMXPath($dom);
    $paragraphs = $xpath->query('//p');

    $imageCount = count($contentImages);
    $paragraphCount = $paragraphs->length;

    if ($paragraphCount > 1) {
        // Calcular cada cuántos párrafos insertar una imagen para distribuirlas
        $insertInterval = floor($paragraphCount / ($imageCount + 1));
        if ($insertInterval < 1) $insertInterval = 1; // Insertar después de cada párrafo si hay más imágenes

        $imageIndex = 0;
        // Iterar desde el segundo párrafo para no poner imagen al inicio
        for ($i = 1; $i < $paragraphCount; $i++) {
            if ($i % $insertInterval === 0 && $imageIndex < $imageCount) {
                $p = $paragraphs->item($i);
                $imgNode = $dom->createElement('img');
                $imgNode->setAttribute('src', $contentImages[$imageIndex]);
                $imgNode->setAttribute('style', 'max-width: 100%; height: auto; display: block; margin: 20px 0;');

                // Insertar la imagen después del párrafo actual
                $p->parentNode->insertBefore($imgNode, $p->nextSibling);
                $imageIndex++;
            }
        }
    }

    // Extraer el HTML final del wrapper
    $bodyNode = $dom->getElementsByTagName('div')->item(0);
    $contentHtml = '';
    foreach ($bodyNode->childNodes as $child) {
        $contentHtml .= $dom->saveHTML($child);
    }
} else {
    // Si no hay imágenes, usar el HTML de la IA tal cual
    $contentHtml = $rewrittenHtml;
}
// --- Fin de la lógica para intercalar imágenes ---

// Paso 4: Publicar el contenido final (con imágenes) en Blogger
$result = $publisher->publishPost($title, $contentHtml);

// Paso 5: Mostrar el resultado
view_header();
echo '<div class="card">';
echo '<h2>Resultado de la publicación en Blogger</h2>';

if (isset($result['url'])) {
    echo '<div class="alert alert-success"><strong>¡Post publicado con éxito!</strong></div>';
    echo '<p>Puedes ver tu post aquí: <a href="' . esc_attr($result['url']) . '" target="_blank">' . esc_html($result['url']) . '</a></p>';
} else {
    echo '<div class="alert alert-error"><strong>Error al publicar el post.</strong></div>';
    echo '<p>Respuesta de la API:</p>';
    echo '<pre>' . esc_html(print_r($result, true)) . '</pre>';
}

// Para diagnóstico: mostrar siempre la respuesta completa de la API
echo '<details class="card" style="margin-top: 20px;"><summary>Respuesta completa de la API de Blogger (para diagnóstico)</summary><pre>';
echo esc_html(print_r($result, true));
echo '</pre></details>';

// Enlace para volver
$backUrl = './';
if (isset($_GET['r'])) {
    $backUrl = './?url=' . rawurlencode($_GET['r']);
}
echo '<p><a href="' . esc_attr($backUrl) . '">← Volver al Scrapper</a></p>';
echo '</div>';
view_footer();
