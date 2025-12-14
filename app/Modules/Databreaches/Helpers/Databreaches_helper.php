<?php

if (!function_exists("generate_databreaches_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_databreaches_permissions(): void
    {
        $permissions = array(
            "databreaches-access",
            //[Cases]---------------------------------------------------------------------------------------------------
            "databreaches-cases-access",
            "databreaches-cases-view",
            "databreaches-cases-view-all",
            "databreaches-cases-create",
            "databreaches-cases-edit",
            "databreaches-cases-edit-all",
            "databreaches-cases-delete",
            "databreaches-cases-delete-all",
            //[Incidents]-----------------------------------------------------------------------------------------------
            "databreaches-incidents-access",
            "databreaches-incidents-view",
            "databreaches-incidents-view-all",
            "databreaches-incidents-create",
            "databreaches-incidents-edit",
            "databreaches-incidents-edit-all",
            "databreaches-incidents-delete",
            "databreaches-incidents-delete-all",
            //[Breaches]------------------------------------------------------------------------------------------------
            "databreaches-breaches-access",
            "databreaches-breaches-view",
            "databreaches-breaches-view-all",
            "databreaches-breaches-create",
            "databreaches-breaches-edit",
            "databreaches-breaches-edit-all",
            "databreaches-breaches-delete",
            "databreaches-breaches-delete-all",
        );
        generate_permissions($permissions, "databreaches");
    }

}

if (!function_exists("get_databreaches_sidebar")) {
    function get_databreaches_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/databreaches/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/databreaches/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "databreaches-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
