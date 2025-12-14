<?php
$r = service('request');
$mcategorias = model("App\Modules\Web\Models\Web_Categories");
$mposts = model("App\Modules\Web\Models\Web_Posts");

$offset = ($r->getVar('offset')) ?? 0;
$limit = 12;
$categories = $mcategorias->get_List();
$sponsoreds = $mposts->get_Sponsoreds();
$articles = $mposts->get_Posts($limit, $offset, $search = "");

//print_r($sponsoreds);
//exit();

$json = array(
    "title" => "Acceso denegado!",
    "description" => "Modulo no contratado!",
    "type" => "denied",
);
echo(json_encode($json));
?>