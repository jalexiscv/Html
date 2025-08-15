<?php if ($modal) { ?>
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="myModalLabel"> Reporte General</h1>
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
                            <div class="alert alert-primary" role="alert">
                                <p class="m-0 p-0">Este reporte incluye estudiantes en los estados.</p>
                                <ol class="my-0 py-0">
                                    <li><b>Matriculado (Nuevo)</b></li>
                                    <li><b>Matriculado Antiguo</b></li>
                                    <li><b>Matriculado por Extensi&oacute;n</b></li>
                                </ol>
                                <p class="m-0 p-0">Para el periodo académico indicado, con el objetivo de hacer
                                    seguimiento al proceso y segun solicitud del área de estadística.</p>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Consultar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>