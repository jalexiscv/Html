<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-02-12 09:39:00
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Security\Views\Users\List\table.php]
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
$musers = model('App\Modules\Sie\Models\Sie_Users');
$mattachments = model('App\Modules\Sie\Models\Sie_Attachments');
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$musers = model("App\Modules\Sie\Models\Sie_Users");
$mhierarchies = model('App\Modules\Sie\Models\Sie_Hierarchies');
$mroles = model('App\Modules\Sie\Models\Sie_Roles');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 100;
$fields = array(
    "general" => "General",
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array();
//$musers->clear_AllCache();
$rows = $musers->get_ListByType($limit, $offset, "TEACHER", $search);
$total = $musers->get_TotalByType("TEACHER", $search);
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
    array("content" => "<i class=\"" . ICON_USER . "\"></i>", "class" => "text-center	align-middle"),
    array("content" => lang("App.Details"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Courses"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sie/teachers';
$count = $offset;
foreach ($rows as $row) {
    if (!empty($row["user"])) {
        $count++;
        $user = @$row['user'];
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$user}";
        $hrefEdit = "$component/edit/{$user}";
        $hrefDelete = "$component/delete/{$user}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-sm btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-sm btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-sm btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[details]-----------------------------------------------------------------------------------------------------
        $fullname = @$row['firstname'] . " " . @$row['lastname'];
        $email = @$row['email'];
        $identification = @$row['identification'];
        $identification_type = @$row['identification_type'];
        $phone = @$row['phone'];
        $hierarchies = $mhierarchies->getHierarchiesByUser($user);
        $tags = array();
        foreach ($hierarchies as $hierarchy) {
            $tags[] = array("value" => $hierarchy['rol'], "label" => $mroles->getName($hierarchy['rol']));
        }
        $roles = $bootstrap->getTags(array("prefix" => "roles", "data" => $tags));
        $details = "<b>Nombre</b>: {$fullname} <span class=\"opacity-25\">{$user}</span><br>";
        $details .= "<b>Documento de identificación</b>:{$identification_type} {$identification}<br>";
        $details .= "<b>Correo eléctronico</b>: {$email}<br>";
        $details .= "<b>Teléfono</b>: {$phone}<br>";
        $details .= "<b>Roles</b>: {$roles}";
        $photo = $musers->get_TeacherPhoto($user);
        $image = $bootstrap->get_Img("img-thumbnail", array("src" => $photo, "alt" => $fullname, "width" => "64", "class" => "w-64px",));
        $count_courses = $mcourses->get_TotalByTeacher($user);
        $courses = get_sie_counter_box($count_courses, ICON_COURSES);
        //[etc]---------------------------------------------------------------------------------------------------------
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $image, "class" => "p-1 w-64px"),
                array("content" => $details, "class" => "text-left align-middle"),
                array("content" => $courses, "class" => "text-center align-middle"),
                array("content" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => lang('Sie_Teachers.list-title'),
    "header-back" => $back,
    "header-add" => "/sie/teachers/create/" . lpk(),
    "alert" => array(
        'type' => 'info',
        'title' => lang('App.Remember'),
        'message' => lang("Sie_Teachers.rol-info")
    ),
    "content" => $bgrid,
));
echo($card);
?>
