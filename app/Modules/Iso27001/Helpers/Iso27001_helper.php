<?php

if (!function_exists("generate_iso27001_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_iso27001_permissions(): void
    {
        $permissions = array(
            "iso27001-access",
        );
        generate_permissions($permissions, "iso27001");
    }

}

if (!function_exists("get_iso27001_sidebar")) {
    function get_iso27001_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/iso27001/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/iso27001/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "iso27001-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
