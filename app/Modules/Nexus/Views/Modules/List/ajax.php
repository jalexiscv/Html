<?php

use App\Libraries\Bootstrap;

$request = service('request');
$authentication = service('authentication');
$columns = $request->getGet("columns");
$search = $request->getGet("search");
/** Asignations * */
$draw = empty($request->getGet("draw")) ? 1 : $request->getGet("draw");
$limit = empty($request->getGet("limit")) ? 10 : $request->getGet("limit");
$offset = empty($request->getGet("offset")) ? 0 : $request->getGet("offset");
$model = model("App\Modules\Application\Models\Application_Modules", true);
$list = $model
    ->where("deleted_at", NULL)
    ->like("applicant", "%{$search}%")
    ->orLike("name", "%{$search}%")
    ->orderBy("created_at", "DESC")
    ->findAll($limit, $offset);
if (!empty($search)) {
    $recordsTotal = $model
        ->where("deleted_at", NULL)
        ->like("applicant", "%{$search}%")
        ->orLike("name", "%{$search}%")
        ->countAllResults();
} else {
    $recordsTotal = $model->countAllResults();
}
$b = new Bootstrap();
$data = array();
foreach ($list as $item) {
    $row = array();
    $pk = $item["pk"];
    $url["view"] = "/application/modules/view/{$pk}";
    $url["edit"] = "/application/modules/edit/{$pk}";
    $url["delete"] = "/application/modules/delete/{$pk}";
    $c = "<div class=\"btn-group\" role=\"group\">";
    $c .= $b->get_Link("view", array("href" => $url["view"], "icon" => "far fa-eye"));
    $c .= $b->get_Link("edit", array("href" => $url["edit"], "icon" => "far fa-edit"));
    $c .= $b->get_Link("delete", array("href" => $url["delete"], "icon" => "far fa-trash"));
    $c .= "</div>";
    /** Fields **/
    $row["module"] = $item["module"];
    $row["alias"] = $item["alias"];
    $row["title"] = $item["title"];
    $row["description"] = $item["description"];
    $row["date"] = $item["date"];
    $row["time"] = $item["time"];
    $row["author"] = $item["author"];

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