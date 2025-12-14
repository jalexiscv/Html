<?php

use App\Libraries\Html\Bootstrap\Tabs;

//[models]--------------------------------------------------------------------------------------------------------------
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent Trasferido desde el controlador * */
/** @var object $authentication Trasferido desde el controlador * */
/** @var object $request Trasferido desde el controlador * */
/** @var object $dates Trasferido desde el controlador * */
/** @var string $component Trasferido desde el controlador * */
/** @var string $view Trasferido desde el controlador * */
/** @var string $oid Trasferido desde el controlador * */
/** @var string $views Trasferido desde el controlador * */
/** @var string $prefix Trasferido desde el controlador * */
/** @var array $data Trasferido desde el controlador * */
/** @var object $model Modelo de datos utilizado en la vista y trasferido desde el index * */
/** @var array $course Vector con los datos del curso para mostrarlos en la vista * */
//[builds]--------------------------------------------------------------------------------------------------------------
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
$bootstrap = service('bootstrap');
$data = $parent->get_Array();
$data["course"] = $course;

$fcourse = view('App\Modules\Sie\Views\Courses\View\Tabs\course', $data);
$fprogram = view('App\Modules\Sie\Views\Courses\View\Tabs\program', $data);
$fagreement = view('App\Modules\Sie\Views\Courses\View\Tabs\agreement', $data);
$fteacher = view('App\Modules\Sie\Views\Courses\View\Tabs\teacher', $data);
$fmoodle = view('App\Modules\Sie\Views\Courses\View\Tabs\moodle', $data);

$tabs = array(
    array("id" => "course", "text" => "Curso", "content" => $fcourse, "active" => true),
    array("id" => "program", "text" => "Programa", "content" => $fprogram, "active" => false),
    array("id" => "agreement", "text" => "Convenio", "content" => $fagreement, "active" => false),
    array("id" => "teacher", "text" => "Profesor", "content" => $fteacher, "active" => false),
    array("id" => "moodle", "text" => "Moodle", "content" => $fmoodle, "active" => false),
);

$tabs = new Tabs($tabs);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
    "header-title" => $course["name"],
    "content" => $tabs,
    "header-print" => "/sie/courses/print/" . $oid,
    "header-back" => "/sie/teachers/list/" . lpk(),
));
echo($card);

$data = $parent->get_Array();
echo(view($component . '\students', $data));
?>
<?php include("modals.php"); ?>
<?php include("javascript.php"); ?>