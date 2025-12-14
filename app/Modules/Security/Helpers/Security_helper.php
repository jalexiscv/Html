<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

if (!function_exists("generate_security_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_security_permissions()
    {
        $permissions = array(
            "security-access",
            //users
            "security-users-access",
            "security-users-view",
            "security-users-view-all",
            "security-users-create",
            "security-users-edit",
            "security-users-edit-all",
            "security-users-delete",
            "security-users-delete-all",
            //permissions
            "security-permissions-create",
            "security-permissions-view",
            "security-permissions-view-all",
            "security-permissions-edit",
            "security-permissions-edit-all",
            "security-permissions-delete",
            "security-permissions-delete-all",
            //logs
            "security-logs-view",
            "security-logs-view-all",
            "security-logs-create",
            "security-logs-edit",
            "security-logs-edit-all",
            "security-logs-delete",
            "security-logs-delete-all",
            //bots
            "security-bots-view",
            "security-bots-view-all",
            "security-bots-create",
            "security-bots-edit",
            "security-bots-edit-all",
            "security-bots-delete",
            "security-bots-delete-all",
        );
        generate_permissions($permissions, "cadastre");
    }

}

if (!function_exists("get_security_sidebar")) {
    function get_security_sidebar($active_url = false)
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/security", "icon" => "far fa-home"),
            "users" => array("text" => lang("App.Users"), "href" => "/security/users/list/" . lpk(), "icon" => ICON_USERS, "permission" => "SECURITY-ACCESS"),
            "roles" => array("text" => lang("App.Roles"), "href" => "/security/roles/list/" . lpk(), "icon" => ICON_CROWN, "permission" => "SECURITY-ACCESS"),
            "permissions" => array("text" => lang("App.Permissions"), "href" => "/security/permissions/list/" . lpk(), "icon" => ICON_KEY, "permission" => "SECURITY-ACCESS"),
            "tools" => array("text" => lang("App.Tools"), "href" => "/security/tools/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "SECURITY-ACCESS"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/security/settings/home/" . lpk(), "icon" => ICON_SETTINGS, "permission" => "SECURITY-ACCESS"),
            //"logs" => array("text" => lang("App.History"), "href" => "/security/history/home/" . lpk(), "icon" => "far fa-history", "permission" => "SECURITY-ACCESS"),
            //"firewall" => array("text" => "Firewall", "href" => "/security/firewall/home/" . lpk(), "icon" => ICON_FIREWALL, "permission" => "SECURITY-ACCESS"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPillsGamma($o, $active_url);
        return ($return);
    }

    function get_security_sidebarOLD($active_url = false)
    {
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/cadastre/", "svg" => "home.svg"),
            "customers" => array("text" => lang("App.Customers"), "href" => "/cadastre/customers/list/" . lpk(), "icon" => ICON_CUSTOMERS, "permission" => "cadastre-access"),
            "map" => array("text" => lang("App.Maps"), "href" => "/cadastre/maps/home/" . lpk(), "icon" => ICON_MAP, "permission" => "cadastre-access"),

        );
        $return = get_application_custom_sidebar($options, $active_url);
        return ($return);
    }
}


if (!function_exists("get_snippet_profiles_history")) {


    function get_snippet_profiles_history($customer)
    {
        $mprofiles = model('App\Modules\Web\Models\Web_Profiles');
        $strings = service("strings");

        $mprofiles = $mprofiles->where('customer', $customer)->findAll();

        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";

        foreach ($mprofiles as $profile) {
            $t .= "<li><b>Perfil: </b>: <a href=\"/cadastre/customers/view/{$customer}?profile={$profile['profile']}\">{$profile['profile']}</a> Fecha: {$profile['created_at']}</li>";
        }
        $t .= "</ul>";

        $c = ""
            . "<div class=\"card mb-1\">"
            . "<div class=\"card-header p-1\"><h2 class=\"card-header-title p-1  m-0 opacity-3\">Historial Perfiles</h2></div>"
            . "<div class=\"card-body\">"
            . $t
            . "</div>"
            . "</div>";
        return ($c);
    }

}


if (!function_exists("get_security_messenger_users")) {
    /**
     * Retorna el listado inicial de usuarios que se graficaran en el listado del messenger
     * @user string còdigo del usuario que realiza la consulta.
     */
    function get_security_messenger_users($user)
    {
        $musers = model('App\Modules\Web\Models\Web_Users');
        $mfields = model('App\Modules\Web\Models\Web_Users_Fields');
        $users = $musers->select('user')->findAll();
        $list = array();
        foreach ($users as $user) {
            $profile = $mfields->get_Profile($user['user']);
            $user["name"] = $profile["name"];
            array_push($list, $user);
        }
        return ($list);
    }

}


if (!function_exists("get_security_copyright")) {

    function get_security_copyright()
    {
        $gridter = "";
        $gridter .= "<div id=\"gridter\">";
        $gridter .= "  <div class=\"xl\">XL</div>";
        $gridter .= "  <div class=\"lg\">LG</div>";
        $gridter .= "  <div class=\"md\">MD</div>";
        $gridter .= "  <div class=\"sm\">SM</div>";
        $gridter .= "  <div class=\"xs\">XS</div>";
        $gridter .= "</div>";
        $c = "";
        $c .= ""
            . "<div class=\"card\">"
            . "<div class=\"card-body\">"
            . "<p style=\"font-size: 1rem;line-height: 1rem;\"><b>Copyright © 2021 - 2031 </b> Todos los derechos reservados, se prohíbe su reproducción total o "
            . "parcial, así como su traducción a cualquier idioma sin la autorización escrita de su titular. "
            . "<a href=\"/policies/conditions\" class=\"link\">Términos y condiciones</a> | "
            . "<a href=\"/policies/privacy\" class=\"link\">Políticas de privacidad</a> | "
            . "<a href=\"/policies/advertising\" class=\"link\">Publicidad</a> | "
            . "<a href=\"/policies/cookies\" class=\"link\">Cookies</a> | "
            . "<a href=\"/policies/more\" class=\"link\">Más</a> | "
            . $gridter
            . "</p></div>"
            . "</div>";
        return ($c);
    }

}


