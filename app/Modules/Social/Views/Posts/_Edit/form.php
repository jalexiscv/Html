<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-03-30 18:05:01
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Social\Views\Posts\Editor\form.php]
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
$f = service("forms", array("lang" => "Posts."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Social\Models\Social_Posts");
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->where('post', $oid)->first();
$r["post"] = $f->get_Value("post", $row["post"]);
$r["semantic"] = $f->get_Value("semantic", $row["semantic"]);
$r["title"] = $f->get_Value("title", $row["title"]);
$r["content"] = $f->get_Value("content", $row["content"]);
$r["type"] = $f->get_Value("type", $row["type"]);
$r["cover"] = $f->get_Value("cover", $row["cover"]);
$r["cover_visible"] = $f->get_Value("cover_visible", $row["cover_visible"]);
$r["description"] = $f->get_Value("description", $row["description"]);
$r["date"] = $f->get_Value("date", service("dates")::get_Date());
$r["time"] = $f->get_Value("time", service("dates")::get_Time());
$r["country"] = $f->get_Value("country", $row["country"]);
$r["region"] = $f->get_Value("region", $row["region"]);
$r["city"] = $f->get_Value("city", $row["city"]);
$r["latitude"] = $f->get_Value("latitude", $row["latitude"]);
$r["longitude"] = $f->get_Value("longitude", $row["longitude"]);
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$r["views"] = $f->get_Value("views", $row["views"]);
$r["views_initials"] = $f->get_Value("views_initials", $row["views_initials"]);
$r["viewers"] = $f->get_Value("viewers", $row["viewers"]);
$r["likes"] = $f->get_Value("likes", $row["likes"]);
$r["shares"] = $f->get_Value("shares", $row["shares"]);
$r["comments"] = $f->get_Value("comments", $row["comments"]);
$r["video"] = $f->get_Value("video", $row["video"]);
$r["source"] = $f->get_Value("source", $row["source"]);
$r["source_alias"] = $f->get_Value("source_alias", $row["source_alias"]);
$r["verified"] = $f->get_Value("verified", $row["verified"]);
$r["status"] = $f->get_Value("status", $row["status"]);
$back = "/social/posts/list/" . lpk();
//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["post"] = $f->get_FieldText("post", array("value" => $r["post"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["semantic"] = $f->get_FieldText("semantic", array("value" => $r["semantic"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["title"] = $f->get_FieldText("title", array("value" => $r["title"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["content"] = $f->get_FieldText("content", array("value" => $r["content"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["type"] = $f->get_FieldText("type", array("value" => $r["type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cover"] = $f->get_FieldText("cover", array("value" => $r["cover"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cover_visible"] = $f->get_FieldText("cover_visible", array("value" => $r["cover_visible"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["description"] = $f->get_FieldText("description", array("value" => $r["description"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["date"] = $f->get_FieldText("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldText("time", array("value" => $r["time"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["country"] = $f->get_FieldText("country", array("value" => $r["country"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["region"] = $f->get_FieldText("region", array("value" => $r["region"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["city"] = $f->get_FieldText("city", array("value" => $r["city"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["latitude"] = $f->get_FieldText("latitude", array("value" => $r["latitude"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["longitude"] = $f->get_FieldText("longitude", array("value" => $r["longitude"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["views"] = $f->get_FieldText("views", array("value" => $r["views"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["views_initials"] = $f->get_FieldText("views_initials", array("value" => $r["views_initials"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["viewers"] = $f->get_FieldText("viewers", array("value" => $r["viewers"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["likes"] = $f->get_FieldText("likes", array("value" => $r["likes"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["shares"] = $f->get_FieldText("shares", array("value" => $r["shares"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["comments"] = $f->get_FieldText("comments", array("value" => $r["comments"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["video"] = $f->get_FieldText("video", array("value" => $r["video"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["source"] = $f->get_FieldText("source", array("value" => $r["source"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["source_alias"] = $f->get_FieldText("source_alias", array("value" => $r["source_alias"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["verified"] = $f->get_FieldText("verified", array("value" => $r["verified"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldText("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["post"] . $f->fields["semantic"] . $f->fields["title"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["content"] . $f->fields["type"] . $f->fields["cover"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["cover_visible"] . $f->fields["description"] . $f->fields["date"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["time"] . $f->fields["country"] . $f->fields["region"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["city"] . $f->fields["latitude"] . $f->fields["longitude"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["author"] . $f->fields["created_at"] . $f->fields["updated_at"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["deleted_at"] . $f->fields["views"] . $f->fields["views_initials"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["viewers"] . $f->fields["likes"] . $f->fields["shares"])));
$f->groups["g9"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["comments"] . $f->fields["video"] . $f->fields["source"])));
$f->groups["g10"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["source_alias"] . $f->fields["verified"] . $f->fields["status"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => lang("Posts.edit-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>
