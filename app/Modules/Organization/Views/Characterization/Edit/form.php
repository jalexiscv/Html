<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-02-05 03:52:50
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Organization\Views\Plans\Editor\form.php]
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
 * * █ @var object $authentication Trasferido desde el controlador
 * * █ @var object $request Trasferido desde el controlador
 * * █ @var object $dates Trasferido desde el controlador
 * * █ @var string $component Trasferido desde el controlador
 * * █ @var string $view Trasferido desde el controlador
 * * █ @var string $oid Trasferido desde el controlador
 * * █ @var string $views Trasferido desde el controlador
 * * █ @var string $prefix Trasferido desde el controlador
 * * █ @var array $data Trasferido desde el controlador
 * * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service('server');
$f = service("forms", array("lang" => "Characterization."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Organization\Models\Organization_Plans");
$mclients = model("App\Models\Application_Clients");
$mcharacterizations = model("App\Modules\Organization\Models\Organization_Characterizations");
//[vars]----------------------------------------------------------------------------------------------------------------
$client = $mclients->get_ClientByDomain($server::get_FullName());
$row = $mcharacterizations->orderBy("created_at", "DESC")->first();

$r["characterization"] = $row["characterization"];
$r["sigep"] = $row["sigep"];
$r["name"] = $row["name"];
$r["vision"] = $row["vision"];
$r["mision"] = $row["mision"];
$r["values"] = @$row["values"];
$r["representative"] = $row["representative"];
$r["representative_position"] = $row["representative_position"];
$r["leader"] = $row["leader"];
$r["leader_position"] = $row["leader_position"];

$r["internalcontrol"] = $row["internalcontrol"];
$r["internalcontrol_position"] = $row["internalcontrol_position"];
$r["support"] = $row["support"];
$r["support_position"] = $row["support_position"];
$r["termsofuse"] = $row["termsofuse"];
$r["privacypolicy"] = $row["privacypolicy"];

$r["logo"] = @$client["logo"];
$r["logo_portrait"] = @$client["logo_portrait"];
$r["logo_landscape"] = @$client["logo_landscape"];
$r["logo_portrait_light"] = @$client["logo_portrait"];
$r["logo_landscape_light"] = @$client["logo_landscape"];


$r["author"] = $row["author"];
$r["created_at"] = $row["created_at"];
$r["updated_at"] = $row["updated_at"];
$r["deleted_at"] = $row["deleted_at"];


$clients = model("App\Models\Application_Clients");
$client = $clients->get_ClientByDomain($server::get_FullName());
//print_r($client);

$back = "/organization";
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("characterization", $r["characterization"]);
$f->add_HiddenField("author", @$r["author"]);
$f->fields["sigep"] = $f->get_FieldText("sigep", array("value" => @$r["sigep"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"], "proportion" => "col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12"));
$f->fields["mision"] = $f->get_FieldTextArea("mision", array("value" => $r["mision"], "type" => "rtf", "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["vision"] = $f->get_FieldTextArea("vision", array("value" => $r["vision"], "type" => "rtf", "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["values"] = $f->get_FieldCKEditor("values", array("value" => $r["values"], "type" => "rtf", "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));

$f->fields["representative"] = $f->get_FieldText("representative", array("value" => $r["representative"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["representative_position"] = $f->get_FieldText("representative_position", array("value" => $r["representative_position"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["leader"] = $f->get_FieldText("leader", array("value" => $r["leader"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["leader_position"] = $f->get_FieldText("leader_position", ["value" => $r["leader_position"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"]);

$f->fields["internalcontrol"] = $f->get_FieldText("internalcontrol", array("value" => $r["internalcontrol"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["internalcontrol_position"] = $f->get_FieldText("internalcontrol_position", ["value" => $r["internalcontrol_position"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"]);
$f->fields["support"] = $f->get_FieldText("support", array("value" => $r["support"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["support_position"] = $f->get_FieldText("support_position", ["value" => $r["support_position"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"]);
$f->fields["termsofuse"] = $f->get_FieldText("termsofuse", ["value" => $r["termsofuse"], "proportion" => "col-12"]);
$f->fields["privacypolicy"] = $f->get_FieldText("privacypolicy", ["value" => $r["privacypolicy"], "proportion" => "col-12"]);

$f->fields["logo"] = $f->get_FieldFile("logo", array("value" => $r["logo"]));
$f->fields["logo_portrait"] = $f->get_FieldFile("logo_portrait", array("value" => $r["logo_portrait"]));
$f->fields["logo_portrait_light"] = $f->get_FieldFile("logo_portrait_light", array("value" => $r["logo_portrait_light"]));
$f->fields["logo_landscape"] = $f->get_FieldFile("logo_landscape", array("value" => $r["logo_landscape"]));
$f->fields["logo_landscape_light"] = $f->get_FieldFile("logo_landscape_light", array("value" => $r["logo_landscape_light"]));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g01"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["sigep"] . $f->fields["name"])));
$f->groups["g02"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["mision"])));
$f->groups["g03"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["vision"])));
$f->groups["g04"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["values"])));
$f->groups["g05"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["representative"] . $f->fields["representative_position"])));
$f->groups["g06"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["leader"] . $f->fields["leader_position"])));
$f->groups["g07"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["internalcontrol"] . $f->fields["internalcontrol_position"])));
$f->groups["g08"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["support"] . $f->fields["support_position"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => lang("Plans.organization-plans-edit-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>



