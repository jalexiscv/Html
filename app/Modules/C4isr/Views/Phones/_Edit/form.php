<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Phones\Editor\form.php]
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
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
//$model = model("App\Modules\C4isr\Models\C4isr_Phones");
//[Form]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Phones."));
//[Values]-----------------------------------------------------------------------------
$row = $model->find($oid);
$r["phone"] = $f->get_Value("phone", $row["phone"]);
$r["profile"] = $f->get_Value("profile", $row["profile"]);
$r["country_code"] = $f->get_Value("country_code", $row["country_code"]);
$r["area_code"] = $f->get_Value("area_code", $row["area_code"]);
$r["local_number"] = $f->get_Value("local_number", $row["local_number"]);
$r["extension"] = $f->get_Value("extension", $row["extension"]);
$r["type"] = $f->get_Value("type", $row["type"]);
$r["carrier"] = $f->get_Value("carrier", $row["carrier"]);
$r["normalized_number"] = $f->get_Value("normalized_number", $row["normalized_number"]);
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$back = "/c4isr/phones/list/" . lpk();
//[Fields]-----------------------------------------------------------------------------
$f->fields["phone"] = $f->get_FieldText("phone", array("value" => $r["phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["profile"] = $f->get_FieldText("profile", array("value" => $r["profile"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["country_code"] = $f->get_FieldText("country_code", array("value" => $r["country_code"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["area_code"] = $f->get_FieldText("area_code", array("value" => $r["area_code"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["local_number"] = $f->get_FieldText("local_number", array("value" => $r["local_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["extension"] = $f->get_FieldText("extension", array("value" => $r["extension"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["type"] = $f->get_FieldText("type", array("value" => $r["type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["carrier"] = $f->get_FieldText("carrier", array("value" => $r["carrier"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["normalized_number"] = $f->get_FieldText("normalized_number", array("value" => $r["normalized_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["phone"] . $f->fields["profile"] . $f->fields["country_code"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["area_code"] . $f->fields["local_number"] . $f->fields["extension"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["type"] . $f->fields["carrier"] . $f->fields["normalized_number"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["author"] . $f->fields["created_at"] . $f->fields["updated_at"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["deleted_at"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[Build]-----------------------------------------------------------------------------

$smarty = service("smarty");
$smarty->set_Mode("bs5x");

$smarty->assign("type", "normal");
$smarty->assign("header", lang("Phones.edit-title"));
$smarty->assign("header_back", $back);

$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>