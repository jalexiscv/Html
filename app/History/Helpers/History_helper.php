<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

if (!function_exists("generate_history_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_history_permissions()
    {
        $permissions = array(
            "history-access",
            /** Programs **/
            "history-stats-view",
            "history-stats-view-all",
            "history-stats-create",
            "history-stats-edit",
            "history-stats-edit-all",
            "history-stats-delete",
            "history-stats-delete-all",
        );
        generate_permissions($permissions, "HISTORY");
    }

}

if (!function_exists("get_history_sidebar")) {
    function get_history_sidebar($active_url = false)
    {
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/history/", "icon" => "far fa-home"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/history/settings/home/" . lpk(), "icon" => "far fa-landmark", "permission" => "HISTORY-ACCESS"),
        );
        $return = get_application_custom_sidebar($options, $active_url);
        return ($return);
    }
}


if (!function_exists("get_history_copyright")) {

    function get_history_copyright()
    {
        $gridter = "";
        $gridter .= "
<div id=\"gridter\">";
        $gridter .= "
    <div class=\"xl\">XL</div>
    ";
        $gridter .= "
    <div class=\"lg\">LG</div>
    ";
        $gridter .= "
    <div class=\"md\">MD</div>
    ";
        $gridter .= "
    <div class=\"sm\">SM</div>
    ";
        $gridter .= "
    <div class=\"xs\">XS</div>
    ";
        $gridter .= "
</div>";
        $c = "";
        $c .= ""
            . "
<div class=\"card\">"
            . "
    <div class=\"card-body\">"
            . "<p style=\"font-size: 1rem;line-height: 1rem;\"><b>Copyright © 2021 - 2031 </b> Todos los derechos
        reservados, se prohíbe su reproducción total o "
            . "parcial, así como su traducción a cualquier idioma sin la autorización escrita de su titular. "
            . "<a href=\"/policies/conditions\" class=\"link\">Términos y condiciones</a> | "
            . "<a href=\"/policies/privacy\" class=\"link\">Políticas de privacidad</a> | "
            . "<a href=\"/policies/advertising\" class=\"link\">Publicidad</a> | "
            . "<a href=\"/policies/cookies\" class=\"link\">Cookies</a> | "
            . "<a href=\"/policies/more\" class=\"link\">Más</a> | "
            . $gridter
            . "</p></div>
    "
            . "
</div>";
        return ($c);
    }

}
?>