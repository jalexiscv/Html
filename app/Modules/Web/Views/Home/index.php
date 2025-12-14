<?php
$r = service('request');
$mcategorias = model("App\Modules\Web\Models\Web_Categories");
$mposts = model("App\Modules\Web\Models\Web_Posts");

$offset = ($r->getVar('offset')) ?? 0;
$limit = 12;
$categories = $mcategorias->get_List();
$featureds = $mposts->get_Featureds();
$sponsoreds = $mposts->get_Sponsoreds();
$articles = $mposts->get_Posts($limit, $offset, $search = "");
$themostseens = $mposts->get_Themostseens($limit, $offset, $search = "");
//echo("HOLA!");
//print_r($sponsoreds);
//exit();

$json = array(
    "canonical" => site_url("/web/home/index.html"),
    "title" => "Prueba",
    "description" => "Sitio web de noticias globales",
    "type" => "home",
    "categories" => $categories,
    "featureds" => $featureds,
    "sponsoreds" => $sponsoreds,
    "articles" => $articles,
    "themostseens" => $themostseens,
);
echo(json_encode($json));
?>