<?php
require_once 'Libraries/ChromaDB/ChromaDB.php';
require_once 'Libraries/Embeddings/EmbeddingGenerator.php';

use App\Libraries\ChromaDB\ChromaDB;
use App\Libraries\Embeddings\EmbeddingGenerator;

$config = require 'config.php';
$embedder = new EmbeddingGenerator($config['google_palm_api_key']);

$chroma = new ChromaDB();
$selectedCollection = $_GET['collection'] ?? null;

if (!$selectedCollection) {
    die('Error: No se especificó una colección');
}

// Verificar si la colección existe y obtener su ID
$collectionResult = $chroma->getCollection($selectedCollection);

// Debug detallado de la respuesta de getCollection
error_log("ChromaDB getCollection raw response: " . print_r($collectionResult, true));

if (!$collectionResult['status']) {
    // Si la colección no existe, intentamos crearla
    error_log("ChromaDB attempting to create collection: " . $selectedCollection);
    $createResult = $chroma->createCollection($selectedCollection, true);
    error_log("ChromaDB createCollection result: " . print_r($createResult, true));
    
    if (!$createResult['status']) {
        die('Error: No se pudo acceder o crear la colección. Detalles: ' . print_r($createResult, true));
    }
    // Obtenemos el ID de la colección recién creada
    $collectionResult = $chroma->getCollection($selectedCollection);
    error_log("ChromaDB getCollection after create - raw response: " . print_r($collectionResult, true));
}

// Verificar que tenemos una respuesta válida
if (!$collectionResult['status']) {
    die('Error: No se pudo obtener la información de la colección. Detalles: ' . print_r($collectionResult, true));
}

// Guardar el ID de la colección - ahora usando la ubicación correcta
$collectionId = $collectionResult['id'] ?? null;
error_log("ChromaDB collection ID obtained: " . ($collectionId ?? 'null'));

if (!$collectionId) {
    die('Error: No se pudo obtener el ID de la colección. Detalles: ' . print_r($collectionResult, true));
}

$searchResults = null;
$error = null;

// Procesar la búsqueda cuando se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchText = $_POST['search_text'] ?? '';
    $metadata = $_POST['metadata'] ?? '';
    $limit = intval($_POST['limit'] ?? 10);
    
    if (!empty($searchText)) {
        try {
            // Procesar metadatos si se proporcionaron
            $metadataFilter = null;
            if (!empty($metadata)) {
                $metadataArray = json_decode($metadata, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception("Error en el formato JSON de los metadatos");
                }
                // Convertir el formato de metadatos al formato esperado por ChromaDB
                // ChromaDB espera un solo operador $and que contenga todas las condiciones
                $conditions = [];
                foreach ($metadataArray as $key => $value) {
                    $conditions[] = [$key => ['$eq' => $value]];
                }
                if (!empty($conditions)) {
                    $metadataFilter = ['$and' => $conditions];
                }
            }
            
            // Debug de los parámetros de búsqueda
            error_log("ChromaDB search text: " . $searchText);
            error_log("ChromaDB metadata filter: " . json_encode($metadataFilter, JSON_PRETTY_PRINT));
            
            // Generar embedding para el texto de búsqueda
            $embedding = $embedder->generateEmbedding($searchText);
            error_log("Generated embedding for search: " . json_encode($embedding, JSON_PRETTY_PRINT));
            
            if (!$embedding) { 
                throw new Exception("No se pudo generar el embedding para el texto de búsqueda");
            } 
            //print_r($embedding);
            
            // Preparar los parámetros de búsqueda
            $queryParams = [
                'collectionId' => $collectionId,
                'queryEmbeddings' => [$embedding],
                'queryTexts' => [$searchText],
                'where' => $metadataFilter,
                'whereDocument' => null,
                'include' => ['documents', 'metadatas', 'distances'],
                'nResults' => $limit 
            ];
             
            // Debug de los parámetros
            error_log("ChromaDB query parameters: " . json_encode($queryParams, JSON_PRETTY_PRINT));
             
            // Realizar la búsqueda usando los parámetros preparados
            $result = $chroma->queryItems(...$queryParams);

            //print_r($result);
            
            // Agregar más detalles al log para depuración
            error_log("ChromaDB query response status: " . ($result['status'] ?? 'N/A'));
            error_log("ChromaDB query response details: " . json_encode($result['details'] ?? [], JSON_PRETTY_PRINT));
            
            if ($result['status']) {
                $searchResults = $result;
                error_log("ChromaDB query success: " . print_r($result, true));
            } else {
                $error = "Error en la búsqueda: " . ($result['message'] ?? 'Error desconocido');
                error_log("ChromaDB query error: " . print_r($result, true));
            }
        } catch (Exception $e) {
            $error = "Error al realizar la búsqueda: " . $e->getMessage();
            error_log("ChromaDB search exception: " . $e->getMessage() . "\nTrace: " . $e->getTraceAsString());
        }
    }
}
?>

<div class="container mt-4">
    <h2>Buscar en <?php echo htmlspecialchars($selectedCollection); ?></h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?collection=<?php echo urlencode($selectedCollection); ?>&option=search" class="mb-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="search_text" class="form-label">Texto a buscar:</label>
                <textarea class="form-control" id="search_text" name="search_text" rows="3" required><?php echo isset($_POST['search_text']) ? htmlspecialchars($_POST['search_text']) : ''; ?></textarea>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="metadata" class="form-label">Filtrar por metadata (JSON formato, opcional):</label>
                <textarea class="form-control" id="metadata" name="metadata" rows="3"><?php echo isset($_POST['metadata']) ? htmlspecialchars($_POST['metadata']) : ''; ?></textarea>
                <div class="form-text">Ejemplo: {"categoria": "importante"}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="limit" class="form-label">Número máximo de resultados:</label>
                <input type="number" class="form-control" id="limit" name="limit" value="<?php echo isset($_POST['limit']) ? intval($_POST['limit']) : 10; ?>" min="1" max="100">
            </div>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="index.php?collection=<?php echo urlencode($selectedCollection); ?>" class="btn btn-secondary">Volver a la Colección</a>
        </div>
    </form>

    <?php if ($searchResults && isset($searchResults['details']['response'])): ?>
        <h3>Resultados de la búsqueda</h3>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Documento</th>
                        <th>Metadata</th>
                        <th>Similitud</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $response = $searchResults['details']['response'];
                    $documents = $response['documents'][0] ?? [];
                    $metadatas = $response['metadatas'][0] ?? [];
                    $distances = $response['distances'][0] ?? [];
                    
                    for ($i = 0; $i < count($documents); $i++): 
                        $similarity = 1 - ($distances[$i] ?? 0); // Convertir distancia a similitud
                        $similarityPercentage = round($similarity * 100, 2);
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($documents[$i]); ?></td>
                            <td>
                                <?php if (isset($metadatas[$i])): ?>
                                    <pre class="mb-0"><code><?php echo htmlspecialchars(json_encode($metadatas[$i], JSON_PRETTY_PRINT)); ?></code></pre>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $similarityPercentage; ?>%</td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($error)): ?>
        <div class="alert alert-info">No se encontraron resultados para tu búsqueda.</div>
    <?php endif; ?>
</div>