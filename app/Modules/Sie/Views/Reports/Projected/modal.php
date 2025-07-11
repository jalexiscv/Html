<?php if ($modal) { ?>
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="myModalLabel">Cupos Proyectados</h1>
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
                            <div class="mb-3">
                                <div class="alert alert-primary" role="alert">
                                    Este reporte es solo un formato descargable para ser diligenciado, al cual puede
                                    acceder en la opción descarga.
                                </div>
                            </div>
                        </div>
                        <!-- close button -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <a href="/themes/assets/docs/sie/cupos_proyectados_y_matricula_esperada.xlsx" class="btn btn-primary">Descargar Formato</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>