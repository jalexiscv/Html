<?php

if (!function_exists("generate_sogt_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_sogt_permissions(): void
    {
        $permissions = array(
            "sogt-access",
            //[Devices]----------------------------------------------------------------------------------------
            "sogt-devices-access",
            "sogt-devices-view",
            "sogt-devices-view-all",
            "sogt-devices-create",
            "sogt-devices-edit",
            "sogt-devices-edit-all",
            "sogt-devices-delete",
            "sogt-devices-delete-all",
            //[Telemetry]----------------------------------------------------------------------------------------
            "sogt-telemetry-access",
            "sogt-telemetry-view",
            "sogt-telemetry-view-all",
            "sogt-telemetry-create",
            "sogt-telemetry-edit",
            "sogt-telemetry-edit-all",
            "sogt-telemetry-delete",
            "sogt-telemetry-delete-all",
        );
        generate_permissions($permissions, "sogt");
    }

}

if (!function_exists("get_sogt_sidebar")) {
    function get_sogt_sidebar($active_url = false): array
    {
        $options = array(
            "title"=>"Componentes",
            "sidebar_options" => array(
                "home" => array("text" => lang("App.Home"), "href" => "/sogt/", "svg" => "home.svg"),
                "telemetry" => array("text" => lang("App.Telemetry"), "href" => "/sogt/telemetry/list/" . lpk(), "icon" => ICON_HISTORY, "permission" => "sogt-access"),
                "settings" => array("text" => lang("App.Settings"), "href" => "/sogt/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "sogt-access"),
            )
        );
        return ($options);
    }
}

?>
