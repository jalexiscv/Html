<?php

/*
 * -----------------------------------------------------------------------------
 *  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
 *  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK]
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

use App\Libraries\Files;

$f = service("forms", array("lang" => "Nexus."));
$model = model("App\Modules\Nexus\Models\Nexus_Clients");
/*
 * -----------------------------------------------------------------------------
 * [Request]
 * -----------------------------------------------------------------------------
*/
$pathfile = $f->get_Value("pathfile");
$mkdir = $f->get_Value("mkdir");
$code = $f->get_Value("code");

$files = new Files();
$files->mkDir($mkdir);
$files->open($pathfile, "writeOnly")->write($code);
//$c = ("<b>Archivo creado</b>: {$relative}");
/*
 * -----------------------------------------------------------------------------
 * [Processing]
 * -----------------------------------------------------------------------------
*/
//$row = $model->find($d["client"]);
if (isset($row["client"])) {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Nexus.clients-duplicate-title"));
    $smarty->assign("message", lang("Nexus.clients-duplicate-message"));
    $smarty->assign("continue", base_url("/nexus/generators"));
    $smarty->assign("voice", "nexus/clients-duplicate-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
} else {
    //$create = $model->insert($d);
    //
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Nexus.clients-create-success-title"));
    $smarty->assign("message", sprintf(lang("Nexus.clients-create-success-message"), ""));
    //$smarty->assign("edit", base_url("/nexus/clients/edit/{$d['client']}/" . lpk()));
    $smarty->assign("continue", base_url("/nexus/generators"));
    $smarty->assign("voice", "nexus/clients-create-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
}
echo($c);
?>