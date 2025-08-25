<?php
$periodos = PERIODS;
?>
<div class="modal fade" id="modal-grade-certificate" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="myModalLabel">Certificado de Notas Formato Antiguo (Q10)</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="get" target="_blank" action="/sie/documents/certificate/grade?t=<?= $oid ?? '' ?>">
                    <input type="hidden" name="lpk" value="<?= lpk() ?>">
                    <div class="mb-3">
                        <label for="enrollment" class="form-label">Matricula</label>
                        <input type="text" class="form-control readonly" id="enrollment" name="enrollment"
                               value="<?= $oid ?? '' ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="period" class="form-label">Período Académico</label>
                        <select class="form-select" id="period" name="period" required>
                            <option value="">Seleccione un período</option>
                            <?php foreach ($periodos as $p): ?>
                                <option value="<?= $p ?>"><?= $p ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="alert alert-info" role="alert">
                            <strong>Nota:</strong> Este certificado utiliza el formato antiguo del sistema.
                            Para el formato estándar ISO, utilice la primera opción de la lista.
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Generar Certificado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>