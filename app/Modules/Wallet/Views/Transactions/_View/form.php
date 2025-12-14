<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Wallet\Views\Transactions\Editor\form.php]
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
$f = service("forms", array("lang" => "Transactions."));
//[Request]-----------------------------------------------------------------------------
$row = $model->find($oid);
$r["transaction"] = $row["transaction"];
$r["module"] = $row["module"];
$r["user"] = $row["user"];
$r["reference"] = $row["reference"];
$r["description"] = $row["description"];
$r["currency"] = $row["currency"];
$r["debit"] = $row["debit"];
$r["credit"] = $row["credit"];
$r["balance"] = $row["balance"];
$r["status"] = $row["status"];
$r["author"] = $row["author"];
$r["created_at"] = $row["created_at"];
$r["updated_at"] = $row["updated_at"];
$r["deleted_at"] = $row["deleted_at"];
$back = "/wallet/transactions/list/" . lpk();
//[Fields]-----------------------------------------------------------------------------
$f->fields["transaction"] = $f->get_FieldView("transaction", array("value" => $r["transaction"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["module"] = $f->get_FieldView("module", array("value" => $r["module"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["user"] = $f->get_FieldView("user", array("value" => $r["user"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["reference"] = $f->get_FieldView("reference", array("value" => $r["reference"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["description"] = $f->get_FieldView("description", array("value" => $r["description"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["currency"] = $f->get_FieldView("currency", array("value" => $r["currency"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["debit"] = $f->get_FieldView("debit", array("value" => $r["debit"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["credit"] = $f->get_FieldView("credit", array("value" => $r["credit"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["balance"] = $f->get_FieldView("balance", array("value" => $r["balance"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldView("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/wallet/transactions/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["transaction"] . $f->fields["module"] . $f->fields["user"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["reference"] . $f->fields["description"] . $f->fields["currency"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["debit"] . $f->fields["credit"] . $f->fields["balance"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["status"] . $f->fields["author"] . $f->fields["created_at"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["updated_at"] . $f->fields["deleted_at"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[Build]-----------------------------------------------------------------------------
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", lang("Transactions.view-title"));
$smarty->assign("header_back", $back);
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>
