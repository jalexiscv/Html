<?php

//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$strings = service("strings");
$mdiagnostics = model('App\Modules\Iso9001\Models\Iso9001_Diagnostics');
$diagnostics = $mdiagnostics->where("requirement", $oid)->findAll();
//[vars]----------------------------------------------------------------------------------------------------------------
//Recibe el componente $oid
$mdiagnostics = model('App\Modules\Iso9001\Models\Iso9001_Diagnostics');
$mcomponents = model('App\Modules\Iso9001\Models\Iso9001_Components');
$mcategories = model('App\Modules\Iso9001\Models\Iso9001_Categories');
$component = $mcomponents->where("component", $oid)->first();
$categories = $mcategories->where("component", $oid)->findAll();
$back = "/iso9001/components/home/{$component["diagnostic"]}";

$code = "<div class=\"row\trow-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1\ttext-center shortcuts\">\n";
$count = 0;
foreach ($categories as $categorie) {
    $count++;
    $percentage =$mcategories->getScore($categorie['category']);
    $title = "".$categorie['name'];
    $subtitle = "$percentage%";
    $code .= "\t\t<div class=\"col mb-1\">\n";
    $code .= "<div class=\"card mb-1\">\n";
    $code .= "\t<div class=\"card-body d-flex align-items-center position-relative\">\n";
    $code .= "\t\t<span class=\"card-badge bg-secondary absolute float-right opacity-1 \">{$count}</span>\n";
    $code .= "<div class=\"row w-100 p-0 m-0\">\n";
    $code .= "<div class=\"col-12 d-flex align-items-center justify-content-center\">\n";
    $code .= "<a href=\"/iso9001/activities/home/{$categorie['category']}\" class=\"stretched-link\">\n";
    $code .= "\t\t\t\t\t\t<canvas id=\"heatGraph-{$categorie['category']}\" class=\"heatgraph-canvas\" height=\"254px\" data-type=\"Categoria\" data-title=\"$title\" data-subtitle=\"$subtitle\" data-percentage=\"{$percentage}\"></canvas>\n";
    $code .= "</a>\n";
    $code .= "</div>\n";
    $code .= "</div>\n";
    $code .= "</div>\n";
    $code .= "</div>\n";
    $code .= "\t</div>\n";
}
$code .= "</div>\n";

$title = $strings->get_Clear($component["name"]);
$message = $strings->get_Clear($component["description"]);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => sprintf(lang('Categories.home-title'), ""),
    "header-back" => $back,
    "header-list" => '/iso9001/categories/list/' . $oid,
    "alert" => array(
        'type' => 'info',
        'title' => $title,
        'message' => $message
    ),
    "content" => $code,
));
echo($card);
?>