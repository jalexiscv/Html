<?php
require_once 'Libraries/ChromaDB/ChromaDB.php';

use App\Libraries\ChromaDB\ChromaDB;

$selectedCollection = $_GET['collection'] ?? null;
$item = $_GET['item'] ?? null;
$confirmation = $_GET['confirm'] ?? null;
$chroma = new ChromaDB();

if (!$selectedCollection || !$item) {
    header('Location: index.php');
    exit;
}

if ($confirmation !== 'yes') {
    // Mostrar página de confirmación
    ?>
        <div class="container mt-5">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title">¿Está seguro que desea eliminar el item "<?php echo htmlspecialchars($item); ?>"?</h3>
                    <p class="card-text text-danger">Esta acción no se puede deshacer.</p>
                    <div class="mt-4">
                        <a href="?collection=<?php echo urlencode($selectedCollection); ?>&option=delete-item&item=<?php echo urlencode($item); ?>&confirm=yes" class="btn btn-danger">Sí, Eliminar</a>
                        <a href="?collection=<?php echo urlencode($selectedCollection); ?>" class="btn btn-secondary ms-2">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    <?php
    exit;
}

// Si llegamos aquí, el usuario confirmó la eliminación
try {
    // Primero obtenemos el ID de la colección
    $collectionInfo = $chroma->getCollection($selectedCollection);
    if (!$collectionInfo['status']) {
        header('Location: index.php?collection=' . urlencode($selectedCollection) . '&error=' . urlencode('No se pudo encontrar la colección'));
        exit;
    }

    // Ahora intentamos eliminar el item usando el ID de la colección
    $result = $chroma->deleteItems($collectionInfo['id'], [$item]);
    print_r($result);
    if ($result['status']) {
        header('Location: index.php?collection=' . urlencode($selectedCollection) . '&success=deleted');
    } else {
        header('Location: index.php?collection=' . urlencode($selectedCollection) . '&error=' . urlencode($result['message']));
    }
} catch (Exception $e) {
    header('Location: index.php?collection=' . urlencode($selectedCollection) . '&error=' . urlencode($e->getMessage()));
} 
exit;
?>