<?php
//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$dates = service('dates');
//[models]--------------------------------------------------------------------------------------------------------------
$morders = model('App\Modules\Sie\Models\Sie_Orders');
$mitems = model('App\Modules\Sie\Models\Sie_Orders_Items');
$mproducts = model('App\Modules\Sie\Models\Sie_Products');
$mdiscounteds = model('App\Modules\Sie\Models\Sie_Discounteds');
$mdiscounts = model('App\Modules\Sie\Models\Sie_Discounts');


//[vars]----------------------------------------------------------------------------------------------------------------
$data = $request->getJSON(true);
/**
 * const data = {
 * order: order,
 * user: user,
 * ticket: ticket,
 * parent: parent,
 * period: period,
 * date: date,
 * time: time,
 * expiration: expiration,
 * program: program,
 * description: description,
 * items:invoiceItems,
 * };
 **/
$order = $data['order'];
$user = $data['user'];
$ticket = $data['ticket'];
$parent = $data['parent'];
$period = $data['period'];
$cycle = $data['cycle'];
$moment = $data['moment'];
$date = $data['date'];
$time = $data['time'];
$expiration = $data['expiration'];
$program = $data['program'];
$description = $data['description'];
$neto = $data['neto'];
$items = $data['items'];
/**
 * "order"
 * "user"
 * "ticket"
 * "parent"
 * "period"
 * "total"
 * "paid"
 * "status"
 * "author"
 * "type"
 * "date"
 * "time"
 * "expiration"
 */
// Obtener el ticket más alto existente
$newTicket = $morders->getNextTicketNumber();

//[bill]----------------------------------------------------------------------------------------------------------------
$order = [
    'order' => pk(),
    'user' => $user,
    'program' => $program,
    'description' => $description,
    'ticket' => $newTicket,
    'total' => $neto,
    'period' => $period,
    "cycle" => $cycle,
    'moment' => $moment,
    'status' => 'pending',
    'date' => $dates->get_Date(),
    'expiration' => $expiration,
    'created_at' => $dates->get_Date(),
    'updated_at' => $dates->get_Date(),
    'deleted_at' => null,
];
$create_order = $morders->insert($order);
//[items]---------------------------------------------------------------------------------------------------------------
$products = array();
foreach ($items as $item) {
    $product = $mproducts->get_Product($item['product']);
    $amount = $item['quantity'];
    $value = $item['price'] * $amount;
    $description = $product["name"];
    if ($amount > 1) {
        $description .= " x" . $amount;
    }
    $dproduct = array(
        "item" => pk(),
        "order" => $order['order'],
        "product" => $product['product'],
        "type" => $product['type'],
        "value" => $value,
        "amount" => $amount,
        "description" => $description,
        "percentage" => $item['discount'],
        "author" => safe_get_user(),
    );
    $mitems->insert($dproduct);
    $products[] = $dproduct;
}
include("Create/Discounts/manuals.php");
//include("Create/Discounts/automatics.php");
//[build]---------------------------------------------------------------------------------------------------------------
$data = [
    'status' => true,
    'message' => 'Orden creada correctamente',
    'callback' => 'reload-bills',
    'data' => $data
];
echo(json_encode($data));
cache()->clean();
?>