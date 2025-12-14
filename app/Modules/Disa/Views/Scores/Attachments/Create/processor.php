<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Storage\Views\Attachments\Creator\processor.php]
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

use App\Libraries\Server;
use App\Libraries\Dates;

$server = service('server');
$Authentication = service('authentication');
$request = service('request');
$dates = service('dates');
$mattachments = model("App\Modules\Storage\Models\Storage_Attachments");
$back = '/disa/mipg/scores/edit/' . $oid;

$f = service("forms", array("lang" => "Disa.institutionality-committee-upload-"));


$user = $authentication->get_User();
$path = '/storages/' . md5($server->get_FullName()) . 'disa/institutionality/committees';
$file = $request->getFile($f->get_fieldId('file'));

if (!is_null($file) && $file->isValid()) {
    $rname = $file->getRandomName();
    $file->move(ROOTPATH . 'public' . $path, $rname);
    $name = $file->getClientName();
    $type = $file->getClientMimeType();
    $url = $path . "/" . $rname;
    $d = array(
        "attachment" => pk(),
        "object" => $f->get_Value("object"),
        "file" => $url,
        "type" => $type,
        "date" => $dates->get_Date(),
        "time" => $dates->get_Time(),
        "alt" => "",
        "title" => "",
        "size" => $file->getSize(),
        "reference" => "EVIDENCES",
        "author" => $user,
    );
    $create = $mattachments->insert($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.institutionality-committee-upload-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.institutionality-committee-upload-success-message"), $d['attachment']));
    //$smarty->assign("edit", base_url("/storage/attachments/edit/{$d['client']}/" . lpk()));
    $smarty->assign("continue", $back);
    $smarty->assign("voice", "disa/institutionality-committee-upload-success-message.mp3");
    $c = $smarty->view('alerts/card/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.institutionality-committee-attachment-error-title"));
    $smarty->assign("message", lang("Disa.institutionality-committee-attachment-error-message"));
    $smarty->assign("continue", $back);
    $smarty->assign("voice", "disa/institutionality-committee-attachment-error-message.mp3");
    $c = $smarty->view('alerts/card/warning.tpl');
}
echo($c);
?>