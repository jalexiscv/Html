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
$mdiagnostics = model('App\Modules\Iris\Models\Iris_Diagnostics');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/iris";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    //"diagnostic" => lang("App.diagnostic"),
    //"study" => lang("App.study"),
    //"attachment" => lang("App.attachment"),
    //"result_ia" => lang("App.result_ia"),
    //"result" => lang("App.result"),
    //"created_by" => lang("App.created_by"),
    //"updated_by" => lang("App.updated_by"),
    //"deleted_by" => lang("App.deleted_by"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array(
    "study" => $oid,
);
//$mdiagnostics->clear_AllCache();
$rows = $mdiagnostics->getCachedSearch($conditions, $limit, $offset, "diagnostic DESC");
$total = $mdiagnostics->getCountAllResults($conditions);
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
    array("content" => "Diagnostico", "class" => "text-center	align-middle"),
    array("content" => "Detalles", "class" => "text-center	align-middle"),
    //array("content" => lang("App.attachment"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.result_ia"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.result"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_by"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_by"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_by"), "class" => "text-center	align-middle"),
    array("content" => "Fecha", "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/iris/diagnostics';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row["diagnostic"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["diagnostic"]}";
        $hrefEdit = "$component/edit/{$row["diagnostic"]}";
        $hrefDelete = "$component/delete/{$row["diagnostic"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $details = "Analizado por IA";
        if (!empty($row["result"])) {
            $details = "Diagnosticado";
        }
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $row['diagnostic'], "class" => "text-left align-middle"),
                array("content" => $details, "class" => "text-left align-middle"),
                //array("content" => $row['attachment'], "class" => "text-left align-middle"),
                //array("content" => $row['result_ia'], "class" => "text-left align-middle"),
                //array("content" => $row['result'], "class" => "text-left align-middle"),
                //array("content" => $row['created_by'], "class" => "text-left align-middle"),
                //array("content" => $row['updated_by'], "class" => "text-left align-middle"),
                //array("content" => $row['deleted_by'], "class" => "text-left align-middle"),
                array("content" => $row['created_at'], "class" => "text-center align-middle"),
                //array("content" => $row['updated_at'], "class" => "text-left align-middle"),
                //array("content" => $row['deleted_at'], "class" => "text-left align-middle"),
                array("content" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("card-grid", array(
    "header-title" => lang('Iris_Diagnostics.list-title'),
    "header-back" => $back,
    //"header-add"=>"/iris/diagnostics/create/" . lpk(),
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Iris_Diagnostics.list-title'), "message" => lang('Iris_Diagnostics.list-description')),
    "content" => $bgrid,
));
echo($card);
?>