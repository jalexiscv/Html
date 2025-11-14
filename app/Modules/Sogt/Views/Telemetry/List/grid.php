<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-08-26 00:44:27
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sogt\Views\Telemetry\List\table.php]
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
$mtelemetry = model('App\Modules\Sogt\Models\Sogt_Telemetry');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sogt";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    "telemetry" => lang("App.telemetry"),
    "device" => lang("App.device"),
    "user" => lang("App.user"),
    "latitude" => lang("App.latitude"),
    "longitude" => lang("App.longitude"),
    "altitude" => lang("App.altitude"),
    "speed" => lang("App.speed"),
    "heading" => lang("App.heading"),
    //"gps_valid" => lang("App.gps_valid"),
    //"satellites" => lang("App.satellites"),
    //"network" => lang("App.network"),
    //"battery" => lang("App.battery"),
    //"ignition" => lang("App.ignition"),
    //"event" => lang("App.event"),
    //"motion" => lang("App.motion"),
    //"timestamp" => lang("App.timestamp"),
    //"author" => lang("App.author"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array();
//$mtelemetry->clear_AllCache();
$rows = $mtelemetry->getCachedSearch($conditions, $limit, $offset, "telemetry DESC");
$total = $mtelemetry->getCountAllResults($conditions);
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
    array("content" => lang("Sogt.Telemetry"), "class" => "text-center	align-middle"),
    array("content" => lang("Sogt.Device"), "class" => "text-center	align-middle"),
    array("content" => lang("Sogt.User"), "class" => "text-center	align-middle"),
    array("content" => lang("Sogt.Latitude"), "class" => "text-center	align-middle"),
    array("content" => lang("Sogt.Longitude"), "class" => "text-center	align-middle"),
    array("content" => lang("Sogt.Altitude"), "class" => "text-center	align-middle"),
    array("content" => lang("Sogt.Speed"), "class" => "text-center	align-middle"),
    array("content" => lang("Sogt.Heading"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.gps_valid"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.satellites"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.network"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.battery"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.ignition"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.event"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.motion"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.timestamp"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sogt/telemetry';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row["telemetry"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["telemetry"]}";
        $hrefEdit = "$component/edit/{$row["telemetry"]}";
        $hrefDelete = "$component/delete/{$row["telemetry"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $row['telemetry'], "class" => "text-left align-middle"),
                array("content" => $row['device'], "class" => "text-left align-middle"),
                array("content" => $row['user'], "class" => "text-left align-middle"),
                array("content" => $row['latitude'], "class" => "text-left align-middle"),
                array("content" => $row['longitude'], "class" => "text-left align-middle"),
                array("content" => $row['altitude'], "class" => "text-left align-middle"),
                array("content" => $row['speed'], "class" => "text-left align-middle"),
                array("content" => $row['heading'], "class" => "text-left align-middle"),
                //array("content" => $row['gps_valid'], "class" => "text-left align-middle"),
                //array("content" => $row['satellites'], "class" => "text-left align-middle"),
                //array("content" => $row['network'], "class" => "text-left align-middle"),
                //array("content" => $row['battery'], "class" => "text-left align-middle"),
                //array("content" => $row['ignition'], "class" => "text-left align-middle"),
                //array("content" => $row['event'], "class" => "text-left align-middle"),
                //array("content" => $row['motion'], "class" => "text-left align-middle"),
                //array("content" => $row['timestamp'], "class" => "text-left align-middle"),
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
    "header-title" => lang('Telemetry.list-title'),
    "header-back" => $back,
    "header-add" => "/sogt/telemetry/create/" . lpk(),
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Telemetry.list-title'), "message" => lang('Telemetry.list-description')),
    "content" => $bgrid,
));
echo($card);
?>
