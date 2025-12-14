<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Security\Views\Roles\List\json.php]
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
$mpermissions = model("\App\Modules\Security\Models\Security_Permissions");
$mpolicies = model("App\Modules\Security\Models\Security_Policies");
//[Query]---------------------------------------------------------------------------------------------------------------
$list = $mpermissions->get_List($limit, $offset, $search);
$recordsTotal = $mpermissions->get_Total($search);
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
    $permission = $item["permission"];
    /** Fields * */
    $row["permission"] = $permission;
    $row["alias"] = $item["alias"];
    $row["module"] = $item["module"];
    $row["created_at"] = $item["created_at"];
    $row["updated_at"] = $item["updated_at"];
    $row["deleted_at"] = $item["deleted_at"];
    $policy = $mpolicies->where("rol", $oid)->where("permission", $permission)->first();
    $span = HtmlTag::tag('span');
    $span->attr('class', 'slider round');
    $span->content(array());

    if (is_array($policy) && isset($policy["policy"])) {
        $input = HtmlTag::tag('input');
        $input->attr('name', 'policie');
        $input->attr('id', 'policie');
        $input->attr('class', 'checkbox success');
        $input->attr('type', 'checkbox');
        $input->attr('permission', $permission);
        $input->attr('checked', 'true');
        $input->attr('onchange', 'check_policie($(this).prop(\'checked\'),\'' . $permission . '\')');
        $status = HtmlTag::tag('label');
        $status->attr('class', 'switch');
        $status->content(array($input, $span));
    } else {
        $input = HtmlTag::tag('input');
        $input->attr('name', 'policie');
        $input->attr('id', 'policie');
        $input->attr('class', 'checkbox success');
        $input->attr('type', 'checkbox');
        $input->attr('permission', $permission);
        $input->attr('onchange', 'check_policie($(this).prop(\'checked\'),\'' . $permission . '\')');
        $status = HtmlTag::tag('label');
        $status->attr('class', 'switch');
        $status->content(array($input, $span));
    }

    $options = HtmlTag::tag('div');
    $options->attr('class', 'btn-group');
    $options->attr('role', 'group');
    $options->content(array($status));
    /* Build */
    $row["status"] = $options->render();
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
$json["total"] = $recordsTotal;
$json["data"] = $data;
echo(json_encode($json));
?>



