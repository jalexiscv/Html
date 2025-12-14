<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Application\Views\Clients\List\json.php]
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
$model = model('App\Modules\Nexus\Models\Nexus_Clients');
$list = $model
    ->where("deleted_at", NULL)
    ->groupStart()
    ->like("client", "%{$search}%")
    ->orLike("name", "%{$search}%")
    ->groupEnd()
    ->orderBy("name", "ASC")
    ->findAll($limit, $offset);
if (!empty($search)) {
    $recordsTotal = $model
        ->where("deleted_at", NULL)
        ->groupStart()
        ->like("client", "%{$search}%")
        ->orLike("name", "%{$search}%")
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
$iview = HtmlTag::tag('i', array('class' => 'icon far fa-eye'), '');
$icreate = HtmlTag::tag('i', array('class' => 'icon far fa-sparkles'), '');
$ilist = HtmlTag::tag('i', array('class' => 'icon fas fa-list'));
$iedit = HtmlTag::tag('i', array('class' => 'icon far fa-edit'));
$idelete = HtmlTag::tag('i', array('class' => 'far fa-trash'));
$component = '/nexus/clients';
foreach ($list as $item) {
    //[Buttons]-----------------------------------------------------------------------------
    $viewer = "{$component}/view/{$item["client"]}";
    $editor = "{$component}/edit/{$item["client"]}/" . lpk();
    $deleter = "{$component}/delete/{$item["client"]}";
    $lviewer = $bootstrap::get_Link('view', array('href' => $viewer, 'icon' => ICON_VIEW, 'text' => lang("App.View"), 'class' => 'btn-primary'));
    $leditor = $bootstrap::get_Link('edit', array('href' => $editor, 'icon' => ICON_EDIT, 'text' => lang("App.Edit"), 'class' => 'btn-secondary'));
    $ldeleter = $bootstrap::get_Link('delete', array('href' => $deleter, 'icon' => ICON_DELETE, 'text' => lang("App.Delete"), 'class' => 'btn-danger'));
    $options = $bootstrap::get_BtnGroup('options', array("content" => array($lviewer, $leditor, $ldeleter)));
    //[Fields]-----------------------------------------------------------------------------
    $row["client"] = $item["client"];
    $row["name"] = $item["name"];
    $row["rut"] = $item["rut"];
    $row["vpn"] = $item["vpn"];
    $row["users"] = $item["users"];
    $row["domain"] = $item["domain"];
    $row["default_url"] = $item["default_url"];
    $row["db_host"] = $item["db_host"];
    $row["db_port"] = $item["db_port"];
    $row["db"] = $item["db"];
    $row["db_user"] = $item["db_user"];
    $row["db_password"] = $item["db_password"];
    $row["status"] = $item["status"];
    $row["logo"] = $item["logo"];
    $row["logo_portrait"] = $item["logo_portrait"];
    $row["logo_portrait_light"] = $item["logo_portrait_light"];
    $row["logo_landscape"] = $item["logo_landscape"];
    $row["logo_landscape_light"] = $item["logo_landscape_light"];
    $row["theme"] = $item["theme"];
    $row["theme_color"] = $item["theme_color"];
    $row["fb_app_id"] = $item["fb_app_id"];
    $row["fb_app_secret"] = $item["fb_app_secret"];
    $row["fb_page"] = $item["fb_page"];
    $row["footer"] = $item["footer"];
    $row["google_trackingid"] = $item["google_trackingid"];
    $row["google_ad_client"] = $item["google_ad_client"];
    $row["google_ad_display_square"] = $item["google_ad_display_square"];
    $row["google_ad_display_rectangle"] = $item["google_ad_display_rectangle"];
    $row["google_ad_links_retangle"] = $item["google_ad_links_retangle"];
    $row["google_ad_display_vertical"] = $item["google_ad_display_vertical"];
    $row["google_ad_infeed"] = $item["google_ad_infeed"];
    $row["google_ad_inarticle"] = $item["google_ad_inarticle"];
    $row["google_ad_matching_content"] = $item["google_ad_matching_content"];
    $row["google_ad_links_square"] = $item["google_ad_links_square"];
    $row["arc_id"] = $item["arc_id"];
    $row["matomo"] = $item["matomo"];
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