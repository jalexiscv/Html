<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-06-22 13:47:13
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Cadastre\Views\Profiles\List\json.php]
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
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
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
//[Models]---------------------------------------------------------------------------------------------------------------
$model = model('App\Modules\Cadastre\Models\Cadastre_Profiles');
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
    ->like("profile", "%{$search}%")
    ->orLike("customer", "%{$search}%")
    ->groupEnd()
    ->orderBy("created_at", "DESC")
    ->findAll($limit, $offset);
if (!empty($search)) {
    $recordsTotal = $model
        ->where("deleted_at", NULL)
        ->groupStart()
        ->like("profile", "%{$search}%")
        ->orLike("customer", "%{$search}%")
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
$component = '/cadastre/profiles';
foreach ($list as $item) {
    //[Buttons]---------------------------------------------------------------------------------------------------------
    $viewer = "{$component}/view/{$item["profile"]}";
    $editor = "{$component}/edit/{$item["profile"]}";
    $deleter = "{$component}/delete/{$item["profile"]}";
    $lviewer = $bootstrap::get_Link('view', array('href' => $viewer, 'icon' => ICON_VIEW, 'text' => lang("App.View"), 'class' => 'btn-primary'));
    $leditor = $bootstrap::get_Link('edit', array('href' => $editor, 'icon' => ICON_EDIT, 'text' => lang("App.Edit"), 'class' => 'btn-secondary'));
    $ldeleter = $bootstrap::get_Link('delete', array('href' => $deleter, 'icon' => ICON_DELETE, 'text' => lang("App.Delete"), 'class' => 'btn-danger'));
    $options = $bootstrap::get_BtnGroup('options', array('content' => array($lviewer, $leditor, $ldeleter)));
    //[Fields]----------------------------------------------------------------------------------------------------------
    $row["profile"] = $item["profile"];
    $row["customer"] = $item["customer"];
    $row["registration"] = $item["registration"];
    $row["names"] = $item["names"];
    $row["address"] = $item["address"];
    $row["cycle"] = $item["cycle"];
    $row["stratum"] = $item["stratum"];
    $row["use_type"] = $item["use_type"];
    $row["consumption"] = $item["consumption"];
    $row["service"] = $item["service"];
    $row["neighborhood_description"] = $item["neighborhood_description"];
    $row["unit_id"] = $item["unit_id"];
    $row["phone"] = $item["phone"];
    $row["entry_date"] = $item["entry_date"];
    $row["reading_route"] = $item["reading_route"];
    $row["national_property_number"] = $item["national_property_number"];
    $row["rate"] = $item["rate"];
    $row["route_sequence"] = $item["route_sequence"];
    $row["diameter"] = $item["diameter"];
    $row["meter_number"] = $item["meter_number"];
    $row["historical"] = $item["historical"];
    $row["longitude"] = $item["longitude"];
    $row["latitude"] = $item["latitude"];
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



