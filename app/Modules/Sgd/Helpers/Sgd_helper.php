<?php

if (!function_exists("generate_sgd_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_sgd_permissions(): void
    {
        $permissions = array(
            "sgd-access",
            //[Subseries]-----------------------------------------------------------------------------------------------
            "sgd-subseries-access",
            "sgd-subseries-view",
            "sgd-subseries-view-all",
            "sgd-subseries-create",
            "sgd-subseries-edit",
            "sgd-subseries-edit-all",
            "sgd-subseries-delete",
            "sgd-subseries-delete-all",
            //[Metatags]------------------------------------------------------------------------------------------------
            "sgd-metatags-access",
            "sgd-metatags-view",
            "sgd-metatags-view-all",
            "sgd-metatags-create",
            "sgd-metatags-edit",
            "sgd-metatags-edit-all",
            "sgd-metatags-delete",
            "sgd-metatags-delete-all",
            //[Versions]------------------------------------------------------------------------------------------------
            "sgd-versions-access",
            "sgd-versions-view",
            "sgd-versions-view-all",
            "sgd-versions-create",
            "sgd-versions-edit",
            "sgd-versions-edit-all",
            "sgd-versions-delete",
            "sgd-versions-delete-all",
            //[Units]---------------------------------------------------------------------------------------------------
            "sgd-units-access",
            "sgd-units-view",
            "sgd-units-view-all",
            "sgd-units-create",
            "sgd-units-edit",
            "sgd-units-edit-all",
            "sgd-units-delete",
            "sgd-units-delete-all",
            //[Registrations]-------------------------------------------------------------------------------------------
            "sgd-registrations-access",
            "sgd-registrations-view",
            "sgd-registrations-view-all",
            "sgd-registrations-create",
            "sgd-registrations-edit",
            "sgd-registrations-edit-all",
            "sgd-registrations-delete",
            "sgd-registrations-delete-all",
            //[Centers]----------------------------------------------------------------------------------------
            "sgd-centers-access",
            "sgd-centers-view",
            "sgd-centers-view-all",
            "sgd-centers-create",
            "sgd-centers-edit",
            "sgd-centers-edit-all",
            "sgd-centers-delete",
            "sgd-centers-delete-all",
            //[Shelves]----------------------------------------------------------------------------------------
            "sgd-shelves-access",
            "sgd-shelves-view",
            "sgd-shelves-view-all",
            "sgd-shelves-create",
            "sgd-shelves-edit",
            "sgd-shelves-edit-all",
            "sgd-shelves-delete",
            "sgd-shelves-delete-all",
            //[Boxes]----------------------------------------------------------------------------------------
            "sgd-boxes-access",
            "sgd-boxes-view",
            "sgd-boxes-view-all",
            "sgd-boxes-create",
            "sgd-boxes-edit",
            "sgd-boxes-edit-all",
            "sgd-boxes-delete",
            "sgd-boxes-delete-all",
            //[Folders]----------------------------------------------------------------------------------------
            "sgd-folders-access",
            "sgd-folders-view",
            "sgd-folders-view-all",
            "sgd-folders-create",
            "sgd-folders-edit",
            "sgd-folders-edit-all",
            "sgd-folders-delete",
            "sgd-folders-delete-all",
            //[Files]----------------------------------------------------------------------------------------
            "sgd-files-access",
            "sgd-files-view",
            "sgd-files-view-all",
            "sgd-files-create",
            "sgd-files-edit",
            "sgd-files-edit-all",
            "sgd-files-delete",
            "sgd-files-delete-all",
        );
        generate_permissions($permissions, "sgd");
    }

}

if (!function_exists("get_sgd_sidebar")) {
    function get_sgd_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/sgd/", "svg" => "home.svg"),
            "radication" => array("text" => lang("App.Radication"), "href" => "/sgd/registrations/list/" . lpk(), "icon" => ICON_BOOK, "permission" => "sgd-access"),
            "series" => array("text" => "Series", "href" => "/sgd/series/list/" . lpk(), "icon" => ICON_BOOK, "permission" => "sgd-access"),
            "metadatos" => array("text" => "Metadatos", "href" => "/sgd/metatags/list/" . lpk(), "icon" => ICON_BOOK, "permission" => "sgd-access"),
            //"files" => array("text" => "Archivos", "href" => "/sgd/files/list/" . lpk(), "icon" => ICON_BOOK, "permission" => "sgd-access"),
            "version" => array("text" => lang("App.Version"), "href" => "/sgd/versions/list/" . lpk(), "icon" => ICON_BOOK, "permission" => "sgd-access"),
            "centers" => array("text" => "Centros de gestión", "href" => "/sgd/centers/list/" . lpk(), "icon" => ICON_BOOK, "permission" => "sgd-access"),
            "settings" => array("text" => "Configuración", "href" => "/sgd/series/settings/" . lpk(), "icon" => ICON_TOOLS, "permission" => "sgd-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}


/**
 * Retorna el usuario activo
 */
if (!function_exists("safe_get_user")) {

    function safe_get_user()
    {
        $authentication = service('authentication');
        $user = $authentication->get_User();
        return ($user ?? "anonymous");
    }

}


if (!function_exists("pk")) {

    function pk($len = 13)
    {
        if ($len == 13) {
            return (strtoupper(uniqid()));
        } else {
            return (strtoupper(substr(uniqid(), -$len)));
        }
    }

}

?>