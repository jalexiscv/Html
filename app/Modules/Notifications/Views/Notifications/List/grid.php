<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-11-06 00:10:19
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Notifications\Views\Notifications\List\table.php]
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
$mnotifications = model('App\Modules\Notifications\Models\Notifications_Notifications');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/notifications";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    //"notification" => lang("App.notification"),
    //"user" => lang("App.user"),
    //"recipient_email" => lang("App.recipient_email"),
    //"recipient_phone" => lang("App.recipient_phone"),
    //"type" => lang("App.type"),
    //"category" => lang("App.category"),
    //"priority" => lang("App.priority"),
    //"subject" => lang("App.subject"),
    //"message" => lang("App.message"),
    //"data" => lang("App.data"),
    //"is_read" => lang("App.is_read"),
    //"read_at" => lang("App.read_at"),
    //"email_sent" => lang("App.email_sent"),
    //"email_sent_at" => lang("App.email_sent_at"),
    //"email_error" => lang("App.email_error"),
    //"sms_sent" => lang("App.sms_sent"),
    //"sms_sent_at" => lang("App.sms_sent_at"),
    //"sms_error" => lang("App.sms_error"),
    //"action_url" => lang("App.action_url"),
    //"action_text" => lang("App.action_text"),
    //"expires_at" => lang("App.expires_at"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array();
//$mnotifications->clear_AllCache();
$rows = $mnotifications->getCachedSearch($conditions, $limit, $offset, "notification DESC");
$total = $mnotifications->getCountAllResults($conditions);
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
    //array("content" => lang("App.notification"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.user"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.recipient_email"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.recipient_phone"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.type"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.category"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.priority"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.subject"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.message"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.data"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.is_read"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.read_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.email_sent"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.email_sent_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.email_error"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.sms_sent"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.sms_sent_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.sms_error"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.action_url"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.action_text"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.expires_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/notifications/notifications';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row["notification"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["notification"]}";
        $hrefEdit = "$component/edit/{$row["notification"]}";
        $hrefDelete = "$component/delete/{$row["notification"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                //array("content" => $row['notification'], "class" => "text-left align-middle"),
                //array("content" => $row['user'], "class" => "text-left align-middle"),
                //array("content" => $row['recipient_email'], "class" => "text-left align-middle"),
                //array("content" => $row['recipient_phone'], "class" => "text-left align-middle"),
                //array("content" => $row['type'], "class" => "text-left align-middle"),
                //array("content" => $row['category'], "class" => "text-left align-middle"),
                //array("content" => $row['priority'], "class" => "text-left align-middle"),
                //array("content" => $row['subject'], "class" => "text-left align-middle"),
                //array("content" => $row['message'], "class" => "text-left align-middle"),
                //array("content" => $row['data'], "class" => "text-left align-middle"),
                //array("content" => $row['is_read'], "class" => "text-left align-middle"),
                //array("content" => $row['read_at'], "class" => "text-left align-middle"),
                //array("content" => $row['email_sent'], "class" => "text-left align-middle"),
                //array("content" => $row['email_sent_at'], "class" => "text-left align-middle"),
                //array("content" => $row['email_error'], "class" => "text-left align-middle"),
                //array("content" => $row['sms_sent'], "class" => "text-left align-middle"),
                //array("content" => $row['sms_sent_at'], "class" => "text-left align-middle"),
                //array("content" => $row['sms_error'], "class" => "text-left align-middle"),
                //array("content" => $row['action_url'], "class" => "text-left align-middle"),
                //array("content" => $row['action_text'], "class" => "text-left align-middle"),
                //array("content" => $row['expires_at'], "class" => "text-left align-middle"),
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
    "header-title" => lang('Notifications.list-title'),
    "header-back" => $back,
    "header-add" => "/notifications/notifications/create/" . lpk(),
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Notifications.list-title'), "message" => lang('Notifications.list-description')),
    "content" => $bgrid,
));
echo($card);
?>
