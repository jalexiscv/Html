<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-07-05 05:15:11
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
//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Clients."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Application\Models\Plex_Clients");
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->getClient($oid);
$r["client"] = $f->get_Value("client", $row["client"]);
$r["name"] = $f->get_Value("name", $row["name"]);
$r["rut"] = $f->get_Value("rut", $row["rut"]);
$r["vpn"] = $f->get_Value("vpn", $row["vpn"]);
$r["users"] = $f->get_Value("users", $row["users"]);
$r["domain"] = $f->get_Value("domain", $row["domain"]);
$r["default_url"] = $f->get_Value("default_url", $row["default_url"]);
$r["db_host"] = $f->get_Value("db_host", $row["db_host"]);
$r["db_port"] = $f->get_Value("db_port", $row["db_port"]);
$r["db"] = $f->get_Value("db", $row["db"]);
$r["db_user"] = $f->get_Value("db_user", $row["db_user"]);
$r["db_password"] = $f->get_Value("db_password", $row["db_password"]);
$r["status"] = $f->get_Value("status", $row["status"]);
$r["logo"] = $f->get_Value("logo", $row["logo"]);
$r["logo_portrait"] = $f->get_Value("logo_portrait", $row["logo_portrait"]);
$r["logo_portrait_light"] = $f->get_Value("logo_portrait_light", $row["logo_portrait_light"]);
$r["logo_landscape"] = $f->get_Value("logo_landscape", $row["logo_landscape"]);
$r["logo_landscape_light"] = $f->get_Value("logo_landscape_light", $row["logo_landscape_light"]);
$r["theme"] = $f->get_Value("theme", $row["theme"]);
$r["theme_color"] = $f->get_Value("theme_color", $row["theme_color"]);
$r["fb_app_id"] = $f->get_Value("fb_app_id", $row["fb_app_id"]);
$r["fb_app_secret"] = $f->get_Value("fb_app_secret", $row["fb_app_secret"]);
$r["fb_page"] = $f->get_Value("fb_page", $row["fb_page"]);
$r["footer"] = $f->get_Value("footer", $row["footer"]);
$r["google_trackingid"] = $f->get_Value("google_trackingid", $row["google_trackingid"]);
$r["google_ad_client"] = $f->get_Value("google_ad_client", $row["google_ad_client"]);
$r["google_ad_display_square"] = $f->get_Value("google_ad_display_square", $row["google_ad_display_square"]);
$r["google_ad_display_rectangle"] = $f->get_Value("google_ad_display_rectangle", $row["google_ad_display_rectangle"]);
$r["google_ad_links_retangle"] = $f->get_Value("google_ad_links_retangle", $row["google_ad_links_retangle"]);
$r["google_ad_display_vertical"] = $f->get_Value("google_ad_display_vertical", $row["google_ad_display_vertical"]);
$r["google_ad_infeed"] = $f->get_Value("google_ad_infeed", $row["google_ad_infeed"]);
$r["google_ad_inarticle"] = $f->get_Value("google_ad_inarticle", $row["google_ad_inarticle"]);
$r["google_ad_matching_content"] = $f->get_Value("google_ad_matching_content", $row["google_ad_matching_content"]);
$r["google_ad_links_square"] = $f->get_Value("google_ad_links_square", $row["google_ad_links_square"]);
$r["arc_id"] = $f->get_Value("arc_id", $row["arc_id"]);
$r["matomo"] = $f->get_Value("matomo", $row["matomo"]);
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$back = "/plex/clients/list/" . lpk();
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("tab", "db");
$f->add_HiddenField("client", $r["client"]);
$f->fields["db_host"] = $f->get_FieldText("db_host", array("value" => $r["db_host"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["db_port"] = $f->get_FieldText("db_port", array("value" => $r["db_port"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["db"] = $f->get_FieldText("db", array("value" => $r["db"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["db_user"] = $f->get_FieldText("db_user", array("value" => $r["db_user"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["db_password"] = $f->get_FieldText("db_password", array("value" => $r["db_password"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["db_host"] . $f->fields["db_port"] . $f->fields["db"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["db_user"] . $f->fields["db_password"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
echo($f);
?>