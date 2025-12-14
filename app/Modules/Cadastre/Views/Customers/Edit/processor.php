<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-06-21 20:03:04
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Cadastre\Views\Customers\Editor\processor.php]
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
//[Models]-----------------------------------------------------------------------------
$mcustomers = model("App\Modules\Cadastre\Models\Cadastre_Customers");
$mprofiles = model("App\Modules\Cadastre\Models\Cadastre_Profiles");
$mgeoreferences = model("App\Modules\Cadastre\Models\Cadastre_Georeferences");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Customers."));
$d = array(
    "customer" => $f->get_Value("customer"),
    "registration" => $f->get_Value("registration"),
    "date" => $f->get_Value("date"),
    "time" => $f->get_Value("time"),
    "author" => safe_get_user(),
);

$profile = array(
    "profile" => pk(),
    "customer" => $f->get_Value("customer"),
    "type" => $f->get_Value("type"),
    "registration" => $f->get_Value("registration"),
    "names" => $f->get_Value("names"),
    "firstname" => safe_trim($f->get_Value("firstname")),
    "lastname" => safe_trim($f->get_Value("lastname")),
    "address" => $f->get_Value("address"),
    "cycle" => $f->get_Value("cycle"),
    "stratum" => $f->get_Value("stratum"),
    "use_type" => $f->get_Value("use_type"),
    "consumption" => $f->get_Value("consumption"),
    "service" => $f->get_Value("service"),
    "neighborhood_description" => $f->get_Value("neighborhood_description"),
    "unit_id" => $f->get_Value("unit_id"),
    "phone" => $f->get_Value("phone"),
    "entry_date" => $f->get_Value("entry_date"),
    "reading_route" => $f->get_Value("reading_route"),
    "national_property_number" => $f->get_Value("national_property_number"),
    "rate" => $f->get_Value("rate"),
    "route_sequence" => $f->get_Value("route_sequence"),
    "diameter" => $f->get_Value("diameter"),
    "meter_number" => $f->get_Value("meter_number"),
    "historical" => $f->get_Value("historical"),
    "longitude" => $f->get_Value("longitude"),
    "latitude" => $f->get_Value("latitude"),
    "status" => $f->get_Value("status"),
);
//print_r($profile);
//[Elements]------------------------------------------------------------------------------------------------------------
$row = $model->find($d["customer"]);
$l["back"] = "/cadastre/customers/view/{$d["customer"]}";
$l["edit"] = "/cadastre/customers/edit/{$d["customer"]}";
$asuccess = "cadastre/customers-edit-success-message.mp3";
$anoexist = "cadastre/customers-edit-noexist-message.mp3";
//[Build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    //print_r($profile);
    $create = $mprofiles->insert($profile);

    //[georeferences]---------------------------------------------------------------------------------------------------
    $latitude_decimal = $profile["latitude"];
    $longitude_decimal = $profile["longitude"];
    // Latitud
    $latitude = $latitude_decimal >= 0 ? 'N' : 'S';
    $latitude_decimal = ($latitude_decimal != 0) ? abs($latitude_decimal) : "0.0";
    $latitude_degrees = floor($latitude_decimal);
    $latitude_minutes = floor(($latitude_decimal - $latitude_degrees) * 60);
    $latitude_seconds = ($latitude_decimal - $latitude_degrees - ($latitude_minutes / 60)) * 3600;
    // Longitud
    $longitude = $longitude_decimal >= 0 ? 'E' : 'W';
    $longitude_decimal = ($longitude_decimal != 0) ? abs($longitude_decimal) : "0.0";
    $longitude_degrees = floor($longitude_decimal);
    $longitude_minutes = floor(($longitude_decimal - $longitude_degrees) * 60);
    $longitude_seconds = ($longitude_decimal - $longitude_degrees - ($longitude_minutes / 60)) * 3600;

    $georeference = array(
        "georeference" => pk(),
        "registration" => $profile["registration"],
        "latitud" => $latitude,
        "latitude_degrees" => $latitude_degrees,
        "latitude_minutes" => $latitude_minutes,
        "latitude_seconds" => $latitude_seconds,
        "latitude_decimal" => $profile["latitude"],
        "longitude" => $longitude,
        "longitude_degrees" => $longitude_degrees,
        "longitude_minutes" => $longitude_minutes,
        "longitude_seconds" => $longitude_seconds,
        "longitude_decimal" => $profile["longitude"],
        "date" => safe_get_date(),
        "time" => safe_get_time(),
        "author" => safe_get_user(),
    );
    //print_r($georeference);

    $create = $mgeoreferences->insert($georeference);

    $delete = $mgeoreferences
        ->where('registration', $georeference["registration"])
        ->where('created_at', null)
        ->delete();


    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Customers.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Customers.edit-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Customers.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Customers.edit-noexist-message"), $d['customer']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>