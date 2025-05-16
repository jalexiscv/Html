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

$strings = service("strings");
//[models]--------------------------------------------------------------------------------------------------------------
$mplans = model('App\Modules\Plans\Models\Plans_Plans');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/plans";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    //"plan" => lang("App.plan"),
    //"plan_institutional" => lang("App.plan_institutional"),
    //"activity" => lang("App.activity"),
    //"manager" => lang("App.manager"),
    //"manager_subprocess" => lang("App.manager_subprocess"),
    //"manager_position" => lang("App.manager_position"),
    //"order" => lang("App.order"),
    //"description" => lang("App.description"),
    //"formulation" => lang("App.formulation"),
    //"value" => lang("App.value"),
    //"start" => lang("App.start"),
    //"end" => lang("App.end"),
    //"evaluation" => lang("App.evaluation"),
    //"author" => lang("App.author"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array();
//$mplans->clear_AllCache();
$rows = $mplans->getCachedSearch($conditions, $limit, $offset, "plan DESC");
$total = $mplans->getCountAllResults($conditions);
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
    array("content" => lang("Plans_Plans.Module"), "class" => "text-center	align-middle"),
    array("content" => "Código del plan", "class" => "text-center	align-middle"),
    array("content" => "Consecutivo", "class" => "text-center	align-middle"),
    //array("content" => lang("App.plan_institutional"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.activity"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.manager"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.manager_subprocess"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.manager_position"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.order"), "class" => "text-center	align-middle"),
    array("content" => lang("Plans_Plans.Description"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.formulation"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.value"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.start"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.end"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.evaluation"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/plans/plans';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row["plan"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["plan"]}";
        $hrefEdit = "$component/edit/{$row["plan"]}";
        $hrefDelete = "$component/delete/{$row["plan"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $module = safe_strtoupper($row['module']);
        $order = "" . $strings->get_ZeroFill($row['order'], 4);

        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $module, "class" => "text-center align-middle"),
                array("content" => $row['plan'], "class" => "text-center align-middle"),
                array("content" => $order, "class" => "text-center align-middle"),
                //array("content" => $row['plan_institutional'], "class" => "text-left align-middle"),
                //array("content" => $row['activity'], "class" => "text-left align-middle"),
                //array("content" => $row['manager'], "class" => "text-left align-middle"),
                //array("content" => $row['manager_subprocess'], "class" => "text-left align-middle"),
                //array("content" => $row['manager_position'], "class" => "text-left align-middle"),
                //array("content" => $row['order'], "class" => "text-left align-middle"),
                array("content" => $row['description'], "class" => "text-left align-middle"),
                //array("content" => $row['formulation'], "class" => "text-left align-middle"),
                //array("content" => $row['value'], "class" => "text-left align-middle"),
                //array("content" => $row['start'], "class" => "text-left align-middle"),
                //array("content" => $row['end'], "class" => "text-left align-middle"),
                //array("content" => $row['evaluation'], "class" => "text-left align-middle"),
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
    "header-title" => lang('Plans.list-title'),
    "header-back" => $back,
    "header-add" => "/plans/plans/create/" . lpk(),
    "alert" => array(
        "icon" => ICON_INFO,
        "type" => "info",
        "title" => lang('Plans_Plans.list-title'),
        "message" => lang('Plans_Plans.list-description')),
    "content" => $bgrid,
));
echo($card);
?>