if (!function_exists("get_security_code_copyright")) {
    function get_security_code_copyright(array $args)
    {
        $path = $args["path"];
        $author = "Jose Alexis Correa Valencia <jalexiscv@gmail.com>";
        $date = date("Y-m-d H:i:s");
        $c = "\n/**";
        $c .= "\n* █ ---------------------------------------------------------------------------------------------------------------------";
        $c .= "\n* █ ░FRAMEWORK                                  {$date}";
        $c .= "\n* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [{$path}]";
        $c .= "\n* █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>";
        $c .= "\n* █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,";
        $c .= "\n* █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.";
        $c .= "\n* █ ---------------------------------------------------------------------------------------------------------------------";
        $c .= "\n* █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O";
        $c .= "\n* █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,";
        $c .= "\n* █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ";
        $c .= "\n* █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER";
        $c .= "\n* █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,";
        $c .= "\n* █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE";
        $c .= "\n* █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.";
        $c .= "\n* █ ---------------------------------------------------------------------------------------------------------------------";
        $c .= "\n* █ @Author {$author}";
        $c .= "\n* █ @link https://www.codehiggs.com";
        $c .= "\n* █ @Version 1.5.0 @since PHP 7, PHP 8";
        $c .= "\n* █ ---------------------------------------------------------------------------------------------------------------------";
        $c .= "\n* █ Datos recibidos desde el controlador - @ModuleController";
        $c .= "\n* █ ---------------------------------------------------------------------------------------------------------------------";
        $c .= "\n* █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix";
        $c .= "\n* █ ---------------------------------------------------------------------------------------------------------------------";
        $c .= "\n**/\n";
        return ($c);
    }
}


if (!function_exists("get_security_count_permissions")) {

    function get_security_count_permissions()
    {
        $mpermissions = model('App\Modules\Security\Models\Security_Permissions');
        $count = $mpermissions->countAllResults();
        $code = "";
        $code .= "<div class=\"card flex-row align-items-center align-items-stretch mb-3\">\n";
        $code .= "\t\t<div class=\"col-4 d-flex align-items-center bg-gray justify-content-center rounded-left\">\n";
        $code .= "\t\t\t\t<i class=\"fad fa-key fa-3x\"></i>\n";
        $code .= "\t\t</div>\n";
        $code .= "\t\t<div class=\"col-8 py-3 bg-gray rounded-right\">\n";
        $code .= "\t\t\t\t<div class=\"fs-5 lh-5 my-0\">\n";
        $code .= "\t\t\t\t\t\t{$count}\t\t\t\t</div>\n";
        $code .= "\t\t\t\t<div class=\"\t\tmy-0\">\n";
        $code .= "\t\t\t\t\t\t" . lang("App.Permissions") . "\t\t\t\t</div>\n";
        $code .= "\t\t</div>\n";
        $code .= "</div>\n";
        return ($code);
    }

}


if (!function_exists("get_security_count_roles")) {

    function get_security_count_roles()
    {
        $mroles = model('App\Modules\Security\Models\Security_Roles');
        $count = $mroles->countAllResults();
        $code = "";
        $code .= "<div class=\"card flex-row align-items-center align-items-stretch mb-3\">\n";
        $code .= "\t\t<div class=\"col-4 d-flex align-items-center bg-gray justify-content-center rounded-left\">\n";
        $code .= "\t\t\t\t<i class=\"fad fa-crown fa-3x\"></i>\n";
        $code .= "\t\t</div>\n";
        $code .= "\t\t<div class=\"col-8 py-3 bg-gray rounded-right\">\n";
        $code .= "\t\t\t\t<div class=\"fs-5 lh-5 my-0\">\n";
        $code .= "\t\t\t\t\t\t{$count}\t\t\t\t</div>\n";
        $code .= "\t\t\t\t<div class=\"\t\tmy-0\">\n";
        $code .= "\t\t\t\t\t\t" . lang("App.Roles") . "\t\t\t\t</div>\n";
        $code .= "\t\t</div>\n";
        $code .= "</div>\n";
        return ($code);
    }

}


if (!function_exists("get_security_count_users")) {

    function get_security_count_users()
    {
        $musers = model('App\Modules\Security\Models\Security_Users');
        $count = $musers->get_CountAllResults();
        $code = "";
        $code .= "<div class=\"card flex-row align-items-center align-items-stretch mb-3\">\n";
        $code .= "\t\t<div class=\"col-4 d-flex align-items-center bg-gray justify-content-center rounded-left\">\n";
        $code .= "\t\t\t\t<i class=\"fad fa-users fa-3x\"></i>\n";
        $code .= "\t\t</div>\n";
        $code .= "\t\t<div class=\"col-8 py-3 bg-gray rounded-right\">\n";
        $code .= "\t\t\t\t<div class=\"fs-5 lh-5 my-0\">\n";
        $code .= "\t\t\t\t\t\t{$count}\t\t\t\t</div>\n";
        $code .= "\t\t\t\t<div class=\"\t\tmy-0\">\n";
        $code .= "\t\t\t\t\t\t" . lang("App.Users") . "\t\t\t\t</div>\n";
        $code .= "\t\t</div>\n";
        $code .= "</div>\n";
        return ($code);
    }

}

?>