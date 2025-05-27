<?php
// Son las becas de bienestar
// $descuent_recurrentes_de_la_ies=0;
/** @var string $valor_bruto_derechos_matricula */
/** @var array $registration */
/** @var array $discounteds listado de descuentos aplicables */
/** @var TYPE_NAME $mdiscounts */
$descuent_recurrentes_de_la_ies = 0;
foreach ($discounteds as $discounted) {
    $discount = $mdiscounts->getDiscount($discounted['discount']);
    if (@$discount['type'] == "FIXED" && @$discount['character'] == "PERCENTAGE") {
        $descuent_recurrentes_de_la_ies += $valor_bruto_derechos_matricula * $discount['value'] / 100;
    }
}


?>