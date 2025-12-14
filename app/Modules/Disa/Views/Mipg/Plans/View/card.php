<?php


use App\Libraries\Strings;

$authentication = service('authentication');
$strings = new Strings();
$mplans = model("App\Modules\Disa\Models\Disa_Plans");
$mprocesses = model('App\Modules\Disa\Models\Disa_Processes');
$msubprocesses = model('App\Modules\Disa\Models\Disa_Subprocesses');
$mpositions = model('App\Modules\Disa\Models\Disa_Positions');
$mcauses = model("App\Modules\Disa\Models\Disa_Causes", true);
$mactions = model('App\Modules\Disa\Models\Disa_Actions');
$mstatuses = model('App\Modules\Disa\Models\Disa_Statuses');
$mwhys = model("App\Modules\Disa\Models\Disa_Whys");

$plan = $mplans->find($oid);
$manager_subprocess = @$plan["manager_subprocess"];
$manager_position = @$plan["manager_position"];


$mcause = $mcauses->where("plan", $oid)->orderBy("score", "DESC")->first();
$mscore = @$mcause["score"];

$whys = $mwhys->where("cause", @$mcause["cause"])->orderBy("why", "ASC")->findAll();
//print_r(json_encode($whys));
//echo(count($whys));

$actions = $mactions->get_ListByPlan($oid);
$status = $mstatuses->where("object", $oid)->orderBy("created_at", "DESC")->first();

if (is_array($status)) {
    $state = $status["value"];
} else {
    $state = "UNDEFINED";
}


if ($state == "COMPLETED") {
    $state = "Completado";
} else {

}

?>
<style>
    .disa-plan-status {
        float: right;
        width: 100px;
        border: 1px solid #ff4500;
        text-align: center;
        border-radius: 5px;
    }

    .text-orange-cloud {
        color: #ff4500 !important;
    }

    .text-orange-danger {
        color: #d10900 !important;
    }

    .text-orange-success {
        color: #099e00 !important;
    }
</style>
<?php
$status["owners"] = false;
$status["analysis"] = false;
$status["formulation"] = false;
$status["action"] = false;
$status["status"] = false
?>
<ul class="list-group mb-3">
    <li class="list-group-item"><i class="fad fa-asterisk text-secondary text-orange-cloud"></i> Detalles del plan <a
                href="/disa/mipg/plans/details/<?php echo($oid); ?>">
            <div class="disa-plan-status"><i class="fas fa-eye text-150 text-orange-cloud align-center"></i>
        </a></div></li>

    <?php if ($manager_subprocess) { ?>
        <li class="list-group-item"><i class="fad fa-asterisk text-secondary text-orange-cloud"></i> Equipo de trabajo
            <a
                    href="/disa/mipg/plans/team/<?php echo($oid); ?>">
                <div class="disa-plan-status"><i class="fas fa-check text-150 text-orange-success"></i></div>
            </a></li>
    <?php } else { ?>
        <li class="list-group-item"><i class="fad fa-asterisk text-secondary text-orange-cloud"></i> Equipo de trabajo
            <a
                    href="/disa/mipg/plans/team/<?php echo($oid); ?>">
                <div class="disa-plan-status"><i class="fas fa-times text-150 text-orange-danger"></i></div>
            </a></li>
    <?php } ?>

    <?php if ($mscore > 0) { ?>
        <?php if (is_array($whys) && count($whys) > 0) { ?>
            <li class="list-group-item"><i class="fad fa-asterisk text-secondary text-orange-cloud"></i> Análisis de
                causas<a href="/disa/mipg/plans/causes/list/<?php echo($oid); ?>">
                    <div class="disa-plan-status"><i class="fas fa-check text-150 text-orange-success"></i></div>
                </a></li>
        <?php } else { ?>
            <li class="list-group-item"><i class="fad fa-asterisk text-secondary text-orange-cloud"></i> Análisis de
                causas<a href="/disa/mipg/plans/causes/list/<?php echo($oid); ?>">
                    <div class="disa-plan-status"><i class="fas fa-times text-150 text-orange-danger"></i></div>
                </a></li>
        <?php } ?>
    <?php } else { ?>
        <li class="list-group-item"><i class="fad fa-asterisk text-secondary text-orange-cloud"></i> Análisis de
            causas<a href="/disa/mipg/plans/causes/list/<?php echo($oid); ?>">
                <div class="disa-plan-status"><i class="fas fa-times text-150 text-orange-danger"></i></div>
            </a></li>
    <?php } ?>

    <?php if (!empty($plan["formulation"])) { ?>
        <li class="list-group-item"><i class="fad fa-asterisk text-secondary text-orange-cloud"></i> Formulación del
            plan <a href="/disa/mipg/plans/formulation/view/<?php echo($oid); ?>">
                <div class="disa-plan-status"><i class="fas fa-check text-150 text-orange-success"></i></div>
            </a></li>
    <?php } else { ?>
        <li class="list-group-item"><i class="fad fa-asterisk text-secondary text-orange-cloud"></i> Formulación del
            plan <a
                    href="/disa/mipg/plans/formulation/view/<?php echo($oid); ?>">
                <div class="disa-plan-status"><i class="fas fa-times text-150 text-orange-danger"></i></div>
            </a></li>
    <?php } ?>

    <?php if (is_array($actions) && count($actions) > 0) { ?>
        <li class="list-group-item"><i class="fad fa-asterisk text-secondary text-orange-cloud"></i> Acciones <a
                    href="/disa/mipg/plans/actions/list/<?php echo($oid); ?>">
                <div class="disa-plan-status"><i class="fas fa-check text-150 text-orange-success"></i></div>
            </a></li>
    <?php } else { ?>
        <li class="list-group-item"><i class="fad fa-asterisk text-secondary text-orange-cloud"></i> Acciones <a
                    href="/disa/mipg/plans/actions/list/<?php echo($oid); ?>">
                <div class="disa-plan-status"><i class="fas fa-times text-150 text-orange-danger"></i></div>
            </a></li>
    <?php } ?>

</ul>

