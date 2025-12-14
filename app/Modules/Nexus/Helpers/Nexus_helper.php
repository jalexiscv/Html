<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

if (!function_exists("generate_nexus_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_nexus_permissions()
    {
        $permissions = array(
            "nexus-access",
            /** Tasas * */
            "nexus-modules-create",
            "nexus-modules-view",
            "nexus-modules-view-all",
            "nexus-modules-edit",
            "nexus-modules-edit-all",
            "nexus-modules-delete",
            "nexus-modules-delete-all",
            /* Clients */
            "nexus-clients-create",
            "nexus-clients-view",
            "nexus-clients-view-all",
            "nexus-clients-edit",
            "nexus-clients-edit-all",
            "nexus-clients-delete",
            "nexus-clients-delete-all",
            /* Themes */
            "nexus-themes-create",
            "nexus-themes-view",
            "nexus-themes-view-all",
            "nexus-themes-edit",
            "nexus-themes-edit-all",
            "nexus-themes-delete",
            "nexus-themes-delete-all",
            /* Styles */
            "nexus-styles-create",
            "nexus-styles-view",
            "nexus-styles-view-all",
            "nexus-styles-edit",
            "nexus-styles-edit-all",
            "nexus-styles-delete",
            "nexus-styles-delete-all",
            /* Modules */
            "nexus-modules-create",
            "nexus-modules-view",
            "nexus-modules-view-all",
            "nexus-modules-edit",
            "nexus-modules-edit-all",
            "nexus-modules-delete",
            "nexus-modules-delete-all",
        );
        generate_permissions($permissions, "nexus");
    }

}

if (!function_exists("get_nexus_sidebar")) {
    function get_nexus_sidebar($active_url = false)
    {
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/nexus/", "svg" => "home.svg"),
            "clients" => array("text" => lang("App.Clients"), "href" => "/nexus/clients/home/" . lpk(), "svg" => "clients.svg", "permission" => "nexus-clients-view-all"),
            "generators" => array("text" => lang("App.Generators"), "href" => "/nexus/generators/", "svg" => "generators.svg", "permission" => "nexus-access"),
            "modules" => array("text" => lang("App.Modules"), "href" => "/nexus/modules/list/{$lpk}", "svg" => "modules.svg", "permission" => "nexus-access"),
            "tools" => array("text" => lang("App.Tools"), "href" => "/nexus/tools/home/{$lpk}", "svg" => "pen-tool.svg", "permission" => "nexus-access"),
            "minifiers" => array("text" => lang("App.Minifiers"), "href" => "/nexus/minifiers/php/{$lpk}", "svg" => "zip.svg", "permission" => "nexus-access"),
            "themes" => array("text" => lang("App.Themes"), "href" => "/nexus/themes/list/{$lpk}", "svg" => "themes.svg", "permission" => "nexus-access"),
        );
        $return = get_application_custom_sidebar($options, $active_url);
        return ($return);
    }
}


if (!function_exists("get_nexus_messenger_users")) {
    /**
     * Retorna el listado inicial de usuarios que se graficaran en el listado del messenger
     * @user string còdigo del usuario que realiza la consulta.
     */
    function get_nexus_messenger_users($user)
    {
        $musers = model('App\Modules\Nexus\Models\Nexus_Users');
        $mfields = model('App\Modules\Nexus\Models\Nexus_Users_Fields');
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


if (!function_exists("get_nexus_code_copyright")) {
    function get_nexus_code_copyright(array $args)
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


if (!function_exists("get_nexus_copyright")) {

    function get_nexus_copyright()
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