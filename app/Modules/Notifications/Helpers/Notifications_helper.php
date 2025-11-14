<?php

if (!function_exists("generate_notifications_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_notifications_permissions(): void
    {
        $permissions = array(
            "notifications-access",
            //[Notifications]----------------------------------------------------------------------------------------
            "notifications-notifications-access",
            "notifications-notifications-view",
            "notifications-notifications-view-all",
            "notifications-notifications-create",
            "notifications-notifications-edit",
            "notifications-notifications-edit-all",
            "notifications-notifications-delete",
            "notifications-notifications-delete-all",
        );
        generate_permissions($permissions, "notifications");
    }

}

if (!function_exists("get_notifications_sidebar")) {
    function get_notifications_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/notifications/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/notifications/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "notifications-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
