<?php
/**
 * @var object $authentication Authentication service from the ModuleController.
 * @var object $bootstrap Instance of the Bootstrap class from the ModuleController.
 * @var string $component Complete URI to the requested component.
 * @var object $dates Date service from the ModuleController.
 * @var string $oid String representing the object received, usually an object/data to be viewed, transferred from the ModuleController.
 * @var object $parent Represents the ModuleController.
 * @var object $request Request service from the ModuleController.
 * @var object $strings String service from the ModuleController.
 * @var string $view String passed to the view defined in the viewer for evaluation.
 * @var string $viewer Complete URI to the view responsible for evaluating each requested view.
 * @var string $views Complete URI to the module views.
 **/

//[models]--------------------------------------------------------------------------------------------------------------
$mobjects = model('App\Modules\Standards\Models\Standards_Objects');
$mcategories = model('App\Modules\Standards\Models\Standards_Categories');
//[vars]----------------------------------------------------------------------------------------------------------------
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$parent = !empty($request->getVar("parent")) ? $request->getVar("parent") : "";
$conditions = array();

if (!empty($parent)) {
    $mobjects->propagateChangesFrom($parent);
    $rows = $mobjects->where("parent", $parent)->orderBy("weight", "ASC")->find();
} else {
    $rows = $mobjects
        ->groupStart()
        ->where("parent", "")
        ->orWhere("parent", NULL)
        ->groupEnd()
        ->orderBy("weight", "ASC")
        ->find();
}

$code = "<div class=\"row row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1 text-center shortcuts\">\n";
$component = '/standards/objects';
$count = $offset;
$total = $mobjects->get_CountAllResults($conditions);
foreach ($rows as $row) {
    if (!empty($row["object"])) {
        $count++;
        $title = $row['name'];
        $percentage = @$row['value'];
        $subtitle = "$percentage";
        $categoryData = $mcategories->getCategory($row['category']);
        $category = is_array($categoryData) ? $categoryData['name'] : 'Sin categoría';

        $link_view = "$component/list/{$row["object"]}?parent={$row["object"]}";
        $link_edit = "$component/edit/{$row["object"]}";
        $link_delete = "$component/delete/{$row["object"]}";

        $code .= "\t\t<div class=\"col mb-1\">\n";
        $code .= "<div class=\"card mb-1\">\n";
        $code .= "\t<div class=\"card-body d-flex align-items-center position-relative\">\n";
        $code .= "\t\t<span class=\"card-badge bg-secondary absolute float-right opacity-1 \">{$count}</span>\n";
        $code .= "<div class=\"row w-100 p-0 m-0\">\n";
        $code .= "<div class=\"col-12 d-flex align-items-center justify-content-center\">\n";
        $code .= "<a href=\"{$link_view}\" class=\"\">\n";
        $code .= "\t\t\t\t\t\t<canvas id=\"heatGraph-{$row['object']}\" class=\"heatgraph-canvas v2\"  data-type=\"{$category}\" data-title=\"$title\" data-subtitle=\"$subtitle\" data-percentage=\"$percentage\"></canvas>\n";
        $code .= "</a>\n";
        $code .= "</div>\n";
        $code .= "<di><a href=\"{$link_edit}\">Editar</a> | <a href=\"{$link_delete}\">Eliminar</a></di>";
        $code .= "</div>\n";
        $code .= "</div>\n";
        $code .= "</div>\n";
        $code .= "\t</div>\n";
    }
}

$code .= "</div>\n";

//[build]---------------------------------------------------------------------------------------------------------------
if (!empty($parent)) {
    $link_create = "/standards/objects/create/{$parent}" . "?parent=" . $parent;
    $object = $mobjects->where("object", $parent)->first();
    if (!empty($object['parent'])) {
        $link_back = "/standards/objects/list/{$object['parent']}" . "?parent=" . $object['parent'];
    } else {
        $link_back = "/standards/objects/list/" . lpk();
    }
} else {
    $link_create = "/standards/objects/create/" . lpk();
    $link_back = "/standards/objects/list/" . lpk();
}

$card = $bootstrap->get_Card2("card-grid", array(
    "header-title" => @$object["name"],
    "header-back" => $link_back,
    "header-add" => $link_create,
    "alert" => array(
        "icon" => ICON_INFO,
        "type" => "info",
        "title" => "Descripción",
        "message" => " " . @$object["description"]),
    "content" => $code,
));

echo($card);


?>