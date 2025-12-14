<?php

//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
generate_sogt_permissions($module);
$bootstrap = service("bootstrap");
$server = service("server");
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Plex') / 102400), 6);


if ($authentication->get_LoggedIn() && $authentication->has_Permission("sogt-access")) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sogt/telemetry/list/" . lpk(), "icon" => ICON_HISTORY, "value" => "Telemetría", "description" => "Historial")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sogt/devices/list/" . lpk(), "icon" => ICON_CLIENTS, "value" => "Dispositivos", "description" => "Componente")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sogt/operations/list/" . lpk(), "icon" => ICON_CLIENTS, "value" => "Operaciones", "description" => "Componente")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sogt/groups/list/" . lpk(), "icon" => ICON_CLIENTS, "value" => "Grupos", "description" => "Componente")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sogt/maps/home/" . lpk(), "icon" => ICON_MAP, "value" => "Mapas", "description" => "General")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sogt/settings/home/" . lpk(), "icon" => ICON_TOOLS, "value" => "Configuración", "description" => "Componente")));

    $card = $bootstrap->get_Card("card-view-Plex", array(
        "class" => "mb-3",
        "title" => lang("App.Components"),
        "content" => $shortcuts,
    ));
    //echo($card);
    echo($shortcuts);
}

$card = $bootstrap->get_Card("card-view-Plex", array(
    "class" => "mb-3",
    "title" => lang("Sogt.module") . " <span class='text-muted'>v{$version}</span>",
    "image" => "/themes/assets/images/header/logo-sogt.png?v2",
    "image-class" => "img-fluid p-3",
    "content" => lang("Sogt.intro-1") . " " . lang("Sogt.more-info"),
));
echo($card);


?>