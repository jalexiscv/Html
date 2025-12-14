<?php
/** @var $oid string Es el código de la matricula o estudiante */
$dates = service("dates");
$bootstrap = service("bootstrap");
$numbers = service("numbers");
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$morders = model("App\Modules\Sie\Models\Sie_Orders");
//[orders]--------------------------------------------------------------------------------------------------------------
$orders = $morders->get_ListByRegistration($oid);
$c = "<table class=\"table table-bordered\">\n";
$c .= "<tr class=\"text-center\">\n";
$c .= "<td class=\"text-center\">Orden</td>\n";
$c .= "<td class=\"text-center\">Ticket</td>\n";
$c .= "<td class=\"text-center\">Fecha</td>\n";
$c .= "<td class=\"text-center\">Periodo</td>\n";
$c .= "<td class=\"text-center\">Total</td>\n";
$c .= "<td class=\"text-center\">Pagado</td>\n";
$c .= "<td class=\"text-center\">Pendiente</td>\n";
$c .= "<td class=\"text-center\">Estado</td>\n";
$c .= "<td class=\"text-center\">Opciones</td>\n";
$c .= "</tr>\n";
foreach ($orders as $order) {
    $total = $numbers->to_Currency($order["total"], "COP");
    $paid = $numbers->to_Currency($order["paid"], "COP");
    $pending = $numbers->to_Currency($order["total"] - $order["paid"], "COP");
    $options = "";
    $viewer = "/sie/orders/print/{$order['order']}?origin=registrations";
    $credit = "/sie/orders/credit/{$order['order']}?origin=registrations";
    $deleter = "/sie/orders/delete/{$order['order']}?origin=registrations";
    $lviewer = $bootstrap::get_Link('view', array('href' => $viewer, 'icon' => ICON_PRINT, 'text' => lang("App.View"), 'class' => 'btn-secondary', 'target' => '_blank'));
    $lcredit = $bootstrap::get_Link('credit', array('href' => $credit, 'icon' => ICON_CREDIT, 'text' => lang("App.Credit"), 'class' => 'btn-warning'));
    $ldeleter = $bootstrap::get_Link('delete', array('href' => $deleter, 'icon' => ICON_DELETE, 'text' => lang("App.Delete"), 'class' => 'btn-danger'));
    if ($order["status"] == "CREDIT") {
        $options = $bootstrap::get_BtnGroup('options', array('content' => array($lviewer, $lcredit, $ldeleter)));
    } else {
        $options = $bootstrap::get_BtnGroup('options', array('content' => array($lcredit, $ldeleter)));
    }


    $c .= "<tr>";
    $c .= "<td class=\"text-center align-middle\">{$order["order"]}</td>";
    if ($order["parent"] > 0) {
        //$c .= "<td class=\"text-center align-middle\"> + <a href=\"/sie/registrations/billing/{$oid}\" target=\"_blank\">{$order["ticket"]}</a></td>";
    } else {
        //$c .= "<td class=\"text-center align-middle\"><a href=\"/sie/registrations/billing/{$oid}\" target=\"_blank\">{$order["ticket"]}</a></td>";
    }
    $c .= "<td class=\"text-center align-middle\">{$order["ticket"]}</td>";
    ///sie/enrollments/billing/668D44610C9B1
    $c .= "<td class=\"text-center align-middle\">{$order["date"]}</td>";
    $c .= "<td class=\"text-center align-middle\">{$order["period"]}</td>";
    $c .= "<td class=\"align-middle text-end\">$ {$total}</td>";
    $c .= "<td class=\"align-middle text-end\">$ {$paid}</td>";
    $c .= "<td class=\"align-middle text-end\">$ {$pending}</td>";
    $c .= "<td class=\"text-center align-middle\">{$order["status"]}</td>";
    $c .= "<td class=\"text-end align-middle\">{$options}</td>";
    $c .= "</tr>";
}
$c .= "</table>";
echo($c);
?>