<?php

if (!function_exists("generate_mipg_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_mipg_permissions(): void
    {
        $permissions = array(
            "mipg-access",
            //[dimension]------------------------------------------------------------------------------------------------
            "mipg-dimensions-create",
            "mipg-dimensions-view",
            "mipg-dimensions-view-all",
            "mipg-dimensions-edit",
            "mipg-dimensions-edit-all",
            "mipg-dimensions-delete",
            "mipg-dimensions-delete-all",
            //[politics]------------------------------------------------------------------------------------------------
            "mipg-politics-create",
            "mipg-politics-view",
            "mipg-politics-view-all",
            "mipg-politics-edit",
            "mipg-politics-edit-all",
            "mipg-politics-delete",
            "mipg-politics-delete-all",
            //[diagnostics]---------------------------------------------------------------------------------------------
            "mipg-diagnostics-create",
            "mipg-diagnostics-view",
            "mipg-diagnostics-view-all",
            "mipg-diagnostics-edit",
            "mipg-diagnostics-edit-all",
            "mipg-diagnostics-delete",
            "mipg-diagnostics-delete-all",
            //[components]----------------------------------------------------------------------------------------------
            "mipg-components-create",
            "mipg-components-view",
            "mipg-components-view-all",
            "mipg-components-edit",
            "mipg-components-edit-all",
            "mipg-components-delete",
            "mipg-components-delete-all",
            //[categories]----------------------------------------------------------------------------------------------
            "mipg-categories-create",
            "mipg-categories-view",
            "mipg-categories-view-all",
            "mipg-categories-edit",
            "mipg-categories-edit-all",
            "mipg-categories-delete",
            "mipg-categories-delete-all",
            //[activities]----------------------------------------------------------------------------------------------
            "mipg-activities-create",
            "mipg-activities-view",
            "mipg-activities-view-all",
            "mipg-activities-edit",
            "mipg-activities-edit-all",
            "mipg-activities-delete",
            "mipg-activities-delete-all",
            //[scores]--------------------------------------------------------------------------------------------------
            "mipg-scores-create",
            "mipg-scores-view",
            "mipg-scores-view-all",
            "mipg-scores-edit",
            "mipg-scores-edit-all",
            "mipg-scores-delete",
            "mipg-scores-delete-all",
            //[Causes]--------------------------------------------------------------------------------------------------
            "mipg-causes-access",
            "mipg-causes-view",
            "mipg-causes-view-all",
            "mipg-causes-create",
            "mipg-causes-edit",
            "mipg-causes-edit-all",
            "mipg-causes-delete",
            "mipg-causes-delete-all",
            "mipg-causes-evaluate",
            //[Whys]----------------------------------------------------------------------------------------------------
            "mipg-whys-access",
            "mipg-whys-view",
            "mipg-whys-view-all",
            "mipg-whys-create",
            "mipg-whys-edit",
            "mipg-whys-edit-all",
            "mipg-whys-delete",
            "mipg-whys-delete-all",
            //[actions]-------------------------------------------------------------------------------------------------
            "mipg-actions-access",
            "mipg-actions-view",
            "mipg-actions-view-all",
            "mipg-actions-create",
            "mipg-actions-edit",
            "mipg-actions-edit-all",
            "mipg-actions-delete",
            "mipg-actions-delete-all",
            //[actions]-------------------------------------------------------------------------------------------------
        );
        generate_permissions($permissions, "mipg");
    }

}

if (!function_exists("get_mipg_sidebar")) {
    function get_mipg_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/mipg/", "svg" => "home.svg"),
            "dimensions" => array("text" => lang("App.Dimensions"), "href" => "/mipg/dimensions/home/" . lpk(), "icon" => ICON_DIMENSIONS, "permission" => "mipg-access"),
            //"settings" => array("text" => lang("App.Settings"), "href" => "/mipg/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "mipg-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
