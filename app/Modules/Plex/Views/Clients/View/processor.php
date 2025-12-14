<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-07-05 05:15:10
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Application\Views\Clients\Editor\processor.php]
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
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[vars]----------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Clients."));
$model = model("App\Modules\Application\Models\Plex_Clients");
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
//[build]---------------------------------------------------------------------------------------------------------------
$row = $model->find($d["client"]);
if (isset($row["client"])) {
//$edit = $model->update($d);
    $c = $bootstrap->get_Card('warning', array(
        'class' => 'card-warning',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Clients.view-success-title"),
        'text' => lang("Clients.view-success-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/plex/clients/view/{$d["client"]}/" . lpk()),
        'voice' => "application/clients-view-success-message.mp3",
    ));
} else {
    $c = $bootstrap->get_Card('success', array(
        'class' => 'card-success',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Clients.view-noexist-title"),
        'text' => lang("Clients.view-noexist-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/plex/clients"),
        'voice' => "application/clients-view-noexist-message.mp3",
    ));
}
echo($c);
?>
