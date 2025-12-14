<?php
//[discounts]-----------------------------------------------------------------------------------------------------------
// Analiza y registra los descuentos manuales
// todos excepto los asociados a metriculas

$discounts = array();
foreach ($items as $item) {
    $product = $mproducts->get_Product($item['product']);
    if ($item['discount'] > 0) {
        $textual_percentage = $item['discount'] . "%";
        $amount = $item['quantity'];
        $value = $item['price'] * $amount;
        $discount = ($value * ($item['discount'] / 100));
        $name = substr($item['name'], 14, strlen($item['name']));
        $description = "Descuento: {$textual_percentage} " . $name;
        if ($amount > 1) {
            $description = $description . " x" . $amount;
        }

        if ($item['type'] == "ENROLLMENT") {
            // Analiza los descuentos y si tiene descuentos tipo tipo matrícula
            // Si es matrícula, se aplica el descuento a la matrícula analizando si tiene descuentos
            // por gratuidad y/o decuento por votaciones
            $discounteds = $mdiscounteds->where("object", $order['user'])->findAll();
            foreach ($discounteds as $discounted) {
                if (!empty($discounted['discount'])) {
                    $discount = $mdiscounts->getDiscount($discounted['discount']);
                    $concept = $discount['name'];
                    $character = $discount['character'];
                    $type = $discount['type'];
                    $value = "0";
                    if ($type == "ENROLLMENT") {
                        $dproduct = array(
                            "item" => pk(),
                            "order" => $order['order'],
                            "product" => $discount['discount'],
                            "type" => $discount['type'],
                            "value" => -($product['value'] * ($discount['value'] / 100)),
                            "amount" => "1",
                            "description" => "Descuento: {$discount['value']}% - {$discount['name']}",
                            "percentage" => "0",
                            "author" => safe_get_user(),
                        );
                        $mitems->insert($dproduct);
                    }
                }
            }

        } else {
            $dproduct = array(
                "item" => pk(),
                "order" => $order['order'],
                "product" => $product['product'],
                "type" => $item['type'],
                "value" => -($discount),
                "amount" => $item['quantity'],
                "description" => $description,
                "percentage" => "0",
                "author" => safe_get_user(),
            );
            $mitems->insert($dproduct);
        }

    }
}

?>