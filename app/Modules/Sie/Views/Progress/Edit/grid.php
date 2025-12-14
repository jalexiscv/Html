<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-11-18 07:17:07
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Executions\List\table.php]
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
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    //"execution" => lang("App.execution"),
    //"progress" => lang("App.progress"),
    //"course" => lang("App.course"),
    //"date_start" => lang("App.date_start"),
    //"date_end" => lang("App.date_end"),
    //"c1" => lang("App.c1"),
    //"c2" => lang("App.c2"),
    //"c3" => lang("App.c3"),
    //"total" => lang("App.total"),
    //"author" => lang("App.author"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array();
//$mexecutions->clear_AllCache();
/** @var TYPE_NAME $progress */
$rows = $mexecutions->get_GridByProgress($progress);
$total = $mexecutions->get_CountByProgress($progress);
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
    array("content" => "Ejecución", "class" => "text-center	align-middle"),
    //array("content" => lang("App.progress"), "class" => "text-center	align-middle"),
    //array("content" => "Curso", "class" => "text-center	align-middle"),
    array("content" => "Detalles", "class" => "text-left	align-middle"),
    //array("content" => lang("App.date_start"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.date_end"), "class" => "text-center	align-middle"),
    array("content" => "C1", "class" => "text-center align-middle"),
    array("content" => "C2", "class" => "text-center align-middle"),
    array("content" => "C3", "class" => "text-center align-middle"),
    array("content" => lang("App.Total"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Status"), "class" => "text-center	align-middle"),
    array("content" => "Periodo", "class" => "text-center align-middle"),
    //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sie/executions';
$count = $offset;
foreach ($rows as $row) {
    if (!empty($row['execution'])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "/$component/view/{$row["execution"]}";
        $hrefEdit = "/$component/edit/{$row["execution"]}";
        $hrefDelete = $component . "/delete/{$row["execution"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-sm btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-sm btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => "$hrefDelete", "class" => "btn-sm btn-danger ml-1 disabled",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $course = $mcourses->getCourse($row['course']);
        $course_name = !empty($course["name"]) ? $course["name"] : "Posible importación historica";
        $course_description = !empty($course["description"]) ? $course["description"] : "Posible importación historica";
        $teacher = !empty($course["teacher"]) ? $mfields->get_Profile($course["teacher"]) : "";
        $teacher_name = (is_array($teacher) && !empty($teacher["name"])) ? $teacher["name"] : "Posible importación historica";
        $created_at = $row['created_at'];
        $responsible = !empty($row['author']) ? $mfields->get_Profile($row['author']) : "";
        $responsible_name = (is_array($responsible) && !empty($responsible["name"])) ? $responsible["name"] : "";

        $details = "<b>Curso</b>: {$course_name} - <span class='opacity-25'>{$row["course"]}</span> <br>";
        $details .= "<b>Descripción:</b>{$course_description}<br>";
        $details .= "<b>Profesor:</b>{$teacher_name}<br>";

        $details .= "<b>Fecha del registro:</b> {$created_at}<br>";
        $details .= "<b>Responsable:</b> {$responsible_name}";

        $status = $row['status'];
        foreach (LIST_STATUSES_PROGRESS as $lstatus) {
            if ($lstatus['value'] == $status) {
                $status = $lstatus['label'];
            }
        }
        //[rows]--------------------------------------------------------------------------------------------------------
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $row['execution'], "class" => "text-left align-middle"),
                //array("content" => $row['progress'], "class" => "text-left align-middle"),
                //array("content" => $row['course'], "class" => "text-left align-middle"),
                array("content" => $details, "class" => "text-left align-middle"),
                //array("content" => $row['date_start'], "class" => "text-left align-middle"),
                //array("content" => $row['date_end'], "class" => "text-left align-middle"),
                array("content" => $row['c1'], "class" => "text-center align-middle"),
                array("content" => $row['c2'], "class" => "text-center align-middle"),
                array("content" => $row['c3'], "class" => "text-center align-middle"),
                array("content" => $row['total'], "class" => "text-center align-middle"),
                array("content" => $status, "class" => "text-center align-middle"),
                array("content" => @$row['period'], "class" => "text-center align-middle"),
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
    "header-title" => lang('Executions.list-title'),
    "header-back" => $back,
    "header-add" => "/sie/q10files/import/" . lpk(),
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Executions.list-title'), "message" => lang('Executions.list-description')),
    "content" => $bgrid,
));
echo($bgrid);
?>