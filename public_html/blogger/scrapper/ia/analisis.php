<?php
// analisis.php: Recibe contenido textual, lo envía a la IA para que lo reescriba como una noticia y retorna el resultado en JSON.

use App\Libraries\Ai\AiFactory;

require_once __DIR__ . '/api/../libraries/Ai/Ai.php';
require_once __DIR__ . '/api/../libraries/Ai/ClaudeAi.php';
require_once __DIR__ . '/api/../libraries/Ai/AiFactory.php';

header('Content-Type: application/json');

// Cambiado a POST para manejar textos largos
if (!isset($_POST['content'])) {
    echo json_encode([
        'error' => 'No se proporcionó contenido textual. Usa el parámetro POST "content".'
    ]);
    exit;
}

$textContent = $_POST['content'];

if (empty(trim($textContent))) {
    echo json_encode([
        'error' => 'El contenido textual está vacío.'
    ]);
    exit;
}

// Configuración de la IA como Periodista Profesional Colombiano
$config = [
    'service_account_path' => __DIR__ . '/api/../service-account.json',
    'endpoint' => 'us-east5-aiplatform.googleapis.com',
    'location_id' => 'us-east5',
    'project_id' => 'anssible',
    'model_id' => 'claude-3-7-sonnet',
    'method' => 'rawPredict',
    'system_prompt' => [
        'name' => 'Redactor Digital',
        'role' => 'Periodista profesional colombiano, experto en redacción de noticias para medios digitales y optimización SEO.',
        'personality' => 'Objetivo, claro, conciso y utiliza un lenguaje formal pero accesible para el público general en Colombia.',
        'rules' => [
            'Tu tarea es convertir el texto recibido en un artículo de noticias profesional y bien estructurado.',
            'Crea un titular (título) atractivo, informativo y optimizado para motores de búsqueda (SEO).',
            'Redacta la noticia en un tono neutral y objetivo, propio del periodismo.',
            'Utiliza vocabulario y expresiones comunes en los medios de comunicación de Colombia.',
            'Estructura el artículo con párrafos claros y lógicos. El primer párrafo debe ser un "lead" que resuma lo más importante.',
            'El contenido debe estar en formato HTML (párrafos <p>, etc.).',
            'Tu respuesta DEBE ser un objeto JSON válido, sin ningún texto o explicación antes o después del JSON.',
            'El objeto JSON debe tener exactamente la siguiente estructura: {"title": "Tu titular aquí", "content_html": "<p>El contenido del artículo en HTML...</p>"}'
        ],
        'capabilities' => [
            'Redacción de noticias',
            'Creación de titulares SEO',
            'Estructuración de contenido web',
            'Adaptación de tono y estilo al periodismo colombiano',
            'Generación de respuestas en formato JSON'
        ]
    ]
];

try {
    $ai = AiFactory::create('claude', $config);

    $message = 'A partir del siguiente texto, por favor redacta una noticia periodística completa siguiendo mis instrucciones. El texto a reescribir es: ' . $textContent;

    // La IA ya no procesa un archivo, solo el mensaje de texto.
    $responseArray = $ai->sendMessage($message, [
        'max_tokens' => 4096,
        'temperature' => 0.8, // Ligeramente menos creativo para mantener el tono periodístico
        'top_p' => 0.95,
        'top_k' => 1
    ]);

    // La respuesta de la IA ya es un array, extraemos el contenido.
    if (!isset($responseArray['success']) || !$responseArray['success'] || !isset($responseArray['response'][0]['text'])) {
        throw new Exception('La respuesta de la IA no tiene el formato esperado. Respuesta recibida: ' . json_encode($responseArray));
    }

    // El contenido real es un string JSON dentro del array de respuesta.
    $rewritten_news_json = $responseArray['response'][0]['text'];
    $rewritten_news = json_decode($rewritten_news_json, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('El contenido de la IA no es un JSON válido. Contenido recibido: ' . $rewritten_news_json);
    }

    echo json_encode([
        'success' => true,
        'result' => $rewritten_news
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
    exit;
}
?>
