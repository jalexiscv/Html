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
    "header-title" => lang("Settings.sie-settings-title"),
    "header-back" => "/",
    "image-class" => "img-fluid p-3",
    "alert" => array(
        "type" => "info",
        "class" => "alert alert-info",
        "icon" => ICON_INFO,
        "title" => lang("Settings.sie-settings-title"),
        "message" => lang("Settings.sie-settings-message")
    )
));
echo($card);

if ($authentication->get_LoggedIn()) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/models/list/" . lpk(), "icon" => ICONS_MODELS, "value" => lang("App.Models"), "description" => lang("App.Academics"))));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/products/list/" . lpk(), "icon" => ICON_PRODUCTS, "value" => lang("App.Products"), "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/discounts/list/" . lpk(), "icon" => ICON_DISCOUNTS, "value" => lang("App.Discounts"), "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/settings/contact/" . lpk(), "icon" => ICON_AGREEMENTS, "value" => "Información", "description" => "Corporativa")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/agreements/list/" . lpk(), "icon" => ICON_AGREEMENTS, "value" => lang("App.Agreements"), "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/institutions/list/" . lpk(), "icon" => ICON_INSTITUTIONS, "value" => lang("App.Institutions"), "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/spaces/list/" . lpk(), "icon" => ICON_WAYPONT, "value" => lang("App.Spaces"), "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/headquarters/list/" . lpk(), "icon" => ICON_HEADQUARTERS, "value" => lang("App.Headquarters"), "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/graduations/settings/view/" . lpk(), "icon" => ICON_GRADUATIONS, "value" => lang("Sie.Graduations"), "description" => "Parametros & Estado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/registrations/settings/view/" . lpk(), "icon" => ICON_SETTINGS, "value" => "Inscripciones", "description" => "Estado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/networks/list/" . lpk(), "icon" => ICON_SETTINGS, "value" => "Redes de Conocimiento", "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/settings/formats/" . lpk(), "icon" => ICON_SETTINGS, "value" => "Formatos Documentos", "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/settings/moodle/" . lpk(), "icon" => ICON_SETTINGS, "value" => "LMS", "description" => "Moodle")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/sie/formats/list/" . lpk(), "icon" => ICON_GRADUATIONS, "value" => "Certificados", "description" => "Modelos")));
    echo($shortcuts);
} else {

}
?>