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
$back = "/standards";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$parent = !empty($request->getVar("parent")) ? $request->getVar("parent") : "";
$fields = array(
    //"object" => lang("App.object"),
    //"name" => lang("App.name"),
    //"category" => lang("App.category"),
    //"parent" => lang("App.parent"),
    //"attributes" => lang("App.attributes"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array();
//$mobjects->clear_AllCache();


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


$total = $mobjects->get_CountAllResults($conditions);
//echo(safe_dump($rows['sql']));
//[build]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center	align-middle"),
    array("content" => lang("App.Object"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Category"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Details"), "class" => "text-left	align-middle"),
    array("content" => "Calificación", "class" => "text-center align-middle"),
    //array("content" => lang("App.parent"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.attributes"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/standards/objects';
$count = $offset;
foreach ($rows as $row) {
    if (!empty($row["object"])) {
        $count++;
        $category = $mcategories->getCategory($row["category"]);
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/list/{$row["object"]}?parent={$row["object"]}";
        $hrefEdit = "$component/edit/{$row["object"]}";
        $hrefDelete = "$component/delete/{$row["object"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------


        $value = !empty(@$row["value"]) ? $row["value"] : "0.0";
        $islastinline = $mobjects->isLastInLine($row["object"]);

        $ilil = "NO";
        if ($islastinline) {
            $ilil = "SI";
        }

        $details = @$row["name"];
        if ($row["category"] == "686594E670415") {
            $details = @$row["description"];
        }
        $details .= "<br>";
        //$details.="<b>Último en la linea:</b> {$ilil}<br>";


        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $row['object'], "class" => "text-left align-middle"),
                array("content" => @$category['name'], "class" => "text-center align-middle"),
                array("content" => $details, "class" => "text-left align-middle"),
                array("content" => $value, "class" => "text-center align-middle"),
                //array("content" => $row['parent'], "class" => "text-left align-middle"),
                //array("content" => $row['attributes'], "class" => "text-left align-middle"),
                array("content" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}
//[build]--------------------------------------------------------------------------------------------------------------

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

$object = $mobjects->get_Object($oid);

$card = $bootstrap->get_Card2("card-grid", array(
    "header-title" => @$object["name"],
    "header-back" => $link_back,
    "header-add" => $link_create,
    "alert" => array(
        "icon" => ICON_INFO,
        "type" => "info",
        "title" => "Descripción",
        "message" => " " . @$object["description"]),
    "content" => $bgrid,
));
echo($card);
?>