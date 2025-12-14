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
$mgraduations = model('App\Modules\Sie\Models\Sie_Graduations');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 25;
$fields = array(
    "general" => "General",
    //"graduation" => lang("App.graduation"),
    //"city" => lang("App.city"),
    //"date" => lang("App.date"),
    //"application_type" => lang("App.application_type"),
    //"full_name" => lang("App.full_name"),
    //"document_type" => lang("App.document_type"),
    //"document_number" => lang("App.document_number"),
    //"expedition_place" => lang("App.expedition_place"),
    //"address" => lang("App.address"),
    //"phone_1" => lang("App.phone_1"),
    //"email" => lang("App.email"),
    //"phone_2" => lang("App.phone_2"),
    //"degree" => lang("App.degree"),
    //"doc_id" => lang("App.doc_id"),
    //"highschool_diploma" => lang("App.highschool_diploma"),
    //"highschool_graduation_act" => lang("App.highschool_graduation_act"),
    //"icfes_results" => lang("App.icfes_results"),
    //"saber_pro" => lang("App.saber_pro"),
    //"academic_clearance" => lang("App.academic_clearance"),
    //"financial_clearance" => lang("App.financial_clearance"),
    //"graduation_fee_receipt" => lang("App.graduation_fee_receipt"),
    //"graduation_request" => lang("App.graduation_request"),
    //"admin_graduation_request" => lang("App.admin_graduation_request"),
    //"ac" => lang("App.ac"),
    //"ac_score" => lang("App.ac_score"),
    //"ek" => lang("App.ek"),
    //"ek_score" => lang("App.ek_score"),
    //"author" => lang("App.author"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array();
if (!empty($search)) {
    $conditions["search"] = $search;
}
//$mgraduations->clear_AllCache();
$rows = $mgraduations->getSearch($conditions, $limit, $offset, "graduation` DESC");
$total = $rows["total"];
//echo(safe_dump($rows['sql-search']));
//[build]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(25, 50, 100, 200, 400, 800, 1600));
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center	align-middle"),
    array("content" => "Postulación", "class" => "text-center	align-middle"),
    //array("content" => lang("App.city"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.date"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.application_type"), "class" => "text-center	align-middle"),
    array("content" => "Nombre Completo", "class" => "text-center	align-middle"),
    //array("content" => lang("App.document_type"), "class" => "text-center	align-middle"),
    array("content" => "Programa Academico", "class" => "text-center	align-middle"),
    //array("content" => lang("App.expedition_place"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.address"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.phone_1"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.email"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.phone_2"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.degree"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.doc_id"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.highschool_diploma"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.highschool_graduation_act"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.icfes_results"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.saber_pro"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.academic_clearance"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.financial_clearance"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.graduation_fee_receipt"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.graduation_request"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.admin_graduation_request"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.ac"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.ac_score"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.ek"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.ek_score"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sie/graduations';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row['graduation'])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["graduation"]}";
        $hrefEdit = "$component/edit/{$row["graduation"]}";
        $hrefDelete = "$component/delete/{$row["graduation"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-sm btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-sm btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-sm btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $status = "XX";
        if ($row['status'] === "PROCESS") {
            $status = "<span class='badge text-bg-primary'>En proceso</span>";
        } else if ($row['status'] === "APROVED") {
            $status = "<span class='badge text-bg-success'>Aprobado</span>";
        } else if ($row['status'] === "NOTAPROVED") {
            $status = "<span class='badge text-bg-danger'>No aprobado</span>";
        } else if ($row['status'] === "PENDING") {
            $status = "<span class='badge text-bg-warning'>Pendiente</span>";
        } else if ($row['status'] === "REJECTED") {
            $status = "<span class='badge text-bg-danger'>Rechazado</span>";
        } else if ($row['status'] === "CANCELED") {
            $status = "<span class='badge text-bg-warning'>Cancelado</span>";
        } else {
            $status = "<span class='badge text-bg-secondary'>{$row['status']}</span>";
        }

        $details = "<b>Nombre Completo</b>: {$row['full_name']}<br>";
        $details .= "<b>Documento</b>: {$row['document_number']}<br>";
        $details .= "<b>Postulación</b>: {$row['graduation']}<br>";
        $details .= "<b>Estado</b>: {$status}<br>";

        $program = "";
        foreach (LIST_DEGREES_TYPES as $degree) {
            if ($degree['value'] === $row['degree']) {
                $program = $degree['label'];
            }
        }

        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $row['graduation'], "class" => "text-left align-middle"),
                //array("content" => $row['city'], "class" => "text-left align-middle"),
                //array("content" => $row['date'], "class" => "text-left align-middle"),
                //array("content" => $row['application_type'], "class" => "text-left align-middle"),
                array("content" => $details, "class" => "text-left align-middle"),
                //array("content" => $row['document_type'], "class" => "text-left align-middle"),
                //array("content" => $row['document_number'], "class" => "text-left align-middle"),
                //array("content" => $row['expedition_place'], "class" => "text-left align-middle"),
                //array("content" => $row['address'], "class" => "text-left align-middle"),
                //array("content" => $row['phone_1'], "class" => "text-left align-middle"),
                //array("content" => $row['email'], "class" => "text-left align-middle"),
                //array("content" => $row['phone_2'], "class" => "text-left align-middle"),
                array("content" => $program, "class" => "text-left align-middle"),
                //array("content" => $row['doc_id'], "class" => "text-left align-middle"),
                //array("content" => $row['highschool_diploma'], "class" => "text-left align-middle"),
                //array("content" => $row['highschool_graduation_act'], "class" => "text-left align-middle"),
                //array("content" => $row['icfes_results'], "class" => "text-left align-middle"),
                //array("content" => $row['saber_pro'], "class" => "text-left align-middle"),
                //array("content" => $row['academic_clearance'], "class" => "text-left align-middle"),
                //array("content" => $row['financial_clearance'], "class" => "text-left align-middle"),
                //array("content" => $row['graduation_fee_receipt'], "class" => "text-left align-middle"),
                //array("content" => $row['graduation_request'], "class" => "text-left align-middle"),
                //array("content" => $row['admin_graduation_request'], "class" => "text-left align-middle"),
                //array("content" => $row['ac'], "class" => "text-left align-middle"),
                //array("content" => $row['ac_score'], "class" => "text-left align-middle"),
                //array("content" => $row['ek'], "class" => "text-left align-middle"),
                //array("content" => $row['ek_score'], "class" => "text-left align-middle"),
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
    "header-title" => lang('Sie_Graduations.list-title'),
    "header-back" => $back,
    "header-add" => "/sie/graduations/create/" . lpk(),
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Sie_Graduations.list-title'), "message" => lang('Sie_Graduations.list-description')),
    "content" => $bgrid,
));
echo($card);
?>