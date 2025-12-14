<?php
/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */
$bootstrap = service("bootstrap");
$request = service('request');
$mdiscounts = model("App\Modules\Sie\Models\Sie_Discounts");
$mdiscounteds = model("App\Modules\Sie\Models\Sie_Discounteds");

$bgrid = $bootstrap->get_Grid();

$bgrid->set_Class("P-0 m-0");
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center text-nowrap align-middle"),
    array("content" => "Descuento", "class" => "text-center align-middle"),
    array("content" => "Valor", "class" => "text-center align-middle"),
    array("content" => "Opciones", "class" => "text-center text-nowrap align-middle"),
));
$count = 0;
$discounteds = $mdiscounteds->where('object', $oid)->findAll();
if (is_array($discounteds)) {
    foreach ($discounteds as $discounted) {
        $discount = $mdiscounts->getDiscount($discounted['discount']);
        $count++;
        $options = "";
        $cell_count = array("content" => $count, "class" => "text-center  align-middle",);
        $cell_discount = array("content" => @$discount['name'], "class" => "text-center  align-middle",);
        $cell_value = array("content" => @$discount['value'], "class" => "text-center  align-middle",);
        $cell_options = "<div class=\"btn-group w-auto\">";
        $cell_options .= "<a href=\"#\" onclick=\"deleteDiscounted('{$discounted['discounted']}')\" title=\"\" class=\"btn btn-sm btn-danger\"><i class=\"fa-light fa-trash\"></i></a>";
        $cell_options .= "</div>";
        $bgrid->add_Row(array($cell_count, $cell_discount, $cell_value, $cell_options));
    }
} else {
    //mensaje no hay mallas
}
echo(json_encode(array(
    "oid" => $oid,
    "grid" => $bgrid . "",

)));

?>