<?php
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');

$programs = $mprograms->get_SelectData();


$periodos = PERIODS;

$resultados = null; // Inicializa $resultados

$modal = true;
if (isset($_GET['period']) && isset($_GET['program'])) {
    $period = $_GET['period'];
    $program = $_GET['program'];
    $modal = false;
}

include("grid.php");

?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
