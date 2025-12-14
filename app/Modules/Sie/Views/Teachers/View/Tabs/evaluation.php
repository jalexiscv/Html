<?php
$mqualifications = model("App\Modules\Sie\Models\Sie_Qualifications");
$mevaluations = model("App\Modules\Sie\Models\Sie_Evaluations");
$mpsychometrics = model("App\Modules\Sie\Models\Sie_Psychometrics");
$mattachments = model("App\Modules\Storage\Models\Storage_Attachments");
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');

$qualification = $mqualifications->get_LastQualificationByTeacher($oid);
$evaluations = $mevaluations->where("teacher", $oid)->findAll();
$psychometric = $mpsychometrics->get_PsychometricByTeacher($oid);
$attachments = $mattachments->get_AttachmentByObject(@$psychometric['psychometric']);

$ppe = round((40 / 27), 2);

$r1 = @$qualification["score"];

$weighting = (@$qualification["weighting"] * 100) . "%";


$q = array(
        array("question" => "q1", "label" => "Coherencia título del proyecto con Módulo elegido."),
        array("question" => "q2", "label" => "Coherencia del objetivo general, con el título del proyecto."),
        array("question" => "q3", "label" => "Desarrollo objetivo general, con objetivos específicos postulados."),
        array("question" => "q4", "label" => "Lista de actividades, en relación con logro objetivos específicos."),
        array("question" => "q5", "label" => "Metas proyecto alineados con módulo elegido para proyecto."),
        array("question" => "q6", "label" => "Coherencia de la propuesta de evaluación del proyecto."),
        array("question" => "q7", "label" => "Actividades de participación estudiantes en proyecto."),
        array("question" => "q8", "label" => "Desarrollo de la presentación, para avanzar aspectos claves del proyecto."),
        array("question" => "q9", "label" => "Medios usados para presentación y sustentación de utilidad."),
);

