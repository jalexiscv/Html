<?php
/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Descuentos Automáticos
 * ---------------------------------------------------------------------------------------------------------------------
 * 1) Debo revisar si el usuario tiene descuentos automaticos
 * 2) Debo revisar cada uno evaluando su "type" si es por "Beca|SCHOLARSHIP" o "Descuento|FIXED"
 */
$discounteds = $mdiscounteds->where("object", $order['user'])->findAll();

$count = 0;
$discounts = [];
$exist_enrroled = false;
foreach ($discounteds as $discounted) {
    $count++;
    if (!empty($discounted['discount'])) {
        $discount = $mdiscounts->getDiscount($discounted['discount']);
        $concept = $discount['name'];
        $character = $discount['character'];
        $type = $discount['type'];
        $value = "0";
        if ($type == "ENROLLMENT") {
            //include("Automatics/scholarship.php");
        } elseif ($type == "FIXED") {
            //include("Automatics/fixed.php");
        }
    }
}
?>