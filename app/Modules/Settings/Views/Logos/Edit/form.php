<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Social\Views\Settings\Editor\form.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* -----------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* -----------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* -----------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* -----------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* -----------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* -----------------------------------------------------------------------------
*/
$bootstrap = service("bootstrap");
$server = service("server");
$f = service("forms", array("lang" => "Social.settings-logotypes-"));
/*
* -----------------------------------------------------------------------------
* [Requests]
* -----------------------------------------------------------------------------
*/
//$msettings = model("App\Modules\Social\Models\Social_Settings");
//$row=$msettings->where("name","logo")->first();


$clients = model("App\Models\Application_Clients");
$row = $clients->get_ClientByDomain($server::get_FullName());

$r["client"] = @$row["client"];
$r["logo"] = @$row["logo"];
$r["logo_portrait"] = @$row["logo_portrait"];
$r["logo_landscape"] = @$row["logo_landscape"];
$r["logo_portrait_light"] = @$row["logo_portrait_light"];
$r["logo_landscape_light"] = @$row["logo_landscape_light"];

$r["setting"] = @$row["setting"];
$r["name"] = @$row["name"];
$r["value"] = @$row["value"];
$r["author"] = @$row["author"];
$r["created_at"] = @$row["created_at"];
$r["updated_at"] = @$row["updated_at"];
$r["deleted_at"] = @$row["deleted_at"];
//[Fields]--------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("client", $r["client"]);
$f->fields["logo"] = $f->get_FieldFile("logo", array("value" => $r["logo"], "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["logo"] = $f->get_FieldFile("logo", array("value" => $r["logo"]));
$f->fields["logo_portrait"] = $f->get_FieldFile("logo_portrait", array("value" => $r["logo_portrait"]));
$f->fields["logo_portrait_light"] = $f->get_FieldFile("logo_portrait_light", array("value" => $r["logo_portrait_light"]));
$f->fields["logo_landscape"] = $f->get_FieldFile("logo_landscape", array("value" => $r["logo_landscape"]));
$f->fields["logo_landscape_light"] = $f->get_FieldFile("logo_landscape_light", array("value" => $r["logo_landscape_light"]));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/settings", "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[Groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["logo"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["logo_portrait"] . $f->fields["logo_portrait_light"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["logo_landscape"] . $f->fields["logo_landscape_light"])));
//$f->groups["g2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["author"].$f->fields["created_at"].$f->fields["updated_at"])));
//$f->groups["g3"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["deleted_at"])));
//[Buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[Build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-logotypes", array(
    "title" => lang("Settings.settings-logotypes-view-title"),
    "header-back" => "/settings/",
    "content" => $f
));
echo($card);
?>