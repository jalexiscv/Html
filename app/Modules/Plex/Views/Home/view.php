<?php

//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
generate_plex_permissions($module);
$bootstrap = service("bootstrap");
$server = service("server");
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Plex') / 102400), 6);


if ($authentication->get_LoggedIn() && $authentication->has_Permission("plex-access")) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/plex/clients/list/" . lpk(), "icon" => ICON_CLIENTS, "value" => "Clientes", "description" => "Componente")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/plex/settings/home/" . lpk(), "icon" => ICON_TOOLS, "value" => "Configuración", "description" => "Componente")));
    $card = $bootstrap->get_Card("card-view-Plex", array(
        "class" => "mb-3",
        "title" => lang("App.Components"),
        "content" => $shortcuts,
    ));
    echo($card);
}

$card = $bootstrap->get_Card("card-view-Plex", array(
    "class" => "mb-3",
    "title" => lang("Plex.module") . " <span class='text-muted'>v{$version}</span>",
    "image" => "/themes/assets/images/header/plex.svg",
    "image-class" => "img-fluid p-3",
    "content" => lang("Plex.intro-1") . " " . lang("Plex.more-info"),
));
echo($card);


?>