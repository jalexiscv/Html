<?php
/*
 * Copyright (c) 2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

use App\Libraries\Html\HtmlTag;

use Config\Services;

$mrecommendations = model('App\Modules\Disa\Models\Disa_Recommendations');
$mdimensions = model('App\Modules\Disa\Models\Disa_Dimensions');
$mpolitics = model('App\Modules\Disa\Models\Disa_Politics');
/*
* -----------------------------------------------------------------------------
* [Requests]
* -----------------------------------------------------------------------------
*/
$request = service('request');
$authentication = service('authentication');
$columns = $request->getGet("columns");
$offset = $request->getGet("offset");
$search = $request->getGet("search");
/*
* -----------------------------------------------------------------------------
* [Query]
* -----------------------------------------------------------------------------
*/
$draw = empty($request->getGet("draw")) ? 1 : $request->getGet("draw");
$limit = empty($request->getGet("limit")) ? 10 : $request->getGet("limit");

$list = $mrecommendations
    ->select("*")
    ->selectCount('recommendation', 'total')
    ->groupBy("description")
    ->where('activity', NULL)
    ->orWhere('activity', '')
    ->having('total>', 1)
    ->findAll($limit, $offset);
//$sql = $mrecommendations->getCompiledSelect();


if (!empty($search)) {
    $recordsTotal = $mrecommendations
        ->selectCount('recommendation', 'total')
        ->groupBy("description")
        ->where('activity', NULL)
        ->orWhere('activity', '')
        ->having('total>', 1)
        ->countAllResults();
} else {
    $recordsTotal = $mrecommendations
        ->selectCount('recommendation', 'total')
        ->groupBy("description")
        ->where('activity', NULL)
        ->orWhere('activity', '')
        ->having('total>', 1)
        ->countAllResults();
}


/*
* -----------------------------------------------------------------------------
* [Asignations]
* -----------------------------------------------------------------------------
*/
$data = array();
$iassign = HtmlTag::tag('i', array('class' => 'far fa-compass'), "");
$iunassign = HtmlTag::tag('i', array('class' => 'far fa-compass-slash'), "");
$iview = HtmlTag::tag('i', array('class' => 'icon far fa-eye'), "");
$icreate = HtmlTag::tag('i', array('class' => 'icon far fa-sparkles'), "");
$ilist = HtmlTag::tag('i', array('class' => 'icon fas fa-list'));
$iedit = HtmlTag::tag('i', array('class' => 'icon far fa-edit'));
$idelete = HtmlTag::tag('i', array('class' => 'far fa-trash'));

foreach ($list as $item) {
    if ($item["total"] > 1) {
        $dimension = $mdimensions->find($item['dimension']);
        $politic = $mpolitics->find($item['politic']);

        if (empty($item["activity"])) {
            $lview = HtmlTag::tag('a');
            $lview->attr('class', 'btn btn-outline-secondary');
            $lview->attr('href', '/disa/mipg/recommendations/assign/' . $item["recommendation"]);
            $lview->attr('target', '_self');
            $lview->content(array($iassign, " " . lang("App.Assign")));

            $lactivity = HtmlTag::tag('a');
            $lactivity->attr('class', 'btn btn-outline-secondary disabled');
            $lactivity->attr('href', '#');
            $lactivity->attr('target', '_self');
            $lactivity->content(array($iview, " " . lang("App.Activity")));

        } else {
            $lview = HtmlTag::tag('a');
            $lview->attr('class', 'btn btn-outline-danger');
            $lview->attr('href', '/disa/mipg/recommendations/unassign/' . $item["recommendation"]);
            $lview->attr('target', '_self');
            $lview->content(array($iunassign, " " . lang("App.Unassign")));

            $lactivity = HtmlTag::tag('a');
            $lactivity->attr('class', 'btn btn-outline-success');
            $lactivity->attr('href', '/disa/mipg/plans/list/' . $item["activity"]);
            $lactivity->attr('target', '_blank');
            $lactivity->content(array($iview, " " . lang("App.Activity")));
        }

        $leditor = HtmlTag::tag('a');
        $leditor->attr('class', 'btn btn-outline-secondary');
        $leditor->attr('href', '/disa/mipg/recommendations/edit/' . $item["recommendation"]);
        $leditor->attr('target', '_self');
        $leditor->content(array($iedit, " " . lang("App.Edit")));
        $options = HtmlTag::tag('div');
        $options->attr('class', 'btn-group');
        $options->attr('role', 'group');

        $options->content(array($lactivity . $lview));

        $tdimension = urldecode($dimension["name"]);
        $tpolitic = urldecode($politic["name"]);

        /* Build */
        $row["recommendation"] = $item["recommendation"];
        $row["reference"] = $item["reference"];
        $row["total"] = $item["total"];
        $row["dimension"] = $dimension;
        $row["politic"] = urldecode($politic["name"]);
        $row["component"] = $item["component"];
        $row["category"] = $item["category"];
        $row["activity"] = $item["activity"];
        $row["description"] = "<p style=\"font-size:1rem;line-height:1rem;\">"
            . "<b>Dimensión</b>: {$tdimension} "
            . "<br><b>Política</b>: {$tpolitic}"
            . "<br><b>Descripción</b >:" . urldecode($item["description"])
            . "</p>";
        $row["author"] = $item["author"];
        $row["created_at"] = $item["created_at"];
        $row["updated_at"] = $item["updated_at"];
        $row["deleted_at"] = $item["deleted_at"];
        $row["options"] = $options->render();
        array_push($data, $row);
    }
}
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$json["reference"] = $oid;
//$json["sql"] = $sql;
$json["draw"] = $draw;
$json["columns"] = $columns;
$json["offset"] = $offset;
$json["search"] = $search;
$json["limit"] = $limit;
$json["total"] = $recordsTotal;
$json["data"] = $data;
echo(json_encode($json));

?>