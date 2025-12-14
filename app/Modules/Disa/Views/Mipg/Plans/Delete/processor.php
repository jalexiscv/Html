<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Plans\Editor\processor.php]
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
$model = model("App\Modules\Disa\Models\Disa_Plans");
$pkey = $f->get_Value("pkey");
$row = $model->find($oid);
if (isset($row["plan"])) {
    $delete = $model->delete($pkey);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.plans-delete-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.plans-delete-success-message"), $row['plan']));
    $smarty->assign("continue", base_url("/disa/mipg/plans/list/" . $row["activity"]));
    $smarty->assign("voice", "disa/plans-delete-success-message.mp3");
    $c = $smarty->view('alerts/card/success.tpl');
    /** Logger **/
    history_logger(array(
        "log" => pk(),
        "module" => "DISA",
        "author" => $authentication->get_User(),
        "description" => "El usuario <b>@" . $authentication->get_Alias() . "</b> ha eliminado el plan de acción <b>{$oid}</b>.",
        "code" => "",
    ));
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.plans-delete-noexist-title"));
    $smarty->assign("message", lang("Disa.plans-delete-noexist-message"));
    $smarty->assign("continue", base_url("/disa/mipg/plans/list/" . $row["activity"]));
    $smarty->assign("voice", "disa/plans-delete-noexist-message.mp3");
    $c = $smarty->view('alerts/card/warning.tpl');
}
echo($c);
?>
