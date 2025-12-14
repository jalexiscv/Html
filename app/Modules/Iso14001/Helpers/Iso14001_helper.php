<?php

if (!function_exists("generate_iso14001_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_iso14001_permissions(): void
    {
        $permissions = array(
            "iso14001-access",
        );
        generate_permissions($permissions, "iso14001");
    }

}

if (!function_exists("get_iso14001_sidebar")) {
    function get_iso14001_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/iso14001/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/iso14001/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "iso14001-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
