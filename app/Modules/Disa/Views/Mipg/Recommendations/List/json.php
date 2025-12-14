<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Recommendations\List\json.php]
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
    ->where("reference", $oid)
    ->like("recommendation", "%{$search}%")
    ->like("dimension", "%{$search}%")
    ->orderBy("dimension", "ASC")
    ->orderBy("politic", "ASC")
    ->orderBy("recommendation", "ASC")
    ->findAll($limit, $offset);
//$sql = $mrecommendations->getCompiledSelect();

if (!empty($search)) {
    $recordsTotal = $mrecommendations
        ->where("reference", $oid)
        ->like("recommendation", "%{$search}%")
        ->like("dimension", "%{$search}%")
        ->countAllResults();
} else {
    $recordsTotal = $mrecommendations
        ->where("reference", $oid)
        ->countAllResults();
}

/*
* -----------------------------------------------------------------------------
* [Asignations]
* -----------------------------------------------------------------------------
*/
$data = array();
$iview = HtmlTag::tag('i', array('class' => 'icon far fa-eye'), "");
$icreate = HtmlTag::tag('i', array('class' => 'icon far fa-sparkles'), "");
$ilist = HtmlTag::tag('i', array('class' => 'icon fas fa-list'));
$iedit = HtmlTag::tag('i', array('class' => 'icon far fa-edit'));
$idelete = HtmlTag::tag('i', array('class' => 'far fa-trash'));
foreach ($list as $item) {
    $dimension = $mdimensions->find($item['dimension']);
    $politic = $mpolitics->find($item['politic']);
    $lview = HtmlTag::tag('a');
    $lview->attr('class', 'btn btn-outline-secondary');
    $lview->attr('href', '/disa/mipg/recommendations/assign/' . $item["recommendation"]);
    $lview->attr('target', '_self');
    $lview->content(array($iview, " " . lang("App.Assign")));
    $leditor = HtmlTag::tag('a');
    $leditor->attr('class', 'btn btn-outline-secondary');
    $leditor->attr('href', '/disa/mipg/recommendations/edit/' . $item["recommendation"]);
    $leditor->attr('target', '_self');
    $leditor->content(array($iedit, " " . lang("App.Edit")));
    $ldeleter = HtmlTag::tag('a');
    $ldeleter->attr('class', 'btn btn-outline-secondary');
    $ldeleter->attr('href', '/disa/mipg/recommendations/delete/' . $item["recommendation"]);
    $ldeleter->attr('target', '_self');
    $ldeleter->content(array($idelete, " " . lang("App.Delete")));
    $options = HtmlTag::tag('div');
    $options->attr('class', 'btn-group');
    $options->attr('role', 'group');
    $options->content(array($lview . $leditor, $ldeleter));
    /* Build */
    $row["recommendation"] = $item["recommendation"];
    $row["reference"] = $item["reference"];
    $row["dimension"] = urldecode($dimension["name"]);
    $row["politic"] = urldecode($politic["name"]);
    $row["component"] = $item["component"];
    $row["category"] = $item["category"];
    $row["activity"] = $item["activity"];
    $row["description"] = "<p style=\"font-size:0.70rem;line-height:0.70rem;\">" . urldecode($item["description"]) . "</p>";
    $row["author"] = $item["author"];
    $row["created_at"] = $item["created_at"];
    $row["updated_at"] = $item["updated_at"];
    $row["deleted_at"] = $item["deleted_at"];
    $row["options"] = $options->render();
    array_push($data, $row);
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