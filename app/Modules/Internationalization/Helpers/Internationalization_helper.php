<?php

if (!function_exists("generate_internationalization_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_internationalization_permissions(): void
    {
        $permissions = array(
            "internationalization-access",
            //[Languages]----------------------------------------------------------------------------------------
            "application-languages-access",
            "application-languages-view",
            "application-languages-view-all",
            "application-languages-create",
            "application-languages-edit",
            "application-languages-edit-all",
            "application-languages-delete",
            "application-languages-delete-all",
        );
        generate_permissions($permissions, "internationalization");
    }

}

if (!function_exists("get_internationalization_sidebar")) {
    function get_internationalization_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/internationalization/", "svg" => "home.svg"),
            "languages" => array("text" => lang("App.Languages"), "href" => "/internationalization/languages/list/" . lpk(), "icon" => ICON_LANGUAGES, "permission" => ""),
            "settings" => array("text" => lang("App.Settings"), "href" => "/internationalization/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "internationalization-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}

?>
