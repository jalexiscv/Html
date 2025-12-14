<?php if ($modal) { ?>
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="myModalLabel">Inscrito programas</h1>
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
                                <option value="ALL">Todos los programas</option>
                                <?php foreach ($programs as $program) { ?>
                                    <option value="<?php echo(@$program['value']); ?>"><?php echo(@$program['label']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="mb-3">
                                <div class="alert alert-primary" role="alert">
                                    Este reporte solo incluye estudiantes <b>Aprobado por psicología</b>, <b>Aprobado
                                        por psicología - Renovación</b>,
                                    <b>Aprobado por psicología - Reingreso</b> y <b>Aprobado por psicología -
                                        Homologación</b> en el periodo académico indicado, con
                                    el objetivo de hacer seguimiento al proceso.
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