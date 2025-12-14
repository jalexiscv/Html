<?php

if (!function_exists("generate_history_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_history_permissions(): void
    {
        $permissions = array(
            "history-access",
            /** Programs **/
            "history-stats-view",
            "history-stats-view-all",
            "history-stats-create",
            "history-stats-edit",
            "history-stats-edit-all",
            "history-stats-delete",
            "history-stats-delete-all",
        );
        generate_permissions($permissions, "history");
    }

}

if (!function_exists("get_history_sidebar")) {
    function get_history_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/history/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/history/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "history-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
