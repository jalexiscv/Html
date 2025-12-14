<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Physicals\List\json.php]
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

//[Uses]-----------------------------------------------------------------------------
use App\Libraries\Html\HtmlTag;
use App\Libraries\Authentication;
use Config\Services;

//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Request]-----------------------------------------------------------------------------
$columns = $request->getGet("columns");
$offset = $request->getGet("offset");
$search = $request->getGet("search");
//[Query]-----------------------------------------------------------------------------
$draw = empty($request->getGet("draw")) ? 1 : $request->getGet("draw");
$limit = empty($request->getGet("limit")) ? 10 : $request->getGet("limit");
$model = model('App\Modules\C4isr\Models\C4isr_Physicals');
$list = $model
    ->where("deleted_at", NULL)
    ->groupStart()
    ->like("physical", "%{$search}%")
    ->orLike("profile", "%{$search}%")
    ->groupEnd()
    ->orderBy("created_at", "DESC")
    ->findAll($limit, $offset);
if (!empty($search)) {
    $recordsTotal = $model
        ->where("deleted_at", NULL)
        ->groupStart()
        ->like("physical", "%{$search}%")
        ->orLike("profile", "%{$search}%")
        ->groupEnd()
        ->countAllResults();
} else {
    $recordsTotal = $model
        ->where("deleted_at", NULL)
        ->countAllResults();
}
//$sql=$model->getLastQuery()->getQuery();
//[Asignations]-----------------------------------------------------------------------------
$data = array();
$component = '/c4isr/physicals';
foreach ($list as $item) {
    //[Buttons]-----------------------------------------------------------------------------
    $viewer = "{$component}/view/{$item["physical"]}";
    $editor = "{$component}/edit/{$item["physical"]}";
    $deleter = "{$component}/delete/{$item["physical"]}";
    $lviewer = $bootstrap::get_Link('view', array('href' => $viewer, 'icon' => ICON_VIEW, 'text' => lang("App.View"), 'class' => 'btn-primary'));
    $leditor = $bootstrap::get_Link('edit', array('href' => $editor, 'icon' => ICON_EDIT, 'text' => lang("App.Edit"), 'class' => 'btn-secondary'));
    $ldeleter = $bootstrap::get_Link('delete', array('href' => $deleter, 'icon' => ICON_DELETE, 'text' => lang("App.Delete"), 'class' => 'btn-danger'));
    $options = $bootstrap::get_BtnGroup('options', array("content" => array($lviewer, $leditor, $ldeleter)));
    //[Fields]-----------------------------------------------------------------------------
    $row["physical"] = $item["physical"];
    $row["profile"] = $item["profile"];
    $row["height"] = $item["height"];
    $row["weight"] = $item["weight"];
    $row["skin_color"] = $item["skin_color"];
    $row["eye_color"] = $item["eye_color"];
    $row["eye_shape"] = $item["eye_shape"];
    $row["eye_size"] = $item["eye_size"];
    $row["hair_color"] = $item["hair_color"];
    $row["hair_type"] = $item["hair_type"];
    $row["hair_length"] = $item["hair_length"];
    $row["face_shape"] = $item["face_shape"];
    $row["nose_size_shape"] = $item["nose_size_shape"];
    $row["ear_size_shape"] = $item["ear_size_shape"];
    $row["lip_size_shape"] = $item["lip_size_shape"];
    $row["chin_size_shape"] = $item["chin_size_shape"];
    $row["facial_hair_presence_type"] = $item["facial_hair_presence_type"];
    $row["eyebrow_presence_type"] = $item["eyebrow_presence_type"];
    $row["moles_freckles_birthmarks_presence_location"] = $item["moles_freckles_birthmarks_presence_location"];
    $row["scars_presence_location"] = $item["scars_presence_location"];
    $row["tattoos_presence_location"] = $item["tattoos_presence_location"];
    $row["piercings_presence_location"] = $item["piercings_presence_location"];
    $row["interpupillary_distance"] = $item["interpupillary_distance"];
    $row["eyes_forehead_distance"] = $item["eyes_forehead_distance"];
    $row["nose_mouth_distance"] = $item["nose_mouth_distance"];
    $row["shoulder_width"] = $item["shoulder_width"];
    $row["arm_length"] = $item["arm_length"];
    $row["hand_size_shape"] = $item["hand_size_shape"];
    $row["finger_size_shape"] = $item["finger_size_shape"];
    $row["nail_size_shape"] = $item["nail_size_shape"];
    $row["leg_length"] = $item["leg_length"];
    $row["foot_size_shape"] = $item["foot_size_shape"];
    $row["author"] = $item["author"];
    $row["created_at"] = $item["created_at"];
    $row["updated_at"] = $item["updated_at"];
    $row["deleted_at"] = $item["deleted_at"];
    $row["options"] = $options;
    //[Push]-----------------------------------------------------------------------------
    array_push($data, $row);
}
//[Build]-----------------------------------------------------------------------------
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



