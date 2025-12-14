<?php

//[request]--------------------------------------------------------------------------------------------------------------
$dates = service('dates');
//[models]--------------------------------------------------------------------------------------------------------------
$morders = model('App\Modules\Sie\Models\Sie_Orders');
$mitems = model('App\Modules\Sie\Models\Sie_Orders_Items');
$mproducts = model('App\Modules\Sie\Models\Sie_Products');
$mdiscounteds = model('App\Modules\Sie\Models\Sie_Discounteds');
$mdiscounts = model('Modules\Sie\Models\Sie_Discounts');

/** @var string $registration */
/** @var string $facture */
/** @var string $program */
/** @var array $data */
/** @var array $period */

//Array ( [order] => 672360BDA48BC [date] => 2024-10-31 [registration] => 66ABD712770F1 [total] => $ 1.583.400,00 [items] => Array ( [0] => Array ( [code] => 6657A60B770A5 [description] => Seguro Estudiantil [quantity] => 1 [price] => 23400 [subtotal] => 23400 ) [1] => Array ( [code] => 6630B1EB4307E [description] => Matrícula Nivel Tecnológico [quantity] => 1 [price] => 1560000 [subtotal] => 1560000 ) ) )
$order = $facture;
$date = $dates->get_Date();
$registration = $registration;
$total = "91000";
$description = "Preinscripción {$period}";
$program = $program;
$period = $period;

$items = array(
    array(
        'code' => '6657A680B1616',
        'description' => 'Inscripción de Estudiantes',
        'quantity' => 1,
        'price' => 91000,
        'subtotal' => 91000
    ),
);

// Eliminar el símbolo de moneda y los separadores de miles
$total = str_replace(['$', '.', ' '], '', $total);
// Reemplazar la coma decimal por un punto
$total = str_replace(',', '.', $total);
// Convertir a número flotante
$total = (float)$total;
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
$nextTicket = $morders->getNextTicketNumber();
//[bill]----------------------------------------------------------------------------------------------------------------
$order = [
    'order' => $order,
    'user' => $registration,
    'program' => $program,
    'description' => $description,
    'ticket' => $nextTicket,
    'total' => $total,
    'period' => $period,
    'status' => 'pending',
    'date' => $dates->get_Date(),
    'expiration' => sie_get_setting("R-E-D"),
];
//[items]---------------------------------------------------------------------------------------------------------------
$create_order = $morders->insert($order);
// Create items
$products = array();
foreach ($items as $item) {
    $product = $mproducts->get_Product($item['code']);
    $dproduct = array(
        "item" => pk(),
        "order" => $order['order'],
        "product" => $product['product'],
        "type" => $product['type'],
        "value" => $product['value'],
        "amount" => $item['quantity'],
        "description" => $product['name'],
        //"description" => $product['name']." - {$product['type']}",
        "percentage" => "0",
        "author" => safe_get_user(),
    );
    $mitems->insert($dproduct);
    $products[] = $dproduct;
}
//[discounts]-----------------------------------------------------------------------------------------------------------
$discounteds = $mdiscounteds->where("object", $registration)->findAll();
$discounts = [];
foreach ($discounteds as $discounted) {
    $discount = $mdiscounts->getDiscount($discounted['discount']);
    $concept = $discount['name'];
    $type = $discount['type'];
    $character = $discount['character'];
    $value = "0";

    if ($character == "PERCENTAGE") {
        foreach ($products as $product) {
            if ($product['type'] == "ENROLLMENT") {
                $discount_percentage = $discount['value'] / 100;
                $value += $product['value'] * $discount_percentage;
            }
        }
    } else {
        $value = $discount['value'];
    }

    $dproduct = array(
        "item" => pk(),
        "order" => $order['order'],
        "product" => $discounted['discount'],
        "type" => $type,
        "value" => $value * -1,
        "amount" => "1",
        "description" => $discount['name'],
        //"description" => $discount['name']." - {$character}",
        "percentage" => "0",
        "author" => safe_get_user(),
    );
    $mitems->insert($dproduct);
    $discounts[] = $dproduct;
}

$total_products = 0;
foreach ($products as $product) {
    $total_products += $product['value'];
}
$total_discounts = 0;
foreach ($discounts as $discount) {
    $total_discounts += $discount['value'];
}

$total = $total_products + $total_discounts;
$update_order = $morders->update($order['order'], ['total' => $total]);
//[build]---------------------------------------------------------------------------------------------------------------
?>