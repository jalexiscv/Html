<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-08-26 00:44:19
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sogt\Views\Devices\Editor\processor.php]
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
$f = service("forms", array("lang" => "Sogt_Devices."));
$model = model("App\Modules\Sogt\Models\Sogt_Devices");
$d = array(
    "device" => $f->get_Value("device"),
    "user" => $f->get_Value("user"),
    "tenant" => $f->get_Value("tenant"),
    "name" => $f->get_Value("name"),
    "alias" => $f->get_Value("alias"),
    "device_type" => $f->get_Value("device_type"),
    "asset_type" => $f->get_Value("asset_type"),
    "asset_ref" => $f->get_Value("asset_ref"),
    "imei" => $f->get_Value("imei"),
    "serial" => $f->get_Value("serial"),
    "iccid" => $f->get_Value("iccid"),
    "imsi" => $f->get_Value("imsi"),
    "mac_address" => $f->get_Value("mac_address"),
    "vendor" => $f->get_Value("vendor"),
    "model" => $f->get_Value("model"),
    "firmware_version" => $f->get_Value("firmware_version"),
    "protocol" => $f->get_Value("protocol"),
    "transport" => $f->get_Value("transport"),
    "server_host" => $f->get_Value("server_host"),
    "server_port" => $f->get_Value("server_port"),
    "apn" => $f->get_Value("apn"),
    "carrier" => $f->get_Value("carrier"),
    "sim_phone" => $f->get_Value("sim_phone"),
    "auth_key" => $f->get_Value("auth_key"),
    "ip_whitelist" => $f->get_Value("ip_whitelist"),
    "has_ignition" => $f->get_Value("has_ignition"),
    "has_sos" => $f->get_Value("has_sos"),
    "has_temp" => $f->get_Value("has_temp"),
    "has_fuel" => $f->get_Value("has_fuel"),
    "supports_ble" => $f->get_Value("supports_ble"),
    "report_interval_moving_s" => $f->get_Value("report_interval_moving_s"),
    "report_interval_idle_s" => $f->get_Value("report_interval_idle_s"),
    "overspeed_kmh" => $f->get_Value("overspeed_kmh"),
    "timezone_offset_min" => $f->get_Value("timezone_offset_min"),
    "status" => $f->get_Value("status"),
    "activation_date" => $f->get_Value("activation_date"),
    "installed_on" => $f->get_Value("installed_on"),
    "installed_by" => $f->get_Value("installed_by"),
    "warranty_until" => $f->get_Value("warranty_until"),
    "tags" => $f->get_Value("tags"),
    "notes" => $f->get_Value("notes"),
    "author" => safe_get_user(),
);
//[build]---------------------------------------------------------------------------------------------------------------
$row = $model->find($d["device"]);
if (isset($row["device"])) {
//$edit = $model->update($d);
    $c = $bootstrap->get_Card('warning', array(
        'class' => 'card-warning',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Sogt_Devices.view-success-title"),
        'text' => lang("Sogt_Devices.view-success-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/sogt/devices/view/{$d["device"]}/" . lpk()),
        'voice' => "sogt/devices-view-success-message.mp3",
    ));
} else {
    $c = $bootstrap->get_Card('success', array(
        'class' => 'card-success',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Sogt_Devices.view-noexist-title"),
        'text' => lang("Sogt_Devices.view-noexist-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/sogt/devices"),
        'voice' => "sogt/devices-view-noexist-message.mp3",
    ));
}
echo($c);
?>
