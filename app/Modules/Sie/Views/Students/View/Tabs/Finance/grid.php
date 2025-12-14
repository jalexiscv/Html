<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-10-28 23:21:45
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Orders\List\table.php]
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
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
//[models]--------------------------------------------------------------------------------------------------------------
$morders = model('App\Modules\Sie\Models\Sie_Orders');
$mproducts = model('App\Modules\Sie\Models\Sie_Products');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mpayments = model('App\Modules\Sie\Models\Sie_Payments');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 100;
$fields = array(
    "order" => "Factura(Orden)",
    //"user" => lang("App.user"),
    "ticket" => lang("App.Ticket"),
    //"parent" => lang("App.parent"),
    //"period" => lang("App.period"),
    //"total" => lang("App.total"),
    //"paid" => lang("App.paid"),
    //"status" => lang("App.status"),
    //"author" => lang("App.author"),
    //"type" => lang("App.type"),
    //"date" => lang("App.date"),
    //"time" => lang("App.time"),
    //"expiration" => lang("App.expiration"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array("user" => $oid);
$morders->clear_AllCache();
$rows = $morders->get_CachedSearch($conditions, $limit, $offset, "date DESC");
$total = $morders->get_CountAllResults($conditions);
//echo(safe_dump($rows['sql']));
//echo(safe_dump($rows['data']));
$registration = $mregistrations->getRegistration($oid);
//[build]--------------------------------------------------------------------------------------------------------------
$tid = "grid-" . uniqid();
$bgrid = $bootstrap->get_Grid(array("id" => $tid));
$bgrid->set_Id($tid);
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center	align-middle"),
    //array("content" => lang("App.Order"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.user"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Ticket"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.parent"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Period"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Description"), "class" => "text-left	align-middle"),
    array("content" => lang("App.Total"), "class" => "text-center align-middle"),
    array("content" => lang("App.Paid"), "class" => "text-center	align-middle"),
    array("content" => "Saldo", "class" => "text-center	align-middle"),
    //array("content" => lang("App.status"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.type"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.date"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.time"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.expiration"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$bgrid->set_Buttons(
    array(
        //$bootstrap->get_Link("btn-bill", array("size" => "sm", "icon" => ICON_PLUS, "text" => "Facturar", "title" => lang("App.New"), "data-bs-toggle" => "modal", "data-bs-target" => "#invoiceModal")),
        $bootstrap->get_Link("btn-bill", array("size" => "sm", "icon" => ICON_PLUS, "text" => "Facturar", "title" => lang("App.New"), "href" => "/sie/orders/create/{$oid}", "target" => "_self")),
        //$bootstrap->get_Link("btn-secondary", array("size" => "sm", "icon" => ICON_BACK, "title" => lang("App.Back"), "href" => $back)),
    )
);
$component = '/sie/orders';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row['order'])) {
        $count++;
        //echo(safe_dump($row));
        $payment = $mpayments->where("ticket", $row['ticket'])->first();
        $paid = !empty($payment['value']) ? $payment['value'] : 0;
        $total = !empty($row['total']) ? $row['total'] : 0;
        $balance = $total - $paid;
        $lockeds = ($balance == 0) ? "disabled opacity-25" : "";
        $locked_credit = ($balance == 0 || !empty($row['parent'])) ? "disabled opacity-25" : "";
        $ctext = ($balance == 0) ? "text-success" : "text-danger";
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/print/{$row["order"]}?student={$oid}&origin=students-view";
        $hrefEdit = "$component/edit/{$row["order"]}?student={$oid}";
        $hrefDelete = "$component/delete/{$row["order"]}?student={$oid}";
        $hrefCredit = "/sie/orders/credit/{$row['order']}?student={$oid}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-sm btn-primary ml-1", "target" => "_self"));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-secondary ml-1",));
        $btnCredit = $bootstrap::get_Link('btn-credit', array("size" => "sm", 'icon' => ICON_CREDIT, 'title' => lang("App.Credit"), 'href' => $hrefCredit, 'class' => "btn-warning {$locked_credit}"));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-sm btn-danger ml-1 ",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnCredit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------


        $payment_payment = @$payment['payment'];
        if ($balance == 0) {
            if ($row['total'] <= "0") {
                $apaid = array("content" => "$ " . number_format($paid, 2, ',', '.'), "class" => "text-end align-middle {$ctext}");
            } else {
                $apaid = array("content" => "<a href=\"/sie/payments/view/{$payment_payment}\" target=\"_blank\">$ " . number_format($paid, 2, ',', '.') . "</a>", "class" => "text-end align-middle {$ctext}");
            }
        } else {
            $apaid = array("content" => "$ " . number_format($paid, 2, ',', '.'), "class" => "text-end align-middle {$ctext}");
        }

        $textbalance = "$ " . number_format($balance, 2, ',', '.');
        if ($row["status"] == "DEFERRED") {
            $apaid = array("content" => "<span class=\"badge rounded-pill bg-secondary\">Diferida</span>", "class" => "text-end align-middle {$ctext}");
            $textbalance = "";
        }

        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                //array("content" => $row['order'], "class" => "text-center align-middle"),
                //array("user" => $row['user'], "class" => "text-left align-middle"),
                array("content" => $row['ticket'], "class" => "text-center align-middle"),
                //array("parent" => $row['parent'], "class" => "text-left align-middle"),
                array("content" => $row['period'], "class" => "text-center align-middle"),
                array("content" => @$row['description'], "class" => "text-start align-middle"),
                array("content" => "$ " . number_format($row['total'], 2, ',', '.'), "class" => "text-end align-middle"),
                $apaid,
                array("content" => $textbalance, "class" => "text-end align-middle {$ctext}"),
                //array("status" => $row['status'], "class" => "text-left align-middle"),
                //array("author" => $row['author'], "class" => "text-left align-middle"),
                //array("type" => $row['type'], "class" => "text-left align-middle"),
                //array("date" => $row['date'], "class" => "text-left align-middle"),
                //array("time" => $row['time'], "class" => "text-left align-middle"),
                //array("expiration" => $row['expiration'], "class" => "text-left align-middle"),
                //array("created_at" => $row['created_at'], "class" => "text-left align-middle"),
                //array("updated_at" => $row['updated_at'], "class" => "text-left align-middle"),
                //array("deleted_at" => $row['deleted_at'], "class" => "text-left align-middle"),
                array("content" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}
//[build]---------------------------------------------------------------------------------------------------------------
echo($bgrid);
?>