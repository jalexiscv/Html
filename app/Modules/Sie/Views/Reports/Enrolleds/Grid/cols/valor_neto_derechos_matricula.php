<?php
/** @var TYPE_NAME $valor_bruto_derechos_matricula */
/** @var TYPE_NAME $apoyo_gob_nac_descuento_votac */
/** @var TYPE_NAME $apoyo_gobernac_progr_permanent */
/** @var TYPE_NAME $apoyo_alcaldia_progr_permanent */
/** @var TYPE_NAME $descuent_recurrentes_de_la_ies */
/** @var TYPE_NAME $otros_apoyos_a_la_matricula */
/** @var TYPE_NAME $valor_neto_derechos_matricula */

$valor_neto_derechos_matricula = $valor_bruto_derechos_matricula - $apoyo_gob_nac_descuento_votac - $apoyo_gobernac_progr_permanent - $apoyo_alcaldia_progr_permanent - $descuent_recurrentes_de_la_ies - $otros_apoyos_a_la_matricula;

?>