<?php

if (!function_exists("generate_sint_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_sint_permissions(): void
    {
        $permissions = array(
            "sint-access",
            //[Cases]---------------------------------------------------------------------------------------------------
            "sint-cases-access",
            "sint-cases-view",
            "sint-cases-view-all",
            "sint-cases-create",
            "sint-cases-edit",
            "sint-cases-edit-all",
            "sint-cases-delete",
            "sint-cases-delete-all",
            //[Incidents]-----------------------------------------------------------------------------------------------
            "sint-incidents-access",
            "sint-incidents-view",
            "sint-incidents-view-all",
            "sint-incidents-create",
            "sint-incidents-edit",
            "sint-incidents-edit-all",
            "sint-incidents-delete",
            "sint-incidents-delete-all",
            //[Breaches]------------------------------------------------------------------------------------------------
            "sint-breaches-access",
            "sint-breaches-view",
            "sint-breaches-view-all",
            "sint-breaches-create",
            "sint-breaches-edit",
            "sint-breaches-edit-all",
            "sint-breaches-delete",
            "sint-breaches-delete-all",
        );
        generate_permissions($permissions, "sint");
    }

}

if (!function_exists("get_sint_sidebar")) {
    function get_sint_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/sint/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/sint/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "sint-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
