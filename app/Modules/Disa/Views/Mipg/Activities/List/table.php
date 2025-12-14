<?php
$strings = service("strings");
$mactivities = model("\App\Modules\Disa\Models\Disa_Activities");
$mplans = model("\App\Modules\Disa\Models\Disa_Plans");
$mscores = model("\App\Modules\Disa\Models\Disa_Scores");
$mstatuses = model("\App\Modules\Disa\Models\Disa_Statuses");

$activities = $mactivities->get_ListByCategory($oid);
$mdp = model("\App\Modules\Disa\Models\Disa_Plans", true);

?>

<div class="row ">
    <div class="col-12 activities pb-1">
        <table width="100%" class="table table-bordered table-hover" border="1">
            <thead class="">
            <tr>
                <th class="th">#</th>
                <th class="th align-left">Actividad</th>
                <th class="th align-center">Puntaje</th>
                <th class="th align-center">Opciones</th>
            </tr>
            </thead>
            <?php foreach ($activities as $d) { ?>
                <?php $score = $mscores->get_ScoreByActivity($d["activity"]); ?>
                <?php $realizados = $mdp->get_ListMadesByActivity($d["activity"]); ?>
                <?php $pendientes = $mdp->get_ListPendingByActivity($d["activity"]); ?>
                <?php $plan = $mplans->where("activity", $d["activity"])->orderBy("plan", "DESC")->first(); ?>
                <tr>
                    <td class="order"><?php echo($d["order"]); ?></td>
                    <td class="description  ">
                        <?php echo($strings->get_Striptags(urldecode($d["description"]))); ?>
                        <br><b>Periodo de análisis</b>: <?php echo(urldecode($d["period"])); ?>
                        <?php if (is_array($plan)) { ?>
                            <?php $status = $mstatuses->where("object", $plan["plan"])->orderBy("status", "DESC")->first(); ?>
                            <br><b>Plan actual</b>: <a
                                    href="/disa/mipg/plans/view/<?php echo(@$plan["plan"]); ?>">#<?php echo($strings->get_ZeroFill(@$plan["order"], 4)); ?></a>
                            | <b>Estado</b>: <?php echo(lang("Disa." . @$status["value"])); ?>
                        <?php } else { ?>
                            <br><b>Plan actual</b>: Ninguno | <a
                                    href="/disa/mipg/plans/create/<?php echo($d["activity"]); ?>">Crear plan</a>
                        <?php } ?>
                        <br><a href="/disa/mipg/plans/list/<?php echo($d["activity"]); ?>" data-toggle="tooltip"
                               data-placement="top" title="Pendientes">Histórico planes de acción</a>
                        | <a class="" href="/disa/mipg/scores/list/<?php echo($d["activity"]); ?>">Recalificaciones</a>
                    </td>
                    <td class="score text-center fs-4" nowrap><?php echo(round($score, 0)); ?></td>
                    <td class="p-2">
                        <div class="btn-group" role="group">
                            <a class="btn btn-outline-secondary"
                               href="/disa/mipg/activities/edit/<?php echo($d["activity"]); ?>" target="_self"><i
                                        class="icon far fa-edit"></i><span class="button-text"> Editar</span></a>
                            <a class="btn btn-outline-danger"
                               href="/disa/mipg/activities/delete/<?php echo($d["activity"]); ?>" target="_self"><i
                                        class="far fa-trash"></i><span class="button-text"> Eliminar</span></a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>