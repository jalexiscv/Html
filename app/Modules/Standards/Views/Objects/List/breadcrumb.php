<?php

$bootstrap = service("bootstrap");

$mobjects = model('App\Modules\Standards\Models\Standards_Objects');
$mcategories = model('App\Modules\Standards\Models\Standards_Categories');

/** @var string $oid */


$parents = [];
$currentObject = $mobjects->get_Object($oid);

if (!empty($currentObject)) {
    // Agregar el objeto inicial
    $parents[] = $currentObject;

    // Explorar padres mientras existan
    while (!empty($currentObject['parent'])) {
        $parentId = $currentObject['parent'];
        $currentObject = $mobjects->get_Object($parentId);

        if (!empty($currentObject)) {
            $parents[] = $currentObject;
        } else {
            break;
        }
    }
}

// Invertir el array
$parents = array_reverse($parents);

$menu = array(
    array("href" => "/standards/", "text" => "standards", "class" => false),
    //array("href" => "/standards/objects/home/" . lpk(), "text" => lang("App.objects"), "class" => "active"),
);


foreach ($parents as $index => $parent) {
    $parentId = ($index > 0) ? $parents[$index - 1]['object'] : '';
    $category=$mcategories->getCategory($parent["category"]);
    $menu[]=array("href" =>"/standards/objects/list/{$parent['object']}?parent={$parentId}", "text" => "{$category["name"]}", "class" => "active");
}

echo($bootstrap->get_Breadcrumb($menu));
?>