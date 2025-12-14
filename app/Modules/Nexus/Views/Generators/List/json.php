<?php


use App\Libraries\Html\HtmlTag;

$request = service('request');

$columns = $request->getGet("columns");
$offset = $request->getGet("offset");
$search = $request->getGet("search");

/** Asignations * */
$draw = empty($request->getGet("draw")) ? 1 : $request->getGet("draw");
$limit = empty($request->getGet("limit")) ? 10 : $request->getGet("limit");

$model = model("\App\Modules\Nexus\Models\Nexus_Entities", true);
$list = $model->where("TABLE_SCHEMA", "anssible_anssible")->findAll();
$recordsTotal = count($list);

$data = array();
$icontroller = HtmlTag::tag('i', array('class' => 'icon far fa-gamepad-alt'), "");
$imodel = HtmlTag::tag('i', array('class' => 'icon far fa-database'), "");
$iview = HtmlTag::tag('i', array('class' => 'icon far fa-eye'), "");
$icreate = HtmlTag::tag('i', array('class' => 'icon far fa-sparkles'), "");
$ilist = HtmlTag::tag('i', array('class' => 'icon fas fa-list'));
$iedit = HtmlTag::tag('i', array('class' => 'icon far fa-edit'));
$idelete = HtmlTag::tag('i', array('class' => 'far fa-trash'));
$ilang = HtmlTag::tag('i', array('class' => 'icon fal fa-language'));

foreach ($list as $item) {
    $lmodel = HtmlTag::tag('a');
    $lmodel->attr('class', 'btn btn-outline-secondary');
    $lmodel->attr('href', '/nexus/generators/model/' . $item["TABLE_NAME"]);
    $lmodel->attr('target', '_blank');
    $lmodel->content(array($imodel, " Modelo"));

    $lcontroller = HtmlTag::tag('a');
    $lcontroller->attr('class', 'btn btn-outline-secondary');
    $lcontroller->attr('href', '/nexus/generators/controller/' . $item["TABLE_NAME"]);
    $lcontroller->attr('target', '_blank');
    $lcontroller->content(array($icontroller, " Controlador"));

    $llister = HtmlTag::tag('a');
    $llister->attr('class', 'btn btn-outline-secondary');
    $llister->attr('href', '/nexus/generators/lister/' . $item["TABLE_NAME"]);
    $llister->attr('target', '_blank');
    $llister->content(array($ilist, " Listado"));

    $lcreator = HtmlTag::tag('a');
    $lcreator->attr('class', 'btn btn-outline-secondary');
    $lcreator->attr('href', '/nexus/generators/creator/' . $item["TABLE_NAME"]);
    $lcreator->attr('target', '_blank');
    $lcreator->content(array($icreate, " Creador"));

    $lviewer = HtmlTag::tag('a');
    $lviewer->attr('class', 'btn btn-outline-secondary');
    $lviewer->attr('href', '/nexus/generators/viewer/' . $item["TABLE_NAME"]);
    $lviewer->attr('target', '_blank');
    $lviewer->content(array($iview, " Visualizador"));

    $leditor = HtmlTag::tag('a');
    $leditor->attr('class', 'btn btn-outline-secondary');
    $leditor->attr('href', '/nexus/generators/editor/' . $item["TABLE_NAME"]);
    $leditor->attr('target', '_blank');
    $leditor->content(array($iedit, " Editor"));

    $ldeleter = HtmlTag::tag('a');
    $ldeleter->attr('class', 'btn btn-outline-secondary');
    $ldeleter->attr('href', '/nexus/generators/deleter/' . $item["TABLE_NAME"]);
    $ldeleter->attr('target', '_blank');
    $ldeleter->content(array($idelete, " Eliminador"));

    $llangs = HtmlTag::tag('a');
    $llangs->attr('class', 'btn btn-outline-secondary');
    $llangs->attr('href', '/nexus/generators/lang/' . $item["TABLE_NAME"]);
    $llangs->attr('target', '_blank');
    $llangs->content(array($ilang, " Lenguaje"));

    $options = HtmlTag::tag('div');
    $options->attr('class', 'btn-group');
    $options->attr('role', 'group');
    $options->content(array($lmodel, $lcontroller, $llister, $lcreator, $lviewer, $leditor, $ldeleter, $llangs));

    $row["entitie"] = $item["TABLE_NAME"];
    $row["name"] = urldecode($item["TABLE_NAME"]);
    $row["options"] = $options->render();
    array_push($data, $row);
}


$json["draw"] = $draw;
$json["columns"] = $columns;
$json["offset"] = $offset;
$json["search"] = $search;
$json["limit"] = $limit;
$json["total"] = $recordsTotal;
$json["data"] = $data;

echo(json_encode($json));

?>