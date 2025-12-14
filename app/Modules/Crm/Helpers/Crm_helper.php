<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

if (!function_exists("generate_crm_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_crm_permissions()
    {
        $permissions = array(
            "crm-access",
            /** Tasas * */
            "crm-customers-create",
            "crm-customers-view",
            "crm-customers-view-all",
            "crm-customers-edit",
            "crm-customers-edit-all",
            "crm-customers-delete",
            "crm-customers-delete-all",
            "crm-approve-create",
            /** Agents * */
            "crm-agents-create",
            "crm-agents-view",
            "crm-agents-view-all",
            "crm-agents-edit",
            "crm-agents-edit-all",
            "crm-agents-delete",
            "crm-agents-delete-all",
            /** Appointments * */
            "crm-appointments-create",
            "crm-appointments-view",
            "crm-appointments-view-all",
            "crm-appointments-edit",
            "crm-appointments-edit-all",
            "crm-appointments-delete",
            "crm-appointments-delete-all",
            /** Tickets * */
            "crm-tickets-create",
            "crm-tickets-view",
            "crm-tickets-view-all",
            "crm-tickets-edit",
            "crm-tickets-edit-all",
            "crm-tickets-delete",
            "crm-tickets-delete-all",
        );
        generate_permissions($permissions, "crm");
    }

}

if (!function_exists("get_crm_sidebar")) {
    function get_crm_sidebar($active_url = false)
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/crm/", "svg" => "home.svg"),
            "agents" => array("text" => lang("App.Agents"), "href" => "/crm/agents/list/" . lpk(), "icon" => ICON_CUSTOMERS, "permission" => "crm-access"),
            "tickets" => array("text" => lang("App.Tickets"), "href" => "/crm/tickets/list/" . lpk(), "icon" => ICON_TICKETS, "permission" => "crm-access"),
            "appointments" => array("text" => lang("App.Appointments"), "href" => "/crm/appointments/list/" . lpk(), "icon" => ICON_APPOINTMENTS, "permission" => "crm-access"),
            "reports" => array("text" => lang("App.Reports"), "href" => "/crm/reports/home/" . lpk(), "icon" => ICON_REPORTS, "permission" => "crm-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }

    function get_crm_sidebarOLD($active_url = false)
    {
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/crm/", "svg" => "home.svg"),
            "customers" => array("text" => lang("App.Customers"), "href" => "/crm/customers/list/" . lpk(), "icon" => ICON_CUSTOMERS, "permission" => "crm-access"),
            "map" => array("text" => lang("App.Maps"), "href" => "/crm/maps/home/" . lpk(), "icon" => ICON_MAP, "permission" => "crm-access"),

        );
        $return = get_application_custom_sidebar($options, $active_url);
        return ($return);
    }
}


if (!function_exists("get_snippet_profiles_history")) {


    function get_snippet_profiles_history($customer)
    {
        $mprofiles = model('App\Modules\Crm\Models\Crm_Profiles');
        $strings = service("strings");

        $mprofiles = $mprofiles->where('customer', $customer)->findAll();

        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";

        foreach ($mprofiles as $profile) {
            $t .= "<li><b>Perfil: </b>: <a href=\"/crm/customers/view/{$customer}?profile={$profile['profile']}\">{$profile['profile']}</a> Fecha: {$profile['created_at']}</li>";
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


if (!function_exists("get_crm_messenger_users")) {
    /**
     * Retorna el listado inicial de usuarios que se graficaran en el listado del messenger
     * @user string còdigo del usuario que realiza la consulta.
     */
    function get_crm_messenger_users($user)
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


if (!function_exists("get_crm_copyright")) {

    function get_crm_copyright()
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