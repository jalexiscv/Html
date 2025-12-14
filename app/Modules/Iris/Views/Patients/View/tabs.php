<?php

use App\Libraries\Html\Bootstrap\Tabs;

/** @var string $oid */
/** @var object $parent */
$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mpatients = model('App\Modules\Iris\Models\Iris_Patients');
//[vars]----------------------------------------------------------------------------------------------------------------
$data = $parent->get_Array();
$fprofile = view("{$data["component"]}\\Tabs\\profile", $data);
$fhistory = view("{$data["component"]}\\Tabs\\history", $data);

$tabs = array(
        array("id" => "profile", "icon" => ICON_USER, "content" => $fprofile, "class" => "fs-3", "active" => true),
        array("id" => "history", "icon" => ICON_HISTORY, "content" => $fhistory, "class" => "fs-3", "active" => false),
);

$patient = $mpatients->getPatient($oid);
$fullname = @$patient["fullname"];
$tabs = new Tabs($tabs);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
        "header-title" => sprintf("Paciente: %s", $fullname),
        "content" => $tabs,
        "header-back" => "/iris/patients/list/" . lpk(),
        "header-edit" => "/iris/patients/edit/" . $oid,
        "header-delete" => "/iris/patients/delete/" . $oid,
));
echo($card);
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.title = "<?php echo($fullname);?>";
    });
</script>