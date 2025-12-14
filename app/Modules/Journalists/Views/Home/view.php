<?php

//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */

generate_journalists_permissions($module);
$bootstrap = service("bootstrap");
$server = service("server");
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Journalists') / 102400), 6);
$card = $bootstrap->get_Card("card-view-Journalists", array(
    "class" => "mb-3",
    "title" => lang("Journalists.module") . "<span class='text-muted'>v{$version}</span>",
    "header-back" => "/",
    "image" => "/themes/assets/images/header/feriadebuga.png",
    "image-class" => "img-fluid p-3",
    "content" => lang("Journalists.intro-1")
));

$shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
if ($authentication->get_LoggedIn() && $authentication->has_Permission("journalists-access")) {
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/journalists/invitations/list/" . lpk(), "icon" => ICON_TOOLS, "value" => "Invitaciones", "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/journalists/list/" . lpk(), "icon" => ICON_TOOLS, "value" => "Periodistas", "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/journalists/journalists/prints/".lpk(), "icon" => ICON_TOOLS, "value" => "Impresiones", "description" => "Formato")));
}
$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/journalists/create/" . lpk(), "icon" => ICON_TOOLS, "value" => "Registro", "description" => "Periodistas")));
echo($shortcuts);
echo($card);
?>