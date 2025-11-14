<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-08-26 00:44:16
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sogt\Views\Devices\List\table.php]
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
$mdevices = model('App\Modules\Sogt\Models\Sogt_Devices');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sogt";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    //"device" => lang("App.device"),
    //"user" => lang("App.user"),
    //"tenant" => lang("App.tenant"),
    //"name" => lang("App.name"),
    //"alias" => lang("App.alias"),
    //"device_type" => lang("App.device_type"),
    //"asset_type" => lang("App.asset_type"),
    //"asset_ref" => lang("App.asset_ref"),
    //"imei" => lang("App.imei"),
    //"serial" => lang("App.serial"),
    //"iccid" => lang("App.iccid"),
    //"imsi" => lang("App.imsi"),
    //"mac_address" => lang("App.mac_address"),
    //"vendor" => lang("App.vendor"),
    //"model" => lang("App.model"),
    //"firmware_version" => lang("App.firmware_version"),
    //"protocol" => lang("App.protocol"),
    //"transport" => lang("App.transport"),
    //"server_host" => lang("App.server_host"),
    //"server_port" => lang("App.server_port"),
    //"apn" => lang("App.apn"),
    //"carrier" => lang("App.carrier"),
    //"sim_phone" => lang("App.sim_phone"),
    //"auth_key" => lang("App.auth_key"),
    //"ip_whitelist" => lang("App.ip_whitelist"),
    //"has_ignition" => lang("App.has_ignition"),
    //"has_sos" => lang("App.has_sos"),
    //"has_temp" => lang("App.has_temp"),
    //"has_fuel" => lang("App.has_fuel"),
    //"supports_ble" => lang("App.supports_ble"),
    //"report_interval_moving_s" => lang("App.report_interval_moving_s"),
    //"report_interval_idle_s" => lang("App.report_interval_idle_s"),
    //"overspeed_kmh" => lang("App.overspeed_kmh"),
    //"timezone_offset_min" => lang("App.timezone_offset_min"),
    //"status" => lang("App.status"),
    //"activation_date" => lang("App.activation_date"),
    //"installed_on" => lang("App.installed_on"),
    //"installed_by" => lang("App.installed_by"),
    //"warranty_until" => lang("App.warranty_until"),
    //"tags" => lang("App.tags"),
    //"notes" => lang("App.notes"),
    //"author" => lang("App.author"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array();
//$mdevices->clear_AllCache();
$rows = $mdevices->getCachedSearch($conditions, $limit, $offset, "device DESC");
$total = $mdevices->getCountAllResults($conditions);
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
    //array("content" => lang("App.device"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.user"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.tenant"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.name"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.alias"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.device_type"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.asset_type"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.asset_ref"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.imei"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.serial"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.iccid"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.imsi"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.mac_address"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.vendor"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.model"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.firmware_version"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.protocol"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.transport"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.server_host"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.server_port"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.apn"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.carrier"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.sim_phone"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.auth_key"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.ip_whitelist"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.has_ignition"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.has_sos"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.has_temp"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.has_fuel"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.supports_ble"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.report_interval_moving_s"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.report_interval_idle_s"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.overspeed_kmh"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.timezone_offset_min"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.status"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.activation_date"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.installed_on"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.installed_by"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.warranty_until"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.tags"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.notes"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sogt/devices';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row["device"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["device"]}";
        $hrefEdit = "$component/edit/{$row["device"]}";
        $hrefDelete = "$component/delete/{$row["device"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                //array("content" => $row['device'], "class" => "text-left align-middle"),
                //array("content" => $row['user'], "class" => "text-left align-middle"),
                //array("content" => $row['tenant'], "class" => "text-left align-middle"),
                //array("content" => $row['name'], "class" => "text-left align-middle"),
                //array("content" => $row['alias'], "class" => "text-left align-middle"),
                //array("content" => $row['device_type'], "class" => "text-left align-middle"),
                //array("content" => $row['asset_type'], "class" => "text-left align-middle"),
                //array("content" => $row['asset_ref'], "class" => "text-left align-middle"),
                //array("content" => $row['imei'], "class" => "text-left align-middle"),
                //array("content" => $row['serial'], "class" => "text-left align-middle"),
                //array("content" => $row['iccid'], "class" => "text-left align-middle"),
                //array("content" => $row['imsi'], "class" => "text-left align-middle"),
                //array("content" => $row['mac_address'], "class" => "text-left align-middle"),
                //array("content" => $row['vendor'], "class" => "text-left align-middle"),
                //array("content" => $row['model'], "class" => "text-left align-middle"),
                //array("content" => $row['firmware_version'], "class" => "text-left align-middle"),
                //array("content" => $row['protocol'], "class" => "text-left align-middle"),
                //array("content" => $row['transport'], "class" => "text-left align-middle"),
                //array("content" => $row['server_host'], "class" => "text-left align-middle"),
                //array("content" => $row['server_port'], "class" => "text-left align-middle"),
                //array("content" => $row['apn'], "class" => "text-left align-middle"),
                //array("content" => $row['carrier'], "class" => "text-left align-middle"),
                //array("content" => $row['sim_phone'], "class" => "text-left align-middle"),
                //array("content" => $row['auth_key'], "class" => "text-left align-middle"),
                //array("content" => $row['ip_whitelist'], "class" => "text-left align-middle"),
                //array("content" => $row['has_ignition'], "class" => "text-left align-middle"),
                //array("content" => $row['has_sos'], "class" => "text-left align-middle"),
                //array("content" => $row['has_temp'], "class" => "text-left align-middle"),
                //array("content" => $row['has_fuel'], "class" => "text-left align-middle"),
                //array("content" => $row['supports_ble'], "class" => "text-left align-middle"),
                //array("content" => $row['report_interval_moving_s'], "class" => "text-left align-middle"),
                //array("content" => $row['report_interval_idle_s'], "class" => "text-left align-middle"),
                //array("content" => $row['overspeed_kmh'], "class" => "text-left align-middle"),
                //array("content" => $row['timezone_offset_min'], "class" => "text-left align-middle"),
                //array("content" => $row['status'], "class" => "text-left align-middle"),
                //array("content" => $row['activation_date'], "class" => "text-left align-middle"),
                //array("content" => $row['installed_on'], "class" => "text-left align-middle"),
                //array("content" => $row['installed_by'], "class" => "text-left align-middle"),
                //array("content" => $row['warranty_until'], "class" => "text-left align-middle"),
                //array("content" => $row['tags'], "class" => "text-left align-middle"),
                //array("content" => $row['notes'], "class" => "text-left align-middle"),
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
    "header-title" => lang('Devices.list-title'),
    "header-back" => $back,
    "header-add" => "/sogt/devices/create/" . lpk(),
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Devices.list-title'), "message" => lang('Devices.list-description')),
    "content" => $bgrid,
));
echo($card);
?>
