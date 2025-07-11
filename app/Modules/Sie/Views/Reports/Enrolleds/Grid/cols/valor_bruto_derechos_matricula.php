<?php
/**
 * 6630B31E9349B    003    Matrícula Nivel Profesional Universitario    $1.950.000,00
 * 6630B1EB4307E    002    Matrícula Nivel Tecnológico    $1.560.000,00
 * 6630AE0FC6936    001    Matrícula Nivel Técnico    $1.300.000,00
 */
if (@$program['education_level'] == "TECHNICAL") {
    $valor_bruto_derechos_matricula = 1300000;
} elseif (@$program['education_level'] == "TECHNOLOGICAL") {
    $valor_bruto_derechos_matricula = 1560000;
} elseif (@$program['education_level'] == "UNIVERSITY") {
    $valor_bruto_derechos_matricula = 1950000;
}
?>