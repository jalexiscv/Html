<?php
$server = service("server");
$bootstrap = service("bootstrap");
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Settings') / 102400), 6);

generate_settings_permissions();

if ($authentication->get_LoggedIn() && $authentication->has_Permission("settings-access")) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/settings/logos/view/" . lpk(), "icon" => ICON_LOGOS, "value" => "Logotipos", "description" => "Herramienta")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/settings/countries/list/" . lpk(), "icon" => ICON_COUNTRIES, "value" => "Paises", "description" => "Listado")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/plex/settings/home/" . lpk(), "icon" => ICON_TOOLS, "value" => "Configuración", "description" => "Componente")));
    $card = $bootstrap->get_Card("card-view-Plex", array(
        "class" => "mb-3",
        "title" => lang("App.Components"),
        "content" => $shortcuts,
    ));
    echo($card);
}

$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => lang('Settings.Module') . ": <span class='text-muted'>v{$version}</span>",
    "header-back" => "/",
    "image" => "/themes/assets/images/header/settings.svg?v3",
    "content" => lang("Settings.intro-1")
));
echo($card);
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.title = "Configuración";
    });
</script>
