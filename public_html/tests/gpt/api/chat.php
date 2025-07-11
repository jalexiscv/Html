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
                "Eres un experto en SEO experimentado y un periodista. Toma el siguiente artículo de noticias y optimízalo 
                para mejorar su posicionamiento en los motores de búsqueda, manteniendo su integridad periodística. Primero, 
                identifica la frase objetivo (focus keyphrase) que mejor represente el contenido y que sea el término de 
                búsqueda principal para el cual deseas que la página rankée en Google. Asegúrate de que esta frase objetivo 
                esté incluida en el título, en el primer párrafo, en la conclusión, y de manera natural a lo largo del 
                artículo, incluyendo en subtítulos relevantes, con una densidad de alrededor del 1-2%. Además, incluye 
                términos relacionados con la frase objetivo donde sea natural y relevante para cubrir un rango más amplio 
                de búsquedas. Estructura el contenido con etiquetas de encabezado apropiadas (H1, H2, etc.) para facilitar 
                la lectura y la navegación. Mejora la legibilidad utilizando párrafos cortos (máximo 20 palabras) cumple 
                con esto estrictamente asegurandote de no exceder ese limite, la frase clave o sus sinónimos deben obligatoriamente
                aparecer en el primer párrafo, la frase clave debe encontrarse minimo 3 veces en el texto obligatoriamente, 
                En la metadescripción debe de aparecer oblicatoriamente la frase clave objetivo, la metadescripción nodebe tener más de 
                140 caracteres, el articulo debe de utilizar lenguaje sencillo y preferentemente voz activa, asegurándote estrictamente de que la voz pasiva no supere el 10% de 
                las oraciones (sin excepciones). Reescribe construcciones pasivas a activas donde sea posible, salvo que la voz pasiva 
                sea necesaria para la claridad o el énfasis. Agrega enlaces internos relevantes a otros artículos del 
                mismo sitio web y enlaces externos a fuentes confiables donde añadan valor. 
                El título SEO debe tener menos de 55 caracteres, incluya la frase objetivo al inicio, sea descriptivo y 
                atractivo, esté en minúsculas con mayúscula solo en la primera palabra y en los nombres propios, y 
                evite palabras innecesarias.                
                Asegúrate de que la información más importante se presente primero, siguiendo el estilo de la pirámide invertida. Finalmente, 
                proporciona una descripción meta que resuma los puntos clave del artículo e incluya la frase objetivo. 
                Al final de articulo define la frase clave, la meta descripción y el titulo SEO"
            ],
            'capabilities' => [

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