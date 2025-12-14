<?php

if (!function_exists("generate_helpdesk_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_helpdesk_permissions(): void
    {
        $permissions = array(
            "helpdesk-access",
            /** services * */
            "helpdesk-services-create",
            "helpdesk-services-view",
            "helpdesk-services-view-all",
            "helpdesk-services-edit",
            "helpdesk-services-edit-all",
            "helpdesk-services-delete",
            "helpdesk-services-delete-all",
            /** agents * */
            "helpdesk-agents-create",
            "helpdesk-agents-view",
            "helpdesk-agents-view-all",
            "helpdesk-agents-edit",
            "helpdesk-agents-edit-all",
            "helpdesk-agents-delete",
            "helpdesk-agents-delete-all",
            /** conversations * */
            "helpdesk-conversations-create",
            "helpdesk-conversations-view",
            "helpdesk-conversations-view-all",
            "helpdesk-conversations-edit",
            "helpdesk-conversations-edit-all",
            "helpdesk-conversations-delete",
            "helpdesk-conversations-delete-all",
            /** messages * */
            "helpdesk-messages-create",
            "helpdesk-messages-view",
            "helpdesk-messages-view-all",
            "helpdesk-messages-edit",
            "helpdesk-messages-edit-all",
            "helpdesk-messages-delete",
            "helpdesk-messages-delete-all",
            /** types * */
            "helpdesk-types-create",
            "helpdesk-types-view",
            "helpdesk-types-view-all",
            "helpdesk-types-edit",
            "helpdesk-types-edit-all",
            "helpdesk-types-delete",
            "helpdesk-types-delete-all",
            /** categories * */
            "helpdesk-categories-create",
            "helpdesk-categories-view",
            "helpdesk-categories-view-all",
            "helpdesk-categories-edit",
            "helpdesk-categories-edit-all",
            "helpdesk-categories-delete",
            "helpdesk-categories-delete-all",
        );
        generate_permissions($permissions, "helpdesk");
    }

}

if (!function_exists("get_helpdesk_sidebar")) {
    function get_helpdesk_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/helpdesk/", "svg" => "home.svg"),
            "create" => array("text" => "Crear solicitud", "href" => "/helpdesk/conversations/create/" . lpk(), "icon" => ICON_TOOLS, "permission" => ""),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}


if (!function_exists("get_helpdesk_count_conversations_closed")) {

    function get_helpdesk_count_conversations_closed()
    {
        $mconversations = model("App\Modules\Helpdesk\Models\Helpdesk_Conversations");
        $count = $mconversations->get_TotalClosed();
        $code = "<div class=\"card flex-row align-items-center align-items-stretch mb-3\">\n";
        $code .= "\t\t<div class=\"col-4 d-flex align-items-center bg-gray justify-content-center rounded-left\">\n";
        $code .= "\t\t\t\t<i class=\"fa-light fa-envelope-circle-check fa-3x text-success\"></i>\n";
        $code .= "\t\t</div>\n";
        $code .= "\t\t<div class=\"col-8 py-3 bg-gray rounded-right\">\n";
        $code .= "\t\t\t\t<div class=\"fs-5 lh-5 my-0\">\n";
        $code .= "\t\t\t\t\t\t{$count}\t\t\t\t</div>\n";
        $code .= "\t\t\t\t<div class=\"\t\tmy-0\">\n";
        $code .= "\t\t\t\t\t\t" . lang("Conversations.requests-closed") . "\t\t\t\t</div>\n";
        $code .= "\t\t</div>\n";
        $code .= "</div>\n";
        return ($code);
    }

}


if (!function_exists("get_helpdesk_count_conversations")) {

    function get_helpdesk_count_conversations()
    {
        $mconversations = model("App\Modules\Helpdesk\Models\Helpdesk_Conversations");
        $count = $mconversations->get_Total();
        $code = "<div class=\"card flex-row align-items-center align-items-stretch mb-3\">\n";
        $code .= "\t\t<div class=\"col-4 d-flex align-items-center bg-gray justify-content-center rounded-left\">\n";
        $code .= "\t\t\t\t<i class=\"fa-light fa-envelope fa-3x\"></i>\n";
        $code .= "\t\t</div>\n";
        $code .= "\t\t<div class=\"col-8 py-3 bg-gray rounded-right\">\n";
        $code .= "\t\t\t\t<div class=\"fs-5 lh-5 my-0\">\n";
        $code .= "\t\t\t\t\t\t{$count}\t\t\t\t</div>\n";
        $code .= "\t\t\t\t<div class=\"\t\tmy-0\">\n";
        $code .= "\t\t\t\t\t\t" . lang("Conversations.requests-received") . "\t\t\t\t</div>\n";
        $code .= "\t\t</div>\n";
        $code .= "</div>\n";
        return ($code);
    }

}


?>
