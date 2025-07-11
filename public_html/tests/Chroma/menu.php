<?php
require_once 'Libraries/ChromaDB/ChromaDB.php';

use App\Libraries\ChromaDB\ChromaDB;

$chroma = new ChromaDB();
$collections = $chroma->listCollections();
?>
<ul class="nav nav-pills flex-column mb-auto">
    <?php if ($collections['status'] && isset($collections['details']['response'])): ?>
        <?php foreach ($collections['details']['response'] as $collection): ?>
            <li class="nav-item">
                <a class="nav-link btn-link <?php echo ($selectedCollection === $collection['name']) ? 'active' : ''; ?>"
                   href="?collection=<?php echo urlencode($collection['name']); ?>">
                    <?php echo htmlspecialchars($collection['name']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li class="nav-item">
            <span class="nav-link text-muted">No hay colecciones disponibles</span>
        </li>
    <?php endif; ?>
    <li class="nav-item mt-3">
        <a class="btn btn-secondary w-100 d-flex align-items-center justify-content-center gap-2" href="?option=create-collection">
            <i class="bi bi-plus-circle-fill bg-secondary"></i>
            Crear colección
        </a>
    </li>
</ul>
