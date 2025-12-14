<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-07-05 05:15:10
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Application\Views\Clients\Editor\form.php]
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
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Plex_Clients."));
//[Request]-----------------------------------------------------------------------------
$row = $model->getClient($oid);
$r["client"] = $row["client"];
$r["name"] = $row["name"];
$r["rut"] = $row["rut"];
$r["vpn"] = $row["vpn"];
$r["users"] = $row["users"];
$r["domain"] = $row["domain"];
$r["default_url"] = $row["default_url"];
$r["db_host"] = $row["db_host"];
$r["db_port"] = $row["db_port"];
$r["db"] = $row["db"];
$r["db_user"] = $row["db_user"];
$r["db_password"] = $row["db_password"];
$r["status"] = $row["status"];
$r["logo"] = $row["logo"];
$r["logo_portrait"] = $row["logo_portrait"];
$r["logo_portrait_light"] = $row["logo_portrait_light"];
$r["logo_landscape"] = $row["logo_landscape"];
$r["logo_landscape_light"] = $row["logo_landscape_light"];
$r["theme"] = $row["theme"];
$r["theme_color"] = $row["theme_color"];
$r["fb_app_id"] = $row["fb_app_id"];
$r["fb_app_secret"] = $row["fb_app_secret"];
$r["fb_page"] = $row["fb_page"];
$r["footer"] = $row["footer"];
$r["google_trackingid"] = $row["google_trackingid"];
$r["google_ad_client"] = $row["google_ad_client"];
$r["google_ad_display_square"] = $row["google_ad_display_square"];
$r["google_ad_display_rectangle"] = $row["google_ad_display_rectangle"];
$r["google_ad_links_retangle"] = $row["google_ad_links_retangle"];
$r["google_ad_display_vertical"] = $row["google_ad_display_vertical"];
$r["google_ad_infeed"] = $row["google_ad_infeed"];
$r["google_ad_inarticle"] = $row["google_ad_inarticle"];
$r["google_ad_matching_content"] = $row["google_ad_matching_content"];
$r["google_ad_links_square"] = $row["google_ad_links_square"];
$r["arc_id"] = $row["arc_id"];
$r["matomo"] = $row["matomo"];
$r["author"] = $row["author"];
$r["created_at"] = $row["created_at"];
$r["updated_at"] = $row["updated_at"];
$r["deleted_at"] = $row["deleted_at"];
$back = "/plex/clients/list/" . lpk();
//[Fields]-----------------------------------------------------------------------------
$f->fields["client"] = $f->get_FieldView("client", array("value" => $r["client"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldView("name", array("value" => $r["name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["rut"] = $f->get_FieldView("rut", array("value" => $r["rut"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["vpn"] = $f->get_FieldView("vpn", array("value" => $r["vpn"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["users"] = $f->get_FieldView("users", array("value" => $r["users"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["domain"] = $f->get_FieldView("domain", array("value" => $r["domain"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["default_url"] = $f->get_FieldView("default_url", array("value" => $r["default_url"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["db_host"] = $f->get_FieldView("db_host", array("value" => $r["db_host"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["db_port"] = $f->get_FieldView("db_port", array("value" => $r["db_port"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["db"] = $f->get_FieldView("db", array("value" => $r["db"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["db_user"] = $f->get_FieldView("db_user", array("value" => $r["db_user"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["db_password"] = $f->get_FieldView("db_password", array("value" => $r["db_password"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldView("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["logo"] = $f->get_FieldView("logo", array("value" => $r["logo"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["logo_portrait"] = $f->get_FieldView("logo_portrait", array("value" => $r["logo_portrait"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["logo_portrait_light"] = $f->get_FieldView("logo_portrait_light", array("value" => $r["logo_portrait_light"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["logo_landscape"] = $f->get_FieldView("logo_landscape", array("value" => $r["logo_landscape"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["logo_landscape_light"] = $f->get_FieldView("logo_landscape_light", array("value" => $r["logo_landscape_light"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["theme"] = $f->get_FieldView("theme", array("value" => $r["theme"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["theme_color"] = $f->get_FieldView("theme_color", array("value" => $r["theme_color"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["fb_app_id"] = $f->get_FieldView("fb_app_id", array("value" => $r["fb_app_id"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["fb_app_secret"] = $f->get_FieldView("fb_app_secret", array("value" => $r["fb_app_secret"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["fb_page"] = $f->get_FieldView("fb_page", array("value" => $r["fb_page"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["footer"] = $f->get_FieldView("footer", array("value" => $r["footer"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_trackingid"] = $f->get_FieldView("google_trackingid", array("value" => $r["google_trackingid"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_client"] = $f->get_FieldView("google_ad_client", array("value" => $r["google_ad_client"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_display_square"] = $f->get_FieldView("google_ad_display_square", array("value" => $r["google_ad_display_square"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_display_rectangle"] = $f->get_FieldView("google_ad_display_rectangle", array("value" => $r["google_ad_display_rectangle"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_links_retangle"] = $f->get_FieldView("google_ad_links_retangle", array("value" => $r["google_ad_links_retangle"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_display_vertical"] = $f->get_FieldView("google_ad_display_vertical", array("value" => $r["google_ad_display_vertical"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_infeed"] = $f->get_FieldView("google_ad_infeed", array("value" => $r["google_ad_infeed"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_inarticle"] = $f->get_FieldView("google_ad_inarticle", array("value" => $r["google_ad_inarticle"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_matching_content"] = $f->get_FieldView("google_ad_matching_content", array("value" => $r["google_ad_matching_content"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_links_square"] = $f->get_FieldView("google_ad_links_square", array("value" => $r["google_ad_links_square"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["arc_id"] = $f->get_FieldView("arc_id", array("value" => $r["arc_id"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["matomo"] = $f->get_FieldView("matomo", array("value" => $r["matomo"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/plex/clients/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["client"] . $f->fields["name"] . $f->fields["rut"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["vpn"] . $f->fields["users"] . $f->fields["domain"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["default_url"] . $f->fields["db_host"] . $f->fields["db_port"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["db"] . $f->fields["db_user"] . $f->fields["db_password"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["status"] . $f->fields["logo"] . $f->fields["logo_portrait"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["logo_portrait_light"] . $f->fields["logo_landscape"] . $f->fields["logo_landscape_light"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["theme"] . $f->fields["theme_color"] . $f->fields["fb_app_id"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["fb_app_secret"] . $f->fields["fb_page"] . $f->fields["footer"])));
$f->groups["g9"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["google_trackingid"] . $f->fields["google_ad_client"] . $f->fields["google_ad_display_square"])));
$f->groups["g10"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["google_ad_display_rectangle"] . $f->fields["google_ad_links_retangle"] . $f->fields["google_ad_display_vertical"])));
$f->groups["g11"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["google_ad_infeed"] . $f->fields["google_ad_inarticle"] . $f->fields["google_ad_matching_content"])));
$f->groups["g12"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["google_ad_links_square"] . $f->fields["arc_id"] . $f->fields["matomo"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => lang("Clients.view-title"),
    "header-back" => $back,
    "content" => $f,
));
echo($card);
?>