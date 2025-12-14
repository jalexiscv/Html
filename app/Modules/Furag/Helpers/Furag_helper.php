<?php

if (!function_exists("generate_furag_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_furag_permissions(): void
    {
        $permissions = array(
            "furag-access",
            //[Dimensions]----------------------------------------------------------------------------------------
            "furag-dimensions-access",
            "furag-dimensions-view",
            "furag-dimensions-view-all",
            "furag-dimensions-create",
            "furag-dimensions-edit",
            "furag-dimensions-edit-all",
            "furag-dimensions-delete",
            "furag-dimensions-delete-all",
            //[Politics]----------------------------------------------------------------------------------------
            "furag-politics-access",
            "furag-politics-view",
            "furag-politics-view-all",
            "furag-politics-create",
            "furag-politics-edit",
            "furag-politics-edit-all",
            "furag-politics-delete",
            "furag-politics-delete-all",
            //[Questions]----------------------------------------------------------------------------------------
            "furag-questions-access",
            "furag-questions-view",
            "furag-questions-view-all",
            "furag-questions-create",
            "furag-questions-edit",
            "furag-questions-edit-all",
            "furag-questions-delete",
            "furag-questions-delete-all",
        );
        generate_permissions($permissions, "furag");
    }

}

if (!function_exists("get_furag_sidebar")) {
    function get_furag_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/furag/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/furag/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "furag-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
