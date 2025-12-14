<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-06-22 13:47:15
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Cadastre\Views\Profiles\Editor\processor.php]
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
if (isset($row["profile"])) {
    $edit = $model->update($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Profiles.view-success-title"));
    $smarty->assign("message", sprintf(lang("Profiles.view-success-message"), $d['profile']));
    $smarty->assign("edit", base_url("/cadastre/profiles/edit/{$d['profile']}/" . lpk()));
    $smarty->assign("continue", base_url("/cadastre/profiles/view/{$d["profile"]}/" . lpk()));
    $smarty->assign("voice", "cadastre/profiles-view-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Profiles.view-noexist-title"));
    $smarty->assign("message", lang("Profiles.view-noexist-message"));
    $smarty->assign("continue", base_url("/cadastre/profiles"));
    $smarty->assign("voice", "cadastre/profiles-view-noexist-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);
?>
