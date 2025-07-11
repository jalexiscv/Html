<?php
require_once 'Libraries/ChromaDB/ChromaDB.php';

use App\Libraries\ChromaDB\ChromaDB;

$selectedCollection = $_GET['collection'] ?? null;

$chroma = new ChromaDB();

if ($selectedCollection) {
    $collectionData = $chroma->getCollection($selectedCollection);
    //print_r($collectionData);

    if ($collectionData['status'] && isset($collectionData['details']['response'])) {
        $collection = $collectionData['details']['response'];
        
        // Obtener el conteo de items
        if (isset($collection['id'])) {
            $items = $chroma->getItems(
                collectionId: $collection['id'],
                ids: [],
                include: ['documents']
            );
            $itemCount = isset($items['details']['response']) ? count($items['details']['response']) : 0;
        }
    }
}
?>

<?php if ($selectedCollection && isset($collectionData['status']) && $collectionData['status']): ?>
    <div id="collection" class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Colección: <?php echo htmlspecialchars($selectedCollection); ?></h4>
            <div class="header-actions">
                <a href="index.php?collection=<?php echo urlencode($selectedCollection); ?>&option=delete-collection" class="btn btn-sm btn-outline-danger" title="Eliminar">
                    <i class="fa-regular fa-trash"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if (isset($collection)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered m-0">
                        <tbody>
                            <tr>
                                <th style="width: 200px;">Nombre</th>
                                <td><?php echo htmlspecialchars($collection['name']); ?></td>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <td><?php echo htmlspecialchars($collection['id']); ?></td>
                            </tr>
                            <tr>
                                <th>Número de Items</th>
                                <td><?php echo isset($itemCount) ? number_format($itemCount) : 'N/A'; ?></td>
                            </tr>
                            <tr>
                                <th>Metadata</th>
                                <td>
                                    <?php 
                                    if (isset($collection['metadata']) && !empty($collection['metadata'])) {
                                        echo '<pre class="mb-0">' . htmlspecialchars(json_encode($collection['metadata'], JSON_PRETTY_PRINT)) . '</pre>';
                                    } else {
                                        echo '<span class="text-muted">Sin metadatos</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    No se encontraron detalles para esta colección.
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning">
        <?php if (!$selectedCollection): ?>
            Por favor, seleccione una colección del menú.
        <?php else: ?>
            Error al cargar la colección: <?php echo htmlspecialchars($collectionData['message'] ?? 'Error desconocido'); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
