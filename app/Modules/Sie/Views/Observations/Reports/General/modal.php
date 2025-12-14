<?php if ($modal) { ?>
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="myModalLabel">Periodo & Tipo de Observaciones</h1>
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
                            <label for="option" class="form-label">Tipo de Observaciones</label>
                            <select class="form-select" id="option" name="option" required>
                                <option value="ALL">Todas</option>
                                <?php foreach (LIST_TYPES_OBSERVATIONS as $o): ?>
                                    <?php $value = @$o['value']; ?>
                                    <?php $label = @$o['label']; ?>
                                    <option value="<?= $value ?>"><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Consultar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>