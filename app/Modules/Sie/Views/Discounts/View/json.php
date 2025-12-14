<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-04-30 03:13:12
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Products\List\json.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $mproducts Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/

//[Uses]----------------------------------------------------------------------------------------------------------------
use App\Libraries\Html\HtmlTag;
use App\Libraries\Authentication;
use Config\Services;

//[Services]-------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$numbers = service('numbers');
//[Models]---------------------------------------------------------------------------------------------------------------
$mproducts = model('App\Modules\Sie\Models\Sie_Products');
$mapplieds = model('App\Modules\Sie\Models\Sie_Applieds');
//[Requests]------------------------------------------------------------------------------------------------------------
$columns = $request->getGet("columns");
$offset = $request->getGet("offset");
$search = $request->getGet("search");
$draw = empty($request->getGet("draw")) ? 1 : $request->getGet("draw");
$limit = empty($request->getGet("limit")) ? 10 : $request->getGet("limit");
//[Query]---------------------------------------------------------------------------------------------------------------
$list = $mproducts->get_List($limit, $offset, $search);
$recordsTotal = $mproducts->get_Total($search);
//$sql=$mproducts->getLastQuery()->getQuery();
//[Asignations]---------------------------------------------------------------------------------------------------------
$data = array();
$component = '/sie/products';
foreach ($list as $item) {
    //[Buttons]---------------------------------------------------------------------------------------------------------
    $viewer = "{$component}/view/{$item["product"]}";
    $editor = "{$component}/edit/{$item["product"]}";
    $deleter = "{$component}/delete/{$item["product"]}";
    $lviewer = $bootstrap::get_Link('view', array('href' => $viewer, 'icon' => ICON_VIEW, 'text' => lang("App.View"), 'class' => 'btn-primary', 'target' => '_blank'));
    $leditor = $bootstrap::get_Link('edit', array('href' => $editor, 'icon' => ICON_EDIT, 'text' => lang("App.Edit"), 'class' => 'btn-secondary'));
    $ldeleter = $bootstrap::get_Link('delete', array('href' => $deleter, 'icon' => ICON_DELETE, 'text' => lang("App.Delete"), 'class' => 'btn-danger'));
    $options = $bootstrap::get_BtnGroup('options', array('content' => array($lviewer)));
    $applied = $mapplieds->where("product", $item["product"])->where("discount", $oid)->first();
    $span = HtmlTag::tag('span');
    $span->attr('class', 'slider round');
    $span->content(array());
    if (is_array($applied) && isset($applied["applied"])) {
        $input = HtmlTag::tag('input');
        $input->attr('name', 'applied');
        $input->attr('id', 'applied');
        $input->attr('class', 'checkbox success');
        $input->attr('type', 'checkbox');
        $input->attr('product', $item["product"]);
        $input->attr('checked', 'true');
        $input->attr('onchange', 'check_applied($(this).prop(\'checked\'),\'' . $item["product"] . '\')');
        $status = HtmlTag::tag('label');
        $status->attr('class', 'switch');
        $status->content(array($input, $span));
    } else {
        $input = HtmlTag::tag('input');
        $input->attr('name', 'applied');
        $input->attr('id', 'applied');
        $input->attr('class', 'checkbox success');
        $input->attr('type', 'checkbox');
        $input->attr('product', $item["product"]);
        $input->attr('onchange', 'check_applied($(this).prop(\'checked\'),\'' . $item["product"] . '\')');
        $status = HtmlTag::tag('label');
        $status->attr('class', 'switch');
        $status->content(array($input, $span));
    }
    //[Check]-----------------------------------------------------------------------------------------------------------
    $check = HtmlTag::tag('div');
    $check->attr('class', 'btn-group');
    $check->attr('role', 'group');
    $check->content(array($status));
    //[Fields]----------------------------------------------------------------------------------------------------------
    $row["check"] = $check->render();
    $row["product"] = $item["product"];
    $row["reference"] = $item["reference"];
    $row["name"] = $item["name"];
    $row["description"] = $strings->get_URLDecode($item["description"]);
    $row["status"] = $item["status"];
    $row["value"] = "$" . $numbers->to_Currency($item["value"]);
    $row["taxes"] = $item["taxes"];
    $row["type"] = $item["type"];
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

