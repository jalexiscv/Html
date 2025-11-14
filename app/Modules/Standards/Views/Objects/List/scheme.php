<?php

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

$code = "<div id=\"card-view-service\" class=\"card mb-2\">\n";
$code .= "\t<div class=\"card-header\">\n";
$code .= "\t\t<div class=\"d-flex justify-content-between align-items-center\">\n";
$code .= "\t\t\t<h2 class=\"card-header-title p-1 m-0 opacity-7\">Ruta</h2>\n";
$code .= "\t\t\t<div class=\"card-toolbar float-right align-middle\"></div>\n";
$code .= "\t\t</div>\n";
$code .= "\t</div>\n";
$code .= "\t<div class=\"card-body py-0 px-0\">\n";
$code .= "\t\t<div class=\"card-content\">\n";
$code .= "\t\t\t<div class=\"container easy-tree pt-3\">\n";
$code .= "\t\t\t\t<ul>\n";

$count = 0;
foreach ($parents as $index => $parent) {
    $count++;
    if ($count > 1) {
        $category = $mcategories->getCategory($parent["category"]);
        if (isset($parent['name'])) {
            $prevId = ($index > 0) ? $parents[$index - 1]['object'] : '';
            $prevName = ($index > 0) ? $parents[$index - 1]['name'] : 'Inicio';
            $code .= "<li class=\"w-100\">";
            $code .= "<span class=\"w-100\">\n";
            //$code .= "<span class=\"title\">{$category["name"]}: </span>\n";
            $code .= "<a class=\"\" href=\"/standards/objects/list/{$parent['object']}?parent={$prevId}\" target=\"\">{$prevName}</a>\n";
            $code .= "</span>\n";
            $code .= "</li>\n";
        }
    }
}

$code .= "\t\t\t\t</ul>\n";
$code .= "\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "\t</div>\n";
$code .= "</div>\n";

echo $code;
?>