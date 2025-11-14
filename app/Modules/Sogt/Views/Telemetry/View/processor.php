<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-08-26 00:44:29
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sogt\Views\Telemetry\Editor\processor.php]
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
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[vars]----------------------------------------------------------------------------------------------------------------
/**
 * @var object $authentication Authentication service from the ModuleController.
 * @var object $bootstrap Instance of the Bootstrap class from the ModuleController.
 * @var string $component Complete URI to the requested component.
 * @var object $dates Date service from the ModuleController.
 * @var string $oid String representing the object received, usually an object/data to be viewed, transferred from the ModuleController.
 * @var object $parent Represents the ModuleController.
 * @var object $request Request service from the ModuleController.
 * @var object $strings String service from the ModuleController.
 * @var string $view String passed to the view defined in the viewer for evaluation.
 * @var string $viewer Complete URI to the view responsible for evaluating each requested view.
 * @var string $views Complete URI to the module views.
 **/
$f = service("forms", array("lang" => "Sogt_Telemetry."));
$model = model("App\Modules\Sogt\Models\Sogt_Telemetry");
$d = array(
    "telemetry" => $f->get_Value("telemetry"),
    "device" => $f->get_Value("device"),
    "user" => $f->get_Value("user"),
    "latitude" => $f->get_Value("latitude"),
    "longitude" => $f->get_Value("longitude"),
    "altitude" => $f->get_Value("altitude"),
    "speed" => $f->get_Value("speed"),
    "heading" => $f->get_Value("heading"),
    "gps_valid" => $f->get_Value("gps_valid"),
    "satellites" => $f->get_Value("satellites"),
    "network" => $f->get_Value("network"),
    "battery" => $f->get_Value("battery"),
    "ignition" => $f->get_Value("ignition"),
    "event" => $f->get_Value("event"),
    "motion" => $f->get_Value("motion"),
    "timestamp" => $f->get_Value("timestamp"),
    "author" => safe_get_user(),
);
//[build]---------------------------------------------------------------------------------------------------------------
$row = $model->find($d["telemetry"]);
if (isset($row["telemetry"])) {
//$edit = $model->update($d);
    $c = $bootstrap->get_Card('warning', array(
        'class' => 'card-warning',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Sogt_Telemetry.view-success-title"),
        'text' => lang("Sogt_Telemetry.view-success-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/sogt/telemetry/view/{$d["telemetry"]}/" . lpk()),
        'voice' => "sogt/telemetry-view-success-message.mp3",
    ));
} else {
    $c = $bootstrap->get_Card('success', array(
        'class' => 'card-success',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Sogt_Telemetry.view-noexist-title"),
        'text' => lang("Sogt_Telemetry.view-noexist-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/sogt/telemetry"),
        'voice' => "sogt/telemetry-view-noexist-message.mp3",
    ));
}
echo($c);
?>
