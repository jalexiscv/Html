<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-03-04 15:21:07
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sgd\Views\Registrations\Editor\form.php]
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
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication =service('authentication');
$f = service("forms",array("lang" => "Sgd_Registrations."));
$server = service("server");
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sgd\Models\Sgd_Registrations");
$mversions = model("App\Modules\Sgd\Models\Sgd_Versions");
$munits = model("App\Modules\Sgd\Models\Sgd_Units");
$mseries = model("App\Modules\Sgd\Models\Sgd_Series");
$msubseries = model("App\Modules\Sgd\Models\Sgd_Subseries");
$musers = model("App\Modules\Sgd\Models\Sgd_Users");
$mfields = model("App\Modules\Sgd\Models\Sgd_Users_Fields");
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
$row= $model->getRegistration($oid);

$r["registration"] = $f->get_Value("registration", $row["registration"]);
$r["folios"]=$f->get_Value("folios",@$row["folios"]);
$r["reference"] = $f->get_Value("reference",@$row["reference"]);
$r["observations"] = $f->get_Value("observations",@$row["observations"]);
$r["date"] = $f->get_Value("date", @$row["date"]);
$r["qrcode"] = $f->get_Value("qrcode",@$row["qrcode"]);
$r["version"] = $f->get_Value("version",@$row["version"]);
$r["unit"] = $f->get_Value("unit",@$row["unit"]);
$r["serie"] = $f->get_Value("serie", @$row["serie"]);
$r["subserie"] = $f->get_Value("subserie", @$row["subserie"]);
$r["time"] = $f->get_Value("time", @$row["time"]);
$r["author"] = $f->get_Value("author",@$row["author"]);
$r["from_type"]=$f->get_Value("from_type", @$row["from_type"]);
$r["from_identification"]=$f->get_Value("from_identification",@$row["from_identification"]);
$r["from_name"]=$f->get_Value("from_name", @$row["from_name"]);
$r["from_email"]=$f->get_Value("from_email",@$row["from_email"]);
$r["from_phone"]=$f->get_Value("from_phone", @$row["from_phone"]);
$r["from_user"]=$f->get_Value("from_user", $row["from_user"]);
$r["to_type"]=$f->get_Value("to_type", @$row["to_type"]);
$r["to_identification"]=$f->get_Value("to_identification", @$row["to_identification"]);
$r["to_name"]=$f->get_Value("to_name", @$row["to_name"]);
$r["to_email"]=$f->get_Value("to_email", @$row["to_email"]);
$r["to_phone"]=$f->get_Value("to_phone", @$row["to_phone"]);
$r["to_user"]=$f->get_Value("to_user", @$row["to_user"]);
$r["created_at"] = $f->get_Value("created_at", @$row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", @$row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", @$row["deleted_at"]);

$back = $server->get_Referer();

$versions = array(array("value" => "", "label" => "Seleccione una versión"));
$units = array(array("value" => "", "label" => "Seleccione una unidad"));
$series = array(array("value" => "", "label" => "Seleccione una serie"));
$subseries = array(array("value" => "", "label" => "Seleccione una subserie"));

$qversions = $mversions->get_SelectData();
$qunits = $munits->get_SelectData($r["version"]);
$qseries = $mseries->get_SelectData($r["unit"]);
$qsubseries = $msubseries->get_SelectData($r["serie"]);

$versions = array_merge($versions, $qversions);
$units = array_merge($units, $qunits);
$series = array_merge($series, $qseries);
$subseries = array_merge($subseries, $qsubseries);

$types=array(
    array("value"=>"EXTERNAL","label"=>"Externo"),
    array("value"=>"INTERNAL","label"=>"Interno"),
);



$rusers=$musers->getUsers();
$users=array(
    array("value"=>"","label"=>"- Seleccione uno"),
);
foreach ($rusers as $user) {
    $fullname=$mfields->get_FullName($user["user"]);
    $users[] = array("value" => $user["user"], "label" =>"{$fullname}");
}























