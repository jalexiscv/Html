<?php

if (!function_exists("generate_organization_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_organization_permissions(): void
    {
        $permissions = array(
            "organization-access",
            //[Plans]---------------------------------------------------------------------------------------------------
            "organization-plans-access",
            "organization-plans-view",
            "organization-plans-view-all",
            "organization-plans-create",
            "organization-plans-edit",
            "organization-plans-edit-all",
            "organization-plans-delete",
            "organization-plans-delete-all",
            //[macroprocesses]------------------------------------------------------------------------------------------
            "organization-macroprocesses-access",
            "organization-macroprocesses-view",
            "organization-macroprocesses-view-all",
            "organization-macroprocesses-create",
            "organization-macroprocesses-edit",
            "organization-macroprocesses-edit-all",
            "organization-macroprocesses-delete",
            "organization-macroprocesses-delete-all",
            //[processes]-----------------------------------------------------------------------------------------------
            "organization-processes-access",
            "organization-processes-view",
            "organization-processes-view-all",
            "organization-processes-create",
            "organization-processes-edit",
            "organization-processes-edit-all",
            "organization-processes-delete",
            "organization-processes-delete-all",
            //[subprocesses]--------------------------------------------------------------------------------------------
            "organization-subprocesses-access",
            "organization-subprocesses-view",
            "organization-subprocesses-view-all",
            "organization-subprocesses-create",
            "organization-subprocesses-edit",
            "organization-subprocesses-edit-all",
            "organization-subprocesses-delete",
            "organization-subprocesses-delete-all",
            //[Positions]----------------------------------------------------------------------------------------
            "organization-positions-access",
            "organization-positions-view",
            "organization-positions-view-all",
            "organization-positions-create",
            "organization-positions-edit",
            "organization-positions-edit-all",
            "organization-positions-delete",
            "organization-positions-delete-all",
            //[organization]--------------------------------------------------------------------------------------------
            "organization-characterization-view",
            "organization-characterization-edit",
            //[others]--------------------------------------------------------------------------------------------------
        );
        generate_permissions($permissions, "organization");
    }

}

if (!function_exists("get_organization_sidebar")) {
    function get_organization_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/organization/", "svg" => "home.svg"),
            "orgaization-plans" => array("text" => lang("Organization.institutional-plans"), "href" => "/organization/plans/list/" . lpk(), "icon" => ICON_PLANS, "permission" => "organization-access"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/organization/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "organization-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
