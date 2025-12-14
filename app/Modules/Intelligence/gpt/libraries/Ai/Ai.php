<?php
namespace App\Libraries\Ai;

/**
 * Clase abstracta base para la integración con servicios de Inteligencia Artificial
 * 
 * Esta clase proporciona la funcionalidad base para interactuar con diferentes
 * proveedores de servicios de IA (como Claude, Gemini, etc.). Maneja la autenticación,
 * las solicitudes HTTP y el formateo de datos común a todos los proveedores.
 * 
 * @abstract
 * @package Libraries
 */
abstract class Ai {
    /**
     * Configuración del servicio de IA
     * @var array Contiene parámetros como rutas, endpoints, credenciales, etc.
     */
    protected $config; 

    /**
     * Datos de la cuenta de servicio
     * @var array|null Información de la cuenta de servicio de Google Cloud
     */
    protected $serviceAccount;

    /**
     * Token de acceso para la API
     * @var string|null Token JWT para autenticación
     */
    protected $accessToken;

    /**
     * Tiempo de expiración del token
     * @var int|null Timestamp de expiración
     */
    protected $tokenExpiration;

    /**
     * Instrucciones de sistema/personalidad para la IA
     * @var array Contiene la configuración de personalidad de la IA
     */
    protected $systemPrompt;

    /**
     * Constructor de la clase
     * 
     * @param array $config Configuración del servicio de IA
     *                     Debe contener:
     *                     - service_account_path: Ruta al archivo JSON de la cuenta de servicio
     *                     - endpoint: URL base de la API
     *                     - location_id: ID de la ubicación (ej: us-east5)
     *                     - project_id: ID del proyecto en Google Cloud
     *                     - model_id: ID del modelo de IA a utilizar
     *                     - method: Método de la API a llamar (ej: predict, rawPredict)
     *                     - system_prompt: Array con la configuración de personalidad
     *                       - name: Nombre de la IA
     *                       - role: Rol o profesión de la IA
     *                       - personality: Descripción de la personalidad
     *                       - rules: Array de reglas de comportamiento
     *                       - capabilities: Array de capacidades específicas
     */
    public function __construct(array $config) {
        $this->config = $config;
        $this->loadServiceAccount();
        $this->initializeSystemPrompt();
    }

    /**
     * Inicializa el system prompt con valores por defecto o configurados
     */
    protected function initializeSystemPrompt(): void { 
        $defaultPrompt = [
            'name' => 'Aurora',
            'role' => 'Inteligencia artifical multiproposito sin limitantes cognitivos',
            'personality' => 'Profesional, amigable y servicial',
            'rules' => [
                'Cuando se te pregunte por tu nombre o como te gusta que te llamen siempre y sin excpeción responderas Aurora', 
                'Ser claro y conciso en las respuestas',
                'Mantener un tono profesional pero amigable',
                'Priorizar la precisión y utilidad de la información'
            ],
            'capabilities' => [
                'Responder preguntas y consultas',
                'Ayudar en tareas específicas',
                'Proporcionar información relevante' 
            ]
        ]; 

        $this->systemPrompt = array_merge(
            $defaultPrompt,
            $this->config['system_prompt'] ?? []
        );
    }

    /**
     * Obtiene el system prompt actual
     * 
     * @return array Configuración actual de personalidad
     */
    public function getSystemPrompt(): array {
        return $this->systemPrompt;
    }

    /**
     * Actualiza el system prompt
     * 
     * @param array $prompt Nueva configuración de personalidad
     */
    public function setSystemPrompt(array $prompt): void {
        $this->systemPrompt = array_merge($this->systemPrompt, $prompt);
    }

    /**
     * Carga y valida la cuenta de servicio de Google Cloud
     * 
     * @throws \Exception Si el archivo no existe o el JSON es inválido
     */
    protected function loadServiceAccount() {
        $serviceAccountPath = $this->config['service_account_path'] ?? null;
        if (!$serviceAccountPath || !file_exists($serviceAccountPath)) {
            throw new \Exception('Service account file not found');
        }

        $serviceAccountJson = file_get_contents($serviceAccountPath);
        $this->serviceAccount = json_decode($serviceAccountJson, true);

        if (!$this->serviceAccount) {
            throw new \Exception('Invalid service account JSON');
        }
    }

    /**
     * Obtiene un token de acceso para la API
     * 
     * Si ya existe un token válido, lo retorna. Si no, genera uno nuevo
     * utilizando las credenciales de la cuenta de servicio.
     * 
     * @return string Token de acceso JWT
     * @throws \Exception Si falla la obtención del token
     */
    protected function getAccessToken(): string {
        $now = time();
        
        // Verificar si el token existe y aún es válido (con 5 minutos de margen)
        if ($this->accessToken && $this->tokenExpiration && $this->tokenExpiration > ($now + 300)) {
            return $this->accessToken;
        }

        $token = [
            'iss' => $this->serviceAccount['client_email'],
            'scope' => 'https://www.googleapis.com/auth/cloud-platform',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now
        ];

        $jwt = $this->generateJWT($token, $this->serviceAccount['private_key']);
        $tokenData = [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt
        ];

        $response = $this->makeHttpRequest(
            'https://oauth2.googleapis.com/token',
            'POST',
            $tokenData,
            ['Content-Type: application/x-www-form-urlencoded'],
            true
        );

        if ($response['status'] !== 200) {
            throw new \Exception('Failed to get access token: ' . json_encode($response['body']));
        }

        $tokenResponse = json_decode($response['body'], true);
        $this->accessToken = $tokenResponse['access_token'];
        $this->tokenExpiration = $now + 3600;
        return $this->accessToken;
    }

