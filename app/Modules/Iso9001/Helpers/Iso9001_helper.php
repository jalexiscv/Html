<?php

if (!function_exists("generate_iso9001_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_iso9001_permissions(): void
    {
        $permissions = array(
            "iso9001-access",
            //[requirements]------------------------------------------------------------------------------------------------
            "iso9001-requirements-create",
            "iso9001-requirements-view",
            "iso9001-requirements-view-all",
            "iso9001-requirements-edit",
            "iso9001-requirements-edit-all",
            "iso9001-requirements-delete",
            "iso9001-requirements-delete-all",
            //[diagnostics]------------------------------------------------------------------------------------------------
            "iso9001-diagnostics-create",
            "iso9001-diagnostics-view",
            "iso9001-diagnostics-view-all",
            "iso9001-diagnostics-edit",
            "iso9001-diagnostics-edit-all",
            "iso9001-diagnostics-delete",
            "iso9001-diagnostics-delete-all",
            //[components]------------------------------------------------------------------------------------------------
            "iso9001-components-create",
            "iso9001-components-view",
            "iso9001-components-view-all",
            "iso9001-components-edit",
            "iso9001-components-edit-all",
            "iso9001-components-delete",
            "iso9001-components-delete-all",
            //[categories]------------------------------------------------------------------------------------------------
            "iso9001-categories-create",
            "iso9001-categories-view",
            "iso9001-categories-view-all",
            "iso9001-categories-edit",
            "iso9001-categories-edit-all",
            "iso9001-categories-delete",
            "iso9001-categories-delete-all",
            //[activities]------------------------------------------------------------------------------------------------
            "iso9001-activities-create",
            "iso9001-activities-view",
            "iso9001-activities-view-all",
            "iso9001-activities-edit",
            "iso9001-activities-edit-all",
            "iso9001-activities-delete",
            "iso9001-activities-delete-all",
            //[scores]------------------------------------------------------------------------------------------------
            "iso9001-scores-create",
            "iso9001-scores-view",
            "iso9001-scores-view-all",
            "iso9001-scores-edit",
            "iso9001-scores-edit-all",
            "iso9001-scores-delete",
            "iso9001-scores-delete-all",

        );
        generate_permissions($permissions, "iso9001");
    }

}

if (!function_exists("get_iso9001_sidebar")) {
    function get_iso9001_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/iso9001/", "svg" => "home.svg"),
            "requirements" => array("text" => lang("App.Requirements"), "href" => "/iso9001/requirements/home/" . lpk(), "icon" => ICON_REQUIREMENTS, "permission" => "iso9001-access"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/iso9001/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "iso9001-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
