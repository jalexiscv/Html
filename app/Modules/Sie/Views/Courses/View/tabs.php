<?php

use App\Libraries\Html\Bootstrap\Tabs;

//[models]--------------------------------------------------------------------------------------------------------------
$mcourses = model("App\Modules\Sie\Models\Sie_Courses");
//[vars]----------------------------------------------------------------------------------------------------------------
/** @var String $oid */
/** @var Object $parent */
$course = $mcourses->get_Course($oid);
//[builds]--------------------------------------------------------------------------------------------------------------
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
$bootstrap = service('bootstrap');

$data = $parent->get_Array();

$fcourse = view('App\Modules\Sie\Views\Courses\View\Tabs\course', $data);
$fmoodle = view('App\Modules\Sie\Views\Courses\View\Tabs\moodle', $data);

$tabs = array(
    array("id" => "course", "text" => "Curso", "content" => $fcourse, "active" => true),
    array("id" => "moodle", "text" => "Moodle", "content" => $fmoodle, "active" => false),
);

$tabs = new Tabs($tabs);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
    "header-title" => $course["name"],
    "content" => $tabs,
    "header-back" => "/sie/teachers/list/" . lpk(),
));
echo($card);
?>