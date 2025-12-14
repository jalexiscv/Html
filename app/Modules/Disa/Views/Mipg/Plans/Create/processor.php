<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Plans\Creator\processor.php]
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
$f = service("forms", array("lang" => "Disa.plans-"));
$mplans = model("App\Modules\Disa\Models\Disa_Plans");
$mstatuses = model('App\Modules\Disa\Models\Disa_Statuses');

$d = array(
    "plan" => $f->get_Value("plan"),
    "plan_institutional" => $f->get_Value("plan_institutional"),
    "activity" => $f->get_Value("activity"),
    "manager" => $f->get_Value("manager"),
    "manager_subprocess" => $f->get_Value("manager_subprocess"),
    "manager_position" => $f->get_Value("manager_position"),
    "order" => $mplans->get_Consecutive($oid),
    "description" => urlencode($f->get_Value("description")),
    "formulation" => $f->get_Value("formulation"),
    "value" => $f->get_Value("value"),
    "start" => $f->get_Value("start"),
    "end" => $f->get_Value("end"),
    "evaluation" => $f->get_Value("evaluation"),
    "author" => $authentication->get_User(),
);
$row = $mplans->find($d["plan"]);
if (isset($row["plan"])) {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.plans-create-duplicate-title"));
    $smarty->assign("message", lang("Disa.plans-create-duplicate-message"));
    $smarty->assign("continue", base_url("/disa/mipg/plans/list/{$oid}"));
    $smarty->assign("voice", "disa/plans-create-duplicate-message.mp3");
    $c = $smarty->view('alerts/card/warning.tpl');
} else {
    $create = $mplans->insert($d);
    $mstatuses->insert(array("status" => pk(), "object" => $d["plan"], "value" => "PENDING", "observations" => "", "author" => "SYSTEM"));

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.plans-create-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.plans-create-success-message"), $d['plan']));
    //$smarty->assign("edit", base_url("/disa/plans/edit/{$d['plan']}/" . lpk()));
    $smarty->assign("continue", base_url("/disa/mipg/plans/list/{$oid}"));
    $smarty->assign("voice", "disa/plans-create-success-message.mp3");
    $c = $smarty->view('alerts/card/success.tpl');
    /** Logger **/
    history_logger(array(
        "log" => pk(),
        "module" => "DISA",
        "author" => $authentication->get_User(),
        "description" => "El usuario <b>@" . $authentication->get_Alias() . "</b> ha creado el <b>plan de acción</b> <b><a href=\"/disa/mipg/plans/view/{$d["plan"]}\" target=\"_blank\">{$d["plan"]}</b>.",
        "code" => "",
    ));
}
echo($c);
?>
