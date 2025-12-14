<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-07-17 08:23:12
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Journalists\Views\Journalists\Editor\form.php]
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
$f = service("forms", array("lang" => "Journalists_Journalists."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Journalists\Models\Journalists_Journalists");
$mmedia = model("App\Modules\Journalists\Models\Journalists_Medias");
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->getJournalist($oid);
$r["journalist"] = $f->get_Value("journalist", $row["journalist"]);
$r["citizenshipcard"] = $f->get_Value("citizenshipcard", $row["citizenshipcard"]);
$r["firstname"] = $f->get_Value("firstname", $row["firstname"]);
$r["lastname"] = $f->get_Value("lastname", $row["lastname"]);
$r["email"] = $f->get_Value("email", $row["email"]);
$r["phone"] = $f->get_Value("phone", $row["phone"]);
$r["media"] = $f->get_Value("media", $row["media"]);
$r["photo"] = $f->get_Value("photo", $row["photo"]);
$r["date"] = $f->get_Value("date", service("dates")::get_Date());
$r["time"] = $f->get_Value("time", service("dates")::get_Time());
$r["status"] = $f->get_Value("status", $row["status"]);
$r["position"] = $f->get_Value("position", $row["position"]);
$back = "/journalists/journalists/list/" . lpk();

$medias = array(
    array("value" => "", "label" => "- Seleccione un medio")
);
$medias = array_merge($medias, $mmedia->get_SelectData());
$positions = array(
    array("value" => "", "label" => "- Seleccione un cargo"),
    array("value" => "99", "label" => "FUNCIONARIO PUBLICO"),
    array("value" => "01", "label" => "PERIODISTA"),
    array("value" => "02", "label" => "EDITOR"),
    array("value" => "03", "label" => "FOTÓGRAFO"),
    array("value" => "04", "label" => "CAMARÓGRAFO"),
    array("value" => "05", "label" => "REPORTERO"),
    array("value" => "06", "label" => "CORRESPONSAL"),
    array("value" => "07", "label" => "DIRECTOR"),
    array("value" => "08", "label" => "PRODUCTOR"),
    array("value" => "09", "label" => "LOCUTOR"),
    array("value" => "10", "label" => "PRESENTADOR"),
    array("value" => "11", "label" => "ANALISTA"),
    array("value" => "12", "label" => "COMENTARISTA"),
    array("value" => "13", "label" => "CONDUCTOR"),
    array("value" => "14", "label" => "EDITORIALISTA"),
    array("value" => "15", "label" => "REPORTERO GRÁFICO"),
    array("value" => "16", "label" => "EDITOR DE FOTOGRAFÍA"),
    array("value" => "17", "label" => "EDITOR DE VIDEO"),
    array("value" => "18", "label" => "EDITOR DE SONIDO"),
    array("value" => "19", "label" => "EDITOR DE TEXTOS"),
    array("value" => "20", "label" => "EDITOR DE INVESTIGACIÓN"),
    array("value" => "21", "label" => "MIEMBRO DE JUNTA DIRECTIVA"),
);
//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["journalist"] = $f->get_FieldText("journalist", array("value" => $r["journalist"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["citizenshipcard"] = $f->get_FieldText("citizenshipcard", array("value" => $r["citizenshipcard"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["firstname"] = $f->get_FieldText("firstname", array("value" => $r["firstname"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["lastname"] = $f->get_FieldText("lastname", array("value" => $r["lastname"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["email"] = $f->get_FieldText("email", array("value" => $r["email"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["phone"] = $f->get_FieldText("phone", array("value" => $r["phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["media"] = $f->get_FieldSelect("media", array("selected" => $r["media"], "data" => $medias, "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["photo"] = $f->get_FieldFile("photo", array("value" => $r["photo"], "proportion" => "col-12"));
$f->fields["date"] = $f->get_FieldText("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["time"] = $f->get_FieldText("time", array("value" => $r["time"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["status"] = $f->get_FieldText("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["position"] = $f->get_FieldSelect("position", array("selected" => $r["position"], "data" => $positions, "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["journalist"] . $f->fields["citizenshipcard"] . $f->fields["firstname"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["lastname"] . $f->fields["email"] . $f->fields["phone"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["media"] . $f->fields["position"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["photo"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["date"] . $f->fields["time"] . $f->fields["status"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => lang("Journalists.edit-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>
