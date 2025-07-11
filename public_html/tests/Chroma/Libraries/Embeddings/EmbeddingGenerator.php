<?php

namespace App\Libraries\Embeddings;

require_once('ThirdParty/GeminiAPI/autoload.php');

use GeminiAPI\Client;
use GeminiAPI\Resources\ModelName;
use GeminiAPI\Resources\Parts\TextPart;
use GeminiAPI\Resources\Content;
use GeminiAPI\Enums\Role;

class EmbeddingGenerator {
    private $apiKey;
    public function __construct(string $apiKey) {
        $this->apiKey = $apiKey;
    }

    /**
     * Genera un embedding para el texto dado usando la API de Google PaLM
     *
     * @param string $text El texto para generar el embedding
     * @return array|null Array con el embedding o null si hay error
     */
    public function generateEmbedding(string $text): ?array {
        $ia = new Client($this->apiKey);
        $embedding_response = $ia->embeddingModel(ModelName::EMBEDDING_001)->embedContent(new TextPart($text));
        $embeddings = $embedding_response->embedding->values;
        return $embeddings;
    }
}
