<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                                                    2024-02-12 12:27:23
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Edux\Home\breadcrumb.php]
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
generate_edux_permissions($module);
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-Edux", array(
    "class" => "mb-3",
    "title" => lang("Edux.module") . "",
    "header-back" => "/",
    "image" => "/themes/assets/images/header/module-edux.png",
    "image-class" => "img-fluid p-3",
    "content" => lang("Edux.intro-1")
));
//echo($card);

if ($authentication->get_LoggedIn()) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "https://campus.utede.edu.co", "icon" => ICON_CAMPUS, "value" => "Campus", "description" => "Educativo", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/library/resources/list/" . lpk(), "icon" => ICON_LIBRARY, "value" => "Repositorio", "description" => "Archivo Online")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/furag", "icon" => ICON_FURAG, "value" => "F.U.R.A.G", "description" => "Herramienta")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "https://utede.edu.co", "icon" => ICON_PORTAL, "value" => "Portal", "description" => "Corporativo", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "https://ita.edu.co/contacto/login", "icon" => ICON_PQRSD, "value" => "P.Q.R.S.D", "description" => "Solicitudes", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "https://site2.q10.com/login", "icon" => ICON_Q10, "value" => "Q10", "description" => "Calificaciones", "target" => "_blank")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sedux/modules/list/" . lpk(), "icon" => ICON_MODULES, "value" => "Módulos", "description" => "Académicos")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sedux/teachers/list/" . lpk(), "icon" => ICON_TEACHERS, "value" => "Profesores", "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/edux/men/home/" . lpk(), "icon" => ICON_MEN, "value" => "M.E.N", "description" => "Herramienta")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sedux/agreements/list/" . lpk(), "icon" => ICON_DIRECTIVE, "value" => "Consejo", "description" => "Directivo")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/helpdesk/home/index/" . lpk(), "icon" => ICON_SUPPORT, "value" => "Soporte", "description" => "Herramienta")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/users/me/view/" . lpk(), "icon" => ICON_USER, "value" => "Estudiante", "description" => "Información")));
    echo($shortcuts);
    //+[Logger]------------------------------------------------------------------------------------------------------------
    history_logger(array(
        "module" => "EDUX",
        "type" => "ACCESS",
        "reference" => "COMPONENT",
        "object" => "HOME",
        "log" => "El usuario accede a la vista principal del Módulo Edux",
    ));
} else {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "https://campus.utede.edu.co", "icon" => ICON_CAMPUS, "value" => "Campus", "description" => "Educativo", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "https://utede.edu.co", "icon" => ICON_PORTAL, "value" => "Portal", "description" => "Corporativo", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "https://ita.edu.co/contacto/login", "icon" => ICON_PQRSD, "value" => "P.Q.R.S.D", "description" => "Solicitudes", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "https://site2.q10.com/login", "icon" => ICON_Q10, "value" => "Q10", "description" => "Calificaciones", "target" => "_blank")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/helpdesk/home/index/" . lpk(), "icon" => ICON_SUPPORT, "value" => "Soporte", "description" => "Herramienta")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/users/me/view/" . lpk(), "icon" => ICON_USER, "value" => "Estudiante", "description" => "Información")));
    echo($shortcuts);
}

?>
