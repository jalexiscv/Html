<?php

$mdimensions = model('App\Modules\Furag\Models\Furag_Dimensions');
$mpolitics = model('App\Modules\Furag\Models\Furag_Politics');
$mquestions = model('App\Modules\Furag\Models\Furag_Questions');

$dimension = $mdimensions->getDimension($oid);
$bootstrap = service("bootstrap");
$menu=array(
    array("href"=>"/furag/","text"=>"Furag","class"=>false),
    array("href"=>"/furag/dimensions/view/{$dimension["dimension"]}","text"=>$dimension["name"],"class"=>false),
    array("href"=>"/furag/politics/create/{$dimension["dimension"]}","text"=>"Nueva política","class"=>"active"),
);
echo($bootstrap->get_Breadcrumb($menu));
?>