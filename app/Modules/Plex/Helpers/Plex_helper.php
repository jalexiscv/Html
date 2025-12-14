<?php

if (!function_exists("generate_plex_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_plex_permissions(): void
    {
        $permissions = array(
            "plex-access",
            //[Clients]----------------------------------------------------------------------------------------
            "plex-clients-access",
            "plex-clients-view",
            "plex-clients-view-all",
            "plex-clients-create",
            "plex-clients-edit",
            "plex-clients-edit-all",
            "plex-clients-delete",
            "plex-clients-delete-all",
            //[Modules]----------------------------------------------------------------------------------------
            "plex-modules-access",
            "plex-modules-view",
            "plex-modules-view-all",
            "plex-modules-create",
            "plex-modules-edit",
            "plex-modules-edit-all",
            "plex-modules-delete",
            "plex-modules-delete-all",
        );
        generate_permissions($permissions, "plex");
    }

}

if (!function_exists("get_plex_sidebar")) {
    function get_plex_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/plex/", "svg" => "home.svg"),
            "clients" => array("text" => lang("App.Clients"), "href" => "/plex/clients/list/" . lpk(), "icon" => ICON_CLIENTS, "permission" => "plex-access"),
            "modules" => array("text" => lang("App.Modules"), "href" => "/plex/modules/list/" . lpk(), "icon" => ICON_MODULES, "permission" => "plex-access"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/plex/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "plex-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
