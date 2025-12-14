<?php

$request = service("request");
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
$mobservations = model('App\Modules\Sie\Models\Sie_Observations');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = $request->getVar("back");
$course = $request->getVar("course");

$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    //"observation" => lang("App.observation"),
    //"object" => lang("App.object"),
    //"type" => lang("App.type"),
    //"content" => lang("App.content"),
    //"date" => lang("App.date"),
    //"time" => lang("App.time"),
    //"author" => lang("App.author"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array(
    "author" => safe_get_user(),
    "object" => $oid,
);
//$mobservations->clear_AllCache();
$rows = $mobservations->getCachedSearch($conditions, $limit, $offset, "observation DESC");
$total = $mobservations->getCountAllResults($conditions);
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
    array("content" => lang("App.Observation"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.object"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.type"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Content"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.date"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.time"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Date"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sie/observations';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row["observation"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["observation"]}";
        $hrefEdit = "$component/edit/{$row["observation"]}";
        $hrefDelete = "$component/delete/{$row["observation"]}?back=/sie/observations/teacher/{$oid}&course={$course}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $row['observation'], "class" => "text-left align-middle"),
                //array("content" => $row['object'], "class" => "text-left align-middle"),
                //array("content" => $row['type'], "class" => "text-left align-middle"),
                array("content" => $row['content'], "class" => "text-left align-middle"),
                //array("content" => $row['date'], "class" => "text-left align-middle"),
                //array("content" => $row['time'], "class" => "text-left align-middle"),
                //array("content" => $row['author'], "class" => "text-left align-middle"),
                array("content" => $row['created_at'], "class" => "text-left align-middle"),
                //array("content" => $row['updated_at'], "class" => "text-left align-middle"),
                //array("content" => $row['deleted_at'], "class" => "text-left align-middle"),
                array("content" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}
//[build]---------------------------------------------------------------------------------------------------------------

if (empty($back) && !empty($course)) {
    $back = "/sie/courses/view/{$course}";
}
$card = $bootstrap->get_Card2("card-grid", array(
    "header-title" => lang('Sie_Observations.list-title-teacher'),
    "header-back" => $back,
    "header-add" => "/sie/observations/create/{$oid}?back=/sie/observations/teacher/{$oid}&course={$course}",
    "alert" => array(
        "icon" => ICON_INFO,
        "type" => "info",
        "title" => lang('Sie_Observations.list-alert-title-teacher'),
        "message" => lang('Sie_Observations.list-alert-message-teacher')),
    "content" => $bgrid,
));
echo($card);
?>
