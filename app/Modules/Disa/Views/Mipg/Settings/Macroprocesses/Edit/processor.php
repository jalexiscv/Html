<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Macroprocesses\Editor\processor.php]
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
$f = service("forms", array("lang" => "Disa.macroprocesses-"));
$model = model("App\Modules\Disa\Models\Disa_Macroprocesses");
$d = array(
    "macroprocess" => $f->get_Value("macroprocess"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "position" => $f->get_Value("position"),
    "responsible" => $f->get_Value("responsible"),
    "phone" => $f->get_Value("phone"),
    "email" => $f->get_Value("email"),
    "author" => $authentication->get_User(),
);
$row = $model->find($d["macroprocess"]);
if (isset($row["macroprocess"])) {
    $edit = $model->update($d['macroprocess'], $d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.macroprocesses-edit-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.macroprocesses-edit-success-message"), $d['macroprocess']));
    //$smarty->assign("edit", base_url("/disa/settings/macroprocesses/edit/{$d['macroprocess']}/" . lpk()));
    $smarty->assign("continue", base_url("/disa/settings/macroprocesses/list/{$d["macroprocess"]}/" . lpk()));
    $smarty->assign("voice", "disa/macroprocesses-edit-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.macroprocesses-edit-noexist-title"));
    $smarty->assign("message", lang("Disa.macroprocesses-edit-noexist-message"));
    $smarty->assign("continue", base_url("/disa/settings/macroprocesses/list/" . lpk()));
    $smarty->assign("voice", "disa/macroprocesses-edit-noexist-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);
?>
