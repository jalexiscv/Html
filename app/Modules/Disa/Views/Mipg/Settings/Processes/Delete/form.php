<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Processes\Delete\form.php]
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
$model = model("App\Modules\Disa\Models\Disa_Processes");
$subprocesses = model("App\Modules\Disa\Models\Disa_Subprocesses");
$linkeds = $subprocesses->where("process", $oid)->find();

$r = $model->find($oid);
$name = urldecode($r["name"]);
$message = sprintf(lang("Disa.processes-delete-message"), $name);
$cancel = "/disa/settings/processes/list/" . lpk();

if (is_array($linkeds) && count($linkeds) > 0) {
    $name = urldecode($r["name"]);
    $message = "Este proceso no puede ser eliminado por tener subprocesos vinculados. presioné cancelar para retornar al listado de procesos.";
    $f->add_HiddenField("pkey", $oid);
    $f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $cancel, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
    $f->groups["gy"] = $f->get_GroupSeparator();
    $f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["cancel"]));
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("header", sprintf(lang("Disa.macroprocesses-delete-title"), $name));
    $smarty->assign("message", $message);
    $smarty->assign("form", $f);
    $smarty->assign("continue", null);
    $smarty->assign("voice", "disa/macroprocesses-indelible-message.mp3");
    echo($smarty->view('components/cards/indelible.tpl'));
} else {
    $f->add_HiddenField("pkey", $oid);
    $f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $cancel, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
    $f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Delete"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
    $f->groups["gy"] = $f->get_GroupSeparator();
    $f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("header", sprintf(lang("Disa.processes-delete-title"), $name));
    $smarty->assign("message", sprintf(lang("Disa.processes-delete-message"), $name));
    $smarty->assign("form", $f);
    $smarty->assign("continue", null);
    $smarty->assign("voice", "disa/processes-delete-errors-message.mp3");
    echo($smarty->view('components/cards/delete.tpl'));
}

?>