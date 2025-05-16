<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-04-28 04:55:58
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Project\Views\Tasks\List\table.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
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
$mtasks = model('App\Modules\Project\Models\Project_Tasks');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/project/projects/list/{$oid}";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 1000;
$fields = array(
    //"task" => lang("App.task"),
    //"project" => lang("App.project"),
    //"name" => lang("App.name"),
    //"description" => lang("App.description"),
    //"start" => lang("App.start"),
    //"end" => lang("App.end"),
    //"status" => lang("App.status"),
    //"responsible" => lang("App.responsible"),
    //"priority" => lang("App.priority"),
    //"author" => lang("App.author"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array(
    "project" => $oid,
);
//$mtasks->clear_AllCache();
$rows = $mtasks->getCachedSearch($conditions, $limit, $offset, "order ASC");
$total = $mtasks->getCountAllResults($conditions);
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
    array("content" => lang("Project.Task"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.project"), "class" => "text-center	align-middle"),
    array("content" => lang("Project.Name"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.description"), "class" => "text-center	align-middle"),
    array("content" => lang("Project.Start"), "class" => "text-center	align-middle"),
    array("content" => lang("Project.End"), "class" => "text-center	align-middle"),
    //array("content" => lang("Project.Status"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.responsible"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.priority"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/project/tasks';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row["task"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["task"]}";
        $hrefEdit = "$component/edit/{$row["task"]}";
        $hrefDelete = "$component/delete/{$row["task"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $status = $row['status'];
        if ($status == "PENDING") {
            $status = "<span class=\"badge text-bg-danger\">Pendiente</span>";
        } elseif ($status == "COMPLETED") {
            $status = "<span class=\"badge text-bg-success\">Completada</span>";
        } elseif ($status == "OVERDUE") {
            $status = "<span class=\"badge text-bg-danger\">Vencida</span>";
        } elseif ($status == "NOT STARTED") {
            $status = "<span class=\"badge text-bg-secondary\">No Iniciada</span>";
        } elseif ($status == "IN PROGRESS") {
            $status = "<span class=\"badge text-bg-warning\">En Progreso</span>";
        } elseif ($status == "ON HOLD") {
            $status = "<span class=\"badge text-bg-secondary\">En Espera</span>";
        } elseif ($status == "CANCELED") {
            $status = "<span class=\"badge text-bg-secondary\">Cancelada</span>";
        } elseif ($status == "DELETED") {
            $status = "<span class=\"badge text-bg-secondary\">Eliminada</span>";
        } else {
            $status = "<span class=\"badge text-bg-dark\">Pendiente</span>";
        }
        $details = "{$row['name']}";
        $details .= "<br><b>Estado</b>: {$status}";

        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $row['task'] . "<br>[" . $row['order'] . "]", "class" => "text-center align-middle"),
                //array("content" => $row['project'], "class" => "text-left align-middle"),
                array("content" => $details, "class" => "text-left align-middle"),
                //array("content" => $row['description'], "class" => "text-left align-middle"),
                array("content" => $row['start'], "class" => "text-center align-middle"),
                array("content" => $row['end'], "class" => "text-center align-middle"),
                //array("content" => $row['status'], "class" => "text-center align-middle"),
                //array("content" => $row['responsible'], "class" => "text-left align-middle"),
                //array("content" => $row['priority'], "class" => "text-left align-middle"),
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
    "header-title" => lang('Project_Tasks.list-title'),
    "header-back" => $back,
    "header-add" => "/project/tasks/create/{$oid}",
    "alert" => array(
        "icon" => ICON_INFO,
        "type" => "info",
        "title" => lang('Project_Tasks.list-title'),
        "message" => lang('Project_Tasks.list-description')
    ),
    "content" => $bgrid,
));
echo($card);
?>