$back= "/sgd/registrations/list/".lpk();
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->add_HiddenField("author", $r["author"]);
$f->fields["registration"] = $f->get_FieldText("registration", array("value" => $r["registration"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["folios"] = $f->get_FieldNumber("folios", array("value" => $r["folios"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["date"] = $f->get_FieldText("date", array("value" => $r["date"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["time"] = $f->get_FieldText("time", array("value" => $r["time"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["reference"] = $f->get_FieldText("reference", array("value" => $r["reference"], "proportion" => "col-12"));
$f->fields["observations"] = $f->get_FieldTextArea("observations", array("value" => $r["observations"], "proportion" => "col-12"));
$f->fields["qrcode"] = $f->get_FieldText("qrcode", array("value" => $r["qrcode"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["from_type"] = $f->get_FieldSelect("from_type", array("seleted" => $r["from_type"], "data" => $types, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["from_identification"] =$f->get_FieldText("from_identification", array("value" => $r["from_identification"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["from_name"] =$f->get_FieldText("from_name", array("value" => $r["from_name"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["from_email"] =$f->get_FieldText("from_email", array("value" => $r["from_email"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["from_phone"] =$f->get_FieldText("from_phone", array("value" => $r["from_phone"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["from_user"] = $f->get_FieldSelect("from_user", array("seleted" => $r["from_user"], "data" => $users, "proportion" => "col-12"));
$f->fields["to_type"] = $f->get_FieldSelect("to_type", array("seleted" => $r["to_type"], "data" => $types, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["to_identification"] =$f->get_FieldText("to_identification", array("value" => $r["to_identification"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["to_name"] =$f->get_FieldText("to_name", array("value" => $r["to_name"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["to_email"] =$f->get_FieldText("to_email", array("value" => $r["to_email"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["to_phone"] =$f->get_FieldText("to_phone", array("value" => $r["to_phone"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["to_user"] = $f->get_FieldSelect("to_user", array("seleted" => $r["to_user"], "data" => $users, "proportion" => "col-12"));
$f->fields["version"] = $f->get_FieldSelect("version", array("seleted" => $r["version"], "data" => $versions, "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["unit"] = $f->get_FieldSelect("unit", array("seleted" => $r["unit"], "data" => $units, "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["serie"] = $f->get_FieldSelect("serie", array("seleted" => $r["serie"], "data" => $series, "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["subserie"] = $f->get_FieldSelect("subserie", array("seleted" => $r["subserie"], "data" => $subseries, "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"]=$f->get_Cancel("cancel", array("href" =>$back,"text" =>lang("App.Cancel"),"type"=>"secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] =$f->get_Submit("submit", array("value" =>lang("App.Edit"),"proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["registration"] . $f->fields["date"] . $f->fields["time"]. $f->fields["folios"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["version"] . $f->fields["unit"] . $f->fields["serie"] . $f->fields["subserie"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["reference"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["observations"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["from_type"] . $f->fields["to_type"])));
$f->groups["g6"] = $f->get_Group(array("id"=>"from-group-external","legend" => "Remitente externo", "fields" => ($f->fields["from_identification"] . $f->fields["from_name"] . $f->fields["from_email"] . $f->fields["from_phone"])));
$f->groups["g7"] = $f->get_Group(array("id"=>"from-group-internal","legend" => "Remitente interno", "fields" => ($f->fields["from_user"])));
$f->groups["g8"] = $f->get_Group(array("id"=>"to-group-external","legend" => "Destinatario externo", "fields" => ($f->fields["to_identification"] . $f->fields["to_name"] . $f->fields["to_email"] . $f->fields["to_phone"])));
$f->groups["g9"] = $f->get_Group(array("id"=>"to-group-internal","legend" => "Destinatario interno", "fields" => ($f->fields["to_user"])));
//$f->groups["g4"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["qrcode"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] =$f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["submit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
		 "header-title" => lang("Sgd_Registrations.edit-title"),
		 "content" =>$f,
		 "header-back" =>$back
));
echo($card);
?>