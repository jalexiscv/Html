<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Actions\Editor\processor.php]
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
$f = service("forms", array("lang" => "Disa.actions-"));
$model = model("App\Modules\Disa\Models\Disa_Actions");
$d = array(
    "action" => $f->get_Value("action"),
    "plan" => $f->get_Value("plan"),
    "variables" => $f->get_Value("variables"),
    "alternatives" => $f->get_Value("alternatives"),
    "implementation" => $f->get_Value("implementation"),
    "evaluation" => $f->get_Value("evaluation"),
    "percentage" => $f->get_Value("percentage"),
    "start" => $f->get_Value("start"),
    "end" => $f->get_Value("end"),
    "owner" => $f->get_Value("owner"),
    "author" => $authentication->get_User(),
);
$row = $model->find($d["action"]);
if (isset($row["action"])) {
    $edit = $model->update($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.actions-view-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.actions-view-success-message"), $d['action']));
    $smarty->assign("edit", base_url("/disa/actions/edit/{$d['action']}/" . lpk()));
    $smarty->assign("continue", base_url("/disa/actions/view/{$d["action"]}/" . lpk()));
    $smarty->assign("voice", "disa/actions-view-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.actions-view-noexist-title"));
    $smarty->assign("message", lang("Disa.actions-view-noexist-message"));
    $smarty->assign("continue", base_url("/disa/actions"));
    $smarty->assign("voice", "disa/actions-view-noexist-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);
?>
