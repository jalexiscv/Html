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

?>

<?php if ($modal) { ?>
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="myModalLabel">Selecciona Periodo y Programa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="get">
                        <div class="mb-3">
                            <label for="period" class="form-label">Periodo Académico</label>
                            <select class="form-select" id="period" name="period" required>
                                <?php foreach ($periodos as $p): ?>
                                    <option value="<?= $p ?>"><?= $p ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="program" class="form-label">Programa Académico</label>
                            <select class="form-select" id="program" name="program" required>
                                <?php foreach ($programs as $program) { ?>
                                    <option value="<?php echo(@$program['value']); ?>"><?php echo(@$program['label']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Consultar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (!$modal) { ?>
    <?php include("table.php"); ?>
<?php } ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var myModal = new bootstrap.Modal(document.getElementById('myModal'));
    myModal.show();
</script>