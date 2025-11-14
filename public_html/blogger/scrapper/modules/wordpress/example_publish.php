<?php
/**
 * Ejemplo: Publicar una entrada en WordPress mediante la librería propia.
 *
 * Uso:
 * - Método: POST
 * - Content-Type: application/json
 * - Body ejemplo:
 *   {
 *     "title": "Título de prueba",
 *     "content_html": "<p>Contenido <strong>HTML</strong> de ejemplo</p>",
 *     "categories": ["Noticias", "Tecnología"],
 *     "tags": ["AI", "OpenSource"],
 *     "featured_image_url": "https://example.com/imagen.jpg",
 *     "status": "publish"
 *   }
 *
 * Requiere variables en .env:
 * - WP_BASE_URL, WP_USER, WP_APP_PASSWORD, WP_VERIFY_SSL
 */

// Cargar .env y librerías
require_once dirname(__DIR__) . '/../inc/EnvLoader.php';
EnvLoader::load();
require_once __DIR__ . '/WpPublisher.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido. Usa POST.']);
    exit;
}

$raw = file_get_contents('php://input');
$payload = json_decode($raw, true);
if (!is_array($payload)) {
    http_response_code(400);
    echo json_encode(['error' => 'JSON inválido']);
    exit;
}

$title = isset($payload['title']) ? (string)$payload['title'] : '';
$content = isset($payload['content_html']) ? (string)$payload['content_html'] : '';
$cats = isset($payload['categories']) && is_array($payload['categories']) ? $payload['categories'] : [];
$tags = isset($payload['tags']) && is_array($payload['tags']) ? $payload['tags'] : [];
$featUrl = isset($payload['featured_image_url']) ? (string)$payload['featured_image_url'] : null;
$status = isset($payload['status']) ? (string)$payload['status'] : 'publish';

if ($title === '' || $content === '') {
    http_response_code(422);
    echo json_encode(['error' => 'title y content_html son obligatorios']);
    exit;
}

$baseUrl = env('WP_BASE_URL');
$user = env('WP_USER');
$appPass = env('WP_APP_PASSWORD');
$verify = (bool)env('WP_VERIFY_SSL', true);

if (!$baseUrl || !$user || !$appPass) {
    http_response_code(500);
    echo json_encode(['error' => 'Variables WP_* faltantes en .env']);
    exit;
}

try {
    $wp = new WpPublisher($baseUrl, $user, $appPass, $verify);
    $resp = $wp->publishPost($title, $content, $cats, $tags, $featUrl, $status);
    $statusCode = (int)$resp['status'];
    if ($resp['error']) {
        http_response_code(502);
        echo json_encode(['error' => 'Error de cURL', 'detail' => $resp['error']]);
        exit;
    }
    http_response_code($statusCode ?: 200);
    echo json_encode($resp['json'] !== null ? $resp['json'] : ['raw' => $resp['body']]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Excepción', 'detail' => $e->getMessage()]);
}
