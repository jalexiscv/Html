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
$card = $bootstrap->get_Card2("card-view-Standards", array(
    "class" => "mb-3",
    "header-title" => lang("Standards.module") . "<span class='text-muted'>v{$version}</span>",
    "header-back" => "/",
    "image" => "/themes/assets/images/header/standards.png",
    "image-class" => "img-fluid p-3",
    "content" => lang("Standards.intro-1")
));
echo($card);

if ($authentication->get_LoggedIn() && $authentication->has_Permission("standards-access")) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/standards/objects/list/" . lpk(), "icon" => ICON_TOOLS, "value" => "Listado", "description" => "Normatividades")));
    echo($shortcuts);
}

?>