<?php

if (!function_exists("generate_iso45001_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_iso45001_permissions(): void
    {
        $permissions = array(
            "iso45001-access",
        );
        generate_permissions($permissions, "iso45001");
    }

}

if (!function_exists("get_iso45001_sidebar")) {
    function get_iso45001_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/iso45001/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/iso45001/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "iso45001-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
