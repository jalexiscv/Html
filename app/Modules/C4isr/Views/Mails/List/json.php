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
//[Request]-------------------------------------------------------------------------------------------------------------
$columns = $request->getGet("columns");
$offset = $request->getGet("offset");
$search = $strings->get_URLEncode($request->getGet("search"));
$draw = empty($request->getGet("draw")) ? 1 : $request->getGet("draw");
$limit = empty($request->getGet("limit")) ? 10 : $request->getGet("limit");

$mmails = model('App\Modules\C4isr\Models\C4isr_Mails', false);

$data = array();
$list = $mmails->query_Union($search, $limit, $offset);
$recordsTotal = $mmails->get_TotalUnion($search);
//print_r($list);
//[Asignations]-----------------------------------------------------------------------------
$data = array();
$iview = HtmlTag::tag('i', array('class' => 'icon far fa-eye'), '');
$icreate = HtmlTag::tag('i', array('class' => 'icon far fa-sparkles'), '');
$ilist = HtmlTag::tag('i', array('class' => 'icon fas fa-list'));
$iedit = HtmlTag::tag('i', array('class' => 'icon far fa-edit'));
$idelete = HtmlTag::tag('i', array('class' => 'far fa-trash'));
$component = '/c4isr/mails';
//[Query]--------------------------------------------------------------------------------------------------------------
foreach ($list as $item) {
    //[Buttons]-----------------------------------------------------------------------------
    $viewer = "{$component}/view/{$item["mail"]}";
    $editor = "{$component}/edit/{$item["mail"]}";
    $deleter = "{$component}/delete/{$item["mail"]}";
    $lviewer = $bootstrap::get_Link('view', array('href' => $viewer, 'icon' => ICON_VIEW, 'text' => lang("App.View"), 'class' => 'btn-primary'));
    $leditor = $bootstrap::get_Link('edit', array('href' => $editor, 'icon' => ICON_EDIT, 'text' => lang("App.Edit"), 'class' => 'btn-secondary'));
    $ldeleter = $bootstrap::get_Link('delete', array('href' => $deleter, 'icon' => ICON_DELETE, 'text' => lang("App.Delete"), 'class' => 'btn-danger'));
    $options = $bootstrap::get_BtnGroup('options', array("content" => array($lviewer, $leditor, $ldeleter)));
    //[Fields]-----------------------------------------------------------------------------
    $row["mail"] = $item["mail"];
    $row["profile"] = $item["profile"];
    $row["email"] = $strings->get_URLDecode($item["email"]);
    //$row["author"] = $item["author"];
    //$row["created_at"] = $item["created_at"];
    //$row["updated_at"] = $item["updated_at"];
    //$row["deleted_at"] = $item["deleted_at"];
    $row["options"] = $options;
    //[Push]------------------------------------------------------------------------------------------------------------
    array_push($data, $row);
}
//[/Query]--------------------------------------------------------------------------------------------------------------


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