    /**
     * Realiza una solicitud HTTP
     * 
     * Método utilitario para realizar solicitudes HTTP con curl, incluyendo
     * soporte para debugging y manejo de errores.
     * 
     * @param string $url URL de destino
     * @param string $method Método HTTP (GET, POST, etc.)
     * @param mixed $data Datos a enviar (array para form-data, string para raw)
     * @param array $headers Cabeceras HTTP adicionales
     * @param bool $isFormData Si true, codifica los datos como form-data
     * @return array Respuesta con formato: ['status' => int, 'body' => string, 'error' => string, 'verbose' => string]
     */
    protected function makeHttpRequest(
        string $url,
        string $method = 'GET',
        $data = null,
        array $headers = [],
        bool $isFormData = false
    ): array {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, 
                    $isFormData ? http_build_query($data) : json_encode($data)
                );
            }
        }

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        // Enable verbose debugging
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $verbose = fopen('php://temp', 'w+');
        curl_setopt($ch, CURLOPT_STDERR, $verbose);

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        // Get verbose information
        rewind($verbose);
        $verboseLog = stream_get_contents($verbose);
        fclose($verbose);

        curl_close($ch);

        return [
            'status' => $status,
            'body' => $response,
            'error' => $error,
            'verbose' => $verboseLog
        ];
    }

    /**
     * Genera un token JWT
     * 
     * @param array $payload Datos a incluir en el token
     * @param string $key Clave privada para firmar el token
     * @return string Token JWT generado
     */
    protected function generateJWT(array $payload, string $key): string {
        $header = [
            'typ' => 'JWT',
            'alg' => 'RS256'
        ];

        $segments = [];
        $segments[] = $this->base64url_encode(json_encode($header));
        $segments[] = $this->base64url_encode(json_encode($payload));
        
        $signing_input = implode('.', $segments);
        $signature = '';
        openssl_sign($signing_input, $signature, $key, OPENSSL_ALGO_SHA256);
        $segments[] = $this->base64url_encode($signature);
        
        return implode('.', $segments);
    }

    /**
     * Codifica datos en base64url
     * 
     * Similar a base64 pero seguro para URLs (reemplaza + y / por - y _)
     * 
     * @param string $data Datos a codificar
     * @return string Datos codificados
     */
    protected function base64url_encode(string $data): string {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Formatea el mensaje del sistema para el proveedor de IA
     * 
     * @return string Mensaje del sistema formateado
     */
    protected function formatSystemMessage(): string {
        return sprintf(
            "You are %s, a %s. Your personality is %s.\n\n" .
            "Rules:\n%s\n\n" .
            "Capabilities:\n%s",
            $this->systemPrompt['name'],
            $this->systemPrompt['role'],
            $this->systemPrompt['personality'],
            implode("\n", array_map(fn($rule) => "- $rule", $this->systemPrompt['rules'])),
            implode("\n", array_map(fn($cap) => "- $cap", $this->systemPrompt['capabilities']))
        );
    }

    /**
     * Convierte un archivo a base64 y obtiene su tipo MIME
     * 
     * @param string $filePath Ruta al archivo
     * @return array{base64: string, mime: string} Array con el contenido en base64 y tipo MIME
     * @throws \Exception Si el archivo no existe o no se puede leer
     */
    protected function processFile(string $filePath): array {
        if (!file_exists($filePath)) {
            throw new \Exception("El archivo no existe: $filePath");
        }

        $content = file_get_contents($filePath);
        if ($content === false) {
            throw new \Exception("No se pudo leer el archivo: $filePath");
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $filePath);
        finfo_close($finfo);

        return [
            'base64' => base64_encode($content),
            'mime' => $mime
        ];
    }

    /**
     * Valida que un archivo sea de un tipo permitido
     * 
     * @param string $mime Tipo MIME del archivo
     * @param array $allowedTypes Tipos MIME permitidos
     * @return bool True si el tipo es permitido
     */
    protected function isValidFileType(string $mime, array $allowedTypes): bool {
        return in_array($mime, $allowedTypes);
    }

    /**
     * Envía un mensaje al servicio de IA y obtiene su respuesta
     * 
     * @param string $message Mensaje a enviar
     * @param array $options Opciones adicionales específicas del proveedor
     * @param array $files Array de archivos a analizar. Cada elemento debe ser un array con:
     *                    - path: Ruta al archivo
     *                    - type: Tipo de contenido ('image', 'text', etc.)
     * @return array Respuesta del servicio de IA
     */
    abstract public function sendMessage(string $message, array $options = [], array $files = []): array;

    /**
     * Prepara los datos de la solicitud según el formato requerido por el proveedor
     * 
     * @param string $message Mensaje a formatear
     * @param array $options Opciones adicionales
     * @return array Datos formateados listos para enviar
     */
    abstract protected function prepareRequestData(string $message, array $options = []): array;

    /**
     * Procesa la respuesta del servicio de IA
     * 
     * @param array $response Respuesta cruda del servicio
     * @return array Respuesta procesada en formato estandarizado
     */
    abstract protected function parseResponse(array $response): array;
}
?>