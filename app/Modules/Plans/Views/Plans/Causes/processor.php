<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-05 16:11:06
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Plans\Views\Plans\Editor\processor.php]
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
//[services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[vars]----------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Plans_Plans."));
$model = model("App\Modules\Plans\Models\Plans_Plans");
$d = array(
    "plan" => $f->get_Value("plan"),
    "plan_institutional" => $f->get_Value("plan_institutional"),
    "activity" => $f->get_Value("activity"),
    "manager" => $f->get_Value("manager"),
    "manager_subprocess" => $f->get_Value("manager_subprocess"),
    "manager_position" => $f->get_Value("manager_position"),
    "order" => $f->get_Value("order"),
    "description" => $f->get_Value("description"),
    "formulation" => $f->get_Value("formulation"),
    "value" => $f->get_Value("value"),
    "start" => $f->get_Value("start"),
    "end" => $f->get_Value("end"),
    "evaluation" => $f->get_Value("evaluation"),
    "author" => safe_get_user(),
);
//[build]---------------------------------------------------------------------------------------------------------------
$row = $model->find($d["plan"]);
if (isset($row["plan"])) {
//$edit = $model->update($d);
    $c = $bootstrap->get_Card('warning', array(
        'class' => 'card-warning',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Plans.plans-view-success-title"),
        'text' => lang("Plans.plans-view-success-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/plans/plans/view/{$d["plan"]}/" . lpk()),
        'voice' => "plans/plans-view-success-message.mp3",
    ));
} else {
    $c = $bootstrap->get_Card('success', array(
        'class' => 'card-success',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Plans_Plans.plans-view-noexist-title"),
        'text' => lang("Plans_Plans.plans-view-noexist-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/plans/plans"),
        'voice' => "plans/plans-view-noexist-message.mp3",
    ));
}
echo($c);
?>
