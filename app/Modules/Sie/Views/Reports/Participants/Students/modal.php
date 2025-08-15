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
                            <label for="option" class="form-label">Criterio / Opción</label>
                            <input id="option" name="option" type="text" class="form-control"
                                   value="<?php echo(@$oid) ?>" readonly/>
                        </div>
                        <div class="mb-3">
                            <div class="mb-3">
                                <div class="alert alert-primary" role="alert">
                                    Este reporte solo incluye estudiantes <b>matriculados</b> y <b>matriculados
                                        antiguos</b>,
                                    en el periodo académico indicado, en los <b>ciclos 1</b>,<b>5</b>, y <b>7</b>.
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Consultar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>