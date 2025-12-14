<!-- Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Cambiar Estado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="statusForm">
                    <div class="mb-3">
                        <label for="status_type" class="form-label">Estado</label>
                        <select class="form-select" id="status_type" required>
                            <option value="">Seleccione un estado</option>
                            <?php foreach (LIST_STATUSES as $status) { ?>
                                <option value="<?php echo($status['value']); ?>"><?php echo($status['label']); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-8">
                            <label for="status_program" class="form-label">Programa Academico</label>
                            <select class="form-select" id="status_program" required>
                                <option value="">Seleccione un programa</option>
                                <?php foreach ($programs as $program) { ?>
                                    <option value="<?php echo($program['value']); ?>"><?php echo($program['label']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="status_period" class="form-label">Periodo</label>
                            <select class="form-select" id="status_period" required>
                                <option value="">Seleccione un periodo</option>
                                <?php foreach (LIST_PERIODS as $period) { ?>
                                    <option value="<?php echo($period['value']); ?>"><?php echo($period['label']); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>
                    <div id="adds" class="row mb-3">
                        <div class="col-6">
                            <label for="status_moment" class="form-label">Momento</label>
                            <select class="form-select" id="status_moment" required>
                                <option value="">Seleccione el momento</option>
                                <?php foreach (LIST_MOMENTS as $moment) { ?>
                                    <option value="<?php echo($moment['value']); ?>"><?php echo($moment['label']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="status_cycle" class="form-label">Ciclo</label>
                            <select class="form-select" id="status_cycle" required>
                                <option value="">Seleccione el ciclo</option>
                                <?php foreach (LIST_CYCLES as $cycle) { ?>
                                    <option value="<?php echo($cycle['value']); ?>"><?php echo($cycle['label']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 align-content-end">
                        <label for="observationTextarea" class="form-label">Observación</label>
                        <textarea class="form-control" id="status_observation" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary float-right" id="submitButton" disabled>Actualizar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>



<style>
    .status-title {
        background-color: #000000;
        padding: 10px;
        font-size: 1rem;
        color: #ffffff;
        text-align: center;
        font-weight: bold;
    }
</style>