<?php
require_once 'Libraries/ChromaDB/ChromaDB.php';
require_once 'Libraries/Embeddings/EmbeddingGenerator.php';

use App\Libraries\ChromaDB\ChromaDB;
use App\Libraries\Embeddings\EmbeddingGenerator;

// Cargar configuración
$config = require 'config.php';
$embedder = new EmbeddingGenerator($config['google_palm_api_key']);

$selectedCollection = $_GET['collection'] ?? null;
$option = $_GET['option'] ?? null;

$chroma = new ChromaDB();

if (!$selectedCollection) {
    die('Error: No se especificó una colección');
}

// Verificar si la colección existe y obtener su ID
$collectionResult = $chroma->getCollection($selectedCollection);
if (!$collectionResult['status']) {
    // Si la colección no existe, intentamos crearla
    $createResult = $chroma->createCollection($selectedCollection, true);
    if (!$createResult['status']) {
        die('Error: No se pudo acceder o crear la colección');
    }
    // Obtenemos el ID de la colección recién creada
    $collectionResult = $chroma->getCollection($selectedCollection);
    if (!$collectionResult['status']) {
        die('Error: No se pudo obtener el ID de la colección');
    }
}

// Guardar el ID de la colección
$collectionId = $collectionResult['id'];

$error = null;
$success = null;

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $option === 'add') {
    $document = $_POST['document'] ?? '';
    $metadata = $_POST['metadata'] ?? '';
    
    if (!empty($document)) {
        try {
            $metadataArray = !empty($metadata) ? json_decode($metadata, true) : [];
            if ($metadata && json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Error en el formato JSON de los metadatos");
            }
            
            // Generar embedding para el documento
            $embedding = $embedder->generateEmbedding($document);
            error_log("Generated embedding: " . json_encode($embedding, JSON_PRETTY_PRINT));
            
            if (!$embedding) {
                throw new Exception("No se pudo generar el embedding para el documento");
            }
            
            $id = uniqid(); // Generamos un ID único para el documento
            
            // Preparar los datos para addItems
            $params = [
                'collectionId' => $collectionId,
                'ids' => [$id],
                'documents' => [$document],
                'metadatas' => $metadataArray !== null ? [$metadataArray] : null,
                'embeddings' => [$embedding]
            ];
            
            error_log("Adding item with params: " . json_encode($params, JSON_PRETTY_PRINT));
            
            // Agregar el documento a la colección
            $result = $chroma->addItems(...$params);
            
            error_log("Add result: " . json_encode($result, JSON_PRETTY_PRINT));
            
            if ($result['status']) {
                $success = "Documento agregado exitosamente";
                error_log("Document added successfully. ID: $id");
            } else {
                throw new Exception("Error al agregar el documento: " . ($result['message'] ?? 'Error desconocido'));
            }
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
            error_log("Error adding document: " . $e->getMessage());
        }
    }
}
?>

        <h2>Agregar Documento a <?php echo htmlspecialchars($selectedCollection); ?></h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?collection=<?php echo urlencode($selectedCollection); ?>&option=add" class="mb-4">
            <div class="mb-3">
                <label for="document" class="form-label">Documento:</label>
                <textarea class="form-control" id="document" name="document" rows="4" required><?php echo isset($_POST['document']) ? htmlspecialchars($_POST['document']) : ''; ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="metadata" class="form-label">Metadata (JSON formato):</label>
                <textarea class="form-control" id="metadata" name="metadata" rows="2"><?php echo isset($_POST['metadata']) ? htmlspecialchars($_POST['metadata']) : ''; ?></textarea>
                <div class="form-text">Ejemplo: {"key": "value", "otra_key": "otro_valor"}</div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="index.php?collection=<?php echo urlencode($selectedCollection); ?>" class="btn btn-secondary">Volver a la Colección</a>
        </form>
    </div> 
