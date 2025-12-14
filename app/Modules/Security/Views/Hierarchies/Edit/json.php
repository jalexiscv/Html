<?php

use App\Libraries\Html\HtmlTag;

use Config\Services;

$bootstrap = service('bootstrap');
//[Requests]------------------------------------------------------------------------------------------------------------
$request = service('request');
$authentication = service('authentication');
$columns = $request->getGet("columns");
$offset = $request->getGet("offset");
$search = $request->getGet("search");
//[Query]---------------------------------------------------------------------------------------------------------------
$draw = empty($request->getGet("draw")) ? 1 : $request->getGet("draw");
$limit = empty($request->getGet("limit")) ? 10 : $request->getGet("limit");
$model = model('App\Modules\Security\Models\Security_Roles');
$mhierarchies = model("App\Modules\Security\Models\Security_Hierarchies");

$list = $model
    ->where("deleted_at", NULL)
    ->like("rol", "%{$search}%")
    ->orLike("name", "%{$search}%")
    ->orderBy("created_at", "DESC")
    ->findAll($limit, $offset);
if (!empty($search)) {
    $recordsTotal = $model
        ->where("deleted_at", NULL)
        ->like("rol", "%{$search}%")
        ->orLike("name", "%{$search}%")
        ->countAllResults();
} else {
    $recordsTotal = $model->countAllResults();
}
//[Asignations]---------------------------------------------------------------------------------------------------------
$data = array();
$iview = HtmlTag::tag('i', array('class' => 'icon far fa-eye'), "");
$icreate = HtmlTag::tag('i', array('class' => 'icon far fa-sparkles'), "");
$ilist = HtmlTag::tag('i', array('class' => 'icon fas fa-list'));
$iedit = HtmlTag::tag('i', array('class' => 'icon far fa-edit'));
$idelete = HtmlTag::tag('i', array('class' => 'far fa-trash'));
$ipolicies = HtmlTag::tag('i', array('class' => 'far fa-key'));

$component = '/security/users';
foreach ($list as $item) {
    $rol = $item["rol"];
    $hierarchie = $mhierarchies->where("user", $oid)->where("rol", $item["rol"])->first();
    $span = HtmlTag::tag('span');
    $span->attr('class', 'slider round');
    $span->content(array());
    if (is_array($hierarchie) && isset($hierarchie["hierarchy"])) {
        $input = HtmlTag::tag('input');
        $input->attr('name', 'hierarchie');
        $input->attr('id', 'hierarchie');
        $input->attr('class', 'checkbox success');
        $input->attr('type', 'checkbox');
        $input->attr('permission', $rol);
        $input->attr('checked', 'true');
        $input->attr('onchange', 'check_hierarchie($(this).prop(\'checked\'),\'' . $rol . '\')');
        $status = HtmlTag::tag('label');
        $status->attr('class', 'switch');
        $status->content(array($input, $span));
    } else {
        $input = HtmlTag::tag('input');
        $input->attr('name', 'hierarchie');
        $input->attr('id', 'hierarchie');
        $input->attr('class', 'checkbox success');
        $input->attr('type', 'checkbox');
        $input->attr('permission', $rol);
        $input->attr('onchange', 'check_hierarchie($(this).prop(\'checked\'),\'' . $rol . '\')');
        $status = HtmlTag::tag('label');
        $status->attr('class', 'switch');
        $status->content(array($input, $span));
    }
    //[Check]-----------------------------------------------------------------------------------------------------------
    $check = HtmlTag::tag('div');
    $check->attr('class', 'btn-group');
    $check->attr('role', 'group');
    $check->content(array($status));
    /* Options */

    $viewer = '/security/roles/view/' . $item["rol"];
    $policies = '/security/policies/edit/' . $item["rol"];
    $lviewer = $bootstrap::get_Link('view', array('href' => $viewer, 'icon' => ICON_VIEW, 'text' => lang("App.View"), 'class' => 'btn-primary'));
    $lpolicies = $bootstrap::get_Link('delete', array('href' => $policies, 'icon' => ICON_KEYS, 'text' => lang("App.Policies"), 'class' => 'btn-warning'));
    $options = $bootstrap::get_BtnGroup('options', array('content' => array($lviewer, $lpolicies)));
    //[Build]-----------------------------------------------------------------------------------------------------------
    $row["check"] = $check->render();
    $row["rol"] = $item["rol"];
    $row["name"] = "<a href='/security/policies/edit/{$item["rol"]}'>" . urldecode($item["name"]) . "</a>";
    $row["description"] = urldecode($item["description"]);
    $row["author"] = $item["author"];
    $row["created_at"] = $item["created_at"];
    $row["updated_at"] = $item["updated_at"];
    $row["deleted_at"] = $item["deleted_at"];
    $row["options"] = $options;
    array_push($data, $row);
}
//[Build]---------------------------------------------------------------------------------------------------------------
$json["draw"] = $draw;
$json["columns"] = $columns;
$json["offset"] = $offset;
$json["search"] = $search;
$json["limit"] = $limit;
$json["total"] = $recordsTotal;
$json["data"] = $data;
echo(json_encode($json));
?>