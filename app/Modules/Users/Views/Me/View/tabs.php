<?php

use App\Libraries\Html\Bootstrap\Tabs;

/** @var string $registration */
/** @var string $type */
/** @var object $parent */
$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mcountries = model("App\Modules\Sie\Models\Sie_Countries");
$mregions = model("App\Modules\Sie\Models\Sie_Regions");
$mcities = model("App\Modules\Sie\Models\Sie_Cities");
//[vars]----------------------------------------------------------------------------------------------------------------
$data = $parent->get_Array();
$data["registration"] = $registration;

$fullname ="";

$tabs = array();



if(!empty($type)){
    if($type=="TEACHER"){
        $fcourses = view("{$data["component"]}\\Tabs\\Courses\\teacher", $data);
        $tabs[] = array("id" => "docente", "text" => "Docente", "content" => $fcourses, "class" => "", "active" => true);
    }
}

if(!empty($registration)){
    $registration = $mregistrations->getRegistration($registration);
    $fullname = @$registration["first_name"]." ".@$registration["second_name"]." ".@$registration["first_surname"]." ".@$registration["second_surname"];
    $fprofile = view("{$data["component"]}\\Tabs\\profile", $data);
    $ffiles = view("{$data["component"]}\\Tabs\\files", $data);
    $ffinance = view("{$data["component"]}\\Tabs\\finance", $data);
    $fenrollments = view("{$data["component"]}\\Tabs\\enrollments", $data);
    $tabs[] = array("id" => "profile", "text" => "Perfil Estudiantil", "content" => $fprofile, "class" => "", "active" => false);
    //$tabs[] = array("id" => "files", "text" => "Documentos", "content" => $ffiles, "class" => "", "active" => false);
    //$tabs[] = array("id" => "finance", "text" => "Facturas", "content" => $ffinance, "class" => "", "active" => false);
    $tabs[] = array("id" => "enrollments", "text" => "Matrículas", "content" => $fenrollments, "class" => "", "active" => false);
}





$tabs = new Tabs($tabs);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => sprintf("Bienvenido: %s", $fullname),
    "content" => $tabs,
));
echo($card);
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.title = "<?php echo($fullname);?>";
    });
</script>
