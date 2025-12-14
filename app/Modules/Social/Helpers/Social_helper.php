<?php

if (!function_exists("generate_social_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_social_permissions(): void
    {
        $permissions = array(
            "social-access",
        );
        generate_permissions($permissions, "social");
    }

}

if (!function_exists("get_social_sidebar")) {
    function get_social_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/social/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/social/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "social-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
