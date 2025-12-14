<?php

use App\Libraries\Bootstrap;

use Config\Services;

$request = service('request');
$authentication = service('authentication');
$columns = $request->getGet("columns");
$search = $request->getGet("search");
/** Asignations * */
$draw = empty($request->getGet("draw")) ? 1 : $request->getGet("draw");
$limit = empty($request->getGet("limit")) ? 10 : $request->getGet("limit");
$offset = empty($request->getGet("offset")) ? 0 : $request->getGet("offset");
$model = model("App\Modules\Wallet\Models\Wallet_Currencies", true);
$list = $model
    ->where("deleted_at", NULL)
    ->like("currency", "%{$search}%")
    ->orLike("name", "%{$search}%")
    ->orderBy("created_at", "DESC")
    ->findAll($limit, $offset);
if (!empty($search)) {
    $recordsTotal = $model
        ->where("deleted_at", NULL)
        ->like("currency", "%{$search}%")
        ->orLike("name", "%{$search}%")
        ->countAllResults();
} else {
    $recordsTotal = $model->countAllResults();
}
$b = new Bootstrap();
$data = array();
foreach ($list as $item) {
    $row = array();
    $pk = $item["currency"];
    $url["view"] = "/wallet/currencies/view/{$pk}";
    $url["edit"] = "/wallet/currencies/edit/{$pk}";
    $url["delete"] = "/wallet/currencies/delete/{$pk}";
    $c = "<div class=\"btn-group\" role=\"group\">";
    $c .= $b->get_Link("view", array("href" => $url["view"], "icon" => "far fa-eye"));
    $c .= $b->get_Link("edit", array("href" => $url["edit"], "icon" => "far fa-edit"));
    $c .= $b->get_Link("delete", array("href" => $url["delete"], "icon" => "far fa-trash"));
    $c .= "</div>";
    /** Fields **/
    $row["currency"] = $item["currency"];
    $row["name"] = urldecode($item["name"]);
    $row["abbreviation"] = $item["abbreviation"];
    $row["icon"] = $item["icon"];
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
/** <echo> **/
echo(json_encode($json));
?>