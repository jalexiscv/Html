<?php
require_once 'Libraries/ChromaDB/ChromaDB.php';

use App\Libraries\ChromaDB\ChromaDB;

$selectedCollection = $_GET['collection'] ?? null;

$chroma = new ChromaDB();

if ($selectedCollection) {
    $collectionData = $chroma->getCollection($selectedCollection);

    if ($collectionData['status'] &&
        isset($collectionData['details']['response']) &&
        isset($collectionData['details']['response']['id'])) {

        // Obtener el ID de la colección desde la respuesta
        $collectionId = $collectionData['details']['response']['id'];

        // Obtener todos los items de la colección usando el ID
        $items = $chroma->getItems(
            collectionId: $collectionId,
            ids: [],  // Array vacío para obtener todos los items
            include: ['documents', 'metadatas', 'embeddings']
        );
    }
}
?>
<div id="collection" class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Documentos(Items) de <?php echo htmlspecialchars($selectedCollection); ?></h4>
        <div class="header-actions">
            <a href="index.php?collection=<?php echo urlencode($selectedCollection); ?>&option=add"
               class="btn btn-sm btn-outline-primary mr-1" title="Agregar">
                <i class="fas fa-plus"></i>
            </a>
            <a href="index.php?collection=<?php echo urlencode($selectedCollection); ?>&option=search"
               class="btn btn-sm btn-outline-secondary mr-1" title="Consultar">
                <i class="fas fa-search"></i>
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if ($selectedCollection && isset($collectionData['status']) && $collectionData['status']): ?>
            <div class="table-responsive table-bordered m-0">
                <?php if (isset($items['status']) && $items['status'] && isset($items['items'])): ?>
                    <?php
                    $hasItems = !empty($items['items']['ids']) ||
                        !empty($items['items']['documents']) ||
                        !empty($items['items']['metadatas']) ||
                        !empty($items['items']['embeddings']);
                    ?>

                    <?php if ($hasItems): ?>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Documento</th>
                                <th>Metadatos</th>
                                <th>Embedding</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $totalItems = count($items['items']['ids'] ?? []);
                            for ($i = 0; $i < $totalItems; $i++):
                                ?>
                                <tr>
                                    <td><?php echo isset($items['items']['ids'][$i]) ? htmlspecialchars($items['items']['ids'][$i]) : 'N/A'; ?></td>
                                    <td>
                                        <?php
                                        if (isset($items['items']['documents'][$i])) {
                                            if (is_array($items['items']['documents'][$i])) {
                                                echo '<pre class="mb-0">' . htmlspecialchars(json_encode($items['items']['documents'][$i], JSON_PRETTY_PRINT)) . '</pre>';
                                            } else {
                                                echo htmlspecialchars((string)$items['items']['documents'][$i]);
                                            }
                                        } else {
                                            echo '<span class="text-muted">Sin documento</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($items['items']['metadatas'][$i]) && !empty($items['items']['metadatas'][$i])) {
                                            echo '<pre class="mb-0">' . htmlspecialchars(json_encode($items['items']['metadatas'][$i], JSON_PRETTY_PRINT)) . '</pre>';
                                        } else {
                                            echo '<span class="text-muted">Sin metadatos</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($items['items']['embeddings'][$i]) && !empty($items['items']['embeddings'][$i])) {
                                            $itemId = isset($items['items']['ids'][$i]) ? htmlspecialchars($items['items']['ids'][$i]) : 'item-' . $i;
                                            echo '<button class="btn btn-sm btn-outline-primary" 
                                              type="button" 
                                              data-bs-toggle="collapse" 
                                              data-bs-target="#embedding-' . $itemId . '">
                                              Ver embedding
                                              </button>';
                                            echo '<div class="collapse" id="embedding-' . $itemId . '">';
                                            echo '<pre class="mt-2 mb-0">' . htmlspecialchars(json_encode(array_slice($items['items']['embeddings'][$i], 0, 5))) . '...</pre>';
                                            echo '</div>';
                                        } else {
                                            echo '<span class="text-muted">Sin embedding</span>';
                                        }
                                        ?>
                                        <a href="index.php?collection=<?php echo urlencode($selectedCollection); ?>&option=delete-item&item=<?php echo($itemId);?>" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                           <i class="fa-regular fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-info">
                            No hay items en esta colección.
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-warning">
                        Error al cargar los
                        items: <?php echo htmlspecialchars($items['message'] ?? 'Error desconocido'); ?>
                    </div>
                <?php endif; ?>
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
    </div>
</div>
