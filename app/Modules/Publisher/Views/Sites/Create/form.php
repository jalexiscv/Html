<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-01-14 23:32:52
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Publisher\Views\Sites\Creator\form.php]
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
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sites."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Publisher\Models\Publisher_Sites");
//[vars]----------------------------------------------------------------------------------------------------------------
$r["site"] = $f->get_Value("site", pk());
$r["image"] = $f->get_Value("image");
$r["url"] = $f->get_Value("url");
$r["created"] = $f->get_Value("created");
$r["name"] = $f->get_Value("name");
$r["description"] = $f->get_Value("description");
$r["max_links"] = $f->get_Value("max_links");
$r["links_type"] = $f->get_Value("links_type");
$r["sponsored"] = $f->get_Value("sponsored");
$r["post_cover"] = $f->get_Value("post_cover");
$r["categories"] = $f->get_Value("categories");
$r["min_traffic"] = $f->get_Value("min_traffic");
$r["max_traffic"] = $f->get_Value("max_traffic");
$r["type"] = $f->get_Value("type");
$r["themes"] = $f->get_Value("themes");
$r["moz_da"] = $f->get_Value("moz_da");
$r["moz_pa"] = $f->get_Value("moz_pa");
$r["moz_links"] = $f->get_Value("moz_links");
$r["moz_rank"] = $f->get_Value("moz_rank");
$r["majestic_cf"] = $f->get_Value("majestic_cf");
$r["majestic_tf"] = $f->get_Value("majestic_tf");
$r["majestic_links"] = $f->get_Value("majestic_links");
$r["majestic_rd"] = $f->get_Value("majestic_rd");
$r["ahrefs_dr"] = $f->get_Value("ahrefs_dr");
$r["ahrefs_bl"] = $f->get_Value("ahrefs_bl");
$r["ahrefs_rd"] = $f->get_Value("ahrefs_rd");
$r["ahrefs_obl"] = $f->get_Value("ahrefs_obl");
$r["ahrefs_otm"] = $f->get_Value("ahrefs_otm");
$r["sistrix"] = $f->get_Value("sistrix");
$r["price"] = $f->get_Value("price");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$back = "/publisher/sites/list/" . lpk();
//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["site"] = $f->get_FieldText("site", array("value" => $r["site"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["image"] = $f->get_FieldText("image", array("value" => $r["image"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["url"] = $f->get_FieldText("url", array("value" => $r["url"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created"] = $f->get_FieldDate("created", array("value" => $r["created"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"], "proportion" => "col-12"));
$f->fields["description"] = $f->get_FieldText("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->fields["max_links"] = $f->get_FieldText("max_links", array("value" => $r["max_links"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["links_type"] = $f->get_FieldText("links_type", array("value" => $r["links_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sponsored"] = $f->get_FieldText("sponsored", array("value" => $r["sponsored"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["post_cover"] = $f->get_FieldText("post_cover", array("value" => $r["post_cover"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["categories"] = $f->get_FieldText("categories", array("value" => $r["categories"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["min_traffic"] = $f->get_FieldText("min_traffic", array("value" => $r["min_traffic"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["max_traffic"] = $f->get_FieldText("max_traffic", array("value" => $r["max_traffic"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["type"] = $f->get_FieldText("type", array("value" => $r["type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["themes"] = $f->get_FieldText("themes", array("value" => $r["themes"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["moz_da"] = $f->get_FieldText("moz_da", array("value" => $r["moz_da"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["moz_pa"] = $f->get_FieldText("moz_pa", array("value" => $r["moz_pa"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["moz_links"] = $f->get_FieldText("moz_links", array("value" => $r["moz_links"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["moz_rank"] = $f->get_FieldText("moz_rank", array("value" => $r["moz_rank"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["majestic_cf"] = $f->get_FieldText("majestic_cf", array("value" => $r["majestic_cf"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["majestic_tf"] = $f->get_FieldText("majestic_tf", array("value" => $r["majestic_tf"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["majestic_links"] = $f->get_FieldText("majestic_links", array("value" => $r["majestic_links"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["majestic_rd"] = $f->get_FieldText("majestic_rd", array("value" => $r["majestic_rd"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ahrefs_dr"] = $f->get_FieldText("ahrefs_dr", array("value" => $r["ahrefs_dr"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ahrefs_bl"] = $f->get_FieldText("ahrefs_bl", array("value" => $r["ahrefs_bl"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ahrefs_rd"] = $f->get_FieldText("ahrefs_rd", array("value" => $r["ahrefs_rd"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ahrefs_obl"] = $f->get_FieldText("ahrefs_obl", array("value" => $r["ahrefs_obl"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ahrefs_otm"] = $f->get_FieldText("ahrefs_otm", array("value" => $r["ahrefs_otm"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sistrix"] = $f->get_FieldText("sistrix", array("value" => $r["sistrix"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["price"] = $f->get_FieldText("price", array("value" => $r["price"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g01"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["site"] . $f->fields["url"] . $f->fields["created"])));
$f->groups["g02"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["name"])));
$f->groups["g03"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
$f->groups["g04"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["image"] . $f->fields["max_links"] . $f->fields["links_type"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["sponsored"] . $f->fields["post_cover"] . $f->fields["categories"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["min_traffic"] . $f->fields["max_traffic"] . $f->fields["type"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["themes"] . $f->fields["moz_da"] . $f->fields["moz_pa"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["moz_links"] . $f->fields["moz_rank"] . $f->fields["majestic_cf"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["majestic_tf"] . $f->fields["majestic_links"] . $f->fields["majestic_rd"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ahrefs_dr"] . $f->fields["ahrefs_bl"] . $f->fields["ahrefs_rd"])));
$f->groups["g9"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ahrefs_obl"] . $f->fields["ahrefs_otm"] . $f->fields["sistrix"])));
$f->groups["g10"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["price"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => lang("Sites.create-title"),
    "content" => $f,
));
echo($card);
?>