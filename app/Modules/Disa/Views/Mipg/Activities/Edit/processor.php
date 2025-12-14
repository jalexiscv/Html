<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Activities\Editor\processor.php]
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
$f = service("forms", array("lang" => "Disa.activities-"));
$model = model("App\Modules\Disa\Models\Disa_Activities");
$d = array(
    "activity" => $f->get_Value("activity"),
    "category" => $f->get_Value("category"),
    "order" => $f->get_Value("order"),
    "criteria" => urlencode($f->get_Value("criteria")),
    "description" => urlencode($f->get_Value("description")),
    "evaluation" => urlencode($f->get_Value("evaluation")),
    "period" => $f->get_Value("period"),
    "score" => $f->get_Value("score"),
    "author" => $authentication->get_User(),
);
$row = $model->find($d["activity"]);
if (isset($row["activity"])) {
    $edit = $model->update($d['activity'], $d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.activities-edit-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.activities-edit-success-message"), $d['activity']));
    //$smarty->assign("edit", base_url("/disa/activities/edit/{$d['activity']}/" . lpk()));
    $smarty->assign("continue", base_url("/disa/mipg/activities/list/{$d["category"]}"));
    $smarty->assign("voice", "disa/activities-edit-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.activities-edit-noexist-title"));
    $smarty->assign("message", lang("Disa.activities-edit-noexist-message"));
    $smarty->assign("continue", base_url("/disa/mipg/activities/list/{$d["category"]}"));
    $smarty->assign("voice", "disa/activities-edit-noexist-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);

?>