<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Cadastre\Views\Resources\List\json.php]
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
$model = model('App\Modules\Cadastre\Models\Cadastre_Resources');
$list = $model
    ->where("deleted_at", NULL)
    ->groupStart()
    ->like("resource", "%{$search}%")
    ->orLike("title", "%{$search}%")
    ->groupEnd()
    ->orderBy("created_at", "DESC")
    ->findAll($limit, $offset);
if (!empty($search)) {
    $recordsTotal = $model
        ->where("deleted_at", NULL)
        ->groupStart()
        ->like("resource", "%{$search}%")
        ->orLike("title", "%{$search}%")
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
$component = '/cadastre/resources';
foreach ($list as $item) {
    //[Buttons]-----------------------------------------------------------------------------
    $viewer = "{$component}/view/{$item["resource"]}";
    $editor = "{$component}/edit/{$item["resource"]}";
    $deleter = "{$component}/delete/{$item["resource"]}";
    $lviewer = $bootstrap::get_Link('view', array('href' => $viewer, 'icon' => ICON_VIEW, 'text' => lang("App.View"), 'class' => 'btn-primary'));
    $leditor = $bootstrap::get_Link('edit', array('href' => $editor, 'icon' => ICON_EDIT, 'text' => lang("App.Edit"), 'class' => 'btn-secondary'));
    $ldeleter = $bootstrap::get_Link('delete', array('href' => $deleter, 'icon' => ICON_DELETE, 'text' => lang("App.Delete"), 'class' => 'btn-danger'));
    $options = $bootstrap::get_BtnGroup('options', array("content" => array($lviewer, $leditor, $ldeleter)));
    //[Fields]-----------------------------------------------------------------------------
    $title = $strings->get_URLDecode($item["title"]);
    $description = $strings->get_URLDecode($item["description"]);
    $content = "<p><b>{$title}</b>: {$description}</p>";

    $row["resource"] = $item["resource"];
    $row["title"] = $strings->get_URLDecode($item["title"]);

    if (!empty($item["file"])) {
        $row["cover"] = "<img src=\"/themes/assets/images/icons/posts-attachment.png\" class=\"\" width='100px'/>";
    } else {
        $row["cover"] = "<img src=\"/themes/assets/images/icons/posts-noattachment.png\" class=\"\" width='100px'/>";
    }

    if ($item["category"] == "URL") {
        if (!empty($item["url"])) {
            $row["cover"] = "<img src=\"/themes/assets/images/icons/posts-link.png\" class=\"\" width='100px'/>";
        } else {
            $row["cover"] = "<img src=\"/themes/assets/images/icons/posts-nolink.png\" class=\"\" width='100px'/>";
        }
    } elseif ($item["category"] == "YOUTUBE") {
        if (!empty($item["url"])) {
            $row["cover"] = "<img src=\"/themes/assets/images/icons/posts-youtube.png\" class=\"\" width='100px'/>";
        } else {
            $row["cover"] = "<img src=\"/themes/assets/images/icons/posts-nolink.png\" class=\"\" width='100px'/>";
        }
    } elseif ($item["category"] == "VIMEO") {
        if (!empty($item["url"])) {
            $row["cover"] = "<img src=\"/themes/assets/images/icons/posts-vimeo.png\" class=\"\" width='100px'/>";
        } else {
            $row["cover"] = "<img src=\"/themes/assets/images/icons/posts-nolink.png\" class=\"\" width='100px'/>";
        }
    }


    $row["description"] = $content;
    $row["authors"] = $item["authors"];
    $row["use"] = $item["use"];
    $row["category"] = $item["category"];
    $row["level"] = $item["level"];
    $row["objective"] = $item["objective"];
    $row["program"] = $item["program"];
    $row["type"] = $item["type"];
    $row["format"] = $item["format"];
    $row["language"] = $item["language"];
    $row["file"] = $item["file"];
    $row["url"] = $item["url"];
    $row["keywords"] = $item["keywords"];
    $row["author"] = $item["author"];
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



