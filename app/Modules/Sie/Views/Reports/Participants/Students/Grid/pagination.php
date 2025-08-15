<?php
/** @var int $limit viene desde grid.php */
/** @var int $page viene desde grid.php */
/** @var int $totalRecords viene desde table.php */

// Obtener el total de registros (esto dependerá de tu consulta específica)
//$totalRecords = 2000; // Debes implementar este método
$totalPages = ceil($totalRecords / $limit);
// URL base para la paginación (ajusta según tu estructura de URLs)
$baseUrl = '?'; // Agrega aquí tus otros parámetros GET si los hay
foreach ($_GET as $key => $value) {
    if ($key != 'page') {
        $baseUrl .= $key . '=' . $value . '&';
    }
}


function generatePaginationLinks($currentPage, $totalPages, $baseUrl)
{
    $links = '';

    // Botón Previous
    $prevClass = ($currentPage <= 1) ? ' disabled' : '';
    $links .= '
        <li class="page-item' . $prevClass . '">
            <a class="page-link" href="' . $baseUrl . '&page=' . ($currentPage - 1) . '" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>';

    // Páginas numeradas
    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($currentPage == $i) ? ' active' : '';
        $links .= '
            <li class="page-item' . $activeClass . '">
                <a class="page-link" href="' . $baseUrl . '&page=' . $i . '">' . $i . '</a>
            </li>';
    }

    // Botón Next
    $nextClass = ($currentPage >= $totalPages) ? ' disabled' : '';
    $links .= '
        <li class="page-item' . $nextClass . '">
            <a class="page-link" href="' . $baseUrl . '&page=' . ($currentPage + 1) . '" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>';

    return $links;
}

?>
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center mb-0">
        <?php echo generatePaginationLinks($page, $totalPages, $baseUrl); ?>
        <li class="page-item">
            <a id="btn-excel" class="page-link" href="#">Excel</a>
        </li>
    </ul>
</nav>