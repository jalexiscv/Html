<?php

use App\Libraries\Html\Bootstrap\Tabs;

/** @var string $oid */
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
$fprofile = view("{$data["component"]}\\Tabs\\profile", $data);
$fsnies = view("{$data["component"]}\\Tabs\\snies", $data);
$ffiles = view("{$data["component"]}\\Tabs\\files", $data);
//$finterview = view("{$data["component"]}\\Tabs\\interview", $data);
$fdiscounts = view("{$data["component"]}\\Tabs\\discounts", $data);
$fobservations = view("{$data["component"]}\\Tabs\\observations", $data);
$ffinance = view("{$data["component"]}\\Tabs\\finance", $data);
$fregionalization = view("{$data["component"]}\\Tabs\\regionalization", $data);
$fstatus = view("{$data["component"]}\\Tabs\\status", $data);
$fenrollments = view("{$data["component"]}\\Tabs\\enrollments", $data);
$fupdating = view("{$data["component"]}\\Tabs\\updating", $data);
$fstatuses = view("{$data["component"]}\\Tabs\\statuses", $data);
$ftools = view("{$data["component"]}\\Tabs\\Tools\\index", $data);
$fmoodle = view("{$data["component"]}\\Tabs\\moodle", $data);
$fcertificates = view("{$data["component"]}\\Tabs\\certificates", $data);

$tabs = array(
        array("id" => "profile", "icon" => ICON_USER, "content" => $fprofile, "class" => "fs-3", "active" => true),
        array("id" => "regionalization", "icon" => ICON_GEO, "content" => $fregionalization, "class" => "fs-3", "active" => false),
        array("id" => "snies", "icon" => ICON_SNIES, "content" => $fsnies, "class" => "fs-3", "active" => false),
        array("id" => "observations", "icon" => ICON_OBSERVATIONS, "content" => $fobservations, "class" => "fs-3", "active" => false),
    //array("id" => "interview", "icon" => ICON_INTERVIEW, "content" => $finterview, "class" => "fs-3", "active" => false),
        array("id" => "files", "icon" => ICON_ATTACH_FILE, "content" => $ffiles, "class" => "fs-3", "active" => false),
        array("id" => "discounts", "icon" => ICON_DISCOUNTS, "content" => $fdiscounts, "class" => "fs-3", "active" => false),
        array("id" => "finance", "icon" => ICON_MONEY, "content" => $ffinance, "class" => "fs-3", "active" => false),
    //array("id" => "status", "icon" => ICON_STATUS, "content" => $fupdating, "class" => "fs-3", "active" => false),
        array("id" => "enrollments", "icon" => ICON_ENROLL, "content" => $fenrollments, "class" => "fs-3", "active" => false),
        array("id" => "statuses", "icon" => ICON_STATUSES, "content" => $fstatuses, "class" => "fs-3", "active" => false),
        array("id" => "tools", "icon" => ICON_SETTINGS, "content" => $ftools, "class" => "fs-3", "active" => false),
        array("id" => "certificates", "icon" => ICON_CERTIFICATIONS, "content" => $fcertificates, "class" => "fs-3", "active" => false),
        array("id" => "moodle", "icon" => ICON_MOODLE, "content" => $fmoodle, "class" => "fs-3", "active" => false),
);

$registration = $mregistrations->getRegistration($oid);
$fullname = "{$registration["first_name"]} {$registration["second_name"]} {$registration["first_surname"]} {$registration["second_surname"]}";
$tabs = new Tabs($tabs);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
        "title" => sprintf("Estudiante: %s", $fullname),
        "content" => $tabs,
        "header-back" => "/sie/students/list/" . lpk(),
        "header-edit" => "/sie/students/edit/" . $oid,
        "header-delete" => "/sie/registrations/delete/" . $oid,
));
echo($card);
//[history-logger]------------------------------------------------------------------------------------------------------
history_logger(array(
        "module" => "SIE",
        "type" => "ACCESS",
        "reference" => "COMPONENT",
        "object" => "STUDENTS-VIEW",
        "log" => "El usuario accede al perfil del estudiante <b><i>{$fullname}</i></b>",
));
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.title = "<?php echo($fullname);?>";
    });
</script>
