<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Cases\Creator\processor.php]
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
$s = service('strings');
$f = service("forms", array("lang" => "Cases."));
$model = model("App\Modules\C4isr\Models\C4isr_Cases");
$d = array(
    "case" => $f->get_Value("case"),
    "type" => $f->get_Value("type"),
    "reference" => $s->get_URLEncode($f->get_Value("reference")),
    "title" => $s->get_URLEncode($f->get_Value("title")),
    "description" => $s->get_URLEncode($f->get_Value("description")),
    "status" => $f->get_Value("status"),
    "cover" => $f->get_Value("cover"),
    "author" => $authentication->get_User(),
);
$row = $model->find($d["case"]);
$l["back"] = "/c4isr/cases/home/{$oid}/" . lpk();
$l["edit"] = "/c4isr/cases/edit/{$d["case"]}";
if (isset($row["case"])) {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Cases.create-duplicate-title"));
    $smarty->assign("message", lang("Cases.create-duplicate-message"));
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "c4isr/cases-create-duplicate-message.mp3");
    $c = $smarty->view('alerts/card/warning.tpl');
} else {
    $create = $model->insert($d);
    //cho($model->getLastQuery()->getQuery());
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Cases.create-success-title"));
    $smarty->assign("message", sprintf(lang("Cases.create-success-message"), $d['case']));
    //$smarty->assign("edit", $l["edit"]);
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "c4isr/cases-create-success-message.mp3");
    $c = $smarty->view('alerts/card/success.tpl');
}
echo($c);
?>
