<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-05-21 21:55:10
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Firewall\Views\Livetraffic\List\table.php]
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
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
/**
 * @var object $authentication Authentication service from the ModuleController.
 * @var object $bootstrap Instance of the Bootstrap class from the ModuleController.
 * @var string $component Complete URI to the requested component.
 * @var object $dates Date service from the ModuleController.
 * @var string $oid String representing the object received, usually an object/data to be viewed, transferred from the ModuleController.
 * @var object $parent Represents the ModuleController.
 * @var object $request Request service from the ModuleController.
 * @var object $strings String service from the ModuleController.
 * @var string $view String passed to the view defined in the viewer for evaluation.
 * @var string $viewer Complete URI to the view responsible for evaluating each requested view.
 * @var string $views Complete URI to the module views.
 **/
//[models]--------------------------------------------------------------------------------------------------------------
$mlivetraffic = model('App\Modules\Firewall\Models\Firewall_Livetraffic');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/firewall";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    //"traffic" => lang("App.traffic"),
    //"ip" => lang("App.ip"),
    //"useragent" => lang("App.useragent"),
    //"browser" => lang("App.browser"),
    //"browser_code" => lang("App.browser_code"),
    //"os" => lang("App.os"),
    //"os_code" => lang("App.os_code"),
    //"device_type" => lang("App.device_type"),
    //"country" => lang("App.country"),
    //"country_code" => lang("App.country_code"),
    //"request_uri" => lang("App.request_uri"),
    //"domain" => lang("App.domain"),
    //"referer" => lang("App.referer"),
    //"bot" => lang("App.bot"),
    //"date" => lang("App.date"),
    //"time" => lang("App.time"),
    //"uniquev" => lang("App.uniquev"),
    //"author" => lang("App.author"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array();
//$mlivetraffic->clear_AllCache();
$rows = $mlivetraffic->getCachedSearch($conditions, $limit, $offset, "traffic DESC");
$total = $mlivetraffic->getCountAllResults($conditions);
//echo(safe_dump($rows['sql']));
//[build]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center	align-middle"),
    //array("content" => lang("App.Traffic"), "class" => "text-center	align-middle"),
    array("content" => "IP", "class" => "text-center	align-middle"),
    array("content" => "UserAgent", "class" => "text-center	align-middle"),
    //array("content" => lang("App.browser"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.browser_code"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.os"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.os_code"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.device_type"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.country"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.country_code"), "class" => "text-center	align-middle"),
    //array("content" => "URI", "class" => "text-center	align-middle"),
    //array("content" => lang("App.domain"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.referer"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.bot"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Date"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Time"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.uniquev"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/firewall/livetraffic';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row["traffic"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["traffic"]}";
        $hrefEdit = "$component/edit/{$row["traffic"]}";
        $hrefDelete = "$component/delete/{$row["traffic"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-primary ml-1",));
        if ($row["bot"] == "1") {
            $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_BOT, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-danger ml-1",));
        }
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $details = "{$row['useragent']}<br>{$row['request_uri']}<br>{$row['domain']}<br>{$row['referer']}";
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                //array("content" => $row['traffic'], "class" => "text-left align-middle"),
                array("content" => $row['ip'], "class" => "text-left align-middle"),
                array("content" => $details, "class" => "text-left align-middle"),
                //array("content" => $row['browser'], "class" => "text-left align-middle"),
                //array("content" => $row['browser_code'], "class" => "text-left align-middle"),
                //array("content" => $row['os'], "class" => "text-left align-middle"),
                //array("content" => $row['os_code'], "class" => "text-left align-middle"),
                //array("content" => $row['device_type'], "class" => "text-left align-middle"),
                //array("content" => $row['country'], "class" => "text-left align-middle"),
                //array("content" => $row['country_code'], "class" => "text-left align-middle"),
                //array("content" => $row['request_uri'], "class" => "text-left align-middle"),
                //array("content" => $row['domain'], "class" => "text-left align-middle"),
                //array("content" => $row['referer'], "class" => "text-left align-middle"),
                //array("content" => $row['bot'], "class" => "text-left align-middle"),
                array("content" => $row['date'], "class" => "text-left align-middle"),
                array("content" => $row['time'], "class" => "text-left align-middle"),
                //array("content" => $row['uniquev'], "class" => "text-left align-middle"),
                //array("content" => $row['author'], "class" => "text-left align-middle"),
                //array("content" => $row['created_at'], "class" => "text-left align-middle"),
                //array("content" => $row['updated_at'], "class" => "text-left align-middle"),
                //array("content" => $row['deleted_at'], "class" => "text-left align-middle"),
                array("content" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("card-grid", array(
    "header-title" => lang('Firewall_Livetraffic.list-title'),
    "header-back" => $back,
    "header-add" => "/firewall/livetraffic/create/" . lpk(),
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Firewall_Livetraffic.list-title'), "message" => lang('Firewall_Livetraffic.list-description')),
    "content" => $bgrid,
));
echo($card);
?>
