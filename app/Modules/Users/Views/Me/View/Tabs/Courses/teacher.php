<?php
/** @var object $bootstrap */
/** @var object $request */
//[Models]---------------------------------------------------------------------------------------------------------------
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$mmodules = model('App\Modules\Sie\Models\Sie_Modules');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$mgrids = model('App\Modules\Sie\Models\Sie_Grids');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$musers = model('App\Modules\Sie\Models\Sie_Users');
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields2');
//[Requests]------------------------------------------------------------------------------------------------------------
$courses = $mcourses->getCoursesByTeacher(safe_get_user());
//[Vars]----------------------------------------------------------------------------------------------------------------
$fields = [
    'course' => 'Codigo del curso',
    'name' => 'Nombre',
];
$offset = !empty($request->getGet("offset")) ? $request->getGet("offset") : 0;
$limit = !empty($request->getGet("limit")) ? $request->getGet("limit") : 10;
$search = !empty($request->getGet("search")) ? $request->getGet("search") : "";
$field = !empty($request->getGet("field")) ? $request->getGet("field") : "";
$total = count($courses);
//[build]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center  align-middle"),
    array("content" => lang("App.Course"), "class" => "text-left align-middle"),
));

$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$count = $offset;
foreach ($courses as $course) {
    $count++;
    $linkView = "/sie/courses/view/{$course['course']}?&t=" . pk() . "&referer=" . urlencode(current_url());
    $btnview = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $linkView, "class" => "btn-primary ml-1", "target" => "_blank"));
    $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnview));

    $course_status=@$course["status"];
    foreach (LIST_COURSES_STATUSES as $status) {
        if($status["value"]==$course_status){
            if($status["value"]=="CANCELED"){
                $course_status="<span class='badge rounded-pill bg-warning'>{$status["label"]}</span>";
            }elseif($status["value"]=="CLOSED"){
                $course_status="<span class='badge rounded-pill bg-danger'>{$status["label"]}</span>";
            }else{
                $course_status="<span class='badge rounded-pill bg-success'>{$status["label"]}</span>";
            }
        }
    }

    $bgrid->add_Row(
        array(
            array("content" => $count, "class" => "text-center align-middle"),
            array("content" => "<b>Curso</b>:" . $course['name']
                . "<br><b>Descripción</b>: {$course['description']}"
                . "<br><b>Periodo</b>:{$course['period']}"
                . "<br><b>Estado</b>:{$course_status}",
                "class" => "text-left align-middle"),
            array("content" => $options, "class" => "text-center align-middle"),
        )
    );
}
$code = $bgrid;
echo $code;
?>