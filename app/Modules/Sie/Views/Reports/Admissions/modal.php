<?php if ($modal) { ?>
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="myModalLabel"> Admitidos</h1>
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
                            </select></div>
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
                            <label for="status" class="form-label">Estado</label>
                            <input type="text" name="statusX" value="Admitidos / Admitidos por Reingreso / Admitidos por Homologación"
                                   class="form-control" id="statusX" readonly>
                        </div>
                        <div class="mb-3">
                            <div class="alert alert-primary" role="alert">
                                Este reporte solo incluye estudiantes admitidos, admitidos por reingreso y admitidos por homologación en el periodo académico
                                indicado, con
                                el objetivo de hacer seguimiento al proceso.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Consultar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>