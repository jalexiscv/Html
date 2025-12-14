<?php
//[Uses]----------------------------------------------------------------------------------------------------------------
use App\Libraries\Html\HtmlTag;
use App\Libraries\Authentication;
use Config\Services;

//[Services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]--------------------------------------------------------------------------------------------------------------
$model = model('App\Modules\C4isr\Models\C4isr_Darkweb');
//[Requests]------------------------------------------------------------------------------------------------------------
$columns = $request->getGet("columns");
$offset = $request->getGet("offset");
$search = $request->getGet("search");
$draw = empty($request->getGet("draw")) ? 1 : $request->getGet("draw");
$limit = empty($request->getGet("limit")) ? 10 : $request->getGet("limit");
//[Query]---------------------------------------------------------------------------------------------------------------
$list = $model
    ->where("deleted_at", NULL)
    ->groupStart()
    ->like("file", "%{$search}%")
    ->orLike("title", "%{$search}%")
    ->groupEnd()
    ->orderBy("created_at", "DESC")
    ->findAll($limit, $offset);
if (!empty($search)) {
    $recordsTotal = $model
        ->where("deleted_at", NULL)
        ->groupStart()
        ->like("file", "%{$search}%")
        ->orLike("title", "%{$search}%")
        ->groupEnd()
        ->countAllResults();
} else {
    $recordsTotal = $model
        ->where("deleted_at", NULL)
        ->countAllResults();
}
//$sql=$model->getLastQuery()->getQuery();
//[Asignations]---------------------------------------------------------------------------------------------------------
$data = array();
$component = '/c4isr/darkweb';
foreach ($list as $item) {
    //[Buttons]---------------------------------------------------------------------------------------------------------
    $viewer = "{$component}/view/{$item["file"]}";
    $editor = "{$component}/edit/{$item["file"]}";
    $deleter = "{$component}/delete/{$item["file"]}";
    $lviewer = $bootstrap::get_Link('view', array('href' => $viewer, 'icon' => ICON_VIEW, 'text' => lang("App.View"), 'class' => 'btn-primary'));
    $leditor = $bootstrap::get_Link('edit', array('href' => $editor, 'icon' => ICON_EDIT, 'text' => lang("App.Edit"), 'class' => 'btn-secondary'));
    $ldeleter = $bootstrap::get_Link('delete', array('href' => $deleter, 'icon' => ICON_DELETE, 'text' => lang("App.Delete"), 'class' => 'btn-danger'));
    $options = $bootstrap::get_BtnGroup('options', array('content' => array($lviewer, $leditor, $ldeleter)));
    //[Fields]----------------------------------------------------------------------------------------------------------
    $row["file"] = $item["file"];
    $row["title"] = $strings->get_URLDecode($item["title"]);
    $row["description"] = $strings->get_URLDecode($item["description"]);
    $row["url"] = $item["url"];
    $row["size"] = $item["size"];
    $row["type"] = $item["type"];
    $row["date"] = $item["date"];
    $row["time"] = $item["time"];
    $row["author"] = $item["author"];
    $row["created_at"] = $item["created_at"];
    $row["updated_at"] = $item["updated_at"];
    $row["deleted_at"] = $item["deleted_at"];
    $row["options"] = $options;
    //[Push]------------------------------------------------------------------------------------------------------------
    array_push($data, $row);
}
//[Build]---------------------------------------------------------------------------------------------------------------
$json["draw"] = $draw;
$json["columns"] = $columns;
$json["offset"] = $offset;
$json["search"] = $search;
$json["limit"] = $limit;
//$json["sql"] = $sql;
$json["total"] = $recordsTotal;
$json["data"] = $data;
echo(json_encode($json));
?>