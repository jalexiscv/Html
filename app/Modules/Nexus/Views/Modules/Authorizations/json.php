<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Application\Views\Modules\List\json.php]
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
$mmodules = model('App\Modules\Nexus\Models\Nexus_Modules');
$mClientsXModules = model('App\Modules\Nexus\Models\Nexus_Clients_Modules');

$list = $mmodules
    ->where("deleted_at", NULL)
    ->like("module", "%{$search}%")
    ->orLike("alias", "%{$search}%")
    ->orderBy("created_at", "DESC")
    ->findAll($limit, $offset);
if (!empty($search)) {
    $recordsTotal = $mmodules
        ->where("deleted_at", NULL)
        ->like("module", "%{$search}%")
        ->orLike("alias", "%{$search}%")
        ->countAllResults();
} else {
    $recordsTotal = $mmodules->countAllResults();
}
/*
$sql=$model->getLastQuery()->getQuery();*//*
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
    $lview->attr('href', '/application/modules/view/' . $item["module"]);
    $lview->attr('target', '_blank');
    $lview->content(array($iview, " " . lang("App.View")));
    $leditor = HtmlTag::tag('a');
    $leditor->attr('class', 'btn btn-outline-secondary');
    $leditor->attr('href', '/application/modules/edit/' . $item["module"]);
    $leditor->attr('target', '_blank');
    $leditor->content(array($iedit, " " . lang("App.Edit")));
    $ldeleter = HtmlTag::tag('a');
    $ldeleter->attr('class', 'btn btn-outline-secondary');
    $ldeleter->attr('href', '/application/modules/delete/' . $item["module"]);
    $ldeleter->attr('target', '_blank');
    $ldeleter->content(array($idelete, " " . lang("App.Delete")));

    $span = HtmlTag::tag('span');
    $span->attr('class', 'slider round');
    $span->content(array());

    $authorization = $mClientsXModules
        ->where("client", $oid)
        ->where("module", $item["module"])
        ->orderBy("authorization", "ASC")
        ->first();

    $input = HtmlTag::tag('input');
    $input->attr('name', 'authorization');
    $input->attr('id', 'authorization');
    $input->attr('class', 'checkbox success');
    $input->attr('type', 'checkbox');
    $input->attr('module', $item["module"]);
    $input->attr('onchange', 'check_module_client($(this).prop(\'checked\'),\'' . $item["module"] . '\')');
    if ($authorization) {
        $input->attr('checked', 'true');
    }
    $status = HtmlTag::tag('label');
    $status->attr('class', 'switch');
    $status->content(array($input, $span));

    $options = HtmlTag::tag('div');
    $options->attr('class', 'btn-group');
    $options->attr('role', 'group');
    $options->content(array($status));

    /* Build */
    $row["module"] = $item["module"];
    $row["alias"] = $item["alias"];
    $row["title"] = safe_urldecode($item["title"]);
    $row["description"] = safe_urldecode($item["description"]);
    $row["date"] = $item["date"];
    $row["time"] = $item["time"];
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