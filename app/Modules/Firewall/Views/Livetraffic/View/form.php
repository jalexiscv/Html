<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-02-13 00:45:22
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
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Livetraffic."));
//[Request]-----------------------------------------------------------------------------
$row = $model->find($oid);
$r["traffic"] = $row["traffic"];
$r["ip"] = $row["ip"];
$r["useragent"] = $row["useragent"];
$r["browser"] = $row["browser"];
$r["browser_code"] = $row["browser_code"];
$r["os"] = $row["os"];
$r["os_code"] = $row["os_code"];
$r["device_type"] = $row["device_type"];
$r["country"] = $row["country"];
$r["country_code"] = $row["country_code"];
$r["request_uri"] = $row["request_uri"];
$r["domain"] = $row["domain"];
$r["referer"] = $row["referer"];
$r["bot"] = $row["bot"];
$r["date"] = $row["date"];
$r["time"] = $row["time"];
$r["uniquev"] = $row["uniquev"];
$back = "/firewall/livetraffic/list/" . lpk();
//[Fields]-----------------------------------------------------------------------------
$f->fields["traffic"] = $f->get_FieldView("traffic", array("value" => $r["traffic"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ip"] = $f->get_FieldView("ip", array("value" => $r["ip"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["useragent"] = $f->get_FieldViewArea("useragent", array("value" => $r["useragent"], "proportion" => "col-12"));
$f->fields["browser"] = $f->get_FieldView("browser", array("value" => $r["browser"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["browser_code"] = $f->get_FieldView("browser_code", array("value" => $r["browser_code"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["os"] = $f->get_FieldView("os", array("value" => $r["os"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["os_code"] = $f->get_FieldView("os_code", array("value" => $r["os_code"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["device_type"] = $f->get_FieldView("device_type", array("value" => $r["device_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["country"] = $f->get_FieldView("country", array("value" => $r["country"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["country_code"] = $f->get_FieldView("country_code", array("value" => $r["country_code"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["request_uri"] = $f->get_FieldView("request_uri", array("value" => $r["request_uri"], "proportion" => "col-12"));
$f->fields["domain"] = $f->get_FieldView("domain", array("value" => $r["domain"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["referer"] = $f->get_FieldView("referer", array("value" => $r["referer"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["bot"] = $f->get_FieldView("bot", array("value" => $r["bot"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["date"] = $f->get_FieldView("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldView("time", array("value" => $r["time"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["uniquev"] = $f->get_FieldView("uniquev", array("value" => $r["uniquev"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/firewall/livetraffic/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["traffic"] . $f->fields["ip"] . $f->fields["browser"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["useragent"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["request_uri"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["browser_code"] . $f->fields["os"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["os_code"] . $f->fields["device_type"] . $f->fields["country"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["country_code"] . $f->fields["domain"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["referer"] . $f->fields["bot"] . $f->fields["date"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["time"] . $f->fields["uniquev"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang("Firewall.livetraffic-view-title"),
    "header-back" => $back,
    "content" => $f,
));
echo($card);
?>
