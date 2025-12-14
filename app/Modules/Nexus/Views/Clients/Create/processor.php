<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-10-27 04:59:34
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Application\Views\Clients\Creator\processor.php]
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
$f = service("forms", array("lang" => "Nexus."));
$model = model("App\Modules\Application\Models\Application_Clients");
$d = array(
    "client" => $f->get_Value("client"),
    "name" => $f->get_Value("name"),
    "rut" => $f->get_Value("rut"),
    "vpn" => $f->get_Value("vpn"),
    "users" => $f->get_Value("users"),
    "domain" => $f->get_Value("domain"),
    "default_url" => $f->get_Value("default_url"),
    "db_host" => $f->get_Value("db_host"),
    "db_port" => $f->get_Value("db_port"),
    "db" => $f->get_Value("db"),
    "db_user" => $f->get_Value("db_user"),
    "db_password" => $f->get_Value("db_password"),
    "status" => $f->get_Value("status"),
    "logo" => $f->get_Value("logo"),
    "logo_portrait" => $f->get_Value("logo_portrait"),
    "logo_portrait_light" => $f->get_Value("logo_portrait_light"),
    "logo_landscape" => $f->get_Value("logo_landscape"),
    "logo_landscape_light" => $f->get_Value("logo_landscape_light"),
    "theme" => $f->get_Value("theme"),
    "theme_color" => $f->get_Value("theme_color"),
    "fb_app_id" => $f->get_Value("fb_app_id"),
    "fb_app_secret" => $f->get_Value("fb_app_secret"),
    "fb_page" => $f->get_Value("fb_page"),
    "footer" => $f->get_Value("footer"),
    "google_trackingid" => $f->get_Value("google_trackingid"),
    "google_ad_client" => $f->get_Value("google_ad_client"),
    "google_ad_display_square" => $f->get_Value("google_ad_display_square"),
    "google_ad_display_rectangle" => $f->get_Value("google_ad_display_rectangle"),
    "google_ad_links_retangle" => $f->get_Value("google_ad_links_retangle"),
    "google_ad_display_vertical" => $f->get_Value("google_ad_display_vertical"),
    "google_ad_infeed" => $f->get_Value("google_ad_infeed"),
    "google_ad_inarticle" => $f->get_Value("google_ad_inarticle"),
    "google_ad_matching_content" => $f->get_Value("google_ad_matching_content"),
    "google_ad_links_square" => $f->get_Value("google_ad_links_square"),
    "arc_id" => $f->get_Value("arc_id"),
    "matomo" => $f->get_Value("matomo"),
    "author" => safe_get_user(),
);
$row = $model->find($d["client"]);
$l["back"] = "/nexus/clients/list/" . lpk();
$l["edit"] = "/nexus/clients/edit/{$d["client"]}";
$asuccess = "application/clients-create-success-message.mp3";
$aexist = "application/clients-create-exist-message.mp3";
if (is_array($row)) {
    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Nexus.clients-create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Nexus.clients-create-duplicate-message"),
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
        "title" => lang("Nexus.clients-create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Nexus.clients-create-success-message"), $d['client']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
?>
