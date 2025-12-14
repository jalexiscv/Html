<?php
require_once __DIR__ . '/../libraries/Ai/Ai.php';
require_once __DIR__ . '/../libraries/Ai/ClaudeAi.php';
require_once __DIR__ . '/../libraries/Ai/AiFactory.php';
require_once __DIR__ . '/../libraries/ChromaDB/ChromaDB.php';

use App\Libraries\Ai\AiFactory;
use App\Libraries\ChromaDB\ChromaDB;

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Verificar si hay datos POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
        throw new Exception('Método no permitido');
    }

    // Obtener el mensaje y session_id
    $message = $_POST['message'] ?? '';
    $sessionId = $_POST['session_id'] ?? session_id();

    // Inicializar ChromaDB
    $chromaDb = new ChromaDB(
        'http://34.133.165.149',
        '32768',
        'test-token-chroma-local-dev'
    );

    // Obtener o crear la colección para este usuario
    $collectionName = "chat_history_{$sessionId}";
    $collection = $chromaDb->createCollection($collectionName, true, [
        'metadata' => ['description' => 'Historial de chat del usuario']
    ]);

    // Configure the AI service
    $config = [
        'service_account_path' => __DIR__ . '/../service-account.json',
        'endpoint' => 'us-east5-aiplatform.googleapis.com',
        'location_id' => 'us-east5',
        'project_id' => 'anssible',
        'model_id' => 'claude-3-7-sonnet',
        'method' => 'rawPredict',
        // Configuración de la personalidad de la IA
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

    // Create AI instance using the factory
    $ai = AiFactory::create('claude', $config);

    // Obtener historial reciente (últimos 5 mensajes)
    $history = $chromaDb->queryItems(
        $collectionName,
        [],
        [$message],
        null,
        null,
        ['documents', 'metadatas'],
        5
    );

    // Procesar archivos si existen
    $files = [];
    if (!empty($_FILES)) {
        foreach ($_FILES as $file) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                // Determinar el tipo de contenido basado en la extensión o MIME
                $type = strpos($file['type'], 'image/') === 0 ? 'image' : 'text';
                
                $files[] = [
                    'path' => $file['tmp_name'],
                    'type' => $type
                ];
            }
        }
    }

    // Enviar mensaje y obtener respuesta
    $response = $ai->sendMessage(
        $message,
        [
            'max_tokens' => 4096,
            'temperature' => 1.0,
            'top_p' => 0.95,
            'top_k' => 1
        ],
        $files
    );

    // Guardar la interacción en ChromaDB
    $chromaDb->addItems(
        $collectionName,
        [uniqid()],
        [$message],
        [
            [
                'timestamp' => time(),
                'role' => 'interaction'
            ]
        ],
        [[0.1, 0.2, 0.3]] // Vector de ejemplo - esto debería ser reemplazado por embeddings reales
    );

    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>