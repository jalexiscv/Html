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
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Sie') / 102400), 6);

$card = $bootstrap->get_Card2("card-view-Sie", array(
    "class" => "mb-3",
    "header-title" => lang("Sie_Moodle.home-title"),
    "header-back" => "/",
    "image-class" => "img-fluid p-3",
    "alert" => array(
        "type" => "info",
        "class" => "alert alert-info",
        "icon" => ICON_INFO,
        "title" => lang("Settings.sie-settings-title"),
        "message" => lang("Sie_Moodle.home-message")
    )
));
echo($card);

if ($authentication->get_LoggedIn()) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/moodle/users/synchronization?t=".pk(), "icon" => ICON_USERS, "value" => lang("Sie_Moodle.synchronization-users"), "description" =>lang("Sie_Moodle.synchronization-users-description") )));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/moodle/courses/synchronization?t=".pk(), "icon" => ICON_COURSES, "value" => lang("Sie_Moodle.synchronization-courses"), "description" =>lang("Sie_Moodle.synchronization-courses-description") )));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/moodle/registrations/create/".pk(), "icon" => ICON_COURSES, "value" => lang("Sie_Moodle.registration-course"), "description" =>lang("Sie_Moodle.registration-course-description") )));
    echo($shortcuts);
} else {

}
?>