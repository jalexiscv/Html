<?php
namespace App\Libraries\Ai;

/**
 * Implementación específica para el modelo de IA Claude de Anthropic
 * 
 * Esta clase proporciona la implementación concreta para interactuar con
 * la API de Claude a través de Google Vertex AI. Maneja el formato específico
 * de las solicitudes y respuestas de Claude.
 * 
 * @package Libraries
 * @extends Ai
 */
class ClaudeAi extends Ai {
    /**
     * Opciones predeterminadas para las solicitudes a Claude
     * @var array
     */
    private $defaultOptions = [
        'max_tokens' => 4096,      // Longitud máxima de la respuesta
        'temperature' => 1.0,      // Nivel de creatividad (0.0 - 1.0)
        'top_p' => 0.95,          // Núcleo de probabilidad acumulativa
        'top_k' => 1              // Número de tokens a considerar
    ];

    /**
     * Tipos de archivo permitidos por Claude
     * @var array
     */
    private $allowedFileTypes = [
        'image' => [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp'
        ],
        'text' => [
            'text/plain',
            'text/markdown',
            'text/csv',
            'application/json',
            'application/pdf'
        ]
    ];

    /**
     * Prepara los datos de la solicitud en el formato específico de Claude
     * 
     * @param string $message Mensaje del usuario
     * @param array $options Opciones de generación (sobrescribe las predeterminadas)
     * @param array $files Array de archivos a procesar
     * @return array Datos formateados para la API de Claude
     * @throws \Exception Si hay archivos inválidos
     */
    protected function prepareRequestData(string $message, array $options = [], array $files = []): array {
        $options = array_merge($this->defaultOptions, $options);

        // Preparar el contenido del mensaje
        $messages = [];
        $currentMessage = ['role' => 'user'];
        $content = [];

        // Procesar archivos primero
        foreach ($files as $file) {
            $fileInfo = $this->processFile($file['path']);
            
            // Validar tipo de archivo
            $isValid = false;
            foreach ($this->allowedFileTypes as $type => $mimes) {
                if ($this->isValidFileType($fileInfo['mime'], $mimes)) {
                    $isValid = true;
                    break;
                }
            }
            
            if (!$isValid) {
                throw new \Exception("Tipo de archivo no soportado: {$fileInfo['mime']}");
            }

            // Determinar el tipo de contenido basado en el MIME
            $contentType = strpos($fileInfo['mime'], 'image/') === 0 ? 'image' : 'text';
            
            // Agregar archivo al contenido
            $content[] = [
                'type' => $contentType,
                'source' => [
                    'type' => 'base64',
                    'media_type' => $fileInfo['mime'],
                    'data' => $fileInfo['base64']
                ]
            ];
        }

        // Agregar el mensaje de texto después de los archivos
        if (!empty($message)) {
            $content[] = [
                'type' => 'text',
                'text' => $message
            ];
        }

        // Asignar el contenido al mensaje
        $currentMessage['content'] = $content;
        $messages[] = $currentMessage;

        return [
            'anthropic_version' => 'vertex-2023-10-16',
            'stream' => false,
            'max_tokens' => $options['max_tokens'],
            'temperature' => $options['temperature'],
            'top_p' => $options['top_p'],
            'top_k' => $options['top_k'],
            'system' => $this->formatSystemMessage(),
            'messages' => $messages
        ];
    }

    /**
     * Envía un mensaje a Claude y obtiene su respuesta
     * 
     * @param string $message Mensaje a enviar
     * @param array $options Opciones de generación
     * @param array $files Array de archivos a analizar
     * @return array Respuesta procesada con formato ['success' => bool, 'response' => string|array, 'error' => string|null]
     * @throws \Exception Si hay un error en la configuración o la comunicación con la API
     */
    public function sendMessage(string $message, array $options = [], array $files = []): array {
        try {
            $endpoint = $this->config['endpoint'] ?? 'us-east5-aiplatform.googleapis.com';
            $locationId = $this->config['location_id'] ?? 'us-east5';
            $projectId = $this->config['project_id'] ?? 'anssible';
            $modelId = $this->config['model_id'] ?? 'claude-3-7-sonnet';
            $method = $this->config['method'] ?? 'rawPredict';

            $url = "https://{$endpoint}/v1/projects/{$projectId}/locations/{$locationId}/publishers/anthropic/models/{$modelId}:{$method}";
            
            $requestData = $this->prepareRequestData($message, $options, $files);
            
            $response = $this->makeHttpRequest(
                $url,
                'POST',
                $requestData,
                [
                    'Authorization: Bearer ' . $this->getAccessToken(),
                    'Content-Type: application/json; charset=utf-8'
                ]
            );

            return $this->parseResponse($response);
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Procesa la respuesta de la API de Claude
     * 
     * @param array $response Respuesta cruda de la API
     * @return array Respuesta procesada con formato estándar
     */
    protected function parseResponse(array $response): array {
        if ($response['status'] !== 200) {
            return [
                'success' => false,
                'error' => 'API request failed',
                'details' => [
                    'status' => $response['status'],
                    'error' => $response['error'],
                    'response' => $response['body']
                ]
            ];
        }

        $responseData = json_decode($response['body'], true);
        
        if (!$responseData) {
            return [
                'success' => false,
                'error' => 'Invalid response format',
                'details' => $response
            ];
        }

        return [
            'success' => true,
            'response' => $responseData['content'] ?? []
        ];
    }

    /**
     * Formatea el mensaje del sistema para Claude
     * 
     * @return string Mensaje del sistema formateado
     */
    protected function formatSystemMessage(): string {
        $prompt = $this->getSystemPrompt();
        
        $message = "Tu nombre es {$prompt['name']}. ";
        $message .= "Tu rol es: {$prompt['role']}. ";
        $message .= "Tu personalidad es: {$prompt['personality']}.\n\n";
        
        if (!empty($prompt['rules'])) {
            $message .= "Reglas que debes seguir:\n";
            foreach ($prompt['rules'] as $rule) {
                $message .= "- $rule\n";
            }
            $message .= "\n";
        }
        
        if (!empty($prompt['capabilities'])) {
            $message .= "Tus capacidades incluyen:\n";
            foreach ($prompt['capabilities'] as $capability) {
                $message .= "- $capability\n";
            }
        }
        
        return $message;
    }

    /**
     * Procesa un archivo y devuelve información sobre él
     * 
     * @param string $filePath Ruta del archivo
     * @return array Información del archivo (mime, base64)
     */
    protected function processFile(string $filePath): array {
        $fileInfo = [];
        
        // Obtener el tipo MIME del archivo
        $fileInfo['mime'] = mime_content_type($filePath);
        
        // Leer el contenido del archivo y codificarlo en base64
        $fileInfo['base64'] = base64_encode(file_get_contents($filePath));
        
        return $fileInfo;
    }

    /**
     * Verifica si un tipo MIME es válido según la lista de tipos permitidos
     * 
     * @param string $mime Tipo MIME a verificar
     * @param array $allowedMimes Lista de tipos MIME permitidos
     * @return bool Verdadero si el tipo MIME es válido, falso de lo contrario
     */
    protected function isValidFileType(string $mime, array $allowedMimes): bool {
        return in_array($mime, $allowedMimes);
    }
}
?>
