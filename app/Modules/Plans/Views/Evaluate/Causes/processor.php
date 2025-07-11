<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-02-03 16:17:48
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
//[services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[vars]----------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Plans_Plans.plans-"));
$model = model("App\Modules\Plans\Models\Plans_Plans");
$mcauses = model('App\Modules\Plans\Models\Plans_Causes');
$mscores = model('App\Modules\Plans\Models\Plans_Causes_Scores');
//[Fields]--------------------------------------------------------------------------------------------------------------
$plan = $f->get_Value("plan");
$author = safe_get_user();
$values = $f->get_Value("value");

foreach ($values as $key => $value) {
    $mscores->where("cause", $key)->where("author", $author)->delete();
    $create = $mscores->insert(array("score" => pk(), "cause" => $key, "value" => $value, "author" => $author));
}

$mscores->purgeDeleted();
$subtotals = array();
$causes = $mcauses->where("plan", $plan)->findAll();
foreach ($causes as $cause) {
    $scores = $mscores->where("cause", $cause["cause"])->find();
    $sum = 0;
    foreach ($scores as $score) {
        $sum += $score["value"];
    }
    $subtotals[$cause["cause"]]["subtotal"] = $sum;
}

$total = 0;
foreach ($subtotals as $subtotal) {
    $total += $subtotal["subtotal"];
}
//echo("<br>Total: ".$total);
foreach ($causes as $cause) {
    $subtotal = $subtotals[$cause["cause"]]["subtotal"];
    $subtotals[$cause["cause"]]["percentaje"] = $subtotal / $total;
    $update = $mcauses->update($cause["cause"], array("score" => $subtotals[$cause["cause"]]["percentaje"]));
}
$link["continue"] = "/plans/plans/causes/{$oid}";
//[build]---------------------------------------------------------------------------------------------------------------
$c = $bootstrap->get_Card('warning', array(
    'class' => 'card-success',
    'icon' => 'fa-duotone fa-triangle-exclamation',
    'text-class' => 'text-center',
    'title' => lang("Plans_Causes.evaluation-success-title"),
    'text' => lang("Plans_Causes.evaluation-success-message"),
    'footer-class' => 'text-center',
    'footer-continue' => $link["continue"],
    'voice' => "plans/plans-view-success-message.mp3",
));
echo($c);
?>