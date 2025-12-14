<!-- Modal -->
<?php
//[models]--------------------------------------------------------------------------------------------------------------
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
//[vars]----------------------------------------------------------------------------------------------------------------
$enrollments = $menrollments->get_EnrollmentsByStudent($oid);
$listEnrollment = array();
foreach ($enrollments as $enrollment) {
    $program = $mprograms->getProgram($enrollment["program"]);
    $listEnrollment[] = array(
            "value" => @$enrollment["enrollment"],
            "label" => @$enrollment["enrollment"] . " - " . $program["name"],
    );
}

?>
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
                                <option value="<?php echo(@$status['value']); ?>"><?php echo(@$status['label']); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div id="zoneEnrollments" class="mb-3">
                        <label for="status_type" class="form-label">Matricula</label>
                        <select class="form-select" id="status_enrollment">
                            <option value="">Seleccione una matricula</option>
                            <?php foreach ($listEnrollment as $enrollment) { ?>
                                <option value="<?php echo(@$enrollment['value']); ?>"><?php echo(@$enrollment['label']); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div id="zonePrograms" class="row mb-3">
                        <div class="px-0 mx-0 mb-3 row">
                            <div class="col-12">
                                <label for="status_program" class="form-label">Programa Académico Institucional</label>
                                <select class="form-select" id="status_program" required>
                                    <option value="">Seleccione un programa</option>
                                    <?php foreach ($programs as $program) { ?>
                                        <option value="<?php echo($program['value']); ?>"><?php echo($program['label']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="px-0 mx-0 mb-3 row">
                            <div class="col-8">
                                <label for="status_grid" class="form-label">Malla Académica</label>
                                <select class="form-select" id="status_grid">
                                    <option value="">Seleccione una malla</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="status_version" class="form-label ">Versión</label>
                                <select class="form-select" id="status_version">
                                    <option value="">Seleccione una version</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="zoneAditionals" class="row mb-3">
                        <div class="col-4">
                            <label for="status_period" class="form-label">Periodo</label>
                            <select class="form-select" id="status_period" required>
                                <option value="">Seleccione un periodo</option>
                                <?php foreach (LIST_PERIODS as $period) { ?>
                                    <option value="<?php echo($period['value']); ?>"><?php echo($period['label']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="status_moment" class="form-label">Momento</label>
                            <select class="form-select" id="status_moment" required>
                                <option value="">Seleccione el momento</option>
                                <?php foreach (LIST_MOMENTS as $moment) { ?>
                                    <option value="<?php echo($moment['value']); ?>"><?php echo($moment['label']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="status_cycle" class="form-label">Ciclo</label>
                            <select class="form-select" id="status_cycle" required>
                                <option value="">Seleccione el ciclo</option>
                                <?php foreach (LIST_CYCLES as $cycle) { ?>
                                    <option value="<?php echo($cycle['value']); ?>"><?php echo($cycle['label']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div id="zoneExtra" class="row mb-3">
                        <div class="col-4">
                            <label for="status_journey" class="form-label">Jornada</label>
                            <select class="form-select" id="status_journey" required>
                                <option value="">Seleccione la jornada</option>
                                <?php foreach (LIST_JOURNEYS as $journey) { ?>
                                    <option value="<?php echo($journey['value']); ?>"><?php echo($journey['label']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div id="zoneDegree" class="row">
                        <div class="col-12">
                            <div class="mb-3 row">
                                <div class="col-4">
                                    <label for="degree_certificate" class="form-label">Acta de grado</label>
                                    <input type="text" class="form-control" id="degree_certificate"
                                           placeholder="Número del acta">
                                </div>
                                <div class="col-4">
                                    <label for="degree_folio" class="form-label">Número de folio</label>
                                    <input type="text" class="form-control" id="degree_folio"
                                           placeholder="Número del folio">
                                </div>
                                <div class="col-4">
                                    <label for="degree_date" class="form-label">Fecha de grado</label>
                                    <input type="date" class="form-control" id="degree_date"
                                           placeholder="Fecha de grado">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-4">
                                    <label for="degree_diploma" class="form-label">Diploma</label>
                                    <input type="text" class="form-control" id="degree_diploma"
                                           placeholder="#000X">
                                </div>
                                <div class="col-4">
                                    <label for="degree_book" class="form-label">Libro</label>
                                    <input type="text" class="form-control" id="degree_book"
                                           placeholder="#000X">
                                </div>
                                <div class="col-4">
                                    <label for="degree_resolution" class="form-label">Resolución</label>
                                    <input type="text" class="form-control" id="degree_resolution"
                                           placeholder="#000X">

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="mb-3 align-content-end">
                        <label for="status_observation" class="form-label">Observación</label>
                        <textarea class="form-control" id="status_observation" rows="3" required></textarea>
                    </div>
                    <button type="button" class="btn btn-primary float-right" id="submitButton" disabled>Actualizar
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