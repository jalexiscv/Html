<?php

$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
//$mdimensions = model('App\Modules\Plans\Models\Plans_Dimensions');
//$mpolitics = model('App\Modules\Plans\Models\Plans_Politics');
//$mdiagnostics = model('App\Modules\Plans\Models\Plans_Diagnostics');
//$mcomponents = model('App\Modules\Plans\Models\Plans_Components');
//$mcategories = model('App\Modules\Plans\Models\Plans_Categories');
//$mactivities = model('App\Modules\Plans\Models\Plans_Activities');
$mplans = model('App\Modules\Plans\Models\Plans_Plans');
// $oid Recibe  "Plan"
$plan = $mplans->getPlan($oid);
//$activity = $mactivities->get_Activity($plan['activity']);
//$category = $mcategories->get_Category($activity['category']);
//$component = $mcomponents->get_Component($category['component']);
//$diagnostic = $mdiagnostics->get_Diagnostic($component['diagnostic']);
//$politic = $mpolitics->get_Politic($diagnostic['politic']);
//$dimension = $mdimensions->get_Dimension($politic['dimension']);

//$name_category = $strings->get_Striptags($category["name"]);
//$name_component = $strings->get_Striptags($component["name"]);
//$name_diagnostic = $strings->get_Striptags($diagnostic["name"]);
//$name_politic = $strings->get_Striptags($politic["name"]);
//$name_dimension = $strings->get_Striptags($dimension["name"]);

$menu = array(
    array("href" => "/plans/", "text" => "Inicio", "class" => false),
    //array("href" => "/plans/politics/home/{$dimension['dimension']}", "text" => "Dimensión", "class" => false),
    //array("href" => "/plans/diagnostics/home/{$politic['politic']}", "text" => "Política", "class" => false),
    //array("href" => "/plans/components/home/{$diagnostic['diagnostic']}", "text" => "Diagnóstico", "class" => false),
    //array("href" => "/plans/categories/home/{$category['category']}", "text" => "Componente", "class" => false),
    //array("href" => "/plans/activities/home/$oid", "text" => "Categoría", "class" => true),
    //array("href" => "/plans/plans/home/$oid", "text" => "Actividad", "class" => true),
);
echo($bootstrap->get_Breadcrumb($menu));

?>