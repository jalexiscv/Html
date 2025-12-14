<?php

if (!function_exists("generate_tdp_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_tdp_permissions(): void
    {
        $permissions = array(
            "tdp-access",
            //[dimension]------------------------------------------------------------------------------------------------
            "tdp-dimensions-create",
            "tdp-dimensions-view",
            "tdp-dimensions-view-all",
            "tdp-dimensions-edit",
            "tdp-dimensions-edit-all",
            "tdp-dimensions-delete",
            "tdp-dimensions-delete-all",
            //[lines]------------------------------------------------------------------------------------------------
            "tdp-lines-create",
            "tdp-lines-view",
            "tdp-lines-view-all",
            "tdp-lines-edit",
            "tdp-lines-edit-all",
            "tdp-lines-delete",
            "tdp-lines-delete-all",
            //[diagnostics]------------------------------------------------------------------------------------------------
            "tdp-diagnostics-create",
            "tdp-diagnostics-view",
            "tdp-diagnostics-view-all",
            "tdp-diagnostics-edit",
            "tdp-diagnostics-edit-all",
            "tdp-diagnostics-delete",
            "tdp-diagnostics-delete-all",
            //[sectors]------------------------------------------------------------------------------------------------
            "tdp-sectors-create",
            "tdp-sectors-view",
            "tdp-sectors-view-all",
            "tdp-sectors-edit",
            "tdp-sectors-edit-all",
            "tdp-sectors-delete",
            "tdp-sectors-delete-all",
            //[programs]------------------------------------------------------------------------------------------------
            "tdp-programs-create",
            "tdp-programs-view",
            "tdp-programs-view-all",
            "tdp-programs-edit",
            "tdp-programs-edit-all",
            "tdp-programs-delete",
            "tdp-programs-delete-all",
            //[products]------------------------------------------------------------------------------------------------
            "tdp-products-create",
            "tdp-products-view",
            "tdp-products-view-all",
            "tdp-products-edit",
            "tdp-products-edit-all",
            "tdp-products-delete",
            "tdp-products-delete-all",
            //[indicators]------------------------------------------------------------------------------------------------
            "tdp-indicators-create",
            "tdp-indicators-view",
            "tdp-indicators-view-all",
            "tdp-indicators-edit",
            "tdp-indicators-edit-all",
            "tdp-indicators-delete",
            "tdp-indicators-delete-all",
        );
        generate_permissions($permissions, "tdp");
    }

}

if (!function_exists("get_tdp_sidebar")) {
    function get_tdp_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/tdp/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/tdp/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "tdp-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
