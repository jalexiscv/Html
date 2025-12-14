<?php

$bootstrap = service('bootstrap');
$data = $parent->get_Array();
$f = service("forms", array("lang" => "Sie_Registrations."));
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "";
$mregistration = model("App\Modules\Sie\Models\Sie_Registrations");
$mdiscounts = model("App\Modules\Sie\Models\Sie_Discounts");
$mdiscounteds = model("App\Modules\Sie\Models\Sie_Discounteds");

$registrations = $mregistration->findAll();


$code = "";


$code .= "<table class='table table-striped'>";


$code .= "<tr>";
$code .= "<th>#</th>";
$code .= "<th>Identificacion</th>";
$code .= "<th>Primer Nombre</th>";
$code .= "<th>Segundo Nombre</th>";
$code .= "<th>Primer Apellido</th>";
$code .= "<th>Segundo Apellido</th>";
$code .= "<th>Estatus</th>";
$code .= "<th>Descuentos</th>";
$code .= "</tr>";

$count = 0;
foreach ($registrations as $registration) {
    $count++;
    if ($registration["status"] == "ADMITTED" || $registration["status"] == "HOMOLOGATION" || $registration["status"] == "RE-ENTRY") {
        $discounteds = $mdiscounteds->where("object", $registration["registration"])->findAll();
        $code .= "<tr>";
        $code .= "<td>" . $count . "</td>";
        $code .= "<td>" . $registration["identification_number"] . "</td>";
        $code .= "<td>" . $registration["first_name"] . "</td>";
        $code .= "<td>" . $registration["second_name"] . "</td>";
        $code .= "<td>" . $registration["first_surname"] . "</td>";
        $code .= "<td>" . $registration["second_surname"] . "</td>";
        $code .= "<td>" . $registration["status"] . "</td>";
        $txtdiscounts = "";
        if (is_array($discounteds)) {
            foreach ($discounteds as $discounted) {
                $discount = $mdiscounts->where("discount", $discounted["discount"])->first();
                $txtdiscounts .= $discount["name"] . ", ";
            }
        }

        $code .= "<td>" . $txtdiscounts . "</td>";
        $code .= "</tr>";
    }
}

$code .= "</table>";

$card = $bootstrap->get_Card("create", array(
    "title" => "Descuentos",
    "content" => $code,
    "header-back" => $back,
));
echo($card);
?>