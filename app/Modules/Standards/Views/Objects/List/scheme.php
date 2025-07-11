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
$code .= "\t\t\t<div class=\"container easy-tree\">\n";
$code .= "\t\t\t\t<ul>\n";

foreach ($parents as $index => $parent) {
    $category = $mcategories->getCategory($parent["category"]);
    if (isset($parent['name'])) {
        // Obtener el ID del padre del elemento anterior
        $parentId = ($index > 0) ? $parents[$index - 1]['object'] : '';
        $code .= "<li class=\"w-100\">";
        $code .= "<span class=\"w-100\">\n";
        $code .= "<span class=\"title\">{$category["name"]}: </span>\n";
        $code .= "<a class=\"\" href=\"/standards/objects/list/{$parent['object']}?parent={$parentId}\" target=\"\">{$parent['name']}</a>\n";
        $code .= "</span>\n";
        $code .= "</li>\n";
    }
}

$code .= "\t\t\t\t</ul>\n";
$code .= "\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "\t</div>\n";
$code .= "</div>\n";

echo $code;
?>