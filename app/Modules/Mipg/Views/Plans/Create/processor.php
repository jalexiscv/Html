<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-05 15:52:59
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Plans\Views\Plans\Creator\processor.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2024 - CloudEngine S.A.S., Inc. <admin@cgine.com>
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
 * █ @Editor Anderson Ospina Lenis <andersonospina798@gmail.com>
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
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Mipg_Plans."));
$model = model("App\Modules\Plans\Models\Plans_Plans");
$mactivities = model("\App\Modules\Mipg\Models\Mipg_Activities");
//[Data]-----------------------------------------------------------------------------
$order = $model->get_NextPlanNumber();

$d = array(
    "plan" => $f->get_Value("plan"),
    "plan_institutional" => $f->get_Value("plan_institutional"),
    "activity" => $f->get_Value("activity"),
    "manager" => $f->get_Value("manager"),
    "manager_subprocess" => $f->get_Value("manager_subprocess"),
    "manager_position" => $f->get_Value("manager_position"),
    "order" => $order,
    "description" => $f->get_Value("description"),
    "formulation" => $f->get_Value("formulation"),
    "value" => $f->get_Value("value"),
    "start" => $f->get_Value("start"),
    "end" => $f->get_Value("end"),
    "evaluation" => $f->get_Value("evaluation"),
    "author" => safe_get_user(),
);
$row = $model->find($d["plan"]);
$activity = $mactivities->get_Activity($d["activity"]);

//$l["back"] = "/mipg/plans/list/{$d["activity"]}";
$l["back"] = "/mipg/activities/home/{$activity['category']}";
$l["edit"] = "/mipg/plans/edit/{$d["plan"]}";
$asuccess = "plans/plans-create-success-message.mp3";
$aexist = "plans/plans-create-exist-message.mp3";
if (is_array($row)) {
    $c = $card = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Mipg_Plans.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Mipg_Plans.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $card = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Mipg_Plans.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Mipg_Plans.create-success-message"), $d['plan']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
?>