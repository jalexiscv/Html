<?php
$periodos = PERIODS;
?>
<div class="modal fade" id="modal-grade-history" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="myModalLabel">Historial Académico</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="get" target="_blank" action="/sie/documents/certificate/history?t=<?= $oid ?? '' ?>">
                    <input type="hidden" name="lpk" value="<?= lpk() ?>">
                    <div class="mb-3">
                        <label for="enrollment" class="form-label">Matricula</label>
                        <input type="text" class="form-control readonly" id="enrollment" name="enrollment"
                               value="<?= $oid ?? '' ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <div class="alert alert-info" role="alert">
                            <strong>Nota:</strong> Este certificado consolida los periodos académicos con registros del
                            estudiante.
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