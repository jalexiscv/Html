<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-03-30 18:05:00
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
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Posts."));
//[Request]-----------------------------------------------------------------------------
$row = $model->find($oid);
$r["post"] = $row["post"];
$r["semantic"] = $row["semantic"];
$r["title"] = $row["title"];
$r["content"] = $row["content"];
$r["type"] = $row["type"];
$r["cover"] = $row["cover"];
$r["cover_visible"] = $row["cover_visible"];
$r["description"] = $row["description"];
$r["date"] = $row["date"];
$r["time"] = $row["time"];
$r["country"] = $row["country"];
$r["region"] = $row["region"];
$r["city"] = $row["city"];
$r["latitude"] = $row["latitude"];
$r["longitude"] = $row["longitude"];
$r["author"] = $row["author"];
$r["created_at"] = $row["created_at"];
$r["updated_at"] = $row["updated_at"];
$r["deleted_at"] = $row["deleted_at"];
$r["views"] = $row["views"];
$r["views_initials"] = $row["views_initials"];
$r["viewers"] = $row["viewers"];
$r["likes"] = $row["likes"];
$r["shares"] = $row["shares"];
$r["comments"] = $row["comments"];
$r["video"] = $row["video"];
$r["source"] = $row["source"];
$r["source_alias"] = $row["source_alias"];
$r["verified"] = $row["verified"];
$r["status"] = $row["status"];
$back = "/social/posts/list/" . lpk();
//[Fields]-----------------------------------------------------------------------------
$f->fields["post"] = $f->get_FieldView("post", array("value" => $r["post"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["semantic"] = $f->get_FieldView("semantic", array("value" => $r["semantic"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["title"] = $f->get_FieldView("title", array("value" => $r["title"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["content"] = $f->get_FieldView("content", array("value" => $r["content"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["type"] = $f->get_FieldView("type", array("value" => $r["type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cover"] = $f->get_FieldView("cover", array("value" => $r["cover"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cover_visible"] = $f->get_FieldView("cover_visible", array("value" => $r["cover_visible"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["description"] = $f->get_FieldView("description", array("value" => $r["description"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["date"] = $f->get_FieldView("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldView("time", array("value" => $r["time"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["country"] = $f->get_FieldView("country", array("value" => $r["country"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["region"] = $f->get_FieldView("region", array("value" => $r["region"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["city"] = $f->get_FieldView("city", array("value" => $r["city"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["latitude"] = $f->get_FieldView("latitude", array("value" => $r["latitude"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["longitude"] = $f->get_FieldView("longitude", array("value" => $r["longitude"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["views"] = $f->get_FieldView("views", array("value" => $r["views"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["views_initials"] = $f->get_FieldView("views_initials", array("value" => $r["views_initials"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["viewers"] = $f->get_FieldView("viewers", array("value" => $r["viewers"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["likes"] = $f->get_FieldView("likes", array("value" => $r["likes"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["shares"] = $f->get_FieldView("shares", array("value" => $r["shares"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["comments"] = $f->get_FieldView("comments", array("value" => $r["comments"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["video"] = $f->get_FieldView("video", array("value" => $r["video"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["source"] = $f->get_FieldView("source", array("value" => $r["source"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["source_alias"] = $f->get_FieldView("source_alias", array("value" => $r["source_alias"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["verified"] = $f->get_FieldView("verified", array("value" => $r["verified"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldView("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/social/posts/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
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
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang("Posts.view-title"),
    "header-back" => $back,
    "content" => $f,
));
echo($card);
?>
