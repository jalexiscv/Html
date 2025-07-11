<?php

namespace App\Libraries\ChromaDB;

/**
 * Clase ChromaDB
 * 
 * Esta clase proporciona una interfaz para interactuar con ChromaDB, una base de datos de embeddings de código abierto.
 * Permite realizar operaciones CRUD sobre colecciones y gestionar embeddings vectoriales.
 */
class ChromaDB
{
    private string $baseUrl;

    private $token;
    private $host;
    private $port;

    /**
     * Constructor de la clase ChromaDB
     * 
     * @param string $host URL del servidor ChromaDB (por defecto: 'http://34.133.165.149')
     * @param string $port Puerto del servidor ChromaDB (por defecto: '32768')
     * @param string $token Token de autenticación para el servidor (por defecto: 'test-token-chroma-local-dev')
     */
    public function __construct(
        string $host = 'http://34.133.165.149',
        string $port = '32768',
        string $token = 'test-token-chroma-local-dev'
    )
    {
        $this->host = $host;
        $this->port = $port;
        $this->token = $token;
    }

    /**
     * Crea una nueva colección en ChromaDB o recupera una existente
     *
     * @param string $name Nombre único para la nueva colección
     * @param bool $getOrCreate Si es true, obtiene la colección si existe o la crea si no existe
     * @param array|null $metadata Metadatos adicionales para describir la colección
     * @return array Resultado de la operación con la siguiente estructura:
     *               - status: (bool) true si la operación fue exitosa
     *               - error: (bool) true si ocurrió un error
     *               - collection-name: (string) nombre de la colección
     *               - message: (string) mensaje descriptivo del resultado
     *               - details: (array) detalles completos de la respuesta de la API
     *
     * @example
     * // Crear una nueva colección con metadatos
     * $metadata = ['description' => 'Colección para documentos de texto'];
     * $result = $chromadb->createCollection('documentos', false, $metadata);
     * if ($result['status']) {
     *     echo "Colección creada: " . $result['collection-name'];
     * } else {
     *     echo "Error: " . $result['message'];
     * }
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
                $success = array(
                    'status' => true,
                    'error' => false,
                    'collection-name' => $name,
                    'message' => "Collection created successfully",
                    'details' => $result
                );
                return ($success);
            } else {
                $error = array(
                    'status' => false,
                    'error' => true,
                    'collection-name' => $name,
                    'message' => "Failed to create collection",
                    'details' => $result
                );
                return ($error);
            }
        } catch (Exception $e) {
            // Si hay cualquier excepción, retornamos un array con el error
            $error = array(
                'status' => false,
                'error' => true,
                'collection-name' => $name,
                'message' => $e->getMessage()
            );
            return ($error);
        }
    }

    /**
     * Realiza una petición HTTP a la API de ChromaDB
     *
     * @param string $endpoint Endpoint de la API a llamar (ejemplo: 'collections', 'embeddings')
     * @param string $method Método HTTP a utilizar (GET, POST, PUT, DELETE)
     * @param array $data Datos a enviar en la petición en formato array asociativo
     * @return array Respuesta de la API con la siguiente estructura:
     *               - status: (int) Código de estado HTTP
     *               - response: (array|null) Respuesta de la API decodificada
     *               - error: (string) Mensaje de error si ocurrió alguno
     */
    private function makeRequest(string $endpoint, string $method = 'GET', array $data = []): array
    {
        try {
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
                $jsonData = json_encode($data);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

                // Log para depuración
                error_log("ChromaDB Request URL: " . $url);
                error_log("ChromaDB Request Data: " . $jsonData);
            }

            $response = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);

            // Log para depuración
            error_log("ChromaDB Response Status: " . $statusCode);
            error_log("ChromaDB Response Body: " . $response);
            if ($curlError) {
                error_log("ChromaDB Curl Error: " . $curlError);
            }

            curl_close($ch);

