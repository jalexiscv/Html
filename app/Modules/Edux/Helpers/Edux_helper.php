<?php

if (!function_exists("generate_edux_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_edux_permissions(): void
    {
        $permissions = array(
            "edux-access",
        );
        generate_permissions($permissions, "edux");
    }

}

if (!function_exists("get_edux_sidebar")) {
    function get_edux_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/edux/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/edux/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "edux-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
