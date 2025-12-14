<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Institutional\Plans\Editor\processor.php]
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
$f = service("forms", array("lang" => "Disa.institutional-"));
$model = model("App\Modules\Disa\Models\Disa_Institutional_Plans");
$d = array(
    "plan" => $f->get_Value("plan"),
    "name" => urlencode($f->get_Value("name")),
    "description" => urlencode($f->get_Value("description")),
    "author" => $authentication->get_User(),
);
$row = $model->find($d["plan"]);
if (isset($row["plan"])) {
    $edit = $model->update($d['plan'], $d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.institutional-plans-edit-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.institutional-plans-edit-success-message"), $d['plan']));
    //$smarty->assign("edit", base_url("/disa/institutional/edit/{$d['plan']}/" . lpk()));
    $smarty->assign("continue", base_url("/disa/institutional/plans/list/{$d["plan"]}/" . lpk()));
    $smarty->assign("voice", "disa/institutional-edit-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.institutional-edit-noexist-title"));
    $smarty->assign("message", lang("Disa.institutional-edit-noexist-message"));
    $smarty->assign("continue", base_url("/disa/institutional/plans/list/{$d["plan"]}/" . lpk()));
    $smarty->assign("voice", "disa/institutional-edit-noexist-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);
?>
