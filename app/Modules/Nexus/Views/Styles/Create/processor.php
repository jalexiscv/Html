<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Application\Views\Styles\Creator\processor.php]
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
$f = service("forms", array("lang" => "Nexus.styles-"));
$model = model("App\Modules\Nexus\Models\Nexus_Styles");
$d = array(
    "style" => $f->get_Value("style"),
    "theme" => $f->get_Value("theme"),
    "selectors" => urlencode($f->get_Value("selectors")),
    "default" => urlencode($f->get_Value("default")),
    "xxl" => urlencode($f->get_Value("xxl")),
    "xl" => urlencode($f->get_Value("xl")),
    "lg" => urlencode($f->get_Value("lg")),
    "md" => urlencode($f->get_Value("md")),
    "sm" => urlencode($f->get_Value("sm")),
    "xs" => urlencode($f->get_Value("xs")),
    "date" => $f->get_Value("date"),
    "time" => $f->get_Value("time"),
    "author" => $authentication->get_User(),
    "importer" => $f->get_Value("importer"),
);
$row = $model->find($d["style"]);
$l["back"] = "/nexus/styles/list/" . $d["theme"];
//$l["edit"]="/nexus/styles/edit/{$d["style"]}";
if (isset($row["style"])) {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Nexus.styles-create-duplicate-title"));
    $smarty->assign("message", lang("Nexus.styles-create-duplicate-message"));
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "application/styles-create-duplicate-message.mp3");
    $c = $smarty->view('alerts/card/warning.tpl');
} else {
    $create = $model->insert($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Nexus.styles-create-success-title"));
    $smarty->assign("message", sprintf(lang("Nexus.styles-create-success-message"), $d['style']));
    //$smarty->assign("edit", $l["edit"]);
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "application/styles-create-success-message.mp3");
    $c = $smarty->view('alerts/card/success.tpl');
}
echo($c);

?>