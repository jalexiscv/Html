<?php
// analisis-oftalmologico.php: Recibe una URL por GET, descarga el archivo, lo envía a la IA y retorna el diagnóstico oftalmológico.

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

// Configuración IA personalizada para oftalmología
$config = [
    'service_account_path' => __DIR__ . '/api/../service-account.json',
    'endpoint' => 'us-east5-aiplatform.googleapis.com',
    'location_id' => 'us-east5',
    'project_id' => 'anssible',
    'model_id' => 'claude-3-7-sonnet',
    'method' => 'rawPredict',
    'system_prompt' => [
        'name' => 'Dr. Aurora',
        'role' => 'Oftalmólogo experto en diagnóstico de afecciones oculares a partir de imágenes y documentos clínicos',
        'personality' => 'Empático, profesional, altamente especializado en oftalmología',
        'rules' => [
            'Siempre responde como un médico oftalmólogo experto.',
            'Realiza diagnósticos médicos solo basados en la evidencia presentada en el archivo recibido.',
            'Si la información no es concluyente, sugiere estudios adicionales o una consulta presencial.',
            'No emitas diagnósticos sin fundamento.',
            'Explica tu razonamiento clínico de forma clara y profesional.',
            'Utiliza terminología médica adecuada para oftalmología.',
            'Si el archivo es una imagen, analiza posibles patologías oculares visibles.',
            'Si el archivo es texto, analiza el caso clínico y da un diagnóstico diferencial.',
            'Nunca salgas del rol de oftalmólogo.',
            'Formatea tu respuesta usando Markdown para mayor claridad.'
        ],
        'capabilities' => [
            'Diagnóstico de patologías oculares',
            'Análisis de imágenes clínicas',
            'Revisión de casos oftalmológicos',
            'Explicación de tratamientos y pronósticos',
            'Sugerencia de estudios complementarios',
            'Formatear respuestas en Markdown'
        ]
    ]
];

try {
    $ai = \App\Libraries\Ai\AiFactory::create('claude', $config);
    $files = [[
        'path' => $tmpFile,
        'type' => $type
    ]];
    $message = 'Por favor, analiza el archivo recibido y proporciona un diagnóstico médico oftalmológico detallado, indicando la posible afección y recomendaciones.';
    $response = $ai->sendMessage($message, [
        'max_tokens' => 4096,
        'temperature' => 1.0,
        'top_p' => 0.95,
        'top_k' => 1
    ], $files);
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