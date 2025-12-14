<?php

use App\Libraries\Html\Bootstrap\Tabs;

/** @var string $oid */
/** @var object $parent */
$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sgd\Models\Sgd_Registrations");
//[vars]----------------------------------------------------------------------------------------------------------------
$data = $parent->get_Array();
$data["row"]= $mregistrations->getRegistration($oid);

$cgeneral = view("{$data["component"]}\\Tabs\\general", $data);
$cfiled = view("{$data["component"]}\\Tabs\\filed", $data);
$cresponsible = view("{$data["component"]}\\Tabs\\responsible", $data);
$tabs = array(
    array("id" => "cgeneral", "icon" => ICON_BOX, "content" => $cgeneral, "class" => "fs-3", "active" => true),
    array("id" => "cfiled", "icon" => ICON_GEO, "content" => $cfiled, "class" => "fs-3", "active" => false),
    array("id" => "cresponsible", "icon" => ICON_RESPONSIBLE, "content" => $cresponsible, "class" => "fs-3", "active" => false),
);
$tabs = new Tabs($tabs);
//[build]---------------------------------------------------------------------------------------------------------------
$back= "/sgd/registrations/list/".lpk();
$card = $bootstrap->get_Card2("create", array(
    "header-title" => sprintf("Radicado: %s", $oid),
    "content" => $tabs,
    "header-back" => "/sgd/registrations/list/" . lpk(),
    "header-edit" => "/sgd/registrations/edit/" . $oid,
    "header-delete" => "/sgd/registrations/delete/" . $oid,
));
echo($card);

$files= $bootstrap->get_Card2("create", array(
    "header-title" => "Archivos",
    "content" =>view('App\Modules\Sgd\Views\Registrations\View\files',array("oid"=>$oid)),
    "header-back" =>$back
));
echo($files);
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.title = "<?php echo($oid);?>";
    });
</script>