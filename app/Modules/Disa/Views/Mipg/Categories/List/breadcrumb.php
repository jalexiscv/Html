<?php
/*
 * Copyright (c) 2022-2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

// Recibe el codigo del componente
$mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions");
$mpolitics = model("\App\Modules\Disa\Models\Disa_Politics");
$mdiagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics");
$mcomponents = model("\App\Modules\Disa\Models\Disa_Components");
$mcategories = model("\App\Modules\Disa\Models\Disa_Categories");
$mactivities = model("\App\Modules\Disa\Models\Disa_Activities");
$mscores = model("\App\Modules\Disa\Models\Disa_Scores");

//$activity = $mactivities->find($oid);
//$category = $mcategories->find($oid);
$component = $mcomponents->find($oid);
$diagnostic = $mdiagnostics->find($component["diagnostic"]);
$politic = $mpolitics->find($diagnostic["politic"]);

$dimensions = $mdimensions->get_List();
$politics = $mpolitics->get_ListByDimension($politic["dimension"]);
$diagnostics = $mdiagnostics->get_ListByPolitic($diagnostic["politic"]);
$components = $mcomponents->get_ListByDiagnostic($component["diagnostic"]);
//$categories = $mcategories->get_ListByComponent($category["component"]);
//$activities = $mactivities->get_ListByCategory($activity["category"]);

$menu = array(
    "home" => array("href" => "#", "text" => "Inicio"),
    "dimensions" => array("href" => "#", "text" => "Dimensiones", "levels" => array()),
    "politics" => array("href" => "#", "text" => "Politicas", "levels" => array()),
    "diagnostics" => array("href" => "#", "text" => "Autodiagnosticos", "levels" => array()),
    "components" => array("href" => "#", "text" => "Componentes", "levels" => array()),
    //"categories"=>array("href"=>"#","text"=>"Categorias","levels"=>array()),
    //"activities"=>array("href"=>"#","text"=>"Actividades","levels"=>array()),
);

foreach ($dimensions as $dimension) {
    if ($dimension["dimension"] == $politic["dimension"]) {
        $item = array("href" => "/disa/mipg/politics/list/{$dimension["dimension"]}", "text" => urldecode($dimension["name"]), "active" => true);
    } else {
        $item = array("href" => "/disa/mipg/politics/list/{$dimension["dimension"]}", "text" => urldecode($dimension["name"]));
    }
    array_push($menu["dimensions"]["levels"], $item);
}

foreach ($politics as $politic) {
    if ($politic["politic"] == $diagnostic["politic"]) {
        $item = array("href" => "/disa/mipg/diagnostics/list/{$politic["politic"]}", "text" => urldecode($politic["name"]), "active" => true);
    } else {
        $item = array("href" => "/disa/mipg/diagnostics/list/{$politic["politic"]}", "text" => urldecode($politic["name"]));
    }
    array_push($menu["politics"]["levels"], $item);
}

foreach ($diagnostics as $diagnostic) {
    if ($diagnostic["diagnostic"] == $component["diagnostic"]) {
        $item = array("href" => "/disa/mipg/components/list/{$diagnostic["diagnostic"]}", "text" => urldecode($diagnostic["name"]), "active" => true);
    } else {
        $item = array("href" => "/disa/mipg/components/list/{$diagnostic["diagnostic"]}", "text" => urldecode($diagnostic["name"]));
    }
    array_push($menu["diagnostics"]["levels"], $item);
}

foreach ($components as $component) {
    if ($component["component"] == $oid) {
        $item = array("href" => "/disa/mipg/categories/list/{$component["component"]}", "text" => urldecode($component["name"]), "active" => true);
    } else {
        $item = array("href" => "/disa/mipg/categories/list/{$component["component"]}", "text" => urldecode($component["name"]));
    }
    array_push($menu["components"]["levels"], $item);
}

$item = array("href" => "/disa/mipg/categories/create/{$oid}", "text" => "Crear categoria");
array_push($menu["components"]["levels"], array("separator" => true));
array_push($menu["components"]["levels"], $item);

$breadcrumb = service("smarty");
$breadcrumb->caching = 0;
$breadcrumb->set_Mode("bs5x");
$breadcrumb->assign("menu", $menu);
echo($breadcrumb->view('components/breadcrumb/index.tpl'));

?>