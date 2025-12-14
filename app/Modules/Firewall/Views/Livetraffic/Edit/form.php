<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-02-13 00:45:24
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Firewall\Views\Livetraffic\Editor\form.php]
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
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Firewall.livetraffic-"));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Firewall\Models\Firewall_Livetraffic");
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->where('traffic', $oid)->first();
$r["traffic"] = $f->get_Value("traffic", $row["traffic"]);
$r["ip"] = $f->get_Value("ip", $row["ip"]);
$r["useragent"] = $f->get_Value("useragent", $row["useragent"]);
$r["browser"] = $f->get_Value("browser", $row["browser"]);
$r["browser_code"] = $f->get_Value("browser_code", $row["browser_code"]);
$r["os"] = $f->get_Value("os", $row["os"]);
$r["os_code"] = $f->get_Value("os_code", $row["os_code"]);
$r["device_type"] = $f->get_Value("device_type", $row["device_type"]);
$r["country"] = $f->get_Value("country", $row["country"]);
$r["country_code"] = $f->get_Value("country_code", $row["country_code"]);
$r["request_uri"] = $f->get_Value("request_uri", $row["request_uri"]);
$r["domain"] = $f->get_Value("domain", $row["domain"]);
$r["referer"] = $f->get_Value("referer", $row["referer"]);
$r["bot"] = $f->get_Value("bot", $row["bot"]);
$r["date"] = $f->get_Value("date", service("dates")::get_Date());
$r["time"] = $f->get_Value("time", service("dates")::get_Time());
$r["uniquev"] = $f->get_Value("uniquev", $row["uniquev"]);
$back = "/firewall/livetraffic/list/" . lpk();
//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["traffic"] = $f->get_FieldText("traffic", array("value" => $r["traffic"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ip"] = $f->get_FieldText("ip", array("value" => $r["ip"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["useragent"] = $f->get_FieldText("useragent", array("value" => $r["useragent"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["browser"] = $f->get_FieldText("browser", array("value" => $r["browser"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["browser_code"] = $f->get_FieldText("browser_code", array("value" => $r["browser_code"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["os"] = $f->get_FieldText("os", array("value" => $r["os"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["os_code"] = $f->get_FieldText("os_code", array("value" => $r["os_code"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["device_type"] = $f->get_FieldText("device_type", array("value" => $r["device_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["country"] = $f->get_FieldText("country", array("value" => $r["country"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["country_code"] = $f->get_FieldText("country_code", array("value" => $r["country_code"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["request_uri"] = $f->get_FieldText("request_uri", array("value" => $r["request_uri"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["domain"] = $f->get_FieldText("domain", array("value" => $r["domain"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["referer"] = $f->get_FieldText("referer", array("value" => $r["referer"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["bot"] = $f->get_FieldText("bot", array("value" => $r["bot"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["date"] = $f->get_FieldText("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldText("time", array("value" => $r["time"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["uniquev"] = $f->get_FieldText("uniquev", array("value" => $r["uniquev"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["traffic"] . $f->fields["ip"] . $f->fields["useragent"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["browser"] . $f->fields["browser_code"] . $f->fields["os"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["os_code"] . $f->fields["device_type"] . $f->fields["country"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["country_code"] . $f->fields["request_uri"] . $f->fields["domain"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["referer"] . $f->fields["bot"] . $f->fields["date"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["time"] . $f->fields["uniquev"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => lang("Firewall.livetraffic-edit-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>
