<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Cases\Delete\form.php]
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
/*
 * -----------------------------------------------------------------------------
 * [Vars]
 * -----------------------------------------------------------------------------
*/
$f = service("forms", array("lang" => "Nexus."));
//$model = model("App\Modules\C4isr\Models\C4isr_Cases");
$r = $model->find($oid);
$name = urldecode($r["name"]);
$message = sprintf(lang("Cases.delete-message"), $name);
$cancel = "/c4isr/cases/list/" . lpk();
/*
 * -----------------------------------------------------------------------------
 * [Fields]
 * -----------------------------------------------------------------------------
*/
$f->add_HiddenField("pkey", $oid);
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $cancel, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Delete"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/*
 * -----------------------------------------------------------------------------
 * [Groups]
 * -----------------------------------------------------------------------------
*/
/*
 * -----------------------------------------------------------------------------
 * [Buttons]
 * -----------------------------------------------------------------------------
*/
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
/*
 * -----------------------------------------------------------------------------
 * [Bueild]
 * -----------------------------------------------------------------------------
*/

$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("header", sprintf(lang("Cases.delete-title"), $name));
$smarty->assign("message", sprintf(lang("Cases.delete-message"), $name));
$smarty->assign("form", $f);
$smarty->assign("continue", null);
$smarty->assign("voice", "c4isr/cases-delete-errors-message.mp3");
echo($smarty->view('components/cards/delete.tpl')); ?>
