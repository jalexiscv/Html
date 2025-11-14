<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-08-26 00:44:20
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sogt\Views\Devices\Editor\validator.php]
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
$bootstrap = service('bootstrap');
$f = service("forms", array("lang" => "Sogt_Devices."));
//[Request]-----------------------------------------------------------------------------
//$f->set_ValidationRule("device","trim|required");
//$f->set_ValidationRule("user","trim|required");
//$f->set_ValidationRule("tenant","trim|required");
//$f->set_ValidationRule("name","trim|required");
//$f->set_ValidationRule("alias","trim|required");
//$f->set_ValidationRule("device_type","trim|required");
//$f->set_ValidationRule("asset_type","trim|required");
//$f->set_ValidationRule("asset_ref","trim|required");
//$f->set_ValidationRule("imei","trim|required");
//$f->set_ValidationRule("serial","trim|required");
//$f->set_ValidationRule("iccid","trim|required");
//$f->set_ValidationRule("imsi","trim|required");
//$f->set_ValidationRule("mac_address","trim|required");
//$f->set_ValidationRule("vendor","trim|required");
//$f->set_ValidationRule("model","trim|required");
//$f->set_ValidationRule("firmware_version","trim|required");
//$f->set_ValidationRule("protocol","trim|required");
//$f->set_ValidationRule("transport","trim|required");
//$f->set_ValidationRule("server_host","trim|required");
//$f->set_ValidationRule("server_port","trim|required");
//$f->set_ValidationRule("apn","trim|required");
//$f->set_ValidationRule("carrier","trim|required");
//$f->set_ValidationRule("sim_phone","trim|required");
//$f->set_ValidationRule("auth_key","trim|required");
//$f->set_ValidationRule("ip_whitelist","trim|required");
//$f->set_ValidationRule("has_ignition","trim|required");
//$f->set_ValidationRule("has_sos","trim|required");
//$f->set_ValidationRule("has_temp","trim|required");
//$f->set_ValidationRule("has_fuel","trim|required");
//$f->set_ValidationRule("supports_ble","trim|required");
//$f->set_ValidationRule("report_interval_moving_s","trim|required");
//$f->set_ValidationRule("report_interval_idle_s","trim|required");
//$f->set_ValidationRule("overspeed_kmh","trim|required");
//$f->set_ValidationRule("timezone_offset_min","trim|required");
//$f->set_ValidationRule("status","trim|required");
//$f->set_ValidationRule("activation_date","trim|required");
//$f->set_ValidationRule("installed_on","trim|required");
//$f->set_ValidationRule("installed_by","trim|required");
//$f->set_ValidationRule("warranty_until","trim|required");
//$f->set_ValidationRule("tags","trim|required");
//$f->set_ValidationRule("notes","trim|required");
//$f->set_ValidationRule("author","trim|required");
//$f->set_ValidationRule("created_at","trim|required");
//$f->set_ValidationRule("updated_at","trim|required");
//$f->set_ValidationRule("deleted_at","trim|required");
//[build]---------------------------------------------------------------------------------------------------------------
if ($f->run_Validation()) {
    $c = view($component . '\processor', $parent->get_Array());
} else {
    $c = $bootstrap->get_Card('validator-error', array(
        'class' => 'card-danger',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'text' => lang("App.validator-errors-message"),
        'errors' => $f->validation->listErrors(),
        'footer-class' => 'text-center',
        'voice' => "app/validator-errors-message.mp3",
    ));
    $c .= view($component . '\form', $parent->get_Array());
}
echo($c);
?>
