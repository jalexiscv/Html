<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

if (!function_exists("generate_settings_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_settings_permissions()
    {
        $permissions = array(
            "settings-access",
            //users
            "settings-users-access",
            "settings-users-view",
            "settings-users-view-all",
            "settings-users-create",
            "settings-users-edit",
            "settings-users-edit-all",
            "settings-users-delete",
            "settings-users-delete-all",
            //[Countries]----------------------------------------------------------------------------------------
            "settings-countries-access",
            "settings-countries-view",
            "settings-countries-view-all",
            "settings-countries-create",
            "settings-countries-edit",
            "settings-countries-edit-all",
            "settings-countries-delete",
            "settings-countries-delete-all",
            //[Regions]----------------------------------------------------------------------------------------
            "settings-regions-access",
            "settings-regions-view",
            "settings-regions-view-all",
            "settings-regions-create",
            "settings-regions-edit",
            "settings-regions-edit-all",
            "settings-regions-delete",
            "settings-regions-delete-all",
            //[Cities]----------------------------------------------------------------------------------------
            "settings-cities-access",
            "settings-cities-view",
            "settings-cities-view-all",
            "settings-cities-create",
            "settings-cities-edit",
            "settings-cities-edit-all",
            "settings-cities-delete",
            "settings-cities-delete-all",
            //[others]
            "settings-settings-edit",
        );
        generate_permissions($permissions, "cadastre");
    }

}

if (!function_exists("get_settings_sidebar")) {
    function get_settings_sidebar($active_url = false)
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/settings", "icon" => "far fa-home"),
            "logos" => array("text" => lang("App.Logotypes"), "href" => "/settings/logos/view/" . lpk(), "icon" => ICON_DECREES, "permission" => "SETTINGS-ACCESS"),
            "conditions" => array("text" => lang("App.Policies-Conditions"), "href" => "/settings/conditions/view/" . lpk(), "icon" => ICON_POLICIES, "permission" => "SETTINGS-ACCESS"),
            "privacy" => array("text" => lang("App.Policies-Privacy"), "href" => "/settings/privacy/view/" . lpk(), "icon" => ICON_POLICIES, "permission" => "SETTINGS-ACCESS"),
            "advertising" => array("text" => lang("App.Policies-Advertising"), "href" => "/settings/advertising/view/" . lpk(), "icon" => ICON_POLICIES, "permission" => "SETTINGS-ACCESS"),
            "cookies" => array("text" => lang("App.Policies-Cookies"), "href" => "/settings/cookies/view/" . lpk(), "icon" => ICON_POLICIES, "permission" => "SETTINGS-ACCESS"),
            "more" => array("text" => lang("App.Policies-More"), "href" => "/settings/more/view/" . lpk(), "icon" => ICON_POLICIES, "permission" => "SETTINGS-ACCESS"),
            "email" => array("text" => lang("App.Emails"), "href" => "/settings/emails/home/" . lpk(), "icon" => ICON_EMAILS, "permission" => "SETTINGS-ACCESS"),
            //"roles" => array("text" => lang("App.Roles"), "href" => "/settings/roles/list/" . lpk(), "icon" => ICON_CROWN, "permission" => "SECURITY-ACCESS"),
            //"permissions" => array("text" => lang("App.Permissions"), "href" => "/settings/permissions/list/" . lpk(), "icon" => ICON_KEY, "permission" => "SECURITY-ACCESS"),
            //"tools" => array("text" => lang("App.Tools"), "href" => "/settings/tools/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "SECURITY-ACCESS"),
            //"settings" => array("text" => lang("App.Settings"), "href" => "/settings/settings/home/" . lpk(), "icon" => ICON_SETTINGS, "permission" => "SECURITY-ACCESS"),
            //"logs" => array("text" => lang("App.History"), "href" => "/settings/history/home/" . lpk(), "icon" => "far fa-history", "permission" => "SECURITY-ACCESS"),
            //"firewall" => array("text" => "Firewall", "href" => "/settings/firewall/home/" . lpk(), "icon" => ICON_FIREWALL, "permission" => "SECURITY-ACCESS"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
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


if (!function_exists("get_settings_messenger_users")) {
    /**
     * Retorna el listado inicial de usuarios que se graficaran en el listado del messenger
     * @user string còdigo del usuario que realiza la consulta.
     */
    function get_settings_messenger_users($user)
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


if (!function_exists("get_settings_copyright")) {

    function get_settings_copyright()
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


?>