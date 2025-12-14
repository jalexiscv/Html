<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                                                    2024-02-12 10:12:28
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Home\breadcrumb.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2024 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                                                                         consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
generate_sie_permissions($module);
$server = service("server");
$bootstrap = service("bootstrap");
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Sie') / 1024000), 6);


if ($authentication->get_LoggedIn()) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/enrollments/home/" . lpk(), "icon" => ICON_STUDENTS, "value" => "Matrícula", "description" => "")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/students/list/" . lpk(), "icon" => ICON_STUDENTS, "value" => "Estudiantes", "description" => "")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/registrations/list/" . lpk(), "icon" => ICON_STUDENTS, "value" => "Preinscripciones", "description" => "")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/teachers/list/" . lpk(), "icon" => ICON_TEACHERS, "value" => "Profesores", "description" => "")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/programs/list/" . lpk(), "icon" => ICON_ACADEMIC_PROGRAMS, "value" => "Programas", "description" => "")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/modules/list/" . lpk(), "icon" => ICON_MODULES, "value" => "Módulos", "description" => "")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/courses/list/" . lpk(), "icon" => ICON_COURSES, "value" => "Cursos", "description" => "")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/financial/home/" . lpk(), "icon" => "fa-light fa-money-check-dollar", "value" => "Financiero", "description" => "")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/home/" . lpk(), "icon" => "fa-light fa-address-card", "value" => "SNIES", "description" => "")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/tools/snies/" . lpk(), "icon" => "fa-light fa-address-card", "value" => "Actualización", "description" => "")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/graduations/list/" . lpk(), "icon" => ICON_DIPLOMA, "value" => "Postulaciones", "description" => "")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/agreements/list/" . lpk(), "icon" => "fa-light fa-rocket-launch", "value" => "Convenios", "description" => "Componente")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/registrations/list/" . lpk(), "icon" => "fa-light fa-list-check", "value" => "Preinscripciones", "description" => "Componente")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/certifications/home/" . lpk(), "icon" => "fa-light fa-file-certificate", "value" => "Certificaciones", "description" => "")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/reports/home/" . lpk(), "icon" => "fa-light fa-file-chart-column", "value" => "Reportes", "description" => "Componente")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/enrollments/home/" . lpk(), "icon" => "fa-light fa-address-card", "value" => "Matriculas", "description" => "Componente")));
    echo($shortcuts);
} else {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/registrations/create/fullscreen/?" . lpk(), "icon" => ICON_TOOLS, "value" => "Preinscripciones", "description" => "Formato")));
    echo($shortcuts);
}
//[history-logger]------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "SIE",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "HOME",
    "log" => "El usuario accede a la vista principal del <b>Módulo SIE</b>",
));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("card-view-Sie", array(
    "class" => "mb-3",
    "header-title" => lang("Sie.module") . ": <span class='text-muted'>v{$version}</span>",
    "header-back" => "/",
    //"alert" =>array("type" => "success", "title" => "title","message" => "message"),
    "image" => "/themes/assets/images/header/logo-sie.png?v=3",
    "image-class" => "img-fluid p-3",
    "content" => lang("Sie.intro-1")
));
//echo($card);
?>