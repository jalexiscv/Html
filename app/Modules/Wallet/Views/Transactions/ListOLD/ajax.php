<?php
/** Libraries **/

use App\Libraries\Bootstrap;
use App\Libraries\Numbers;

use Config\Services;

$request = service('request');
$authentication = service('authentication');
$numbers = new Numbers();
/** Models **/
$mtransactions = model("App\Modules\Wallet\Models\Wallet_Transactions");
$musers = model("App\Modules\Wallet\Models\Wallet_Users");
$mfields = model("App\Modules\Wallet\Models\Wallet_Users_Fields");

$columns = $request->getGet("columns");
$search = $request->getGet("search");
/** Asignations * */
$draw = empty($request->getGet("draw")) ? 1 : $request->getGet("draw");
$limit = empty($request->getGet("limit")) ? 10 : $request->getGet("limit");
$offset = empty($request->getGet("offset")) ? 0 : $request->getGet("offset");

$list = $mtransactions
    ->like("transaction", "%{$search}%")
    ->like("module", "%{$search}%")
    ->Like("user", "%{$search}%")
    ->orderBy("created_at", "DESC")
    ->findAll($limit, $offset);
if (!empty($search)) {
    $recordsTotal = $mtransactions
        ->where("deleted_at", null)
        ->like("transaction", "%{$search}%")
        ->like("module", "%{$search}%")
        ->like("user", "%{$search}%")
        ->countAllResults();
} else {
    $recordsTotal = $mtransactions->countAllResults();
}
$b = new Bootstrap();
$data = array();
foreach ($list as $item) {
    $row = array();
    $pk = $item["transaction"];
    $url["view"] = "/wallet/transactions/view/{$pk}";
    $url["edit"] = "/wallet/transactions/edit/{$pk}";
    $url["delete"] = "/wallet/transactions/delete/{$pk}";
    $c = "<div class=\"btn-group\" role=\"group\">";
//$c .= $b->get_Link("view", array("href" => $url["view"], "icon" => "far fa-eye"));
    $c .= $b->get_Link("edit", array("href" => $url["edit"], "icon" => "far fa-edit", "class" => "btn-primary"));
    $c .= $b->get_Link("delete", array("href" => $url["delete"], "icon" => "far fa-trash", "class" => "btn-danger"));
    $c .= "</div>";
    /** Fields * */
    $row["transaction"] = $item["transaction"];
    $row["module"] = $item["module"];
    $row["user"] = $mfields->get_Field($item["user"], "alias");
    $row["reference"] = $item["reference"];
    $row["currency"] = $item["currency"];
    $row["debit"] = $numbers->to_Currency($item["debit"], "COP") . "$";
    $row["credit"] = $numbers->to_Currency($item["credit"], "COP") . "$";
    $row["balance"] = $numbers->to_Currency($item["balance"], "COP") . "$";
    $row["status"] = $item["status"];
    $row["author"] = $item["author"];
    $row["created_at"] = $item["created_at"];
    $row["updated_at"] = $item["updated_at"];
    $row["deleted_at"] = $item["deleted_at"];

    $row["options"] = ($c);
    array_push($data, $row);
}

/** <json> * */
$json["draw"] = $draw;
$json["total"] = $recordsTotal;
$json["search"] = $search;
$json["data"] = $data;
/** <echo> * */
echo(json_encode($json));
?>