<?php

if (!function_exists("generate_messenger_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_messenger_permissions(): void
    {
        $permissions = array(
            "messenger-access",
            //[Messages]------------------------------------------------------------------------------------------------
            "messenger-messages-access",
            "messenger-messages-view",
            "messenger-messages-view-all",
            "messenger-messages-create",
            "messenger-messages-edit",
            "messenger-messages-edit-all",
            "messenger-messages-delete",
            "messenger-messages-delete-all",
        );
        generate_permissions($permissions, "messenger");
    }

}

if (!function_exists("get_messenger_sidebar")) {
    function get_messenger_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/messenger/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/messenger/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "messenger-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
