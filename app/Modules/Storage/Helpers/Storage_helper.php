<?php

if (!function_exists("generate_storage_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_storage_permissions(): void
    {
        $permissions = array(
            "storage-access",
        );
        generate_permissions($permissions, "storage");
    }

}

if (!function_exists("get_storage_sidebar")) {
    function get_storage_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/storage/", "svg" => "home.svg"),
            "attachments" => array("text" => lang("App.Attachments"), "href" => "/storage/attachments/list/" . lpk(), "icon" => ICON_ATTACHMENTS, "permission" => "storage-access"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/storage/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "storage-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
