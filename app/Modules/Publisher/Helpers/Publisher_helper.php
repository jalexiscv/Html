<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

if (!function_exists("generate_publisher_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_publisher_permissions()
    {
        $permissions = array(
            "publisher-access",
            //sites
            "publisher-sites-create",
            "publisher-sites-view",
            "publisher-sites-view-all",
            "publisher-sites-edit",
            "publisher-sites-edit-all",
            "publisher-sites-delete",
            "publisher-sites-delete-all",

        );
        generate_permissions($permissions, "cadastre");
    }

}

if (!function_exists("get_publisher_sidebar")) {
    function get_publisher_sidebar($active_url = false)
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/publisher/", "svg" => "home.svg"),
            "sites" => array("text" => lang("App.Websites"), "href" => "/publisher/sites/list/" . lpk(), "icon" => ICON_WEBS, "permission" => "publisher-sites-view-all"),
            "generators" => array("text" => lang("App.Generators"), "href" => "/publisher/generators/list/" . lpk(), "icon" => ICON_GENERATORS, "permission" => "publisher-access"),
            "tools" => array("text" => lang("App.Tools"), "href" => "/publisher/tools/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "publisher-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }

    function get_publisher_sidebarOLD($active_url = false)
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


if (!function_exists("get_publisher_messenger_users")) {
    /**
     * Retorna el listado inicial de usuarios que se graficaran en el listado del messenger
     * @user string còdigo del usuario que realiza la consulta.
     */
    function get_publisher_messenger_users($user)
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


if (!function_exists("get_publisher_copyright")) {

    function get_publisher_copyright()
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


if (!function_exists("get_publisher_code_copyright")) {
    function get_publisher_code_copyright(array $args)
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


?>