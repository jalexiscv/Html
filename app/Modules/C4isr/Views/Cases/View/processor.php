<?php
require_once(APPPATH . 'ThirdParty/Mongo/autoload.php');

use App\Libraries\Mongo;
use \MongoDB\Client;
use \MongoDB\Driver\Cursor;

$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$s = service('strings');

$f = service("forms", array("lang" => "Cases."));
$mcases = model("App\Modules\C4isr\Models\C4isr_Cases");
$mbreaches = model("App\Modules\C4isr\Models\C4isr_Breaches_Milco");

$case = $f->get_Value("case");
$type = $f->get_Value("type");
$identifier = $f->get_Value("identifier");
$search = $f->get_Value("search");

$offset = empty($request->getGet("offset")) ? 0 : $request->getGet("offset");
$limit = empty($request->getGet("limit")) ? 25 : $request->getGet("limit");

$data = array(
    "case" => $oid,
    "search" => $search,
);

if ($type == 'OSINTS') {
    $country = $f->get_Value("country");
    if (!empty($country) && ($country == "CO" || $country == "VE")) {
        $c = view("{$processors}\sint", $data);
    } else {
        $c = view("{$processors}\\forbidden", $data);
    }
} elseif ($type == 'DATABREACHES') {
    $c = view("{$processors}\Breaches\index", $data);
} elseif ($type == 'CVEWEB') {
    $c = view("{$processors}\cveweb", $data);
} elseif ($type == 'DARKWEB') {
    $c = view("{$processors}\darkweb", $data);
} else {
    $c = view("{$processors}\unknow", $data);
}

$back = "/c4isr/cases/view/{$case}";
//[Build]-----------------------------------------------------------------------------
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", lang('Cases.search-title'));
$smarty->assign("header_back", $back);
$smarty->assign("body", $c);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));

?>