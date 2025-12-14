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


$default = preg_replace('/( ){2,}/u', " ", $f->get_Value("default"));
$xxl = preg_replace('/( ){2,}/u', " ", $f->get_Value("xxl"));
$xl = preg_replace('/( ){2,}/u', " ", $f->get_Value("xl"));
$lg = preg_replace('/( ){2,}/u', " ", $f->get_Value("lg"));
$md = preg_replace('/( ){2,}/u', " ", $f->get_Value("md"));
$sm = preg_replace('/( ){2,}/u', " ", $f->get_Value("sm"));
$xs = preg_replace('/( ){2,}/u', " ", $f->get_Value("xs"));

$d = array(
    "style" => $f->get_Value("style"),
    "theme" => $f->get_Value("theme"),
    "selectors" => urlencode($f->get_Value("selectors")),
    "default" => urlencode($default),
    "xxl" => urlencode($xxl),
    "xl" => urlencode($xl),
    "lg" => urlencode($lg),
    "md" => urlencode($md),
    "sm" => urlencode($sm),
    "xs" => urlencode($xs),
    "date" => $f->get_Value("date"),
    "time" => $f->get_Value("time"),
    "author" => $authentication->get_User(),
    "importer" => $f->get_Value("importer"),
);
/* Elements */
$row = $model->find($d["style"]);
$continue = "/nexus/styles/list/{$d["theme"]}/";
$edit = "/nexus/styles/edit/{$d["style"]}/";
$asuccess = "nexus/styles-edit-success-message.mp3";
$anoexist = "nexus/styles-edit-noexist-message.mp3";
/* Build */
if (isset($row["style"])) {
    $edit = $model->update($d['style'], $d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Nexus.styles-edit-success-title"));
    $smarty->assign("message", sprintf(lang("Nexus.styles-edit-success-message"), $d['style']));
    //$smarty->assign("edit", $edit);
    $smarty->assign("continue", $continue);
    $smarty->assign("voice", $asuccess);
    $c = $smarty->view('alerts/card/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Nexus.styles-edit-noexist-title"));
    $smarty->assign("message", lang("Nexus.styles-edit-noexist-message"));
    $smarty->assign("continue", $continue);
    $smarty->assign("voice", $anoexist);
    $c = $smarty->view('alerts/card/warning.tpl');
}
echo($c);
?>