            return [
                'status' => $statusCode,
                'response' => $response ? json_decode($response, true) : null,
                'error' => $curlError
            ];
        } catch (Exception $e) {
            error_log("ChromaDB Exception in makeRequest: " . $e->getMessage());
            return [
                'status' => 500,
                'response' => null,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Elimina permanentemente una colección de ChromaDB
     * 
     * @param string $name Nombre de la colección a eliminar
     * @return bool true si la colección fue eliminada exitosamente, false si ocurrió un error
     * 
     * @example
     * if ($chromadb->deleteCollection('documentos')) {
     *     echo "Colección eliminada exitosamente";
     * } else {
     *     echo "Error al eliminar la colección";
     * }
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
     * Actualiza una colección existente en ChromaDB
     * 
     * @param string $collectionId Identificador único de la colección
     * @param string|null $newName Nuevo nombre para la colección (opcional)
     * @param array|null $newMetadata Nuevos metadatos para la colección (opcional)
     * @return bool true si la actualización fue exitosa, false si hubo un error o no hay cambios
     * 
     * @example
     * $newMetadata = ['description' => 'Nueva descripción', 'category' => 'documentos'];
     * if ($chromadb->updateCollection('col_123', 'nuevo_nombre', $newMetadata)) {
     *     echo "Colección actualizada correctamente";
     * } else {
     *     echo "Error al actualizar la colección";
     * }
     */
    public function updateCollection(
        string  $collectionId,
        ?string $newName = null,
        ?array  $newMetadata = null
    ): bool
    {
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
     * Obtiene los detalles de una colección específica
     * 
     * @param string $name Nombre de la colección a consultar
     * @return array Información de la colección con la siguiente estructura:
     *               - status: (bool) true si la operación fue exitosa
     *               - error: (bool) true si ocurrió un error
     *               - details: (array) información detallada de la colección
     *                 - id: (string) identificador único
     *                 - name: (string) nombre de la colección
     *                 - metadata: (array) metadatos asociados
     * 
     * @example
     * $result = $chromadb->getCollection('documentos');
     * if ($result['status']) {
     *     $details = $result['details']['response'];
     *     echo "ID: " . $details['id'] . "\n";
     *     echo "Nombre: " . $details['name'] . "\n";
     *     echo "Metadatos: " . json_encode($details['metadata']);
     * } else {
     *     echo "Error al obtener la colección";
     * }
     */
    public function getCollection(string $name): array
    {
        try {
            $result = $this->makeRequest(
                endpoint: "collections/{$name}",
                method: 'GET'
            );

            if ($result['status'] >= 200 && $result['status'] < 300 && isset($result['response']['id'])) {
                return [
                    'status' => true,
                    'error' => false,
                    'id' => $result['response']['id'],
                    'name' => $name,
                    'message' => "Collection retrieved successfully",
                    'details' => $result
                ];
            } else {
                error_log("ChromaDB getCollection error: " . print_r($result, true));
                return [
                    'status' => false,
                    'error' => true,
                    'collection-name' => $name,
                    'message' => "Failed to retrieve collection",
                    'details' => $result
                ];
            }
        } catch (Exception $e) {
            error_log("ChromaDB getCollection exception: " . $e->getMessage());
            return [
                'status' => false,
                'error' => true,
                'collection-name' => $name,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Lista todas las colecciones disponibles en ChromaDB
     * 
     * Este método permite obtener un listado de todas las colecciones existentes en la base de datos,
     * con opciones de paginación para manejar grandes cantidades de datos.
     * 
     * @param int|null $limit Número máximo de colecciones a retornar (opcional)
     *                       Si es null, retorna todas las colecciones
     * @param int|null $offset Número de colecciones a saltar antes de comenzar (opcional)
     *                        Útil para implementar paginación
     * @return array Retorna un array con la siguiente estructura:
     *               - status: (bool) true si la operación fue exitosa
     *               - error: (bool) true si ocurrió un error
     *               - message: (string) mensaje descriptivo del resultado
     *               - details: (array) información detallada
     *                   - status: (int) código HTTP de la respuesta
     *                   - response: (array) lista de colecciones, cada una con:
     *                       - id: (string) identificador único
     *                       - name: (string) nombre de la colección
     *                       - metadata: (array) metadatos asociados
     * 
     * @example
     * // Ejemplo 1: Listar todas las colecciones
     * $result = $chromadb->listCollections();
     * if ($result['status']) {
     *     foreach ($result['details']['response'] as $collection) {
     *         echo "ID: " . $collection['id'] . "\n";
     *         echo "Nombre: " . $collection['name'] . "\n";
     *         echo "Metadatos: " . json_encode($collection['metadata']) . "\n";
     *     }
     * }
     * 
     * @example
     * // Ejemplo 2: Implementar paginación
     * $limit = 5;  // 5 colecciones por página
     * $pagina = 2; // Segunda página
     * $offset = ($pagina - 1) * $limit;
     * 
     * $result = $chromadb->listCollections($limit, $offset);
     * if ($result['status']) {
     *     echo "Mostrando colecciones " . ($offset + 1) . " a " . ($offset + $limit) . ":\n";
     *     foreach ($result['details']['response'] as $collection) {
     *         echo "- " . $collection['name'] . "\n";
     *     }
     * } else {
     *     echo "Error: " . $result['message'];
     * }
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
     * @return array Retorna un array con el conteo de colecciones o un array con el error
     * @example
     * $result = $chroma->countCollections();
     * if ($result['status']) {
     *      echo "Número total de colecciones: " . $result['count'];
     * } else {
     *      echo "Error: " . $result['message'];
     * }
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
                    'count' => (int)$result['response'],
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
     *      - Incluye validaciones básicas para asegurar que al menos se proporcionen IDs
     *      - Maneja los errores de manera consistente con el resto de la API
     *      - Espera un código de estado 201 para considerar exitosa la operación (como se ve en los tests)
     *      - Proporciona información detallada en la respuesta, incluyendo el número de items agregados
     * @param string $collectionId ID de la colección
     * @param array $ids Array de IDs únicos para los items
     * @param array|null $documents Array de documentos (opcional)
     * @param array|null $metadatas Array de metadatos para cada item (opcional)
     * @param array|null $embeddings Array de embeddings para cada item (opcional)
     * @return array Retorna un array con el resultado de la operación
     * @example
     * $chroma = new ChromaDBClient(
     * host: '34.133.165.149',
     * port: '32768',
     * token: 'test-token-chroma-local-dev'
     * );
     *
     * // Ejemplo básico: solo IDs y documentos
     * $result = $chroma->addItems(
     * collectionId: 'test-collection-id',
     * ids: ['item1', 'item2'],
     * documents: ['texto del documento 1', 'texto del documento 2']
     * );
     *
     * // Ejemplo completo: con metadatos y embeddings
     * $result = $chroma->addItems(
     * collectionId: 'test-collection-id',
     * ids: ['item1', 'item2'],
     * documents: ['texto del documento 1', 'texto del documento 2'],
     * metadatas: [
     * ['title' => 'metadata1'],
     * ['title' => 'metadata2']
     * ],
     * embeddings: [
     * [0.1, 0.2, 0.3],
     * [0.4, 0.5, 0.6]
     * ]
     * );
     *
     * if ($result['status']) {
     * echo "Items agregados exitosamente: " . $result['items_count'] . " items";
     * } else {
     * echo "Error: " . $result['message'];
     * }
     */
    public function addItems(
        string $collectionId,
        array  $ids,
        ?array $documents = null,
        ?array $metadatas = null,
        ?array $embeddings = null
    ): array
    {
        try {
            // Validaciones mejoradas
            if (empty($ids)) {
                return(array(
                    'status' => false,
                    'error' => true,
                    'message' => 'IDs array cannot be empty'
                ));
            }
            // Validar dimensiones consistentes para embeddings
            if ($embeddings && !$this->validateEmbeddingsDimensions($embeddings)) {
                return(array(
                    'status' => false,
                    'error' => true,
                    'message' => 'All embeddings must have the same number of dimensions'
                ));
            }
            // Validar que los arrays opcionales tengan la misma longitud que $ids si están presentes
            if (($documents !== null && count($documents) !== count($ids)) ||
                ($metadatas !== null && count($metadatas) !== count($ids)) ||
                ($embeddings !== null && count($embeddings) !== count($ids))) {
                return [
                    'status' => false,
                    'error' => true,
                    'message' => 'All provided arrays (documents, metadatas, embeddings) must have the same length as ids array'
                ];
            }

            // Construir el cuerpo de la petición
            $data = array_filter([
                'ids' => array_values($ids), // Asegurar que los índices sean numéricos
                'documents' => $documents,
                'metadatas' => $metadatas,
                'embeddings' => $embeddings
            ]);

            $result = $this->makeRequest(endpoint: "collections/{$collectionId}/add",method: 'POST',data: $data);

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
     * Puntos importantes a tener en cuenta:
     * 1. La dimensionalidad se establece con el primer insert y no puede cambiarse después.
     * Todos los embeddings subsiguientes deben tener la misma dimensionalidad.
     * Es una buena práctica validar que todos los embeddings en tu array tengan la misma dimensionalidad antes de insertarlos.
     * @param array $embeddings
     * @return bool
     */
    private function validateEmbeddingsDimensions(array $embeddings): bool
    {
        if (empty($embeddings)) {
            return true;
        }

        $firstDimension = count($embeddings[0]);

        foreach ($embeddings as $embedding) {
            if (count($embedding) !== $firstDimension) {
                return false;
            }
        }

        return true;
    }

    /**
     * Elimina items de una colección
     * @param string $collectionId ID de la colección
     * @param array $ids Array de IDs de los items a eliminar
     * @param array|null $where Condiciones adicionales de filtrado (opcional)
     * @param array|null $whereDocument Condiciones de filtrado para documentos (opcional)
     * @return array Retorna un array con el resultado de la operación
     * @example
     * // Eliminar por IDs específicos
     * $result = $chroma->deleteItems(collectionId: 'test-collection-id',ids: ['item1', 'item2']);
     * // Eliminar usando condiciones where
     * $result = $chroma->deleteItems(collectionId: 'test-collection-id',where: ['metadata_field' => 'value_to_match']);
     * // Eliminar usando condiciones where_document
     * $result = $chroma->deleteItems(collectionId: 'test-collection-id',whereDocument: ['$contains' => 'texto a buscar']);
     * // Eliminar usando combinación de filtros
     * $result = $chroma->deleteItems(collectionId: 'test-collection-id',ids: ['item1'],where: ['metadata_field' => 'value'],whereDocument: ['$contains' => 'texto']);
     *
     * if ($result['status']) {
     * echo "Items eliminados exitosamente: " . $result['items_deleted'] . " items";
     * } else {
     * echo "Error: " . $result['message'];
     * }
     */
    public function deleteItems(
        string $collectionId,
        array  $ids = [],
        ?array $where = null,
        ?array $whereDocument = null
    ): array
    {
        try {
            // Validación básica
            if (empty($ids) && empty($where) && empty($whereDocument)) {
                return [
                    'status' => false,
                    'error' => true,
                    'message' => 'At least one of ids, where, or where_document must be provided'
                ];
            }

            // Construir el cuerpo de la petición
            $data = array_filter([
                'ids' => $ids,
                'where' => $where,
                'where_document' => $whereDocument
            ]);

            $result = $this->makeRequest(
                endpoint: "collections/{$collectionId}/delete",
                method: 'POST',
                data: $data
            );

            if ($result['status'] >= 200 && $result['status'] < 300) {
                return [
                    'status' => true,
                    'error' => false,
                    'message' => "Items deleted successfully",
                    'collection_id' => $collectionId,
                    'items_deleted' => count($ids),
                    'details' => $result
                ];
            } else {
                return [
                    'status' => false,
                    'error' => true,
                    'message' => "Failed to delete items",
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
     * @param string $collectionId ID de la colección
     * @return array Retorna un array con el resultado del conteo
     * @example
     * // Contar items en una colección
     * $result = $chromadb->countItems('test-collection-id');
     * if ($result['status']) {
     * echo "Número de items en la colección: " . $result['count'];
     * } else {
     * echo "Error: " . $result['message'];
     * }
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
                    'count' => (int)$result['response'],
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
     * Obtiene items específicos de una colección
     *
     * @param string $collectionId ID de la colección
     * @param string|array $ids IDs de los items a obtener
     * @param array|null $include Campos a incluir en la respuesta ['documents', 'metadatas', 'embeddings']
     * @param int|null $limit Límite de resultados
     * @param int|null $offset Número de resultados a saltar
     * @param array|null $where Condiciones de filtrado por metadatos
     * @param array|null $whereDocument Condiciones de filtrado por documento
     * @return array Retorna un array con los items o un array con el error
     * @example:
     *
     */
    public function getItems(
        string       $collectionId,
        string|array $ids,
        ?array       $include = null,
        ?int         $limit = null,
        ?int         $offset = null,
        ?array       $where = null,
        ?array       $whereDocument = null
    ): array
    {
        try {
            // Asegurarse de que $ids sea un array
            $ids = is_string($ids) ? [$ids] : $ids;

            $data = array_filter([
                'ids' => $ids,
                'include' => $include,
                'limit' => $limit,
                'offset' => $offset,
                'where' => $where,
                'where_document' => $whereDocument
            ]);

            $result = $this->makeRequest(
                endpoint: "collections/{$collectionId}/get",
                method: 'POST',
                data: $data
            );

            if ($result['status'] >= 200 && $result['status'] < 300) {
                return [
                    'status' => true,
                    'error' => false,
                    'message' => "Items retrieved successfully",
                    'collection_id' => $collectionId,
                    'items' => $result['response'],
                    'details' => $result
                ];
            } else {
                return [
                    'status' => false,
                    'error' => true,
                    'message' => "Failed to retrieve items",
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
        array  $queryEmbeddings = [],
        ?array $queryTexts = null,
        ?array $where = null,
        ?array $whereDocument = null,
        ?array $include = null,
        ?int   $nResults = null
    ): array
    {
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

    /**
     * Actualiza items existentes en una colección
     * Características principales:
     *      - Validación de IDs requeridos
     *      - Validación de al menos un campo para actualizar
     *      - Soporte para actualizar documentos, metadatos y embeddings
     *      - Información detallada en la respuesta
     *      - Manejo de errores consistente con el resto de la API
     *      - Contador de items actualizados
     * @param string $collectionId ID de la colección
     * @param array $ids IDs de los items a actualizar
     * @param array|null $embeddings Nuevos embeddings para los items (opcional)
     * @param array|null $metadatas Nuevos metadatos para los items (opcional)
     * @param array|string|null $documents Nuevos documentos para los items (opcional)
     * @return array Retorna un array con el resultado de la operación
     */
    public function updateItems(
        string            $collectionId,
        array             $ids,
        ?array            $embeddings = null,
        ?array            $metadatas = null,
        null|array|string $documents = null
    ): array
    {
        try {
            // Validación básica
            if (empty($ids)) {
                return [
                    'status' => false,
                    'error' => true,
                    'message' => 'IDs array cannot be empty',
                    'collection_id' => $collectionId
                ];
            }

            // Validar que al menos hay un campo para actualizar
            if (empty($embeddings) && empty($metadatas) && empty($documents)) {
                return [
                    'status' => false,
                    'error' => true,
                    'message' => 'At least one of embeddings, metadatas, or documents must be provided',
                    'collection_id' => $collectionId
                ];
            }

            // Construir el cuerpo de la petición
            $data = array_filter([
                'ids' => $ids,
                'embeddings' => $embeddings,
                'metadatas' => $metadatas,
                'documents' => $documents
            ]);

            $result = $this->makeRequest(
                endpoint: "collections/{$collectionId}/update",
                method: 'POST',
                data: $data
            );

            if ($result['status'] >= 200 && $result['status'] < 300) {
                return [
                    'status' => true,
                    'error' => false,
                    'message' => "Items updated successfully",
                    'collection_id' => $collectionId,
                    'items_updated' => count($ids),
                    'details' => $result
                ];
            } else {
                return [
                    'status' => false,
                    'error' => true,
                    'message' => "Failed to update items",
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
     * Guardar items es un metodo que inserta o actualiza items en una colección (upsert)
     * Características principales:
     *      - Validación de IDs requeridos
     *      - Validación de al menos un campo para insertar/actualizar
     *      - Soporte para documentos, metadatos y embeddings
     *      - Información detallada en la respuesta
     *      - Manejo de errores consistente con el resto de la API
     *      - Contador de items afectados
     *      - Flexibilidad para hacer upsert con diferentes combinaciones de campos
     * La diferencia principal con updateItems es que upsertItems:
     *      - Creará nuevos items si los IDs no existen
     *      - Actualizará items existentes si los IDs ya existen
     *      - Es más flexible para operaciones donde no estamos seguros si los items existen
     * @param string $collectionId ID de la colección
     * @param array $ids IDs de los items
     * @param array|null $embeddings Embeddings para los items (opcional)
     * @param array|null $metadatas Metadatos para los items (opcional)
     * @param array|string|null $documents Documentos para los items (opcional)
     * @return array Retorna un array con el resultado de la operación
     */
    public function saveItems(
        string            $collectionId,
        array             $ids,
        ?array            $embeddings = null,
        ?array            $metadatas = null,
        null|array|string $documents = null
    ): array
    {
        try {
            // Validación básica
            if (empty($ids)) {
                return [
                    'status' => false,
                    'error' => true,
                    'message' => 'IDs array cannot be empty',
                    'collection_id' => $collectionId
                ];
            }
            // Validar dimensiones consistentes para embeddings
            if ($embeddings && !$this->validateEmbeddingsDimensions($embeddings)) {
                return(array(
                    'status' => false,
                    'error' => true,
                    'message' => 'All embeddings must have the same number of dimensions'
                ));
            }
            // Validar que los arrays opcionales tengan la misma longitud que $ids si están presentes
            if (($documents !== null && count($documents) !== count($ids)) ||
                ($metadatas !== null && count($metadatas) !== count($ids)) ||
                ($embeddings !== null && count($embeddings) !== count($ids))) {
                return [
                    'status' => false,
                    'error' => true,
                    'message' => 'All provided arrays (documents, metadatas, embeddings) must have the same length as ids array'
                ];
            }
            // Validar que al menos hay un campo para insertar/actualizar
            if (empty($embeddings) && empty($metadatas) && empty($documents)) {
                return [
                    'status' => false,
                    'error' => true,
                    'message' => 'At least one of embeddings, metadatas, or documents must be provided',
                    'collection_id' => $collectionId
                ];
            }

            // Construir el cuerpo de la petición
            $data = array_filter([
                'ids' => $ids,
                'embeddings' => $embeddings,
                'metadatas' => $metadatas,
                'documents' => $documents
            ]);

            $result = $this->makeRequest(
                endpoint: "collections/{$collectionId}/upsert",
                method: 'POST',
                data: $data
            );

            if ($result['status'] >= 200 && $result['status'] < 300) {
                return [
                    'status' => true,
                    'error' => false,
                    'message' => "Items upserted successfully",
                    'collection_id' => $collectionId,
                    'items_affected' => count($ids),
                    'details' => $result
                ];
            } else {
                return [
                    'status' => false,
                    'error' => true,
                    'message' => "Failed to upsert items",
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
     * Crea una nueva base de datos
     * Características principales:
     *      - Validación básica del nombre de la base de datos
     *      - Soporte opcional para tenants
     *      - Manejo consistente de errores
     *      - Respuesta estructurada con toda la información relevante
     *      - Sigue el mismo patrón de respuesta que otros métodos de la API
     *      - Incluye detalles completos de la respuesta del servidor
     * @param string $name Nombre de la base de datos
     * @param string|null $tenant Nombre del tenant (opcional)
     * @return array Retorna un array con el resultado de la operación
     */
    public function createDatabase(
        string  $name,
        ?string $tenant = null
    ): array
    {
        try {
            // Validación básica del nombre
            if (empty($name)) {
                return [
                    'status' => false,
                    'error' => true,
                    'message' => 'Database name cannot be empty'
                ];
            }

            // Construir el cuerpo de la petición
            $data = array_filter([
                'name' => $name,
                'tenant' => $tenant
            ]);

            $result = $this->makeRequest(
                endpoint: "databases",
                method: 'POST',
                data: $data
            );

            if ($result['status'] >= 200 && $result['status'] < 300) {
                return [
                    'status' => true,
                    'error' => false,
                    'message' => "Database created successfully",
                    'database_name' => $name,
                    'tenant' => $tenant,
                    'details' => $result
                ];
            } else {
                return [
                    'status' => false,
                    'error' => true,
                    'message' => "Failed to create database",
                    'database_name' => $name,
                    'tenant' => $tenant,
                    'details' => $result
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => false,
                'error' => true,
                'message' => $e->getMessage(),
                'database_name' => $name,
                'tenant' => $tenant
            ];
        }
    }

    /**
     * Obtiene información de una base de datos específica
     *
     * @param string $name Nombre de la base de datos
     * @param string|null $tenant Nombre del tenant (opcional)
     * @return array Retorna un array con la información de la base de datos o un array con el error
     */
    public function getDatabase(string $name, ?string $tenant = null): array
    {
        try {
            $data = array_filter([
                'tenant' => $tenant
            ]);

            $result = $this->makeRequest(
                endpoint: "databases/{$name}",
                method: 'GET',
                data: $data
            );

            if ($result['status'] >= 200 && $result['status'] < 300) {
                return [
                    'status' => true,
                    'error' => false,
                    'database_name' => $name,
                    'tenant' => $tenant,
                    'message' => "Database retrieved successfully",
                    'details' => $result
                ];
            } else {
                return [
                    'status' => false,
                    'error' => true,
                    'database_name' => $name,
                    'tenant' => $tenant,
                    'message' => "Failed to retrieve database",
                    'details' => $result
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => false,
                'error' => true,
                'database_name' => $name,
                'tenant' => $tenant,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Elimina una base de datos específica
     *
     * @param string $name Nombre de la base de datos a eliminar
     * @param string|null $tenant Nombre del tenant (opcional)
     * @return array Retorna un array con el resultado de la operación
     */
    public function deleteDatabase(string $name, ?string $tenant = null): array
    {
        try {
            // Validación básica del nombre
            if (empty($name)) {
                return [
                    'status' => false,
                    'error' => true,
                    'message' => 'Database name cannot be empty'
                ];
            }

            $data = array_filter([
                'tenant' => $tenant
            ]);

            $result = $this->makeRequest(
                endpoint: "databases/{$name}",
                method: 'DELETE',
                data: $data
            );

            if ($result['status'] >= 200 && $result['status'] < 300) {
                return [
                    'status' => true,
                    'error' => false,
                    'message' => "Database deleted successfully",
                    'database_name' => $name,
                    'tenant' => $tenant,
                    'details' => $result
                ];
            } else {
                return [
                    'status' => false,
                    'error' => true,
                    'message' => "Failed to delete database",
                    'database_name' => $name,
                    'tenant' => $tenant,
                    'details' => $result
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => false,
                'error' => true,
                'message' => $e->getMessage(),
                'database_name' => $name,
                'tenant' => $tenant
            ];
        }
    }
}

?>