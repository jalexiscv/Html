<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-02-13 00:45:22
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Firewall\Views\Livetraffic\Editor\processor.php]
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
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[vars]----------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Firewall.livetraffic-"));
$model = model("App\Modules\Firewall\Models\Firewall_Livetraffic");
$d = array(
    "traffic" => $f->get_Value("traffic"),
    "ip" => $f->get_Value("ip"),
    "useragent" => $f->get_Value("useragent"),
    "browser" => $f->get_Value("browser"),
    "browser_code" => $f->get_Value("browser_code"),
    "os" => $f->get_Value("os"),
    "os_code" => $f->get_Value("os_code"),
    "device_type" => $f->get_Value("device_type"),
    "country" => $f->get_Value("country"),
    "country_code" => $f->get_Value("country_code"),
    "request_uri" => $f->get_Value("request_uri"),
    "domain" => $f->get_Value("domain"),
    "referer" => $f->get_Value("referer"),
    "bot" => $f->get_Value("bot"),
    "date" => $f->get_Value("date"),
    "time" => $f->get_Value("time"),
    "uniquev" => $f->get_Value("uniquev"),
);
//[build]---------------------------------------------------------------------------------------------------------------
$row = $model->find($d["traffic"]);
if (isset($row["traffic"])) {
//$edit = $model->update($d);
    $c = $bootstrap->get_Card('warning', array(
        'class' => 'card-warning',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Firewall.livetraffic-view-success-title"),
        'text' => lang("Firewall.livetraffic-view-success-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/firewall/livetraffic/view/{$d["traffic"]}/" . lpk()),
        'voice' => "firewall/livetraffic-view-success-message.mp3",
    ));
} else {
    $c = $bootstrap->get_Card('success', array(
        'class' => 'card-success',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Firewall.livetraffic-view-noexist-title"),
        'text' => lang("Firewall.livetraffic-view-noexist-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/firewall/livetraffic"),
        'voice' => "firewall/livetraffic-view-noexist-message.mp3",
    ));
}
echo($c);
?>
