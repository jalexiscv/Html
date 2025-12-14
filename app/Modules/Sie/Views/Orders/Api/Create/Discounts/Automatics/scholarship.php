<?php
/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Descuentos Automáticos x Beca | Scholarship
 * ---------------------------------------------------------------------------------------------------------------------
 * Esta evaluación se da si el carácter "typo" del descuento es "Beca|SCHOLARSHIP"
 * 1. Si es una beca aplica a la mátricula
 *
 * ---------------------------------------------------------------------------------------------------------------------
 **/

/** @var array $products */
/** @var array $discount */
/** @var array $order */

//$discount['discount'];
//$discount['type'];
//$discount['character'];
//$discount['value'];

$type = $discount['type'];
$character = $discount['character'];

echo("<br>1. Analizando Beca: " . $type . " - " . $character);
if ($character == "PERCENTAGE") {
    echo("<br>1.1. Tipo Porcentaje");
    // 1. Busco en la lista de productos facturados "$products[]" si existe alguno typo matrícula "ENROLLMENT"
    // 2. Si existe le aplico entonces el descuento automático obteniendo el porcentaje del valor correspondiente
    // 3. Y el valor resultante lo registro como un descuento automático con un valor definido
    foreach ($products as $product) {
        if ($product['type'] == "ENROLLMENT") {
            echo("<br>1.1.1 Existe producto tipo matricula");
            $exist_enrroled = true;
            $dproduct = array(
                "item" => pk(),
                "order" => $order['order'],
                "product" => $discount['discount'],
                "type" => $discount['type'],
                "value" => -($product['value'] * ($discount['value'] / 100)),
                "amount" => "1",
                "description" => "Descuento: {$discount['name']} - {$discount['value']}%",
                "percentage" => "0",
                "author" => safe_get_user(),
            );
            $mitems->insert($dproduct);
        } else {
            echo("<br>1.1.1. No existe producto tipo matricula");
        }
    }
} elseif ($character == "VALUE") {
    echo("<br>1.2. Tipo Valor Fijo");
    //$dvalue = $discount['value'];
} else {
    echo("<br>1.3. Tipo Desconocido - " . $character);
    // No se aplica nada
}
echo("<hr><br><br>");
?>