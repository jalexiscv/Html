<?php

$request = service('request');
$mdiscounteds = model("App\Modules\Sie\Models\Sie_Discounteds");

$object = $request->getVar('object');
$discount = $request->getVar('discount');
$data = array(
    "discounted" => pk(),
    "object" => $object,
    "discount" => $discount,
    "author" => safe_get_user(),
);
$mdiscounteds->insert($data);
echo(json_encode(array(
    "status" => "success",
    "message" => "Descuento asignado correctamente",
    "data" => $data
)));
?>