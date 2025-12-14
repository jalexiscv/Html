<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Vulnerabilities\Editor\processor.php]
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
$f = service("forms", array("lang" => "Vulnerabilities."));
$model = model("App\Modules\C4isr\Models\C4isr_Vulnerabilities");
$d = array(
    "vulnerability" => $f->get_Value("vulnerability"),
    "mail" => $f->get_Value("mail"),
    "alias" => $f->get_Value("alias"),
    "password" => $f->get_Value("password"),
    "hash" => $f->get_Value("hash"),
    "salt" => $f->get_Value("salt"),
    "author" => $authentication->get_User(),
);
$row = $model->find($d["vulnerability"]);
if (isset($row["vulnerability"])) {
    $edit = $model->update($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Vulnerabilities.view-success-title"));
    $smarty->assign("message", sprintf(lang("Vulnerabilities.view-success-message"), $d['vulnerability']));
    $smarty->assign("edit", base_url("/c4isr/vulnerabilities/edit/{$d['vulnerability']}/" . lpk()));
    $smarty->assign("continue", base_url("/c4isr/vulnerabilities/view/{$d["vulnerability"]}/" . lpk()));
    $smarty->assign("voice", "c4isr/vulnerabilities-view-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Vulnerabilities.view-noexist-title"));
    $smarty->assign("message", lang("Vulnerabilities.view-noexist-message"));
    $smarty->assign("continue", base_url("/c4isr/vulnerabilities"));
    $smarty->assign("voice", "c4isr/vulnerabilities-view-noexist-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);
?>
