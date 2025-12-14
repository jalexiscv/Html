<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                                                    2024-03-20 18:43:50
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\History\Home\breadcrumb.php]
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
generate_history_permissions($module);
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-History", array(
    "class" => "mb-3",
    "title" => lang("History.module") . "",
    "header-back" => "/",
    "image" => "/themes/assets/images/header/module-history.png",
    "image-class" => "img-fluid p-3",
    "content" => lang("History.intro-1")
));
echo($card);

if ($authentication->get_LoggedIn() && $authentication->has_Permission("history-access")) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/history/stats/general/" . lpk(), "icon" => ICON_LIST, "value" => "General", "description" => "Listado Total")));
    //$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/history/stats/users/" . lpk(), "icon" => ICON_USERS, "value" => "Usuarios", "description" => "Historial x Usuario")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "https://sites.google.com/view/cgine/history", "icon" => ICON_HELP, "value" => "Ayuda", "description" => "Información", "target" => "_blank")));
    echo($shortcuts);
}
//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "HISTORY",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "HOME",
    "log" => "El usuario accede a la vista principal del Módulo History",
));
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.title = "Historial";
    });
</script>
