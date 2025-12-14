<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Application\Views\Stats\Editor\form.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* -----------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* -----------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* -----------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* -----------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* -----------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* -----------------------------------------------------------------------------
*/
$f = service("forms", array("lang" => "Stats.stats-"));
/*
* -----------------------------------------------------------------------------
* [Requests]
* -----------------------------------------------------------------------------
*/
$row = $model->find($oid);
$r["stat"] = $row["stat"];
$r["instance"] = $row["instance"];
$r["module"] = $row["module"];
$r["object"] = $row["object"];
$r["ip"] = $row["ip"];
$r["user"] = $row["user"];
$r["type"] = $row["type"];
$r["reference"] = $row["reference"];
$r["log"] = $row["log"];
$r["author"] = $row["author"];
$r["date"] = $row["date"];
$r["time"] = $row["time"];
$r["created_at"] = $row["created_at"];
$r["updated_at"] = $row["updated_at"];
$r["deleted_at"] = $row["deleted_at"];
$continue = "/history/general/list/" . lpk();
/*
* -----------------------------------------------------------------------------
* [Fields]
* -----------------------------------------------------------------------------
*/
$f->fields["stat"] = $f->get_FieldView("stat", array("value" => $r["stat"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["instance"] = $f->get_FieldView("instance", array("value" => $r["instance"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["module"] = $f->get_FieldView("module", array("value" => $r["module"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["object"] = $f->get_FieldView("object", array("value" => $r["object"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ip"] = $f->get_FieldView("ip", array("value" => $r["ip"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["user"] = $f->get_FieldView("user", array("value" => $r["user"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["type"] = $f->get_FieldView("type", array("value" => $r["type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["reference"] = $f->get_FieldView("reference", array("value" => $r["reference"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["log"] = $f->get_FieldViewArea("log", array("value" => $r["log"], "proportion" => "col-12"));
$f->fields["author"] = $f->get_FieldView("author", array("value" => $r["author"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["date"] = $f->get_FieldView("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldView("time", array("value" => $r["time"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $continue, "text" => lang("App.Continue"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/application/stats/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
/*
* -----------------------------------------------------------------------------
* [Groups]
* -----------------------------------------------------------------------------
*/
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["stat"] . $f->fields["instance"] . $f->fields["module"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["object"] . $f->fields["ip"] . $f->fields["user"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["type"] . $f->fields["reference"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["log"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["author"] . $f->fields["date"] . $f->fields["time"])));
//$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["created_at"] . $f->fields["updated_at"] . $f->fields["deleted_at"])));
/*
* -----------------------------------------------------------------------------
* [Buttons]
* -----------------------------------------------------------------------------
*/
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["cancel"]));


//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "HISTORY",
    "type" => "VIEW",
    "reference" => "COMPONENT",
    "object" => $oid,
    "log" => "El usuario visualiza la vista detallada del evento <a href=\"/history/stats/view/{$oid}\" target=\"_blank\">{$oid}</a>.",
));


/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", lang("Stats.stats-view-title"));
$smarty->assign("header_back", $continue);
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>
