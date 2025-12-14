<?php

if (!function_exists("generate_maintenance_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_maintenance_permissions(): void
    {
        $permissions = array(
            "maintenance-access",
            //[Assets]----------------------------------------------------------------------------------------
            "maintenance-assets-access",
            "maintenance-assets-view",
            "maintenance-assets-view-all",
            "maintenance-assets-create",
            "maintenance-assets-edit",
            "maintenance-assets-edit-all",
            "maintenance-assets-delete",
            "maintenance-assets-delete-all",
            //[Sheets]----------------------------------------------------------------------------------------
            "maintenance-sheets-access",
            "maintenance-sheets-view",
            "maintenance-sheets-view-all",
            "maintenance-sheets-create",
            "maintenance-sheets-edit",
            "maintenance-sheets-edit-all",
            "maintenance-sheets-delete",
            "maintenance-sheets-delete-all",
            //[Sheets]----------------------------------------------------------------------------------------
            "maintenance-sheets-access",
            "maintenance-sheets-view",
            "maintenance-sheets-view-all",
            "maintenance-sheets-create",
            "maintenance-sheets-edit",
            "maintenance-sheets-edit-all",
            "maintenance-sheets-delete",
            "maintenance-sheets-delete-all",
            //[Types]----------------------------------------------------------------------------------------
            "maintenance-types-access",
            "maintenance-types-view",
            "maintenance-types-view-all",
            "maintenance-types-create",
            "maintenance-types-edit",
            "maintenance-types-edit-all",
            "maintenance-types-delete",
            "maintenance-types-delete-all",
            //[Notifications]----------------------------------------------------------------------------------------
            "maintenance-notifications-access",
            "maintenance-notifications-view",
            "maintenance-notifications-view-all",
            "maintenance-notifications-create",
            "maintenance-notifications-edit",
            "maintenance-notifications-edit-all",
            "maintenance-notifications-delete",
            "maintenance-notifications-delete-all",
            //[Maintenances]----------------------------------------------------------------------------------------
            "maintenance-maintenances-access",
            "maintenance-maintenances-view",
            "maintenance-maintenances-view-all",
            "maintenance-maintenances-create",
            "maintenance-maintenances-edit",
            "maintenance-maintenances-edit-all",
            "maintenance-maintenances-delete",
            "maintenance-maintenances-delete-all",

        );
        generate_permissions($permissions, "maintenance");
    }

}

if (!function_exists("get_maintenance_sidebar")) {
    function get_maintenance_sidebar($active_url = false)
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/maintenance/", "svg" => "home.svg"),
            "gestion1" => array("text" => "Gestión de Activos", "href" => "/maintenance/assets/list/" . lpk(), "icon" => ICON_TOOLS, "permission" => ""),
            "gestion2" => array("text" => "Mantenimientos", "href" => "/maintenance/maintenances/list/" . lpk(), "icon" => ICON_TOOLS, "permission" => ""),
            "gestion4" => array("text" => "Notificaciones", "href" => "#" . lpk(), "icon" => ICON_TOOLS, "permission" => ""),
            "gestion5" => array("text" => "Reportes", "href" => "#" . lpk(), "icon" => ICON_TOOLS, "permission" => ""),
            "settings" => array("text" => "Configuración", "href" => "#" . lpk(), "icon" => ICON_TOOLS, "permission" => "maintenance-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPillsGamma($o, $active_url);
        return ($return);
    }
}

?>
