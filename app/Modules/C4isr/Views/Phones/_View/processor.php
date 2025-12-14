<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Phones\Editor\processor.php]
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
$f = service("forms", array("lang" => "Phones."));
$model = model("App\Modules\C4isr\Models\C4isr_Phones");
$d = array(
    "phone" => $f->get_Value("phone"),
    "profile" => $f->get_Value("profile"),
    "country_code" => $f->get_Value("country_code"),
    "area_code" => $f->get_Value("area_code"),
    "local_number" => $f->get_Value("local_number"),
    "extension" => $f->get_Value("extension"),
    "type" => $f->get_Value("type"),
    "carrier" => $f->get_Value("carrier"),
    "normalized_number" => $f->get_Value("normalized_number"),
    "author" => $authentication->get_User(),
);
$row = $model->find($d["phone"]);
if (isset($row["phone"])) {
    $edit = $model->update($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Phones.view-success-title"));
    $smarty->assign("message", sprintf(lang("Phones.view-success-message"), $d['phone']));
    $smarty->assign("edit", base_url("/c4isr/phones/edit/{$d['phone']}/" . lpk()));
    $smarty->assign("continue", base_url("/c4isr/phones/view/{$d["phone"]}/" . lpk()));
    $smarty->assign("voice", "c4isr/phones-view-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Phones.view-noexist-title"));
    $smarty->assign("message", lang("Phones.view-noexist-message"));
    $smarty->assign("continue", base_url("/c4isr/phones"));
    $smarty->assign("voice", "c4isr/phones-view-noexist-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);
?>
