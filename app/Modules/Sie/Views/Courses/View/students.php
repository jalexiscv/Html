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

$fenrolleds = view('App\Modules\Sie\Views\Courses\View\Tabs\enrolleds', $data);
$felegibles = view('App\Modules\Sie\Views\Courses\View\Tabs\elegibles', $data);

$tabs = array(
    array("id" => "enrolleds", "text" => "Matriculados", "content" => $fenrolleds, "active" => true),
    array("id" => "elegibles", "text" => "Elegibles", "content" => $felegibles, "active" => false),
);

$tabs = new Tabs($tabs);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
    "header-title" =>"Estudiantes",
    "content" => $tabs,
    "header-synchronize" => "/sie/tools/moodle/courses/" . $oid,
    "header-add" => "#",
));
echo($card);
?>