<?php
/** @var string $valor_bruto_derechos_matricula */
/** @var array $registration */
/** @var array $discounteds listado de descuentos aplicables */
/** @var model $mdiscounteds viene de la grid.php * */
/** @var string $identification_type videne de table.php * */

//$discounteds = $mdiscounteds->where('object', @$status['registration_registration'])->findAll();
if ($identification_type == "CC") {
    foreach ($discounteds as $discounted) {
        if ($discounted['discount'] == "66578F3AC7987") {
            $apoyo_gob_nac_descuento_votac = $valor_bruto_derechos_matricula * 0.1;
        }
    }
}
?>