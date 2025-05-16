<?php
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');

$programs = $mprograms->get_SelectData();


$periodos = ['2025A', '2024B', '2024A'];

$resultados = null; // Inicializa $resultados

$modal = true;
if (isset($_GET['period']) && isset($_GET['program'])) {
    $period = $_GET['period'];
    $program = $_GET['program'];
    $modal = false;
}

if (!$modal) {
    include("grid.php");
} else {
    include("modal.php");
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var myModal = new bootstrap.Modal(document.getElementById('myModal'));
    myModal.show();
</script>