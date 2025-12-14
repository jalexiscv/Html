<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-12-10 23:14:22
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Payments\List\table.php]
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

$numbers = service('numbers');
//[models]--------------------------------------------------------------------------------------------------------------
$mpayments = model('App\Modules\Sie\Models\Sie_Payments');
$mregistration = model('App\Modules\Sie\Models\Sie_Registrations');
$morders = model('App\Modules\Sie\Models\Sie_Orders');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 100;
$fields = array(
    "general" => "General",
    //"record_type" => lang("App.record_type"),
    //"agreement" => lang("App.agreement"),
    //"id_number" => lang("App.id_number"),
    "ticket" => lang("App.Ticket"),
    //"value" => lang("App.value"),
    //"payment_origin" => lang("App.payment_origin"),
    //"payment_methods" => lang("App.payment_methods"),
    //"operation_number" => lang("App.operation_number"),
    //"authorization" => lang("App.authorization"),
    //"financial_entity" => lang("App.financial_entity"),
    //"branch" => lang("App.branch"),
    //"sequence" => lang("App.sequence"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),

);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array();
if (!empty($search)) {
    $conditions["search"] = $search;
}
//$mpayments->clear_AllCache();
$rows = $mpayments->getSearch($conditions, $limit, $offset, "payment DESC");
$total = $rows["total"];
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
    //array("content" => lang("App.Payment"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.record_type"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.agreement"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.id_number"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Ticket"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Details"), "class" => "text-left	align-middle"),
    array("content" => lang("App.Value"), "class" => "text-right	align-middle"),

    //array("content" => lang("App.value"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.payment_origin"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.payment_methods"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.operation_number"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.authorization"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.financial_entity"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.branch"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.sequence"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Date"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sie/payments';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row["payment"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["payment"]}";
        $hrefEdit = "$component/edit/{$row["payment"]}";
        $hrefDelete = "$component/delete/{$row["payment"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-sm btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-sm btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-sm btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[fields]------------------------------------------------------------------------------------------------------
        $order = $morders->get_OrderByTicket($row["ticket"]);
        $registration = $mregistration->getRegistration(@$order["user"]);
        $client_name = @$registration["first_name"] . " " . @$registration["second_name"] . " " . @$registration["first_surname"] . " " . @$registration["second_surname"];
        $details = "";
        $details .= "<strong>Cliente</strong>: <a href=\"/sie/students/view/" . @$registration["registration"] . "\" target=\"_blank\">{$client_name}</a><br>";
        $details .= "<strong>Identificación</strong>: " . @$registration["identification_type"] . "" . @$registration["identification_number"] . "<br>";
        $details .= "<strong>Pago</strong>: {$row['payment']} | <strong>Orden</strong>: " . @$order["order"] . "<br>";

        $value = "$ " . $numbers->get_NumberFormat($row["value"]);
        $cticket = "<a href=\"/sie/orders/print/" . @$order["order"] . "\" target=\"_blank\">" . @$row["ticket"] . "</a>";
        //[etc]---------------------------------------------------------------------------------------------------------
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                //array("content" => $row['payment'], "class" => "text-center align-middle"),
                //array("content" => $row['record_type'], "class" => "text-left align-middle"),
                //array("content" => $row['agreement'], "class" => "text-left align-middle"),
                //array("content" => $row['id_number'], "class" => "text-left align-middle"),
                array("content" => $cticket, "class" => "text-center align-middle"),
                array("content" => $details, "class" => "text-left align-middle"),
                array("content" => $value, "class" => "text-end align-middle"),
                //array("content" => $row['payment_origin'], "class" => "text-left align-middle"),
                //array("content" => $row['payment_methods'], "class" => "text-left align-middle"),
                //array("content" => $row['operation_number'], "class" => "text-left align-middle"),
                //array("content" => $row['authorization'], "class" => "text-left align-middle"),
                //array("content" => $row['financial_entity'], "class" => "text-left align-middle"),
                //array("content" => $row['branch'], "class" => "text-left align-middle"),
                //array("content" => $row['sequence'], "class" => "text-left align-middle"),
                array("content" => $row['created_at'], "class" => "text-center align-middle"),
                //array("content" => $row['updated_at'], "class" => "text-left align-middle"),
                //array("content" => $row['deleted_at'], "class" => "text-left align-middle"),
                array("content" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-grid", array(
    "title" => lang('Sie_Payments.list-title'),
    "header-back" => $back,
    "header-add" => "/sie/payments/create/" . lpk(),
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Sie_Payments.list-title'), "message" => lang('Sie_Payments.list-message')),
    "content" => $bgrid,
));
echo($card);
?>