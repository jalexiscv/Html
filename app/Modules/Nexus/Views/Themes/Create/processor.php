<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Application\Views\Themes\Creator\processor.php]
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
$f = service("forms", array("lang" => "Nexus.themes-"));
$model = model("App\Modules\Nexus\Models\Nexus_Themes");
$d = array(
    "theme" => $f->get_Value("theme"),
    "name" => urlencode($f->get_Value("name")),
    "description" => urlencode($f->get_Value("description")),
    "date" => $f->get_Value("date"),
    "time" => $f->get_Value("time"),
    "author" => $authentication->get_User(),
);
$row = $model->find($d["theme"]);
$l["back"] = "/nexus/themes/list/" . lpk();
$l["edit"] = "/Nexus/themes/edit/{$d['theme']}/" . lpk();
if (isset($row["theme"])) {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Nexus.themes-create-duplicate-title"));
    $smarty->assign("message", lang("Nexus.themes-create-duplicate-message"));
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "application/themes-create-duplicate-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
} else {
    $create = $model->insert($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Nexus.themes-create-success-title"));
    $smarty->assign("message", sprintf(lang("Nexus.themes-create-success-message"), $d['theme']));
    //$smarty->assign("edit", $l["edit"]);
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "nexus/themes-create-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
}
echo($c);
?>
