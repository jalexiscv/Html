<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Application\Views\Stats\Editor\processor.php]
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
$f = service("forms", array("lang" => "Application.stats-"));
$model = model("App\Modules\Application\Models\Application_Stats");
$d = array(
    "stat" => $f->get_Value("stat"),
    "instance" => $f->get_Value("instance"),
    "module" => $f->get_Value("module"),
    "object" => $f->get_Value("object"),
    "ip" => $f->get_Value("ip"),
    "user" => $f->get_Value("user"),
    "type" => $f->get_Value("type"),
    "reference" => $f->get_Value("reference"),
    "log" => $f->get_Value("log"),
    "author" => $authentication->get_User(),
    "date" => $f->get_Value("date"),
    "time" => $f->get_Value("time"),
);
$row = $model->find($d["stat"]);
if (isset($row["stat"])) {
    $edit = $model->update($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Application.stats-view-success-title"));
    $smarty->assign("message", sprintf(lang("Application.stats-view-success-message"), $d['stat']));
    $smarty->assign("edit", base_url("/application/stats/edit/{$d['stat']}/" . lpk()));
    $smarty->assign("continue", base_url("/application/stats/view/{$d["stat"]}/" . lpk()));
    $smarty->assign("voice", "application/stats-view-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Application.stats-view-noexist-title"));
    $smarty->assign("message", lang("Application.stats-view-noexist-message"));
    $smarty->assign("continue", base_url("/application/stats"));
    $smarty->assign("voice", "application/stats-view-noexist-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);
?>
