<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Cases\Editor\processor.php]
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
require_once(APPPATH . 'ThirdParty/Mongo/autoload.php');

use App\Libraries\Mongo;
use \MongoDB\Client;
use \MongoDB\Driver\Cursor;

//[Services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$s = service('strings');
//[Models]--------------------------------------------------------------------------------------------------------------
$mcases = model("App\Modules\C4isr\Models\C4isr_Cases");
$mmbreaches = model("App\Modules\C4isr\Models\C4isr_Mongo_Breaches");
//[Request]-------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Cases."));
$case = $f->get_Value("case");
$search = $f->get_Value("search");
$offset = empty($request->getGet("offset")) ? 0 : $request->getGet("offset");
$limit = empty($request->getGet("limit")) ? 10 : $request->getGet("limit");
$filter = ['username' => '', 'password' => ''];
$documents = $mmbreaches->findAll($limit, $offset, $filter);
$total = 0;
//[Build]
$c = '<table class="table table-bordered w-100">';

$count = 0;
foreach ($documents as $document) {
    $count++;
    $c .= '<tr>';
    $c .= '<td>' . $count . @$document->_id . '</td>';
    $c .= '<td>' . @$document->breach . '</td>';
    $c .= '<td>' . @$document->source . '</td>';
    $c .= '<td>' . $s->get_Substr($s->get_URLDecode(@$document->username), 32) . '</td>';
    $c .= '<td>' . $s->get_Substr($s->get_URLDecode(@$document->password), 32) . '</td>';
    $c .= '</tr>';
    if (empty($document->username) && empty($document->password)) {
        $mmbreaches->delete($document->_id);
    }
}

$c .= '</table>';

//$c .=

$c .= '<b>Total: </b>' . $total;

//[Build]-----------------------------------------------------------------------------
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", lang("Cases.view-title"));
$smarty->assign("body", $c);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));

?>