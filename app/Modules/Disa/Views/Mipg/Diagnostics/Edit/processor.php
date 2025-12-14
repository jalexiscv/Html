<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Diagnostics\Editor\processor.php]
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
$f = service("forms", array("lang" => "Disa.diagnostics-"));
$model = model("App\Modules\Disa\Models\Disa_Diagnostics");

$d = array(
    "politic" => $f->get_Value("politic"),
    "diagnostic" => $f->get_Value("diagnostic"),
    "order" => $f->get_Value("order"),
    "name" => urlencode($f->get_Value("name")),
    "description" => urlencode($f->get_Value("description")),
    "version" => $f->get_Value("version"),
    "author" => $authentication->get_User(),
);

$row = $model->find($d["diagnostic"]);
if (isset($row["diagnostic"])) {
    $edit = $model->update($d['diagnostic'], $d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.diagnostics-edit-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.diagnostics-edit-success-message"), $d['politic']));
    //$smarty->assign("edit", base_url("/disa/diagnostics/edit/{$d['politic']}/" . lpk()));
    $smarty->assign("continue", base_url("/disa/mipg/diagnostics/list/{$d["politic"]}/"));
    $smarty->assign("voice", "disa/diagnostics-edit-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.diagnostics-edit-noexist-title"));
    $smarty->assign("message", lang("Disa.diagnostics-edit-noexist-message"));
    $smarty->assign("continue", base_url("/disa/mipg/diagnostics/list/{$d["politic"]}/"));
    $smarty->assign("voice", "disa/diagnostics-edit-noexist-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);
?>
