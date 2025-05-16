<?php

if (!function_exists("generate_workflow_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_workflow_permissions(): void
    {
        $permissions = array(
            "workflow-access",
        );
        generate_permissions($permissions, "workflow");
    }

}

if (!function_exists("get_workflow_sidebar")) {
    function get_workflow_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/workflow/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/workflow/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "workflow-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
