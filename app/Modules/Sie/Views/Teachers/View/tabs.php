<?php

use App\Libraries\Html\Bootstrap\Tabs;

$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
$bootstrap = service('bootstrap');
$data = $parent->get_Array();

$profile = $mfields->get_Profile($oid);

$fprofile = view('App\Modules\Sie\Views\Teachers\View\Tabs\profile', $data);
$fevaluation = "";//view('App\Modules\Sie\Views\Teachers\View\Tabs\evaluation', $data);
$fcourses = view('App\Modules\Sie\Views\Teachers\View\Tabs\courses', $data);
$fmoodle = view('App\Modules\Sie\Views\Teachers\View\Tabs\moodle', $data);

$tabs = array(
        array("id" => "profile", "text" => "Perfil", "content" => $fprofile, "active" => true),
        array("id" => "courses", "text" => "Cursos", "content" => $fcourses, "active" => false),
        array("id" => "evaluation", "text" => "Evaluación de ingreso", "content" => $fevaluation, "active" => false),
        array("id" => "moodle", "text" => "Moodle", "content" => $fmoodle, "active" => false),
);


$tabs = new Tabs($tabs);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
        "header-title" => $profile["name"],
        "content" => $tabs,
        "header-back" => "/sie/teachers/list/" . lpk(),
));
echo($card);
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.title = "<?php echo($profile["name"]);?>";
    });
</script>