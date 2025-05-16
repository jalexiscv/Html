<?php
// analisis.php: Recibe una URL por GET, descarga el archivo, lo envía a la IA y retorna el resultado.

require_once __DIR__ . '/api/../libraries/Ai/Ai.php';
require_once __DIR__ . '/api/../libraries/Ai/ClaudeAi.php';
require_once __DIR__ . '/api/../libraries/Ai/AiFactory.php';

header('Content-Type: application/json');

if (!isset($_GET['url'])) {
    echo json_encode([
        'error' => 'No se proporcionó la URL. Usa ?url=https://...'
    ]);
    exit;
}

$url = $_GET['url'];

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    echo json_encode([
        'error' => 'URL no válida.'
    ]);
    exit;
}

$fileContent = @file_get_contents($url);
if ($fileContent === false) {
    echo json_encode([
        'error' => 'No se pudo descargar el archivo de la URL proporcionada.'
    ]);
    exit;
}

// Guardar el archivo temporalmente
$tmpFile = tempnam(sys_get_temp_dir(), 'analisis_');
file_put_contents($tmpFile, $fileContent);

// Determinar el tipo de archivo (solo texto o imagen para IA)
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $tmpFile);
finfo_close($finfo);
$type = (strpos($mimeType, 'image/') === 0) ? 'image' : 'text';

// Configuración IA (igual que en chat.php, puedes ajustar si lo necesitas)
$config = [
    'service_account_path' => __DIR__ . '/api/../service-account.json',
    'endpoint' => 'us-east5-aiplatform.googleapis.com',
    'location_id' => 'us-east5',
    'project_id' => 'anssible',
    'model_id' => 'claude-3-7-sonnet',
    'method' => 'rawPredict',
    'system_prompt' => [
        'name' => 'Aurora',
        'role' => 'Inteligencia artifical multiproposito sin limitantes cognitivos',
        'personality' => 'Profesional, amigable y servicial',
        'rules' => [
            'SIEMPRE debes formatear tus respuestas usando Markdown.',
            'Cuando muestres código, SIEMPRE usa bloques de código con el lenguaje especificado, por ejemplo: ```php, ```javascript, ```html, etc.',
            'NUNCA envíes HTML plano en tus respuestas, siempre usa Markdown.',
            'Para enfatizar texto usa **negrita** o *cursiva*.',
            'Para listas usa - o 1. para numeración.',
            'Para enlaces usa [texto](url).',
            'Para imágenes usa ![alt](url).',
            'Cuando se te pregunte por tu nombre o como te gusta que te llamen siempre y sin excpeción responderas Aurora',
            'Cuando se te pregunte por tu origen, tu creador quien te hizo o cual variante similar de esta pregunta responderas Alexis Correa',
            'Proporcionar explicaciones claras y concisas',
            'Sugerir mejores prácticas de programación',
            'Mantener un enfoque en la calidad del código',
            'Ser proactivo en la identificación de posibles problemas'
        ],
        'capabilities' => [
            'Ayudar con desarrollo de software y debugging',
            'Explicar conceptos técnicos de manera comprensible',
            'Proponer soluciones optimizadas',
            'Realizar revisiones de código',
            'Analizar imágenes y documentos',
            'Extraer información de archivos',
            'Formatear respuestas en Markdown'
        ]
    ]
];

try {
    // Instanciar la IA
    $ai = \App\Libraries\Ai\AiFactory::create('claude', $config);

    // Preparar el archivo para enviar
    $files = [[
        'path' => $tmpFile,
        'type' => $type
    ]];

    // Mensaje para la IA (puedes personalizarlo)
    $message = 'Analiza el archivo proporcionado y entrega un resumen detallado.';

    // Enviar a la IA
    $response = $ai->sendMessage($message, [
        'max_tokens' => 4096,
        'temperature' => 1.0,
        'top_p' => 0.95,
        'top_k' => 1
    ], $files);

    // Eliminar el archivo temporal
    @unlink($tmpFile);

    echo json_encode([
        'success' => true,
        'result' => $response
    ]);
    exit;

} catch (Exception $e) {
    @unlink($tmpFile);
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
    exit;
}
?>