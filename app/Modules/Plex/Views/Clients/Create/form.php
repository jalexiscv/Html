<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-07-05 05:15:08
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Application\Views\Clients\Creator\form.php]
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
$b = service("bootstrap");
$f = service("forms", array("lang" => "Plex_Clients."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Application\Models\Plex_Clients");
//[vars]----------------------------------------------------------------------------------------------------------------
$r["client"] = $f->get_Value("client", pk());
$r["name"] = $f->get_Value("name");
$r["rut"] = $f->get_Value("rut");
$r["vpn"] = $f->get_Value("vpn");
$r["users"] = $f->get_Value("users");
$r["domain"] = $f->get_Value("domain");
$r["default_url"] = $f->get_Value("default_url");
$r["db_host"] = $f->get_Value("db_host");
$r["db_port"] = $f->get_Value("db_port");
$r["db"] = $f->get_Value("db");
$r["db_user"] = $f->get_Value("db_user");
$r["db_password"] = $f->get_Value("db_password");
$r["status"] = $f->get_Value("status");
$r["logo"] = $f->get_Value("logo");
$r["logo_portrait"] = $f->get_Value("logo_portrait");
$r["logo_portrait_light"] = $f->get_Value("logo_portrait_light");
$r["logo_landscape"] = $f->get_Value("logo_landscape");
$r["logo_landscape_light"] = $f->get_Value("logo_landscape_light");
$r["theme"] = $f->get_Value("theme");
$r["theme_color"] = $f->get_Value("theme_color");
$r["fb_app_id"] = $f->get_Value("fb_app_id");
$r["fb_app_secret"] = $f->get_Value("fb_app_secret");
$r["fb_page"] = $f->get_Value("fb_page");
$r["footer"] = $f->get_Value("footer");
$r["google_trackingid"] = $f->get_Value("google_trackingid");
$r["google_ad_client"] = $f->get_Value("google_ad_client");
$r["google_ad_display_square"] = $f->get_Value("google_ad_display_square");
$r["google_ad_display_rectangle"] = $f->get_Value("google_ad_display_rectangle");
$r["google_ad_links_retangle"] = $f->get_Value("google_ad_links_retangle");
$r["google_ad_display_vertical"] = $f->get_Value("google_ad_display_vertical");
$r["google_ad_infeed"] = $f->get_Value("google_ad_infeed");
$r["google_ad_inarticle"] = $f->get_Value("google_ad_inarticle");
$r["google_ad_matching_content"] = $f->get_Value("google_ad_matching_content");
$r["google_ad_links_square"] = $f->get_Value("google_ad_links_square");
$r["arc_id"] = $f->get_Value("arc_id");
$r["matomo"] = $f->get_Value("matomo");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$back = "/plex/clients/list/" . lpk();
//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["client"] = $f->get_FieldText("client", array("value" => $r["client"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["rut"] = $f->get_FieldText("rut", array("value" => $r["rut"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["vpn"] = $f->get_FieldText("vpn", array("value" => $r["vpn"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["users"] = $f->get_FieldText("users", array("value" => $r["users"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["domain"] = $f->get_FieldText("domain", array("value" => $r["domain"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["default_url"] = $f->get_FieldText("default_url", array("value" => $r["default_url"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["db_host"] = $f->get_FieldText("db_host", array("value" => $r["db_host"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["db_port"] = $f->get_FieldText("db_port", array("value" => $r["db_port"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["db"] = $f->get_FieldText("db", array("value" => $r["db"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["db_user"] = $f->get_FieldText("db_user", array("value" => $r["db_user"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["db_password"] = $f->get_FieldText("db_password", array("value" => $r["db_password"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldText("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["logo"] = $f->get_FieldText("logo", array("value" => $r["logo"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["logo_portrait"] = $f->get_FieldText("logo_portrait", array("value" => $r["logo_portrait"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["logo_portrait_light"] = $f->get_FieldText("logo_portrait_light", array("value" => $r["logo_portrait_light"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["logo_landscape"] = $f->get_FieldText("logo_landscape", array("value" => $r["logo_landscape"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["logo_landscape_light"] = $f->get_FieldText("logo_landscape_light", array("value" => $r["logo_landscape_light"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["theme"] = $f->get_FieldText("theme", array("value" => $r["theme"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["theme_color"] = $f->get_FieldText("theme_color", array("value" => $r["theme_color"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["fb_app_id"] = $f->get_FieldText("fb_app_id", array("value" => $r["fb_app_id"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["fb_app_secret"] = $f->get_FieldText("fb_app_secret", array("value" => $r["fb_app_secret"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["fb_page"] = $f->get_FieldText("fb_page", array("value" => $r["fb_page"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["footer"] = $f->get_FieldText("footer", array("value" => $r["footer"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_trackingid"] = $f->get_FieldText("google_trackingid", array("value" => $r["google_trackingid"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_client"] = $f->get_FieldText("google_ad_client", array("value" => $r["google_ad_client"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_display_square"] = $f->get_FieldText("google_ad_display_square", array("value" => $r["google_ad_display_square"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_display_rectangle"] = $f->get_FieldText("google_ad_display_rectangle", array("value" => $r["google_ad_display_rectangle"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_links_retangle"] = $f->get_FieldText("google_ad_links_retangle", array("value" => $r["google_ad_links_retangle"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_display_vertical"] = $f->get_FieldText("google_ad_display_vertical", array("value" => $r["google_ad_display_vertical"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_infeed"] = $f->get_FieldText("google_ad_infeed", array("value" => $r["google_ad_infeed"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_inarticle"] = $f->get_FieldText("google_ad_inarticle", array("value" => $r["google_ad_inarticle"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_matching_content"] = $f->get_FieldText("google_ad_matching_content", array("value" => $r["google_ad_matching_content"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["google_ad_links_square"] = $f->get_FieldText("google_ad_links_square", array("value" => $r["google_ad_links_square"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["arc_id"] = $f->get_FieldText("arc_id", array("value" => $r["arc_id"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["matomo"] = $f->get_FieldText("matomo", array("value" => $r["matomo"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["client"] . $f->fields["name"] . $f->fields["rut"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["vpn"] . $f->fields["users"] . $f->fields["domain"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["default_url"] . $f->fields["status"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => lang("Clients.create-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>