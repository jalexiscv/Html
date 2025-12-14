<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Characterizations\Editor\processor.php]
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
$f = service("forms", array("lang" => "Disa.characterizations-"));
$model = model("App\Modules\Disa\Models\Disa_Characterizations");
$d = array(
    "characterization" => $f->get_Value("characterization"),
    "sigep" => $f->get_Value("sigep"),
    "name" => $f->get_Value("name"),
    "vision" => $f->get_Value("vision"),
    "mision" => $f->get_Value("mision"),
    "representative" => $f->get_Value("representative"),
    "representative_position" => $f->get_Value("representative_position"),
    "leader" => $f->get_Value("leader"),
    "leader_position" => $f->get_Value("leader_position"),
    "logo" => $f->get_Value("logo"),
    "author" => $authentication->get_User(),
);
$row = $model->find($d["characterization"]);
if (isset($row["characterization"])) {
    $edit = $model->update($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.characterizations-view-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.characterizations-view-success-message"), $d['characterization']));
    $smarty->assign("edit", base_url("/disa/characterizations/edit/{$d['characterization']}/" . lpk()));
    $smarty->assign("continue", base_url("/disa/characterizations/view/{$d["characterization"]}/" . lpk()));
    $smarty->assign("voice", "disa/characterizations-view-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.characterizations-view-noexist-title"));
    $smarty->assign("message", lang("Disa.characterizations-view-noexist-message"));
    $smarty->assign("continue", base_url("/disa/characterizations"));
    $smarty->assign("voice", "disa/characterizations-view-noexist-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);
?>
