<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-01-14 23:47:56
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Publisher\Views\Sites\Editor\form.php]
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
$f = service("forms", array("lang" => "Publisher.sites-"));
//[Request]-----------------------------------------------------------------------------
$row = $model->find($oid);
$r["site"] = $row["site"];
$r["image"] = $row["image"];
$r["name"] = $row["name"];
$r["description"] = $row["description"];
$r["max_links"] = $row["max_links"];
$r["links_type"] = $row["links_type"];
$r["sponsored"] = $row["sponsored"];
$r["post_cover"] = $row["post_cover"];
$r["categories"] = $row["categories"];
$r["min_traffic"] = $row["min_traffic"];
$r["max_traffic"] = $row["max_traffic"];
$r["type"] = $row["type"];
$r["themes"] = $row["themes"];
$r["moz_da"] = $row["moz_da"];
$r["moz_pa"] = $row["moz_pa"];
$r["moz_links"] = $row["moz_links"];
$r["moz_rank"] = $row["moz_rank"];
$r["majestic_cf"] = $row["majestic_cf"];
$r["majestic_tf"] = $row["majestic_tf"];
$r["majestic_links"] = $row["majestic_links"];
$r["majestic_rd"] = $row["majestic_rd"];
$r["ahrefs_dr"] = $row["ahrefs_dr"];
$r["ahrefs_bl"] = $row["ahrefs_bl"];
$r["ahrefs_rd"] = $row["ahrefs_rd"];
$r["ahrefs_obl"] = $row["ahrefs_obl"];
$r["ahrefs_otm"] = $row["ahrefs_otm"];
$r["sistrix"] = $row["sistrix"];
$r["price"] = $row["price"];
$r["author"] = $row["author"];
$r["created_at"] = $row["created_at"];
$r["updated_at"] = $row["updated_at"];
$r["deleted_at"] = $row["deleted_at"];
$back = "/publisher/sites/list/" . lpk();
//[Fields]-----------------------------------------------------------------------------
$f->fields["site"] = $f->get_FieldView("site", array("value" => $r["site"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["image"] = $f->get_FieldView("image", array("value" => $r["image"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldView("name", array("value" => $r["name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["description"] = $f->get_FieldView("description", array("value" => $r["description"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["max_links"] = $f->get_FieldView("max_links", array("value" => $r["max_links"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["links_type"] = $f->get_FieldView("links_type", array("value" => $r["links_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sponsored"] = $f->get_FieldView("sponsored", array("value" => $r["sponsored"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["post_cover"] = $f->get_FieldView("post_cover", array("value" => $r["post_cover"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["categories"] = $f->get_FieldView("categories", array("value" => $r["categories"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["min_traffic"] = $f->get_FieldView("min_traffic", array("value" => $r["min_traffic"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["max_traffic"] = $f->get_FieldView("max_traffic", array("value" => $r["max_traffic"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["type"] = $f->get_FieldView("type", array("value" => $r["type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["themes"] = $f->get_FieldView("themes", array("value" => $r["themes"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["moz_da"] = $f->get_FieldView("moz_da", array("value" => $r["moz_da"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["moz_pa"] = $f->get_FieldView("moz_pa", array("value" => $r["moz_pa"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["moz_links"] = $f->get_FieldView("moz_links", array("value" => $r["moz_links"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["moz_rank"] = $f->get_FieldView("moz_rank", array("value" => $r["moz_rank"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["majestic_cf"] = $f->get_FieldView("majestic_cf", array("value" => $r["majestic_cf"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["majestic_tf"] = $f->get_FieldView("majestic_tf", array("value" => $r["majestic_tf"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["majestic_links"] = $f->get_FieldView("majestic_links", array("value" => $r["majestic_links"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["majestic_rd"] = $f->get_FieldView("majestic_rd", array("value" => $r["majestic_rd"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ahrefs_dr"] = $f->get_FieldView("ahrefs_dr", array("value" => $r["ahrefs_dr"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ahrefs_bl"] = $f->get_FieldView("ahrefs_bl", array("value" => $r["ahrefs_bl"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ahrefs_rd"] = $f->get_FieldView("ahrefs_rd", array("value" => $r["ahrefs_rd"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ahrefs_obl"] = $f->get_FieldView("ahrefs_obl", array("value" => $r["ahrefs_obl"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ahrefs_otm"] = $f->get_FieldView("ahrefs_otm", array("value" => $r["ahrefs_otm"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sistrix"] = $f->get_FieldView("sistrix", array("value" => $r["sistrix"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["price"] = $f->get_FieldView("price", array("value" => $r["price"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/publisher/sites/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["site"] . $f->fields["image"] . $f->fields["name"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"] . $f->fields["max_links"] . $f->fields["links_type"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["sponsored"] . $f->fields["post_cover"] . $f->fields["categories"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["min_traffic"] . $f->fields["max_traffic"] . $f->fields["type"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["themes"] . $f->fields["moz_da"] . $f->fields["moz_pa"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["moz_links"] . $f->fields["moz_rank"] . $f->fields["majestic_cf"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["majestic_tf"] . $f->fields["majestic_links"] . $f->fields["majestic_rd"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ahrefs_dr"] . $f->fields["ahrefs_bl"] . $f->fields["ahrefs_rd"])));
$f->groups["g9"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ahrefs_obl"] . $f->fields["ahrefs_otm"] . $f->fields["sistrix"])));
$f->groups["g10"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["price"] . $f->fields["author"] . $f->fields["created_at"])));
$f->groups["g11"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["updated_at"] . $f->fields["deleted_at"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang("Publisher.sites-view-title"),
    "header-back" => $back,
    "content" => $f,
));
echo($card);
?>
