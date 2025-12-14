<?php
$authentication = service("authentication");
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "class" => "mb-3",
    "title" => lang("App.Module-Development") . "",
    "header-back" => "/",
    "image" => "/themes/assets/images/header/development.png",
    "image-class" => "img-fluid p-3",
    "content" => lang("Cadastre.intro-1")
));
echo($card);

if ($authentication->get_LoggedIn() && $authentication->has_Permission("SECURITY-ACCESS")) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/development/tools/modules/generator/" . lpk(), "icon" => ICON_TOOLS, "value" => "Módulos", "description" => "Generador")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/development/tools/texttophp/generator/" . lpk(), "icon" => ICON_TOOLS, "value" => "Texto a PHP", "description" => "Convertidor")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/development/tools/poeditor/generator/" . lpk(), "icon" => ICON_TOOLS, "value" => "PoEditor", "description" => "Traductor")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/development/webpack/home/" . lpk(), "icon" => ICON_EXE, "value" => "WebPack", "description" => "Empaquetador")));

    echo($shortcuts);
}
?>