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
$mactivities = model('App\Modules\Iso9001\Models\Iso9001_Activities');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/iso9001/activities/home/{$oid}";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    //"activity" => lang("App.activity"),
    //"category" => lang("App.category"),
    //"order" => lang("App.order"),
    //"criteria" => lang("App.criteria"),
    //"description" => lang("App.description"),
    //"evaluation" => lang("App.evaluation"),
    //"period" => lang("App.period"),
    //"score" => lang("App.score"),
    //"author" => lang("App.author"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);

//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array(
    "category" => $oid
);
//$mactivities->clear_AllCache();
$rows = $mactivities->getCachedSearch($conditions, $limit, $offset, "order ASC");
$total = $mactivities->getCountAllResults($conditions);
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
    array("content" => lang("App.Activity"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.category"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.order"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.criteria"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Description"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.evaluation"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.period"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.score"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/iso9001/activities';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row["activity"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["activity"]}";
        $hrefEdit = "$component/edit/{$row["activity"]}";
        $hrefDelete = "$component/delete/{$row["activity"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $row['activity'], "class" => "text-left align-middle"),
                //array("content" => $row['category'], "class" => "text-left align-middle"),
                //array("content" => $row['order'], "class" => "text-left align-middle"),
                //array("content" => $row['criteria'], "class" => "text-left align-middle"),
                array("content" => $row['description'], "class" => "text-left align-middle"),
                //array("content" => $row['evaluation'], "class" => "text-left align-middle"),
                //array("content" => $row['period'], "class" => "text-left align-middle"),
                //array("content" => $row['score'], "class" => "text-left align-middle"),
                //array("content" => $row['author'], "class" => "text-left align-middle"),
                //array("content" => $row['created_at'], "class" => "text-left align-middle"),
                //array("content" => $row['updated_at'], "class" => "text-left align-middle"),
                //array("content" => $row['deleted_at'], "class" => "text-left align-middle"),
                array("content" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}

//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("card-grid", array(
    "header-title" => lang('Iso9001_Activities.list-title'),
    "header-back" => $back,
    "header-add" => "/iso9001/activities/create/{$oid}",
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Iso9001_Activities.list-title'), "message" => lang('Iso9001_Activities.list-description')),
    "content" => $bgrid,
));
echo($card);

?>