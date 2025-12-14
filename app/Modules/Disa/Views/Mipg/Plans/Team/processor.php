<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Plans\Editor\processor.php]
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
$f = service("forms", array("lang" => "Disa.plans-team-"));
$model = model("App\Modules\Disa\Models\Disa_Plans");
$option = $f->get_Value("option");

if ($option == "subprocess") {
    $d = array(
        "plan" => $f->get_Value("plan"),
        "manager_subprocess" => $f->get_Value("manager_subprocess")
    );
} else {
    $d = array(
        "plan" => $f->get_Value("plan"),
        "manager_position" => $f->get_Value("manager_position")
    );
}

$row = $model->find($d["plan"]);

if (isset($row["plan"])) {
    $edit = $model->update($d["plan"], $d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.plans-team-view-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.plans-team-view-success-message"), $d['plan']));
    //$smarty->assign("edit", base_url("/disa/plans/edit/{$d['plan']}/" . lpk()));
    $smarty->assign("continue", base_url("/disa/mipg/plans/team/{$d["plan"]}?pk=" . lpk()));
    $smarty->assign("voice", "disa/plans-view-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.plans-team-view-noexist-title"));
    $smarty->assign("message", lang("Disa.plans-team-noexist-message"));
    $smarty->assign("continue", base_url("/disa/mipg/plans/team/{$d["plan"]}?pk=" . lpk()));
    $smarty->assign("voice", "disa/plans-view-noexist-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);

?>
