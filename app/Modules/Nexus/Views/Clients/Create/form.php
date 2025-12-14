<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-10-27 05:29:55
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
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Application\Models\Application_Clients");
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Nexus."));
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
$back = "/nexus/clients/list/" . lpk();
//[fields]--------------------------------------------------------------------------------------------------------------
$f->fields["client"] = $f->get_FieldText("client", array("value" => @$r["client"], "readonly" => true));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"]));
$f->fields["domain"] = $f->get_FieldText("domain", array("value" => $r["domain"]));
$f->fields["default_url"] = $f->get_FieldText("default_url", array("value" => $r["default_url"]));
$f->fields["logo"] = $f->get_FieldFile("logo", array("value" => $r["logo"]));
$f->fields["db"] = $f->get_FieldText("db", array("value" => $r["db"]));
$f->fields["db_host"] = $f->get_FieldText("db_host", array("value" => $r["db_host"]));
$f->fields["db_port"] = $f->get_FieldText("db_port", array("value" => $r["db_port"]));
$f->fields["db_user"] = $f->get_FieldText("db_user", array("value" => $r["db_user"]));
$f->fields["db_password"] = $f->get_FieldText("db_password", array("value" => $r["db_password"]));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["client"] . $f->fields["name"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["domain"] . $f->fields["default_url"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["logo"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["db"] . $f->fields["db_host"] . $f->fields["db_port"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["db_user"] . $f->fields["db_password"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => lang("Application.clients-create-title"),
    "content" => $f,
));
echo($card);
?>