<?php

if (!function_exists("generate_manager_permissions")) {

		/**
		 * Permite registrar los permisos asociados al modulo, tecnicamente su
		 * ejecucion regenera los permisos asignables definidos por el modulo DISA
		 */
		function generate_manager_permissions():void
		{
				$permissions = array(
						"manager-access",
				);
				generate_permissions($permissions, "manager");
		}

}

if (!function_exists("get_manager_sidebar")) {
		function get_manager_sidebar($active_url = false):string
		{
				$bootstrap = service("bootstrap");
				$lpk = safe_strtolower(pk());
				$options = array(
						"home" => array("text" => lang("App.Home"), "href" => "/manager/", "svg" => "home.svg"),
						"settings" => array("text" => lang("App.Settings"), "href" => "/manager/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "manager-access"),
				);
				$o = get_application_custom_sidebar($options, $active_url);
				$return = $bootstrap->get_NavPills($o, $active_url);
				return ($return);
		}
	}

?>
