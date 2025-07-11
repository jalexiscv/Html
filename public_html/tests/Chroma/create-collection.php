<?php
require_once 'Libraries/ChromaDB/ChromaDB.php';

use App\Libraries\ChromaDB\ChromaDB;

$confirmation = $_POST['confirm'] ?? null;
$collectionName = $_POST['collection_name'] ?? null;
$chroma = new ChromaDB();

if ($confirmation !== 'yes') {
    // Mostrar formulario de creación
    ?>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Crear Nueva Colección</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="?option=create-collection">
                            <div class="mb-3">
                                <label for="collection_name" class="form-label">Nombre de la Colección</label>
                                <input type="text" class="form-control" id="collection_name" name="collection_name" required
                                       placeholder="Ingrese el nombre de la colección">
                            </div>
                            <div class="d-flex gap-2">
                                <input type="hidden" name="confirm" value="yes">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-plus-circle-fill me-1"></i>
                                    Crear Colección
                                </button>
                                <a href="index.php" class="btn btn-secondary">
                                    <i class="bi bi-x-circle-fill me-1"></i>
                                    Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    exit;
}

// Si llegamos aquí, el usuario confirmó la creación
if (empty($collectionName)) {
    header('Location: index.php?error=' . urlencode('El nombre de la colección es requerido'));
    exit;
}

try {
    $result = $chroma->createCollection($collectionName);
    if ($result['status']) {
        header('Location: index.php?collection=' . urlencode($collectionName) . '&success=created');
    } else {
        header('Location: index.php?error=' . urlencode($result['message']));
    }
} catch (Exception $e) {
    header('Location: index.php?error=' . urlencode($e->getMessage()));
}
exit;
?>