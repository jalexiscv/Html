<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                                                    2024-02-12 00:44:18
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iso45001\Home\breadcrumb.php]
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
generate_iso45001_permissions($module);
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-Iso45001", array(
    "class" => "mb-3",
    "title" => lang("Iso45001.module") . "",
    "header-back" => "/",
    "image" => "/themes/assets/images/header/module-iso45001.svg",
    "image-class" => "img-fluid p-3",
    "content" => lang("Iso45001.intro-1")
));
echo($card);


$cliente = @$_GET['cliente'];

if (empty($cliente)) {
    if ($authentication->get_LoggedIn() && $authentication->has_Permission("iso9001-access")) {
        $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
        $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/iso9001/requirements/home/" . lpk(), "icon" => ICON_REQUIREMENTS, "value" => "Requisitos", "description" => "ISO9001:2015")));
        $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/#" . lpk(), "icon" => ICON_CHARTS, "value" => "Control", "description" => "Herramienta")));
        $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/#" . lpk(), "icon" => ICON_HISTORY, "value" => "Historial", "description" => "Módulo")));
        echo($shortcuts);
    }
}

?>