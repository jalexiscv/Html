<?php
//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
generate_sie_permissions($module);
$server = service("server");
$bootstrap = service("bootstrap");
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Sie') / 102400), 6);

/**
 * Inscrito Programa - 144
 * Inscrito - relación inscrito - 143
 * Estudiantes de primer curso - 62
 * Admitidos - 59
 * Participantes - 55
 * Matriculados - 61
 * Estudiantes de estrategias de cobertura - 148
 * Graduados - 68
 * Cupos proyectados y matricula esperada - 75
 * Plantilla caracterización politica de gratuidad IES publicas - 301
 * **/


if ($authentication->get_LoggedIn()) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/statistics/general?t=" . lpk(), "icon" => "fa-light fa-folder-tree", "value" => "Población", "description" => "Total", "class" => "text-success", "target" => "_blank")));
    echo($shortcuts);
} else {
}

$card = $bootstrap->get_Card("card-view-Sie", array(
    "class" => "mb-3",
    "title" => lang("Sie.module") . ": <span class='text-muted'>v{$version}</span>",
    "header-back" => "/",
    "image" => "/themes/assets/images/header/logo-sie.png?v=3",
    "image-class" => "img-fluid p-3",
    "content" => lang("Sie.intro-1")
));
//echo($card);
?>