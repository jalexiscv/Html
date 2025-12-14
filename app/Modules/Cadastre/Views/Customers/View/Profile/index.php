<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-06-22 13:47:15
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Cadastre\Views\Profiles\Editor\form.php]
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
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Profiles."));
//[Request]-----------------------------------------------------------------------------
$mcp = model("App\Modules\Cadastre\Models\Cadastre_Profiles");
$mcg = model("App\Modules\Cadastre\Models\Cadastre_Georeferences");

$profile = $request->getVar("profile");
if (!empty($profile)) {
    $row = $mcp->find($profile);
    if (!isset($row['profile'])) {
        $row = $mcp->where('customer', $oid)->orderBy('created_at', 'DESC')->first();
    }
} else {
    $row = $mcp->where('customer', $oid)->orderBy('created_at', 'DESC')->first();
}

$profile = str_pad($row["profile"], 10, '0', STR_PAD_LEFT);
//echo($profile);
$georeference = $mcg->get_ByRegistration($row["registration"]);
if (!isset($georeference['registration'])) {
    $georeference = array();
    $georeference['latitude_decimal'] = 0;
    $georeference['longitude_decimal'] = 0;
}


$r["profile"] = $row["profile"];
$r["customer"] = $row["customer"];
$r["type"] = $row["type"];
$r["registration"] = $row["registration"];
$r["names"] = $row["names"];
$r["firstname"] = $row["firstname"];
$r["lastname"] = $row["lastname"];
$r["address"] = $row["address"];
$r["cycle"] = $row["cycle"];
$r["stratum"] = $row["stratum"];
$r["use_type"] = $row["use_type"];
$r["consumption"] = $row["consumption"];
$r["service"] = $row["service"];
$r["neighborhood_description"] = $row["neighborhood_description"];
$r["unit_id"] = $row["unit_id"];
$r["phone"] = $row["phone"];
$r["entry_date"] = $row["entry_date"];
$r["reading_route"] = $row["reading_route"];
$r["national_property_number"] = $row["national_property_number"];
$r["rate"] = $row["rate"];
$r["route_sequence"] = $row["route_sequence"];
$r["diameter"] = $row["diameter"];
$r["meter_number"] = $row["meter_number"];
$r["historical"] = $row["historical"];
$r["longitude"] = $georeference["longitude_decimal"];
$r["latitude"] = $georeference["latitude_decimal"];
$r["status"] = $row["status"];
$back = "/cadastre/customers/list/" . lpk();
//[Fields]-----------------------------------------------------------------------------
$f->fields["profile"] = $f->get_FieldView("profile", array("value" => $r["profile"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["customer"] = $f->get_FieldView("customer", array("value" => $r["customer"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["type"] = $f->get_FieldView("type", array("value" => $r["type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["registration"] = $f->get_FieldView("registration", array("value" => $r["registration"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["names"] = $f->get_FieldView("names", array("value" => $r["names"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["firstname"] = $f->get_FieldView("firstname", array("value" => $r["firstname"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["lastname"] = $f->get_FieldView("lastname", array("value" => $r["lastname"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["address"] = $f->get_FieldView("address", array("value" => $r["address"], "proportion" => "col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"));
$f->fields["cycle"] = $f->get_FieldView("cycle", array("value" => $r["cycle"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["stratum"] = $f->get_FieldView("stratum", array("value" => $r["stratum"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["use_type"] = $f->get_FieldView("use_type", array("value" => $r["use_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["consumption"] = $f->get_FieldView("consumption", array("value" => $r["consumption"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["service"] = $f->get_FieldView("service", array("value" => $r["service"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["neighborhood_description"] = $f->get_FieldView("neighborhood_description", array("value" => $r["neighborhood_description"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["unit_id"] = $f->get_FieldView("unit_id", array("value" => $r["unit_id"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["phone"] = $f->get_FieldView("phone", array("value" => $r["phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["entry_date"] = $f->get_FieldView("entry_date", array("value" => $r["entry_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["reading_route"] = $f->get_FieldView("reading_route", array("value" => $r["reading_route"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["national_property_number"] = $f->get_FieldView("national_property_number", array("value" => $r["national_property_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["rate"] = $f->get_FieldView("rate", array("value" => $r["rate"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["route_sequence"] = $f->get_FieldView("route_sequence", array("value" => $r["route_sequence"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["diameter"] = $f->get_FieldView("diameter", array("value" => $r["diameter"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["meter_number"] = $f->get_FieldView("meter_number", array("value" => $r["meter_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["historical"] = $f->get_FieldView("historical", array("value" => $r["historical"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["longitude"] = $f->get_FieldView("longitude", array("value" => $r["longitude"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["latitude"] = $f->get_FieldView("latitude", array("value" => $r["latitude"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldView("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/cadastre/customers/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));

$map = new App\Libraries\Maps();
$map->set_LatAndLngFields($f->get_FieldId('latitude'), $f->get_FieldId('longitude'));

$map->add_Marker($georeference['latitude_decimal'], $georeference['longitude_decimal'], array(
    'title' => 'Eiffel Tower',
    'defColor' => '#FA6D6D',
    'defSymbol' => 'C',
    'infoCloseOthers' => true
));

$map->set_Center($georeference['latitude_decimal'], $georeference['longitude_decimal']);
$map->set_Zoom(14);
$f->fields["map"] = $map;

//[Groups]-----------------------------------------------------------------------------
//$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["profile"] . $f->fields["customer"] . $f->fields["registration"])));
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["names"] . $f->fields["firstname"] . $f->fields["lastname"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["address"] . $f->fields["cycle"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["stratum"] . $f->fields["use_type"] . $f->fields["consumption"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["service"] . $f->fields["neighborhood_description"] . $f->fields["unit_id"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["phone"] . $f->fields["entry_date"] . $f->fields["reading_route"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["national_property_number"] . $f->fields["rate"] . $f->fields["route_sequence"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["diameter"] . $f->fields["meter_number"] . $f->fields["historical"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["latitude"] . $f->fields["longitude"] . $f->fields["status"])));
//$f->groups["g9"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["map"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[Build]-----------------------------------------------------------------------------


$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Perfil {$r["profile"] }",
    "header-back" => $back,
    "content" => $f,
));
echo($card);
?>