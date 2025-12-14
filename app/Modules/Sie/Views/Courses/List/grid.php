<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-11-23 10:24:01
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Courses\List\table.php]
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
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$mmodules = model('App\Modules\Sie\Models\Sie_Modules');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$mgrids = model('App\Modules\Sie\Models\Sie_Grids');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$musers = model('App\Modules\Sie\Models\Sie_Users');
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
$magreements = model('App\Modules\Sie\Models\Sie_Agreements');
$minsitutions = model('App\Modules\Sie\Models\Sie_Institutions');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 30;
$fields = array(
    "course" => "General",
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array(
    "course" => "%{$search}%",
);
//$mcourses->clear_AllCache();
$rows = $mcourses->get_List($limit, $offset, $search);
$total = $mcourses->getCountAllResults($conditions);

//echo(safe_dump($rows['sql']));
//[build]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(30, 60, 120, 240, 480, 960, 1920));
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center	align-middle"),
    array("content" => "Curso", "class" => "text-center	align-middle"),
    array("content" => "Detalles", "class" => "text-left	align-middle"),

    //array("content" => lang("App.course"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.reference"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.program"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.grid"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.version"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.module"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.teacher"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.name"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.description"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.maximum_quota"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.start"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.end"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.period"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.space"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.status"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.journey"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.start_time"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.end_time"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.price"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sie/courses';
$count = $offset;
foreach ($rows as $row) {
    if (!empty($row["course"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["course"]}";
        $hrefEdit = "$component/edit/{$row["course"]}";
        $hrefDelete = "$component/delete/{$row["course"]}";

        $class_course_status = "";
        if ($row["status"] == "CANCELED" || $row["status"] == "CLOSED") {
            $class_course_status = "disabled";
        }

        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-sm btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-sm btn-warning ml-1 xx {$class_course_status}",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger xx ml-1 {$class_course_status}",));
        $options = $bootstrap->get_BtnGroupVertical("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        //course[module]=pensum
        $pensum = $mpensums->get_Pensum($row["pensum"]);
        $module = $mmodules->get_Module(@$pensum["module"]);
        $module_name = @$module["name"];
        $teacher = $mfields->get_Profile($row["teacher"]);


        $course_status = @$row["status"];
        foreach (LIST_COURSES_STATUSES as $status) {
            if ($status["value"] == $course_status) {
                if ($status["value"] == "CANCELED") {
                    $course_status = "{$status["label"]}";
                } elseif ($status["value"] == "CLOSED") {
                    $course_status = "{$status["label"]}";
                } else {
                    $course_status = "{$status["label"]}";
                }
            }
        }

        $journey = @$row["journey"];
        foreach (LIST_JOURNEYS as $rjourney) {
            if ($rjourney["value"] == $journey) {
                $journey = $rjourney["label"];
            }
        }

        $agreement = $magreements->get_Agreement(@$row["agreement"]);
        $agreement_institution = $minsitutions->getInstitution(@$row["agreement_institution"]);

        $agreement_agreement = @$agreement["agreement"];
        $agreement_name = @$agreement["name"];
        $agreement_institution_institution = @$agreement_institution["institution"];
        $agreement_institution_name = @$agreement_institution["name"];

        $module_red = @$module["red"];
        $module_subsector = @$module["subsector"];

        $details = "<b>Nombre</b>: {$row["name"]} - <span class='opacity-25'>" . @$row["course"] . "</span> ";
        $details .= "<br><b>Descripción</b>: {$row["description"]}";
        if (!empty($module_red) && !empty($module_subsector)) {
            $details .= "<br><b>Red</b>: {$module_red} | <b>Subsector</b>: {$module_subsector}";
        } else {
            $details .= "<br><span class='badge rounded-pill bg-danger'>Sin red / Subsector</span>";
        }
        $details .= "<br><b>Pensum</b>: {$module_name} - <span class='opacity-25'>{$row["pensum"]}</span>";
        $details .= "<br><b>Modulo Base</b>: <span class='opacity-25'>" . @$pensum["module"] . "</span>";
        $details .= "<br><b>Inicio</b>: {$row["start"]} <b>Finalización</b>: {$row["end"]} | <b>Creado</b>: {$row["created_at"]} ";
        $details .= "<br><b>Profesor</b>: {$teacher['name']} - <span class='opacity-25'>{$row["teacher"]}</span>";
        if (!empty($agreement_agreement)) {
            $details .= "<br><b>Convenio</b>: {$agreement_name} - <span class='opacity-25'>{$agreement_agreement}</span>";
            $details .= "<br><b>Institución</b>: {$agreement_institution_name} - <span class='opacity-25'>{$agreement_institution_institution}</span>";
        }
        if(!empty($row["free"])&&$row["free"]=="Y"){
            $details .= "<br><b>Acceso</b>: Es de libre acceso.";
        }


        $date_start = @$row["start"];
        $date_end = @$row["end"];

        $details .= "<br><b>Jornada</b>: {$journey} <b>Horario</b>: {$row["start_time"]} - {$row["end_time"]}";
        //$details .= "<br><b>Estado</b>: {$course_status}";

        $students_count = $mexecutions->get_StudentsByCourse($row["course"]);

        $students = "<div class=\"four col-12\">\n";
        $students .= "<div class=\"counter-box\">\n";
        $students .= "<i class=\"fa\tfa-user\"></i>\n";
        $students .= "<span class=\"counter\">{$students_count}</span>\n";
        $students .= "</div>\n";
        $students .= "</div>\n";


        $students = sie_get_textual_status_courses($course_status, $students_count, ICON_USER, $course_status);


        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $students, "class" => "text-center align-middle"),
                array("content" => $details, "class" => "text-left align-middle"),
                //array("content" => $row['course'], "class" => "text-left align-middle"),
                //array("content" => $row['reference'], "class" => "text-left align-middle"),
                //array("content" => $row['program'], "class" => "text-left align-middle"),
                //array("content" => $row['grid'], "class" => "text-left align-middle"),
                //array("content" => $row['version'], "class" => "text-left align-middle"),
                //array("content" => $row['module'], "class" => "text-left align-middle"),
                //array("content" => $row['teacher'], "class" => "text-left align-middle"),
                //array("content" => $row['name'], "class" => "text-left align-middle"),
                //array("content" => $row['description'], "class" => "text-left align-middle"),
                //array("content" => $row['maximum_quota'], "class" => "text-left align-middle"),
                //array("content" => $row['start'], "class" => "text-left align-middle"),
                //array("content" => $row['end'], "class" => "text-left align-middle"),
                //array("content" => $row['period'], "class" => "text-left align-middle"),
                //array("content" => $row['space'], "class" => "text-left align-middle"),
                //array("content" => $row['status'], "class" => "text-left align-middle"),
                //array("content" => $row['journey'], "class" => "text-left align-middle"),
                //array("content" => $row['start_time'], "class" => "text-left align-middle"),
                //array("content" => $row['end_time'], "class" => "text-left align-middle"),
                //array("content" => $row['author'], "class" => "text-left align-middle"),
                //array("content" => $row['price'], "class" => "text-left align-middle"),
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
    "header-title" => lang('Sie_Courses.list-title'),
    "header-back" => $back,
    "header-add" => "/sie/courses/create/" . lpk(),
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Sie_Courses.list-title'), "message" => lang('Sie_Courses.list-description')),
    "content" => $bgrid,
));
echo($card);
?>