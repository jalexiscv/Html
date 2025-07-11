<?php
require_once 'Libraries/ChromaDB/ChromaDB.php';

use App\Libraries\ChromaDB\ChromaDB;

$selectedCollection = $_GET['collection'] ?? null;
$confirmation = $_GET['confirm'] ?? null;
$chroma = new ChromaDB();

if (!$selectedCollection) {
    header('Location: index.php');
    exit;
}

if ($confirmation !== 'yes') {
    // Mostrar página de confirmación
    ?>
        <div class="container mt-5">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title">¿Está seguro que desea eliminar la colección "<?php echo htmlspecialchars($selectedCollection); ?>"?</h3>
                    <p class="card-text text-danger">Esta acción no se puede deshacer.</p>
                    <div class="mt-4">
                        <a href="delete-collection.php?collection=<?php echo urlencode($selectedCollection); ?>&confirm=yes" class="btn btn-danger">Sí, Eliminar</a>
                        <a href="?collection=<?php echo($selectedCollection);?>" class="btn btn-secondary ms-2">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>

    <?php
    exit;
}

// Si llegamos aquí, el usuario confirmó la eliminación
try {
    $chroma->deleteCollection($selectedCollection);
    header('Location: index.php?success=deleted'); 
} catch (Exception $e) {
    header('Location: index.php?error=' . urlencode($e->getMessage()));
}
exit;
?>