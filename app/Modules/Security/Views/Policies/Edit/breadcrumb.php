<?php
$b = service("bootstrap");
$mroles = model('App\Modules\Security\Models\Security_Roles');
$rol = $mroles->where('rol', $oid)->first();
$menu = array(
    array("href" => "/security/", "text" => "Security", "class" => false),
    array("href" => "/security/roles/list/" . lpk(), "text" => lang("App.Roles"), "class" => false),
    array("href" => "/security/roles/view/{$oid}?t=" . lpk(), "text" => $rol['name'], "class" => false),
    array("href" => "/security/policies/edit/{$oid}?t=" . lpk(), "text" => lang("App.Hierarchies"), "class" => "active"),
);
echo($b->get_Breadcrumb($menu));
?>