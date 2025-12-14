<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Application\Views\Styles\Editor\form.php]
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
$f = service("forms", array("lang" => "Nexus.styles-"));
/*
* -----------------------------------------------------------------------------
* [Requests]
* -----------------------------------------------------------------------------
*/
$model = model("App\Modules\Nexus\Models\Nexus_Styles");
$row = $model->find($oid);
$r["style"] = $f->get_Value("style", $row["style"]);
$r["theme"] = $f->get_Value("theme", $row["theme"]);
$r["selectors"] = $f->get_Value("selectors", urldecode($row["selectors"]));
$r["default"] = urldecode($f->get_Value("default", urldecode($row["default"])));
$r["xxl"] = urldecode($f->get_Value("xxl", urldecode($row["xxl"])));
$r["xl"] = urldecode($f->get_Value("xl", urldecode($row["xl"])));
$r["lg"] = urldecode($f->get_Value("lg", urldecode($row["lg"])));
$r["md"] = urldecode($f->get_Value("md", urldecode($row["md"])));
$r["sm"] = urldecode($f->get_Value("sm", urldecode($row["sm"])));
$r["xs"] = urldecode($f->get_Value("xs", urldecode($row["xs"])));
$r["date"] = $f->get_Value("date", service("dates")::get_Date());
$r["time"] = $f->get_Value("time", service("dates")::get_Time());
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["importer"] = $f->get_Value("importer", $row["importer"]);
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
/*
* -----------------------------------------------------------------------------
* [Fields]
* -----------------------------------------------------------------------------
*/
$f->fields["style"] = $f->get_FieldText("style", array("value" => $r["style"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["theme"] = $f->get_FieldText("theme", array("value" => $r["theme"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["selectors"] = $f->get_FieldText("selectors", array("value" => $r["selectors"], "proportion" => "col-xl-6 col-lg-6 col-md6 col-sm-12 col-12"));
$f->fields["default"] = $f->get_FieldCode("default", array("value" => $r["default"], "mode" => "css", "proportion" => "col-12"));
$f->fields["xxl"] = $f->get_FieldCode("xxl", array("value" => $r["xxl"], "mode" => "css", "proportion" => "col-12"));
$f->fields["xl"] = $f->get_FieldCode("xl", array("value" => $r["xl"], "mode" => "css", "proportion" => "col-12"));
$f->fields["lg"] = $f->get_FieldCode("lg", array("value" => $r["lg"], "mode" => "css", "proportion" => "col-12"));
$f->fields["md"] = $f->get_FieldCode("md", array("value" => $r["md"], "mode" => "css", "proportion" => "col-12"));
$f->fields["sm"] = $f->get_FieldCode("sm", array("value" => $r["sm"], "mode" => "css", "proportion" => "col-12"));
$f->fields["xs"] = $f->get_FieldCode("xs", array("value" => $r["xs"], "mode" => "css", "proportion" => "col-12"));
$f->fields["date"] = $f->get_FieldText("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldText("time", array("value" => $r["time"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["importer"] = $f->get_FieldText("importer", array("value" => $r["importer"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/nexus/styles/list/" . $r["theme"], "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/*
* -----------------------------------------------------------------------------
* [Groups]
* -----------------------------------------------------------------------------
*/
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["style"] . $f->fields["theme"] . $f->fields["selectors"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["default"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["xxl"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["xl"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["lg"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["md"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["sm"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["xs"])));
//$f->groups["g5"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["author"].$f->fields["importer"].$f->fields["created_at"])));
//$f->groups["g6"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["updated_at"].$f->fields["deleted_at"])));
/*
* -----------------------------------------------------------------------------
* [Buttons]
* -----------------------------------------------------------------------------
*/
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", lang("Nexus.styles-edit-title"));
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>
