<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

if (!function_exists("generate_plans_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_plans_permissions()
    {
        $permissions = array(
            "plans-access",
            //plans
            "plans-plans-create",
            "plans-plans-view",
            "plans-plans-view-all",
            "plans-plans-edit",
            "plans-plans-edit-all",
            "plans-plans-delete",
            "plans-plans-delete-all",
            "plans-plans-approve",
            //Causes
            "plans-causes-create",
            "plans-causes-view",
            "plans-causes-view-all",
            "plans-causes-edit",
            "plans-causes-edit-all",
            "plans-causes-delete",
            "plans-causes-delete-all",
            //[causes]
            "plans-causes-evaluate",
            //[whys]
            "plans-whys-create",
            "plans-whys-view",
            "plans-whys-view-all",
            "plans-whys-edit",
            "plans-whys-edit-all",
            "plans-whys-delete",
            "plans-whys-delete-all",
            //[formulation]
            "plans-formulation-create",
            "plans-formulation-view",
            "plans-formulation-view-all",
            "plans-formulation-edit",
            "plans-formulation-edit-all",
            "plans-formulation-delete",
            "plans-formulation-delete-all",
            //[actions]
            "plans-actions-create",
            "plans-actions-view",
            "plans-actions-view-all",
            "plans-actions-edit",
            "plans-actions-edit-all",
            "plans-actions-delete",
            "plans-actions-delete-all",


        );
        generate_permissions($permissions, "plans");
    }
}



if (!function_exists("get_plans_sidebar2")) {
    function get_plans_sidebar2($active_url = false)
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/plans/", "svg" => "home.svg"),
            "plans" => array("text" => lang("App.Plans"), "href" => "/plans/plans/list/" . lpk(), "icon" => ICON_PLANS, "permission" => "plans-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPillsGamma($o, $active_url);
        return ($return);
    }
}





if (!function_exists("get_plans_sidebar")) {
    function get_plans_sidebar($active_url = false)
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/plans/", "svg" => "home.svg"),
            "plans" => array("text" => lang("App.Plans"), "href" => "/plans/plans/list/" . lpk(), "icon" => ICON_PLANS, "permission" => "plans-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }

    function get_plans_sidebarOLD($active_url = false)
    {
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/plans/", "svg" => "home.svg"),
            "customers" => array("text" => lang("App.Customers"), "href" => "/plans/customers/list/" . lpk(), "icon" => ICON_CUSTOMERS, "permission" => "plans-access"),
            "map" => array("text" => lang("App.Maps"), "href" => "/plans/maps/home/" . lpk(), "icon" => ICON_MAP, "permission" => "plans-access"),

        );
        $return = get_application_custom_sidebar($options, $active_url);
        return ($return);
    }
}


if (!function_exists("get_snippet_profiles_history")) {


    function get_snippet_profiles_history($customer)
    {
        $mprofiles = model('App\Modules\Plans\Models\Plans_Profiles');
        $strings = service("strings");

        $mprofiles = $mprofiles->where('customer', $customer)->findAll();

        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";

        foreach ($mprofiles as $profile) {
            $t .= "<li><b>Perfil: </b>: <a href=\"/plans/customers/view/{$customer}?profile={$profile['profile']}\">{$profile['profile']}</a> Fecha: {$profile['created_at']}</li>";
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


if (!function_exists("get_plans_messenger_users")) {
    /**
     * Retorna el listado inicial de usuarios que se graficaran en el listado del messenger
     * @user string còdigo del usuario que realiza la consulta.
     */
    function get_plans_messenger_users($user)
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


if (!function_exists("get_plans_copyright")) {

    function get_plans_copyright()
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