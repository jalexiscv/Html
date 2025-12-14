<?php
$bootstrap = service('bootstrap');
$mdiscounts = model("App\Modules\Sie\Models\Sie_Discounts");
$mdiscounteds = model("App\Modules\Sie\Models\Sie_Discounteds");
$discounts = $mdiscounts->get_List(1000, 0);
//[grid]----------------------------------------------------------------------------------------------------------------
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
//[build]---------------------------------------------------------------------------------------------------------------
$code = "<!-- [files] //-->\n";
$code .= "<div class=\"container m-0 p-0\">\n";
$code .= "\t\t<form id=\"uploadForm\" class=\"row w-100 p-0 m-0\">\n";
$code .= "\t\t\t\t<div class=\"col-md-10 p-2\">\n";
$code .= "\t\t\t\t\t\t<select class=\"form-select\" id=\"select-discounts\">\n";
$code .= "\t\t\t\t\t\t\t\t<option value=\"\">Seleccione un descuento...</option>\n";
foreach ($discounts as $discount) {
    $code .= "\t\t\t\t\t\t\t\t<option value=\"{$discount['discount']}\">{$discount['name']}</option>\n";
}
$code .= "\t\t\t\t\t\t</select>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"col-md-2 p-2\">\n";
$code .= "\t\t\t\t\t\t<button type=\"button\" onclick=\"setDiscount()\" class=\"btn btn-primary w-100\">Asignar</button>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t</form>\n";
$code .= "\t\t<div class=\"row w-100 p-0 m-0\">\n";
$code .= "\t\t\t\t<div class=\"col-12 p-2\">\n";
$code .= "\t\t\t\t\t\t<div id=\"grid-discounts\">\n";
$code .= "\t\t\t\t\t\t{$bgrid}\n";
$code .= "\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "</div>\n";
$code .= "<!-- [/files] //-->\n";
echo($code);
?>
<script>
    function setDiscount() {
        const object = "<?php echo($oid);?>";
        const discount = document.getElementById('select-discounts').value;
        const grid = document.getElementById('grid-discounts').value;
        const url = "/sie/api/discounteds/json/create/" + object + "/?time=" + new Date().getTime();
        const formData = new FormData();
        formData.append('object', object);
        formData.append('discount', discount);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const response = JSON.parse(xhr.responseText);
                refreshGridDiscounteds();
                //console.log(response);
                //alert('Archivos cargados: ' + response.status)
            }
        };
        xhr.send(formData);
    }

    function refreshGridDiscounteds() {
        const object = "<?php echo($oid);?>";
        const url = "/sie/api/discounteds/json/list/" + object + "/?time=" + new Date().getTime();
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const response = JSON.parse(xhr.responseText);
                const grid = document.getElementById('grid-discounts');
                grid.innerHTML = response.grid;
                //console.log(response.grid);
                //alert('Archivos cargados: ' + response.status)
            }
        };
        xhr.send();
    }

    function deleteDiscounted(discounted) {
        const url = "/sie/api/discounteds/json/delete/" + discounted + "/?time=" + new Date().getTime();
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const response = JSON.parse(xhr.responseText);
                refreshGridDiscounteds();
                console.log(response);
                //alert('Archivos cargados: ' + response.status)
            }
        };
        xhr.send();
    }

</script>