<?php

use App\Libraries\Html\Bootstrap\Tabs;

$massets = model('App\Modules\Maintenance\Models\Maintenance_Assets');
$asset = $massets->getAsset($oid);

$bootstrap = service('bootstrap');
$data = $parent->get_Array();

$fprofile = view($component . '\Tabs\profile', $data);
$fmaintenances = view($component . '\Tabs\maintenances', $data);

$tabs = array(
        array("id" => "profile", "text" => "Perfil", "content" => $fprofile, "active" => true),
        array("id" => "courses", "text" => "Mantenimientos", "content" => $fmaintenances, "active" => false),
);


$tabs = new Tabs($tabs);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
        "header-title" => $asset["name"],
        "content" => $tabs,
        "header-back" => "/maintenance/assets/list/" . lpk(),
));
echo($card);
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.title = "<?php echo($asset["name"]);?>";
    });
</script>
