<?php

//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
generate_sgd_permissions($module);
$bootstrap = service("bootstrap");
$server = service("server");
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Standards') / 102400), 6);
$card = $bootstrap->get_Card("card-view-Standards", array(
    "class" => "mb-3",
    "title" => lang("Standards_Settings.settings_title"),
    "header-back" => "/",
    "content" => lang("Standards_Settings.settings_description"),
));
echo($card);

if ($authentication->get_LoggedIn() && $authentication->has_Permission("sgd-access")) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/standards/categories/list/" . lpk(), "icon" => ICON_TOOLS, "value" => "Categorías", "description" => "Listado")));
    echo($shortcuts);
}

?>