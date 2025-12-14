<?php

//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */

$server = service("server");
$bootstrap = service("bootstrap");

$card = $bootstrap->get_Card2("card-view-Sie", array(
    "class" => "mb-3",
    "header-title" => lang("Settings.sie-settings-title"),
    "header-back" => "/",
    "image-class" => "img-fluid p-3",
    "alert" => array(
        "type" => "info",
        "class" => "alert alert-info",
        "icon" => ICON_INFO,
        "title" => lang("Settings.sie-settings-title"),
        "message" => lang("Settings.sie-settings-message")
    )
));
echo($card);

if ($authentication->get_LoggedIn()) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/iris/mstudies/list/" . lpk(), "icon" => ICON_SETTINGS, "value" => lang("Iris.Studies"), "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/iris/categories/list/" . lpk(), "icon" => ICON_SETTINGS, "value" => lang("Iris.Categories"), "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/iris/procedures/list/" . lpk(), "icon" => ICON_SETTINGS, "value" => lang("Iris.Procedures"), "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/iris/modalities/list/" . lpk(), "icon" => ICON_SETTINGS, "value" => lang("Iris.Modalities"), "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/iris/specialties/list/" . lpk(), "icon" => ICON_SETTINGS, "value" => lang("Iris.Specialties"), "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/iris/groups/list/" . lpk(), "icon" => ICON_SETTINGS, "value" => lang("Iris.Groups"), "description" => "Listado")));
    echo($shortcuts);
} else {

}
?>