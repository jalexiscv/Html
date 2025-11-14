<?php

/**
 * GeminiClient.php
 * Cliente minimalista para la API de Gemini (Google Generative Language) sin librerías externas.
 *
 * Responsabilidades:
 * - Construir el prompt y solicitar a Gemini que retorne SOLO un JSON bien formado con campos predefinidos.
 * - Parsear la respuesta (candidates[0].content.parts[0].text) y decodificar el JSON.
 * - No gestiona cuotas ni reintentos automáticos; devuelve errores normalizados.
 */
class GeminiClient
{
    /** @var string */
    private $apiKey;
    /** @var string */
    private $model;
    /** @var string */
    private $endpointBase;
    /** @var HttpClient */
    private $http;

    /**
     * @param string $apiKey API Key de Gemini (no se debe hardcodear en el repo)
     * @param string $model Modelo a usar (ej: gemini-1.5-flash)
     * @param string $endpointBase Base URL de la API (ej: https://generativelanguage.googleapis.com/v1beta/models)
     * @param HttpClient $http Cliente HTTP propio para POST JSON
     */
    public function __construct($apiKey, $model, $endpointBase, HttpClient $http)
    {
        $this->apiKey = (string)$apiKey;
        $this->model = (string)$model;
        $this->endpointBase = rtrim((string)$endpointBase, '/');
        $this->http = $http;
    }

    /**
     * __analyzeArticle__
     * Envía a Gemini el HTML y la URL para que extraiga metadatos y contenido en un JSON estricto.
     *
     * Estructura esperada del JSON de salida:
     * {
     *   "title": string,
     *   "content_html": string,
     *   "featured_image": string|null,
     *   "category": string|null,
     *   "tags": string[]|null,
     *   "meta_title": string|null,
     *   "meta_description": string|null
     * }
     *
     * @param string $html HTML original descargado
     * @param string $url URL final (canónica o efectiva) del artículo
     * @param string|null $extraInstructions Instrucciones adicionales al modelo (opcional)
     * @return array{error:bool,error_message:string,data:?array}
     */
    public function analyzeArticle($html, $url, $extraInstructions = null)
    {
        $html = (string)$html;
        $url = (string)$url;
        if ($this->apiKey === '' || $this->model === '' || $this->endpointBase === '') {
            return ['error' => true, 'error_message' => 'Gemini no está configurado', 'data' => null];
        }

        $endpoint = $this->endpointBase . '/' . rawurlencode($this->model) . ':generateContent' . '?key=' . rawurlencode($this->apiKey);

        // Prompt claro: exigir SOLO JSON válido y schema explícito
        $schema = <<<JSON
{
  "title": string,
  "content_html": string,  
  "featured_image": string | null,
  "category": string | null,
  "tags": string[] | null,
  "meta_title": string | null,
  "meta_description": string | null
}
JSON;

        $instructions = "Eres un extractor de artículos para publicación en WordPress.\n"
            . "Debes devolver EXCLUSIVAMENTE un JSON VÁLIDO y NADA MÁS. No incluyas explicaciones.\n"
            . "El JSON debe seguir exactamente este esquema y nombres de campos:\n" . $schema . "\n"
            . "Reglas:\n"
            . "- Usa el contenido en español cuando esté disponible.\n"
            . "- Mantén el HTML del cuerpo en 'content_html' con estructura limpia (párrafos, encabezados, listas, imágenes).\n"
            . "- Absolutiza URLs relativas basándote en la URL proporcionada.\n"
            . "- Si no hay 'featured_image', pon null.\n"
            . "- 'tags' es un array o null.\n"
            . "- No agregues texto fuera del JSON.\n";
        if (is_string($extraInstructions) && $extraInstructions !== '') {
            $instructions .= "Instrucciones extra: " . $extraInstructions . "\n";
        }

        // Para modelos 1.5: contents[].parts[].text
        $body = [
            'contents' => [
                ['parts' => [['text' => $instructions]]],
                ['parts' => [['text' => "URL: " . $url]]],
                ['parts' => [['text' => "HTML:\n" . $html]]],
            ],
            'generationConfig' => [
                // Pedimos respuesta en JSON; algunos modelos respetan este hint
                'temperature' => 0.2,
                'maxOutputTokens' => 4096,
                'responseMimeType' => 'application/json'
            ],
        ];

        $resp = $this->http->postJson($endpoint, $body, []);
        if ($resp['error']) {
            return ['error' => true, 'error_message' => 'HTTP: ' . $resp['error_message'], 'data' => null];
        }

        // La API retorna un JSON con candidates[].content.parts[].text
        $payload = $resp['json'];
        if (!is_array($payload) || empty($payload['candidates'][0]['content']['parts'][0]['text'])) {
            return ['error' => true, 'error_message' => 'Respuesta Gemini sin candidates válidos', 'data' => null];
        }
        $text = (string)$payload['candidates'][0]['content']['parts'][0]['text'];

        // El texto debe ser JSON puro. Intentar decodificarlo.
        $data = json_decode($text, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            return ['error' => true, 'error_message' => 'Gemini no retornó JSON válido', 'data' => null];
        }

        // Normalización mínima de campos esperados
        $out = [
            'title' => isset($data['title']) ? (string)$data['title'] : '',
            'content_html' => isset($data['content_html']) ? (string)$data['content_html'] : '',
            'featured_image' => isset($data['featured_image']) && is_string($data['featured_image']) ? $data['featured_image'] : null,
            'category' => isset($data['category']) && is_string($data['category']) ? $data['category'] : null,
            'tags' => isset($data['tags']) && is_array($data['tags']) ? array_values(array_filter(array_map('strval', $data['tags']))) : null,
            'meta_title' => isset($data['meta_title']) && is_string($data['meta_title']) ? $data['meta_title'] : null,
            'meta_description' => isset($data['meta_description']) && is_string($data['meta_description']) ? $data['meta_description'] : null,
        ];

        return ['error' => false, 'error_message' => '', 'data' => $out];
    }
}
