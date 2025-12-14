<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-06-22 13:47:14
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Cadastre\Views\Profiles\Creator\processor.php]
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
$f = service("forms", array("lang" => "Profiles."));
$model = model("App\Modules\Cadastre\Models\Cadastre_Profiles");
$d = array(
    "profile" => $f->get_Value("profile"),
    "customer" => $f->get_Value("customer"),
    "registration" => $f->get_Value("registration"),
    "names" => $f->get_Value("names"),
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
);
$row = $model->find($d["profile"]);
$l["back"] = "/cadastre/profiles/list/" . lpk();
$l["edit"] = "/cadastre/profiles/edit/{$d["profile"]}";
$asuccess = "cadastre/profiles-create-success-message.mp3";
$aexist = "cadastre/profiles-create-exist-message.mp3";
if (is_array($row)) {
    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Profiles.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Profiles.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Profiles.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Profiles.create-success-message"), $d['profile']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
?>
