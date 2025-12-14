<?php
$b = service("bootstrap");
$musers = model('App\Modules\Security\Models\Security_Users_Fields');
$alias = $musers->get_AliasByUser($oid);
$menu = array(
    array("href" => "/security/", "text" => "Security", "class" => false),
    array("href" => "/security/users/list/" . lpk(), "text" => lang("App.Users"), "class" => false),
    array("href" => "/security/users/view/{$oid}?t=" . lpk(), "text" => "@{$alias}", "class" => false),
    array("href" => "/security/hierarchies/edit/{$oid}?t=" . lpk(), "text" => lang("App.Hierarchies"), "class" => "active"),
);
echo($b->get_Breadcrumb($menu));
?>