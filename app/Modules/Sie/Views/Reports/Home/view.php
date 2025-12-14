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
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/biller/" . lpk(), "icon" => ICON_COINS, "value" => "Prematricula", "description" => "Financiera", "target" => "_blank", "class" => "text-danger")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/registrations/" . lpk() . "?status=ADMITTED", "icon" => ICON_REGISTRATIONS, "value" => "Inscripciones", "description" => "2026A", "class" => "text-danger", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/participants/students?t=" . lpk(), "icon" => "fa-light fa-person-chalkboard", "value" => "Estudiantes", "description" => "Participantes #N/A", "target" => "_self", "class" => "text-warning")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/teachers/" . lpk(), "icon" => ICON_TEACHERS, "value" => "Profesores", "description" => "Reporte", "class" => "text-warning", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/observations/general?t=" . lpk(), "icon" => "fa-light fa-folder-tree", "value" => "Observaciones", "description" => "Reporte General", "class" => "text-warning", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/invoicing/" . lpk(), "icon" => ICON_SETTINGS, "value" => "Facturación", "description" => "Reporte", "class" => "text-warning", "target" => "_blank")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/admissions/2025A", "icon" => ICON_REPORTS, "value" => "Admitidos", "description" => "2025A","target" => "_blank")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/programs/2025A" . lpk(), "icon" => ICON_REPORTS, "value" => "Matriculados ", "description" => "Programa", "class" => "","target" => "_blank")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/evalteachers/" . lpk(), "icon" => ICON_REPORTS, "value" => "Profesores", "description" => "Evaluaciones","target" => "_blank")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "#" . lpk(), "icon" => ICON_REPORTS, "value" => "SNIES", "description" => "Reporte", "class" => "text-danger opacity-50","target" => "_blank")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "#" . lpk(), "icon" => ICON_REPORTS, "value" => "SNIES", "description" => "Caracterización", "class" => "text-danger opacity-50","target" => "_blank")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "#" . lpk(), "icon" => ICON_REPORTS, "value" => "Regional", "description" => "Admitidos", "class" => "text-danger opacity-50","target" => "_blank")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "#" . lpk(), "icon" => ICON_REPORTS, "value" => "Notas", "description" => "Profesores", "class" => "text-danger opacity-50","target" => "_blank")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "#" . lpk(), "icon" => ICON_REPORTS, "value" => "Estudiantes  ", "description" => "Extensión", "class" => "text-danger opacity-50","target" => "_blank")));
    //-----------$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/teachers/report/" . lpk(), "icon" => ICON_REPORTS, "value" => "Profesores  ", "description" => "Notas", "class" => "text-success", "target" => "_blank")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/snies/enrolleds/" . lpk(), "icon" => "fa-light fa-dice-d12", "value" => "SNIES  ", "description" => "Matriculados", "class" => "text-success","target" => "_blank")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/snies/coursesenrolled/" . lpk(), "icon" => "fa-light fa-dice-d12", "value" => "Materias ", "description" => "Matriculadas", "class" => "text-success", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/snies/coursed/" . lpk(), "icon" => "fa-light fa-dice-d12", "value" => "Materias ", "description" => "", "class" => "text-success", "target" => "_blank")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/enrolleds/" . lpk(), "icon" => "fa-light fa-dice-d12", "value" => "SNIES ", "description" => "Matriculados", "class" => "text-success", "target" => "_blank")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/participants/" . lpk(), "icon" => "fa-light fa-dice-d12", "value" => "Participantes", "description" => "", "class" => "text-success", "target" => "_blank")));
    // SNIES
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/participants/" . lpk(), "icon" => ICON_REPORTS, "value" => "Participantes", "description" => "SNIES 55", "class" => "text-warning", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/population/home?t=" . lpk(), "icon" => "fa-light fa-folder-tree", "value" => "Población", "description" => "Estudiantil", "class" => "text-success", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/humanresources/home?t=" . lpk(), "icon" => "fa-light fa-folder-tree", "value" => "Recursos", "description" => "Humanos", "class" => "text-success", "target" => "_self")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/control/home?t=" . lpk(), "icon" => "fa-light fa-folder-tree", "value" => "Registro & Control", "description" => "Instituciónal", "class" => "text-success", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/courses/home?t=" . lpk(), "icon" => "fa-light fa-folder-tree", "value" => "Cursos", "description" => "Reportes", "class" => "text-success", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/statistics/home?t=" . lpk(), "icon" => "fa-light fa-folder-tree", "value" => "Estadística", "description" => "Reportes", "class" => "text-success", "target" => "_blank")));
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