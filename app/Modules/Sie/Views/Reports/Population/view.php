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

if ($authentication->get_LoggedIn()) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/admissions/" . lpk(), "icon" => "fa-sharp fa-light fa-flag-checkered", "value" => "Admitidos", "description" => "SNIES R#59", "class" => "text-success", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/enrolleds/" . lpk(), "icon" => ICON_REPORTS, "value" => "Matriculados", "description" => "SNIES R#61", "class" => "text-success", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/firstyear/" . lpk(), "icon" => "fa-light fa-dice-d12", "value" => "Primer Curso", "description" => "SNIES R#62", "class" => "text-success", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/snies/graduateds/" . lpk(), "icon" => ICON_REPORTS, "value" => "Graduados", "description" => "SNIES R#68", "class" => "text-success", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/projected/home?t=" . lpk(), "icon" => ICON_REPORTS, "value" => "Cupos Proyectados", "description" => "SNIES R#75", "class" => "text-success", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/enrolledcourses/home?t=" . lpk(), "icon" => ICON_REPORTS, "value" => "Materias Matriculadas", "description" => "SNIES R#124", "class" => "text-warning", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/registeredslistregistereds/" . lpk(), "icon" => "fa-light fa-dice-d12", "value" => "Relación Inscritos", "description" => "SNIES R#143", "class" => "text-success", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/registereds/" . lpk() . "?status=ADMITTED", "icon" => "fa-light fa-dice-d12", "value" => "Inscrito Programas", "description" => "SNIES R#144", "class" => "text-success", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/coverage/" . lpk(), "icon" => ICON_REPORTS, "value" => "Estrategias de Cobertura", "description" => "SNIES R#148", "class" => "text-success", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/snies/freeofcharge/" . lpk(), "icon" => "fa-light fa-dice-d12", "value" => "Caracterización-Gratuidad", "description" => "SNIES R#301", "class" => "text-success", "target" => "_blank")));
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