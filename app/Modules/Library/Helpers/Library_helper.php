<?php

if (!function_exists("generate_library_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_library_permissions(): void
    {
        $permissions = array(
            "library-access",
            //[Resources]----------------------------------------------------------------------------------------
            "library-resources-access",
            "library-resources-view",
            "library-resources-view-all",
            "library-resources-create",
            "library-resources-edit",
            "library-resources-edit-all",
            "library-resources-delete",
            "library-resources-delete-all",
        );
        generate_permissions($permissions, "library");
    }

}

if (!function_exists("get_library_sidebar")) {
    function get_library_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/library/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/library/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "library-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