?>
<div class="container p-0">

    <div class="row p-3">
        <div class="col-12">
            <table class="table table-bordered p-0 m-0 py-0">
                <tr>
                    <td colspan="2" class="bg-light">1. Revisión de habilitación legal y académica [<a
                                href="/sie/qualifications/create/<?php echo($oid); ?>" target="_blank">+</a>]
                    </td>
                </tr>
                <tr>
                    <td class="text-center" width="50%">Puntaje</td>
                    <td class="text-center" width="50%">Ponderación</td>
                </tr>
                <tr>
                    <td class="text-center"><?php echo($r1); ?></td>
                    <td class="text-center"><?php echo($r1); ?>/50</td>
                </tr>
                <tr>
                    <td class="text-end" colspan="2"> Puntaje: <?php echo($r1); ?>  </td>
                </tr>
            </table>
        </div>
    </div>
    <?php $r2 = 0; ?>
    <div class="row p-3">
        <div class="col-12">
            <?php if ($evaluations) { ?>
                <table class="table table-bordered p-0 m-0 py-0">
                    <tr>
                        <td colspan="10" class="bg-light">
                            2. Evaluación de proyecto escrito [<a href="/sie/evaluations/create/<?php echo($oid); ?>"
                                                                  target="_blank">+</a>]
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">Evaluador</td>
                        <td class="text-center">Q1</td>
                        <td class="text-center">Q2</td>
                        <td class="text-center">Q3</td>
                        <td class="text-center">Q4</td>
                        <td class="text-center">Q5</td>
                        <td class="text-center">Q6</td>
                        <td class="text-center">Q7</td>
                        <td class="text-center">Q8</td>
                        <td class="text-center">Q9</td>
                    </tr>
                    <?php $r2 = 0; ?>
                    <?php $count = 0; ?>
                    <?php foreach ($evaluations as $evaluation) { ?>
                        <?php
                        $alias = $mfields->get_AliasByUser($evaluation['author']);
                        $r2 += ($evaluation['q1'] == "Y") ? 1 : 0;
                        $r2 += ($evaluation['q2'] == "Y") ? 1 : 0;
                        $r2 += ($evaluation['q3'] == "Y") ? 1 : 0;
                        $r2 += ($evaluation['q4'] == "Y") ? 1 : 0;
                        $r2 += ($evaluation['q5'] == "Y") ? 1 : 0;
                        $r2 += ($evaluation['q6'] == "Y") ? 1 : 0;
                        $r2 += ($evaluation['q7'] == "Y") ? 1 : 0;
                        $r2 += ($evaluation['q8'] == "Y") ? 1 : 0;
                        $r2 += ($evaluation['q9'] == "Y") ? 1 : 0;
                        //if($alias=="") {
                        //$count++;
                        //}
                        ?>
                        <tr>
                            <td class="text-center">@<?php echo($alias); ?></td>
                            <td class="text-center"><?php echo(($evaluation['q1'] == "Y") ? "Si" : "No"); ?></td>
                            <td class="text-center"><?php echo(($evaluation['q2'] == "Y") ? "Si" : "No"); ?></td>
                            <td class="text-center"><?php echo(($evaluation['q3'] == "Y") ? "Si" : "No"); ?></td>
                            <td class="text-center"><?php echo(($evaluation['q4'] == "Y") ? "Si" : "No"); ?></td>
                            <td class="text-center"><?php echo(($evaluation['q5'] == "Y") ? "Si" : "No"); ?></td>
                            <td class="text-center"><?php echo(($evaluation['q6'] == "Y") ? "Si" : "No"); ?></td>
                            <td class="text-center"><?php echo(($evaluation['q7'] == "Y") ? "Si" : "No"); ?></td>
                            <td class="text-center"><?php echo(($evaluation['q8'] == "Y") ? "Si" : "No"); ?></td>
                            <td class="text-center"><?php echo(($evaluation['q9'] == "Y") ? "Si" : "No"); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td class="text-end" colspan="10"> Puntaje: <?php echo($r2 * $ppe); ?>  </td>
                    </tr>
                </table>
                <?php $r2 = $r2 * $ppe; ?>
            <?php } else { ?>
                <div class="alert alert-warning" role="alert">
                    No hay evaluaciones registradas, por favor
                    <a href="/sie/evaluations/create/<?php echo($oid); ?>" target="_blank">registre una evaluación</a>.
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="row p-3">
        <?php $r3 = round((@$psychometric['fulfilled'] == "Y") ? "10" : "0", 2); ?>
        <div class="col-12">
            <table class="table table-bordered p-0 m-0 py-0">
                <tr>
                    <td colspan="4" class="bg-light">3. Test tipo DISC de evaluación Psicométrica [<a
                                href="/sie/psychometrics/create/<?php echo($oid); ?>" target="_blank">+</a>]
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="m-0">
                            <a href="<?php echo(cdn_url(@$attachments['file'])); ?>" target="_blank">Resultado
                                DISC <?php echo(@$attachments['attachment']); ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="mb-3">
                            <label for="formTextarea" class="form-label">Área de texto</label>
                            <div class="form-control" id="formTextarea" name="textarea" rows="3">
                                <?php echo(@$psychometric['comments']); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-center" width="25%">Cumple</td>
                    <td class="text-center"
                        width="25%"><?php echo((@$psychometric['fulfilled']) == "Y" ? "Si" : "No"); ?></td>
                    <td class="text-center" width="25%">Puntaje</td>
                    <td class="text-center"
                        width="25%"><?php echo((@$psychometric['fulfilled'] == "Y") ? "10" : "0") ?></td>
                </tr>
                <tr>
                    <td class="text-end" colspan="10"> Puntaje: <?php echo($r3); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row p-3">
        <div class="col-12">
            <table class="table table-bordered p-0 m-0 py-0">
                <tr>
                    <td class="text-center">Total: <?php echo(@$r1 + @$r2 + @$r3); ?></td>
                </tr>
            </table>
        </div>
    </div>
    ccccccc
</div>