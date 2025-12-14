<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Application\Views\Styles\List\json.php]
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


$mstyles = model('App\Modules\Nexus\Models\Nexus_Styles');

/*
* -----------------------------------------------------------------------------
* [Requests]
* -----------------------------------------------------------------------------
*/
$request = service('request');
$authentication = service('authentication');
$columns = $request->getGet("columns");
$offset = $request->getGet("offset");
$search = urlencode($request->getGet("search"));
/*
* -----------------------------------------------------------------------------
* [Query]
* -----------------------------------------------------------------------------
*/
$draw = empty($request->getGet("draw")) ? 1 : $request->getGet("draw");
$limit = empty($request->getGet("limit")) ? 10 : $request->getGet("limit");

if (!empty($search)) {
    $list = $mstyles
        ->where("theme", $oid)
        ->like("selectors", "%{$search}%")
        ->orderBy("updated_at", "DESC")
        ->findAll($limit, $offset);
    $recordsTotal = $mstyles
        ->where("theme", $oid)
        ->like("selectors", "%{$search}%")
        //->orLike("selectors", "%{$search}%")
        ->countAllResults();
} else {
    $list = $mstyles
        ->where("theme", $oid)
        ->orderBy("updated_at", "DESC")
        ->findAll($limit, $offset);
    $recordsTotal = $mstyles
        ->where("theme", $oid)
        ->countAllResults();
}

$sql = $mstyles->getLastQuery()->getQuery();
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
    $lview = HtmlTag::tag('a');
    $lview->attr('class', 'btn btn-outline-secondary');
    $lview->attr('href', '/nexus/styles/view/' . $item["style"]);
    $lview->attr('target', '_self');
    $lview->content(array($iview, " " . lang("App.View")));
    $leditor = HtmlTag::tag('a');
    $leditor->attr('class', 'btn btn-outline-secondary');
    $leditor->attr('href', '/nexus/styles/edit/' . $item["style"]);
    $leditor->attr('target', '_self');
    $leditor->content(array($iedit, " " . lang("App.Edit")));
    $ldeleter = HtmlTag::tag('a');
    $ldeleter->attr('class', 'btn btn-outline-secondary');
    $ldeleter->attr('href', '/nexus/styles/delete/' . $item["style"]);
    $ldeleter->attr('target', '_self');
    $ldeleter->content(array($idelete, " " . lang("App.Delete")));
    $options = HtmlTag::tag('div');
    $options->attr('class', 'btn-group');
    $options->attr('role', 'group');
    $options->content(array($lview, $leditor, $ldeleter));
    /* Build */
    $row["style"] = $item["style"];
    $row["theme"] = $item["theme"];
    $row["selectors"] = urldecode($item["selectors"]);
    $row["default"] = !empty($item["default"]) ? "<i class=\"fas fa-check\"></i>" : "";
    $row["xxl"] = !empty($item["xxl"]) ? "<i class=\"fas fa-check\"></i>" : "";
    $row["xl"] = !empty($item["xl"]) ? "<i class=\"fas fa-check\"></i>" : "";
    $row["lg"] = !empty($item["lg"]) ? "<i class=\"fas fa-check\"></i>" : "";
    $row["md"] = !empty($item["md"]) ? "<i class=\"fas fa-check\"></i>" : "";
    $row["sm"] = !empty($item["sm"]) ? "<i class=\"fas fa-check\"></i>" : "";
    $row["xs"] = !empty($item["xs"]) ? "<i class=\"fas fa-check\"></i>" : "";
    $row["date"] = $item["date"];
    $row["time"] = $item["time"];
    $row["author"] = $item["author"];
    $row["importer"] = $item["importer"];
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
$json["draw"] = $draw;
$json["columns"] = $columns;
$json["offset"] = $offset;
$json["oid"] = $oid;
$json["search"] = $search;
$json["sql"] = $sql;
$json["limit"] = $limit;
$json["total"] = $recordsTotal;
$json["data"] = $data;
echo(json_encode($json));
?>



