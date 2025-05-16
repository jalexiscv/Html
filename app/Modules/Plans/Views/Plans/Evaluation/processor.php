<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-02-03 16:17:50
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Plans\Views\Plans\Editor\processor.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent
 * █ @var object $authentication
 * █ @var object $request
 * █ @var object $dates
 * █ @var string $component
 * █ @var string $view
 * █ @var string $oid
 * █ @var string $views
 * █ @var string $prefix
 * █ @var array $data
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
$mplans = model("App\Modules\Plans\Models\Plans_Plans");
$mactions = model("App\Modules\Plans\Models\Plans_Actions");
$mscores = model("App\Modules\Plans\Models\Plans_Scores");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Plans_Plans."));
$d = array(
    "plan" => $f->get_Value("plan"),
    "status" => $f->get_Value("status"),
    "status_evaluation" => $f->get_Value("status_evaluation"),
    "status_evaluation_date" => $dates->get_Date(),
    "status_evaluation_time" => $dates->get_Time(),
);
//[Elements]-----------------------------------------------------------------------------
$plan = $mplans->getPlan($d["plan"]);
$l["back"] = "/plans/plans/view/" . $oid;
$l["edit"] = "/plans/plans/edit/{$d["plan"]}";
$asuccess = "plans/plans-edit-success-message.mp3";
$anoexist = "plans/plans-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($plan)) {
    $edit = $mplans->update($d['plan'], $d);

    $mactions->where('plan', $d['plan'])->set(['status' => $d['status']])->update();

    if ($d['status'] == "COMPLETED") {
        $propuesta = $plan['value'];
        $activity = $plan['activity'];
        $d = array(
            "score" => pk(),
            "activity" => $activity,
            "value" => $propuesta,
            "details" => "Calificación actualizada por el cumplimiento del plan de acción " . $plan["order"],
            "author" => safe_get_user(),
        );
        $mscores->insert($d);
    }


    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Plans_Plans.edit-success-title"),
        "text-class" => "text-center",
        "text" => "El estado del plan de acción ha sido Aprobado o Rechazado correctamente y los responsables del mismo serán notificados inmediatamente. Para retornar a la vista general del plan,  presione continuar en la parte inferior de este mensaje.",
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Plans_Plans.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Plans_Plans.edit-noexist-message"), $d['plan']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>
