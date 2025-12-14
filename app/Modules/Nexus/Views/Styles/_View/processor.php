<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Application\Views\Styles\Editor\processor.php]
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
    "selectors" => $f->get_Value("selectors"),
    "default" => $f->get_Value("default"),
    "xxl" => $f->get_Value("xxl"),
    "xl" => $f->get_Value("xl"),
    "lg" => $f->get_Value("lg"),
    "md" => $f->get_Value("md"),
    "sm" => $f->get_Value("sm"),
    "xs" => $f->get_Value("xs"),
    "date" => $f->get_Value("date"),
    "time" => $f->get_Value("time"),
    "author" => $authentication->get_User(),
    "importer" => $f->get_Value("importer"),
);
$row = $model->find($d["style"]);
if (isset($row["style"])) {
    $edit = $model->update($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Nexus.styles-view-success-title"));
    $smarty->assign("message", sprintf(lang("Nexus.styles-view-success-message"), $d['style']));
    $smarty->assign("edit", base_url("/application/styles/edit/{$d['style']}/" . lpk()));
    $smarty->assign("continue", base_url("/application/styles/view/{$d["style"]}/" . lpk()));
    $smarty->assign("voice", "application/styles-view-success-message.mp3");
    $c = $smarty->view('alerts/card/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Nexus.styles-view-noexist-title"));
    $smarty->assign("message", lang("Nexus.styles-view-noexist-message"));
    $smarty->assign("continue", base_url("/application/styles"));
    $smarty->assign("voice", "application/styles-view-noexist-message.mp3");
    $c = $smarty->view('alerts/card/warning.tpl');
}
echo($c);
?>
