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

$profile = str_pad($row["profile"], 13, '0', STR_PAD_LEFT);
//echo($profile);

$georeference = $mcg->get_ByRegistration($row["registration"]);
if (!isset($georeference['registration'])) {
    $georeference = array();
    $georeference['latitude_decimal'] = 0;
    $georeference['longitude_decimal'] = 0;
}


$r["profile"] = $f->get_Value("profile", $row["profile"]);
$r["customer"] = $f->get_Value("customer", $row["customer"]);
$r["type"] = $f->get_Value("type", $row["type"]);
$r["registration"] = $f->get_Value("registration", $row["registration"]);
$r["names"] = $f->get_Value("names", $row["names"]);
$r["firstname"] = $f->get_Value("firstname", $row["firstname"]);
$r["lastname"] = $f->get_Value("lastname", $row["lastname"]);
$r["address"] = $f->get_Value("address", $row["address"]);
$r["cycle"] = $f->get_Value("cycle", $row["cycle"]);
$r["stratum"] = $f->get_Value("stratum", $row["stratum"]);
$r["use_type"] = $f->get_Value("use_type", $row["use_type"]);
$r["consumption"] = $f->get_Value("consumption", $row["consumption"]);
$r["service"] = $f->get_Value("service", $row["service"]);
$r["neighborhood_description"] = $f->get_Value("neighborhood_description", $row["neighborhood_description"]);
$r["unit_id"] = $f->get_Value("unit_id", $row["unit_id"]);
$r["phone"] = $f->get_Value("phone", $row["phone"]);
$r["entry_date"] = $f->get_Value("entry_date", $row["entry_date"]);
$r["reading_route"] = $f->get_Value("reading_route", $row["reading_route"]);
$r["national_property_number"] = $f->get_Value("national_property_number", $row["national_property_number"]);
$r["rate"] = $f->get_Value("rate", $row["rate"]);
$r["route_sequence"] = $f->get_Value("route_sequence", $row["route_sequence"]);
$r["diameter"] = $f->get_Value("diameter", $row["diameter"]);
$r["meter_number"] = $f->get_Value("meter_number", $row["meter_number"]);
$r["historical"] = $f->get_Value("historical", $row["historical"]);
$r["longitude"] = $f->get_Value("longitude", $georeference["longitude_decimal"]);
$r["latitude"] = $f->get_Value("latitude", $georeference["latitude_decimal"]);
$r["status"] = $f->get_Value("status", $row["status"]);
$back = "/cadastre/customers/view/{$oid}";
$statuses = array(
    array("label" => "Activo", "value" => "ACTIVE"),
    array("label" => "Inactivo", "value" => "INACTIVE"),
);
//[Fields]-----------------------------------------------------------------------------
$f->add_HiddenField("customer", $r["customer"]);
$f->add_HiddenField("registration", $r["registration"]);
$f->fields["profile"] = $f->get_FieldText("profile", array("value" => $r["profile"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
//$f->fields["customer"] = $f->get_FieldText("customer", array("value" => $r["customer"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["type"] = $f->get_FieldText("type", array("value" => $r["type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
//$f->fields["registration"] = $f->get_FieldText("registration", array("value" => $r["registration"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["names"] = $f->get_FieldText("names", array("value" => $r["names"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["firstname"] = $f->get_FieldText("firstname", array("value" => $r["firstname"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["lastname"] = $f->get_FieldText("lastname", array("value" => $r["lastname"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["address"] = $f->get_FieldText("address", array("value" => $r["address"], "proportion" => "col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"));
$f->fields["cycle"] = $f->get_FieldText("cycle", array("value" => $r["cycle"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["stratum"] = $f->get_FieldText("stratum", array("value" => $r["stratum"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["use_type"] = $f->get_FieldText("use_type", array("value" => $r["use_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["consumption"] = $f->get_FieldText("consumption", array("value" => $r["consumption"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["service"] = $f->get_FieldText("service", array("value" => $r["service"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["neighborhood_description"] = $f->get_FieldText("neighborhood_description", array("value" => $r["neighborhood_description"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["unit_id"] = $f->get_FieldText("unit_id", array("value" => $r["unit_id"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["phone"] = $f->get_FieldText("phone", array("value" => $r["phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["entry_date"] = $f->get_FieldText("entry_date", array("value" => $r["entry_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["reading_route"] = $f->get_FieldText("reading_route", array("value" => $r["reading_route"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["national_property_number"] = $f->get_FieldText("national_property_number", array("value" => $r["national_property_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["rate"] = $f->get_FieldText("rate", array("value" => $r["rate"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["route_sequence"] = $f->get_FieldText("route_sequence", array("value" => $r["route_sequence"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["diameter"] = $f->get_FieldText("diameter", array("value" => $r["diameter"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["meter_number"] = $f->get_FieldText("meter_number", array("value" => $r["meter_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["historical"] = $f->get_FieldText("historical", array("value" => $r["historical"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["longitude"] = $f->get_FieldText("longitude", array("value" => $r["longitude"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["latitude"] = $f->get_FieldText("latitude", array("value" => $r["latitude"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldSelect("status", array("selected" => $r["status"], "data" => $statuses, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
//$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//$f->fields["edit"] = $f->get_Button("edit", array("href" => "/cadastre/profiles/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));


//[Groups]-----------------------------------------------------------------------------
//$f->groups["g0"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["profile"] . $f->fields["customer"] . $f->fields["registration"])));
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["names"] . $f->fields["firstname"] . $f->fields["lastname"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["address"] . $f->fields["cycle"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["stratum"] . $f->fields["use_type"] . $f->fields["consumption"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["service"] . $f->fields["neighborhood_description"] . $f->fields["unit_id"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["phone"] . $f->fields["entry_date"] . $f->fields["reading_route"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["national_property_number"] . $f->fields["rate"] . $f->fields["route_sequence"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["diameter"] . $f->fields["meter_number"] . $f->fields["historical"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["latitude"] . $f->fields["longitude"] . $f->fields["status"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[Build]-----------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Perfil {$r["profile"] }",
    "header-back" => $back,
    "content" => $f,
));
echo($card);
?>