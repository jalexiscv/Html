<?php

if (!function_exists("generate_frontend_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_frontend_permissions(): void
    {
        $permissions = array(
            "frontend-access",
            "frontend-settings-access",
            //[shortcuts]-----------------------------------------------------------------------------------------------
            "frontend-shortcuts-create",
            "frontend-shortcuts-view",
            "frontend-shortcuts-view-all",
            "frontend-shortcuts-edit",
            "frontend-shortcuts-edit-all",
            "frontend-shortcuts-delete",
            "frontend-shortcuts-delete-all",
        );
        generate_permissions($permissions, "frontend");
    }

}

if (!function_exists("get_frontend_sidebar")) {
    function get_frontend_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/frontend/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/frontend/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "frontend-settings-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }

    function get_frontend_sidebar2($active_url = false)
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/frontend/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/frontend/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "frontend-settings-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPillsGamma($o, $active_url);
        return ($return);
    }
}

?>
