<?php

use App\Libraries\Strings;

$strings = new Strings();
$mdp = model("App\Modules\Disa\Models\Disa_Plans");
$mds = model("App\Modules\Disa\Models\Disa_Statuses");
$mda = model('App\Modules\Disa\Models\Disa_Actions');
$musers = model('App\Modules\Disa\Models\Disa_Users');
$mfields = model('App\Modules\Disa\Models\Disa_Users_Fields');
$mprocesses = model("App\Modules\Disa\Models\Disa_Processes");
$mrecommendations = model("App\Modules\Disa\Models\Disa_Recommendations");

$mactivities = model("\App\Modules\Disa\Models\Disa_Activities");
$activity = $mactivities->find($oid);
$description = $strings->get_URLDecode($activity['description']);
$description = $strings->get_Clear($description);

$plans = $mdp->get_ListByActivity($oid);
$recommendations = $mrecommendations->where("activity", $oid)->findAll();

if (is_array($recommendations)) {
    $info = "<p><u>La actividad vinculada a los presentes planes de acción tiene las siguientes recomendaciones asignadas</u>:</p>";
    foreach ($recommendations as $recommendation) {
        $info .= urldecode($recommendation["description"]);
    }
    $swarning = service("smarty");
    $swarning->set_Mode("bs5x");
    $swarning->caching = 0;
    $swarning->assign("title", "Recuerde");
    $swarning->assign("message", "{$info}");
    $warning = ($swarning->view('alerts/inline/warning.tpl'));
    echo($warning);
}

//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "DISA",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "PLANS",
    "log" => "Accedió al  <b>listado de planes de acción</b> de la actividad <b>{$description}</b>",
));

?>
<div class="row ">
    <div class="col-12 activities pb-1">
        <table width="100%" class="table table-bordered table-hover" border="1">
            <thead>
            <tr>
                <th class="th" nowrap>Plan</th>
                <th class="th">Valor</th>
                <th class="th">Descripción</th>
                <th class="th" nowrap>Opciones</th>
            </tr>
            </thead>
            <?php foreach ($plans as $p) { ?>
                <?php $qstatus = $mds->get_Status($p['plan']); ?>
                <?php $status = is_array($qstatus) ? safe_strtolower($qstatus["value"]) : "pending"; ?>
                <?php $count_actions = $mda->get_CountByPlan($p['plan']); ?>
                <?php $profile = $mfields->get_Profile($p["author"]); ?>
                <?php $author = $profile['name']; ?>
                <?php $process = $mprocesses->find($p["manager"]); ?>
                <?php $description = $strings->get_Clear(urldecode($p["description"])); ?>
                <tr>
                    <td class="order <?php echo($status); ?>  " nowrap>
                        <?php echo($strings->get_ZeroFill($p["order"], 4)); ?>
                    </td>
                    <td class="text-center fs-4">
                        <?php echo(round($p["value"], 0)); ?>
                    </td>
                    <td class="description">
                        <?php echo($description); ?>
                        </br><b>Proyectado</b>: <?php echo($author); ?>
                        </br><b>Responsable</b>: <?php echo(@$process["responsible"]); ?>

                        <?php if ($status == "proposed") { ?>
                            </br><b>Estado</b>: <span
                                    class="text-primary"><?php echo(Lang("Disa.plan-status-" . $status)); ?></span>
                        <?php } elseif ($status == "completed") { ?>
                            </br><b>Estado</b>: <span
                                    class="text-success"><?php echo(Lang("Disa.plan-status-" . $status)); ?></span>
                        <?php } else { ?>
                            </br><b>Estado</b>: <span
                                    class="text-danger"><?php echo(Lang("Disa.plan-status-" . $status)); ?></span>
                        <?php } ?>


                        </br><b>Inicio</b>: <?php echo($p["start"]); ?> - <b>Finalización</b>: <?php echo($p["end"]); ?>
                    </td>
                    <td nowrap="" class="text-center p-2">
                        <div class="btn-group" role="group">
                            <a class="btn btn-outline-secondary" href="/disa/mipg/plans/view/<?php echo($p["plan"]); ?>"
                               target="_self">
                                <i class="icon far fa-eye"></i>
                                <span class="button-text">Ver</span>
                            </a>
                            <!--
                            <a class="btn btn-outline-secondary" href="/disa/mipg/plans/edit/<?php echo($p["plan"]); ?>" target="_self">
                                <i class="icon far fa-edit"></i>
                                <span class="button-text">Editar</span>
                            </a>
                            <a class="btn btn-outline-secondary" href="/disa/mipg/plans/delete/<?php echo($p["plan"]); ?>" target="_self">
                                <i class="far fa-trash"></i>
                                <span class="button-text">Eliminar</span>
                            </a>
                            //-->
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>