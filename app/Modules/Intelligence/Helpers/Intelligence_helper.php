<?php

if (!function_exists("generate_intelligence_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_intelligence_permissions(): void
    {
        $permissions = array(
            "intelligence-access",
            //[Settings]------------------------------------------------------------------------------------------------
            "intelligence-settings-access",
            //[Ia]----------------------------------------------------------------------------------------
            "intelligence-personalities-access",
            "intelligence-personalities-view",
            "intelligence-personalities-view-all",
            "intelligence-personalities-create",
            "intelligence-personalities-edit",
            "intelligence-personalities-edit-all",
            "intelligence-personalities-delete",
            "intelligence-personalities-delete-all",
            //[Ias]----------------------------------------------------------------------------------------
            "intelligence-instructions-access",
            "intelligence-instructions-view",
            "intelligence-instructions-view-all",
            "intelligence-instructions-create",
            "intelligence-instructions-edit",
            "intelligence-instructions-edit-all",
            "intelligence-instructions-delete",
            "intelligence-instructions-delete-all",
        );
        generate_permissions($permissions, "intelligence");
    }

}

if (!function_exists("get_intelligence_sidebar")) {
    function get_intelligence_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/intelligence/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/intelligence/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "intelligence-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
