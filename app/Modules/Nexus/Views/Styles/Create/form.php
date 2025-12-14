<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Application\Views\Styles\Creator\form.php]
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
$r["style"] = $f->get_Value("style", pk());
$r["theme"] = $f->get_Value("theme", $oid);
$r["selectors"] = $f->get_Value("selectors");
$r["default"] = $f->get_Value("default");
$r["xxl"] = $f->get_Value("xxl");
$r["xl"] = $f->get_Value("xl");
$r["lg"] = $f->get_Value("lg");
$r["md"] = $f->get_Value("md");
$r["sm"] = $f->get_Value("sm");
$r["xs"] = $f->get_Value("xs");
$r["date"] = $f->get_Value("date", service("dates")::get_Date());
$r["time"] = $f->get_Value("time", service("dates")::get_Time());
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["importer"] = $f->get_Value("importer");
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$back = "/nexus/styles/list/" . $oid;/*
* -----------------------------------------------------------------------------
* [Fields]
* -----------------------------------------------------------------------------
*/
$f->fields["style"] = $f->get_FieldText("style", array("value" => $r["style"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["theme"] = $f->get_FieldText("theme", array("value" => $r["theme"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["selectors"] = $f->get_FieldText("selectors", array("value" => $r["selectors"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["default"] = $f->get_FieldCode("default", array("value" => $r["default"], "mode" => "css", "proportion" => "col-12"));
$f->fields["xxl"] = $f->get_FieldText("xxl", array("value" => $r["xxl"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["xl"] = $f->get_FieldText("xl", array("value" => $r["xl"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["lg"] = $f->get_FieldText("lg", array("value" => $r["lg"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["md"] = $f->get_FieldText("md", array("value" => $r["md"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sm"] = $f->get_FieldText("sm", array("value" => $r["sm"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["xs"] = $f->get_FieldText("xs", array("value" => $r["xs"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["date"] = $f->get_FieldText("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldText("time", array("value" => $r["time"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["importer"] = $f->get_FieldText("importer", array("value" => $r["importer"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/*
* -----------------------------------------------------------------------------
* [Groups]
* -----------------------------------------------------------------------------
*/
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["style"] . $f->fields["theme"] . $f->fields["selectors"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["default"])));
//$f->groups["g3"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["lg"].$f->fields["md"].$f->fields["sm"])));
//$f->groups["g4"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["xs"].$f->fields["date"].$f->fields["time"])));
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
$smarty->assign("header", lang("Nexus.styles-create-title"));
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));

?>