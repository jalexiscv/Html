<?php

class ChromaDB
{
    private string $baseUrl;

    private $token;
    private $host;
    private $port;

    public function __construct(
        string $host = 'http://34.133.165.149',
        string $port = '32768',
        string $token = 'test-token-chroma-local-dev'
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->token = $token;
    }

    private function makeRequest(string $endpoint, string $method = 'GET', array $data = []): array
    {
        $ch = curl_init();
        $url = "{$this->host}:{$this->port}/api/v1/{$endpoint}";

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        if ($this->token) {
            $headers[] = "Authorization: Bearer {$this->token}";
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }

        curl_close($ch);

        if ($statusCode >= 400) {
            throw new Exception('ChromaDB error: ' . $response);
        }

        return json_decode($response, true);
    }

    /**
     * La función devuelve un array que contiene el resultado de la operación. Si la creación de la colección es exitosa,
     * el array contendrá los detalles de la colección creada. Si ocurre un error, el array contendrá un mensaje de error
     * y detalles adicionales.
     * @example
     * // Crear una nueva colección con metadatos
     * $collection_name = 'my_collection';
     * $metadata = ['description' => 'This is a test collection'];
     * $result = $chromadb->createCollection($collection_name, true, $metadata);
     * if (isset($result['error'])) {
     *      echo "Error: " . $result['error'] . "\n";
     *      if (isset($result['details'])) {
     *          echo "Details: " . json_encode($result['details']) . "\n";
     *      }
     * } else {
     *  echo "Collection created successfully:\n";
     *  echo "Status: " . $result['status'] . "\n";
     *  echo "Response: " . json_encode($result['response']) . "\n";
     * }
     * @param string $name El nombre de la colección que se desea crear.
     * @param bool $getOrCreate Un valor booleano que indica si se debe obtener una colección existente con el mismo nombre (true) o crear una nueva (false). El valor predeterminado es false.
     * @param array|null $metadata Un array asociativo opcional que contiene metadatos adicionales para la colección. El valor predeterminado es null.
     * @return array|bool array que contiene el resultado de la operación.
     */
    public function createCollection(string $name, bool $getOrCreate = false, ?array $metadata = null): array
    {
        try {
            $data = array_filter([
                'name' => $name,
                'get_or_create' => $getOrCreate,
                'metadata' => $metadata
            ]);
            $result = $this->makeRequest('collections', 'POST', $data);
            // Consideramos exitoso si el código de estado está en el rango 200-299
            if ($result['status'] >= 200 && $result['status'] < 300) {
                $success=array(
                    'status' =>true,
                    'error' => false,
                    'collection-name' => $name,
                    'message' => "Collection created successfully",
                    'details' => $result
                );
                return($success);
            } else {
                $error=array(
                    'status' =>false,
                    'error' => true,
                    'collection-name' => $name,
                    'message' => "Failed to create collection",
                    'details' => $result
                );
                return($error);
            }
        } catch (Exception $e) {
            // Si hay cualquier excepción, retornamos un array con el error
            $error=array(
                'status' =>false,
                'error' => true,
                'collection-name' => $name,
                'message' => $e->getMessage()
            );
            return($error);
        }
    }

