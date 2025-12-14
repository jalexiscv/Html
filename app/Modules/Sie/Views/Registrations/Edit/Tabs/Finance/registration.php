<?php
/** @var $oid string Es el código de la matricula o estudiante */
$dates = service("dates");
$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$morders = model("App\Modules\Sie\Models\Sie_Orders");
$mitems = model("App\Modules\Sie\Models\Sie_Orders_Items");
//[registro]------------------------------------------------------------------------------------------------------------
$registration = $mregistrations->getRegistration($oid);
$registration_ticket = $registration['ticket'];
$registration_order = $morders->get_OrderByTicket($registration_ticket);
//echo("TICKET: " . $registration_ticket . "<br>");
if (!$registration_order) {
    //echo("NO EXISTE ORDEN PARA EL TICKET: " . $registration_ticket . "<br>");
    $total = "";
    $paid = "";
    $pkorder = pk();
    $order = array(
        "order" => $pkorder,
        "user" => $registration['registration'],
        "ticket" => $registration['ticket'],
        "parent" => "",
        "period" => @$registration['period'],
        "total" => $total,
        "paid" => $paid,
        "status" => "NORMAL",
        "author" => safe_get_user(),
        "type" => "NORMAL",
        "date" => safe_get_date(),
        "time" => safe_get_time(),
        "expiration" => $dates->addDaysExact(safe_get_date(), 30)
    );
    //$morders->insert($order);
    // Debo insertar los items
    $d = array(
        "item" => pk(),
        "order" => $pkorder,
        "type" => "UNIT_PRICE",
        "value" => "91000,00",
        "amount" => "1",
        "description" => "Inscripción de Estudiantes (6657A680B1616)",
        "percentage" => "0",
        "author" => safe_get_user(),
    );
    //$create = $mitems->insert($d);
    //Actualizo el valor de la orden
    //$morders->update($pkorder, array("total" => "91000,00"));
    //$morders->update($pkorder, array("paid" => "0,00"));
}
?>