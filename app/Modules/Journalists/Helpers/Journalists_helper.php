<?php

if (!function_exists("generate_journalists_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_journalists_permissions(): void
    {
        $permissions = array(
            "journalists-access",
            //[Journalists]----------------------------------------------------------------------------------------
            "journalists-journalists-access",
            "journalists-journalists-view",
            "journalists-journalists-view-all",
            "journalists-journalists-create",
            "journalists-journalists-edit",
            "journalists-journalists-edit-all",
            "journalists-journalists-delete",
            "journalists-journalists-delete-all",
            //[Medias]----------------------------------------------------------------------------------------
            "journalists-medias-access",
            "journalists-medias-view",
            "journalists-medias-view-all",
            "journalists-medias-create",
            "journalists-medias-edit",
            "journalists-medias-edit-all",
            "journalists-medias-delete",
            "journalists-medias-delete-all",
            //[Invitations]----------------------------------------------------------------------------------------
            "journalists-invitations-access",
            "journalists-invitations-view",
            "journalists-invitations-view-all",
            "journalists-invitations-create",
            "journalists-invitations-edit",
            "journalists-invitations-edit-all",
            "journalists-invitations-delete",
            "journalists-invitations-delete-all",
        );
        generate_permissions($permissions, "journalists");
    }

}

if (!function_exists("get_journalists_sidebar")) {
    function get_journalists_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/journalists/", "svg" => "home.svg"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/journalists/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "journalists-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