    /**
     * Elimina una colección por su nombre
     *
     * @param string $name Nombre de la colección a eliminar
     * @return bool Retorna true si la colección fue eliminada exitosamente, false en caso contrario
     */
    public function deleteCollection(string $name): bool 
    {
        try {
            $result = $this->makeRequest(
                endpoint: "collections/{$name}", 
                method: 'DELETE'
            );
            
            // Consideramos exitoso si el código de estado es 200 o 204
            return in_array($result['status'], [200, 204]);
            
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Actualiza una colección existente
     *
     * @param string $collectionId ID de la colección a actualizar
     * @param string|null $newName Nuevo nombre para la colección (opcional)
     * @param array|null $newMetadata Nuevos metadatos para la colección (opcional)
     * @return bool Retorna true si la colección fue actualizada exitosamente, false en caso contrario
     */
    public function updateCollection(
        string $collectionId, 
        ?string $newName = null, 
        ?array $newMetadata = null
    ): bool {
        try {
            // Solo incluimos los campos que no son null
            $data = array_filter([
                'new_name' => $newName,
                'new_metadata' => $newMetadata
            ]);
            
            // Si no hay datos para actualizar, retornamos false
            if (empty($data)) {
                return false;
            }
            
            $result = $this->makeRequest(
                endpoint: "collections/{$collectionId}",
                method: 'PUT',
                data: $data
            );
            
            return $result['status'] === 200;
            
        } catch (Exception $e) {
            return false;
        }
    }

    /**
 * Obtiene una colección específica por su nombre
 *
 * @param string $name Nombre de la colección a obtener
 * @return array Retorna un array con la información de la colección o un array con el error
 */
public function getCollection(string $name): array
{
    try {
        $result = $this->makeRequest(
            endpoint: "collections/{$name}",
            method: 'GET'
        );
        
        if ($result['status'] >= 200 && $result['status'] < 300) {
            return [
                'status' => true,
                'error' => false,
                'collection-name' => $name,
                'message' => "Collection retrieved successfully",
                'details' => $result
            ];
        } else {
            return [
                'status' => false,
                'error' => true,
                'collection-name' => $name,
                'message' => "Failed to retrieve collection",
                'details' => $result
            ];
        }
    } catch (Exception $e) {
        return [
            'status' => false,
            'error' => true,
            'collection-name' => $name,
            'message' => $e->getMessage()
        ];
    }
}

/**
 * Lista todas las colecciones disponibles
 *
 * @param int|null $limit Número máximo de colecciones a retornar
 * @param int|null $offset Número de colecciones a saltar
 * @return array Retorna un array con la lista de colecciones o un array con el error
 */
public function listCollections(?int $limit = null, ?int $offset = null): array
{
    try {
        $data = array_filter([
            'limit' => $limit,
            'offset' => $offset
        ]);
        
        $result = $this->makeRequest(
            endpoint: 'collections',
            method: 'GET',
            data: $data
        );
        
        if ($result['status'] >= 200 && $result['status'] < 300) {
            return [
                'status' => true,
                'error' => false,
                'message' => "Collections retrieved successfully",
                'details' => $result
            ];
        } else {
            return [
                'status' => false,
                'error' => true,
                'message' => "Failed to retrieve collections",
                'details' => $result
            ];
        }
    } catch (Exception $e) {
        return [
            'status' => false,
            'error' => true,
            'message' => $e->getMessage()
        ];
    }
}

/**
 * Cuenta el número total de colecciones
 *
 * @return array Retorna un array con el conteo de colecciones o un array con el error
 */
public function countCollections(): array
{
    try {
        $result = $this->makeRequest(
            endpoint: 'count_collections',
            method: 'GET'
        );
        
        if ($result['status'] >= 200 && $result['status'] < 300) {
            return [
                'status' => true,
                'error' => false,
                'message' => "Collections counted successfully",
                'count' => (int) $result['response'],
                'details' => $result
            ];
        } else {
            return [
                'status' => false,
                'error' => true,
                'message' => "Failed to count collections",
                'details' => $result
            ];
        }
    } catch (Exception $e) {
        return [
            'status' => false,
            'error' => true,
            'message' => $e->getMessage()
        ];
    }
}

/**
 * Agrega items a una colección
 *
 * @param string $collectionId ID de la colección
 * @param array $ids Array de IDs únicos para los items
 * @param array|null $documents Array de documentos (opcional)
 * @param array|null $metadatas Array de metadatos para cada item (opcional)
 * @param array|null $embeddings Array de embeddings para cada item (opcional)
 * @return array Retorna un array con el resultado de la operación
 */
public function addItems(
    string $collectionId,
    array $ids,
    ?array $documents = null,
    ?array $metadatas = null,
    ?array $embeddings = null
): array {
    try {
        // Validación básica
        if (empty($ids)) {
            return [
                'status' => false,
                'error' => true,
                'message' => 'IDs array cannot be empty'
            ];
        }

        // Construir el cuerpo de la petición
        $data = array_filter([
            'ids' => $ids,
            'documents' => $documents,
            'metadatas' => $metadatas,
            'embeddings' => $embeddings
        ]);

        $result = $this->makeRequest(
            endpoint: "collections/{$collectionId}/add",
            method: 'POST',
            data: $data
        );

        if ($result['status'] === 201) {
            return [
                'status' => true,
                'error' => false,
                'message' => "Items added successfully",
                'collection_id' => $collectionId,
                'items_count' => count($ids),
                'details' => $result
            ];
        } else {
            return [
                'status' => false,
                'error' => true,
                'message' => "Failed to add items",
                'collection_id' => $collectionId,
                'details' => $result
            ];
        }
    } catch (Exception $e) {
        return [
            'status' => false,
            'error' => true,
            'message' => $e->getMessage(),
            'collection_id' => $collectionId
        ];
    }
}

/**
 * Cuenta el número de items en una colección
 *
 * @param string $collectionId ID de la colección
 * @return array Retorna un array con el resultado del conteo
 */
public function countItems(string $collectionId): array
{
    try {
        $result = $this->makeRequest(
            endpoint: "collections/{$collectionId}/count",
            method: 'GET'
        );
        
        if ($result['status'] >= 200 && $result['status'] < 300) {
            return [
                'status' => true,
                'error' => false,
                'message' => "Items counted successfully",
                'collection_id' => $collectionId,
                'count' => (int) $result['response'],
                'details' => $result
            ];
        } else {
            return [
                'status' => false,
                'error' => true,
                'message' => "Failed to count items",
                'collection_id' => $collectionId,
                'details' => $result
            ];
        }
    } catch (Exception $e) {
        return [
            'status' => false,
            'error' => true,
            'message' => $e->getMessage(),
            'collection_id' => $collectionId
        ];
    }
}

/**
 * Consulta items por similitud en una colección
 *
 * @param string $collectionId ID de la colección
 * @param array $queryEmbeddings Vector de embeddings para la búsqueda por similitud
 * @param array|null $queryTexts Textos para búsqueda por similitud
 * @param array|null $where Filtros por metadatos
 * @param array|null $whereDocument Filtros por contenido del documento
 * @param array|null $include Campos a incluir en la respuesta ['documents', 'metadatas', 'distances']
 * @param int|null $nResults Número máximo de resultados a retornar
 * @return array Retorna un array con los resultados o un array con el error
 */
public function queryItems(
    string $collectionId,
    array $queryEmbeddings = [],
    ?array $queryTexts = null,
    ?array $where = null,
    ?array $whereDocument = null,
    ?array $include = null,
    ?int $nResults = null
): array {
    try {
        $data = array_filter([
            'query_embeddings' => $queryEmbeddings,
            'query_texts' => $queryTexts,
            'where' => $where,
            'where_document' => $whereDocument,
            'include' => $include,
            'n_results' => $nResults
        ]);

        $result = $this->makeRequest(
            endpoint: "collections/{$collectionId}/query",
            method: 'POST',
            data: $data
        );

        if ($result['status'] >= 200 && $result['status'] < 300) {
            return [
                'status' => true,
                'error' => false,
                'message' => "Query executed successfully",
                'collection_id' => $collectionId,
                'results' => $result['response'],
                'details' => $result
            ];
        } else {
            return [
                'status' => false,
                'error' => true,
                'message' => "Failed to execute query",
                'collection_id' => $collectionId,
                'details' => $result
            ];
        }
    } catch (Exception $e) {
        return [
            'status' => false,
            'error' => true,
            'message' => $e->getMessage(),
            'collection_id' => $collectionId
        ];
    }
}



}
?>