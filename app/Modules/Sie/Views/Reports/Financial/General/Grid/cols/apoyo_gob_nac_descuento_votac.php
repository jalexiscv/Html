<?php
/** @var string $valor_bruto_derechos_matricula */
/** @var array $registration */
/** @var array $discounteds listado de descuentos aplicables */
//$discounteds = $mdiscounteds->where('object', $registration['registration'])->findAll();
if (@$registration['identification_type'] == "CC") {
    foreach ($discounteds as $discounted) {
        if ($discounted['discount'] == "66578F3AC7987") {
            $apoyo_gob_nac_descuento_votac = $valor_bruto_derechos_matricula * 0.1;
        }
    }
}
?>