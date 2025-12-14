<?php

if (!function_exists("generate_firewall_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_firewall_permissions(): void
    {
        $permissions = array(
            "firewall-access",
            //[politics]------------------------------------------------------------------------------------------------
            "firewall-livetraffic-create",
            "firewall-livetraffic-view",
            "firewall-livetraffic-view-all",
            "firewall-livetraffic-edit",
            "firewall-livetraffic-edit-all",
            "firewall-livetraffic-delete",
            "firewall-livetraffic-delete-all",
            //[badbots]-------------------------------------------------------------------------------------------------
            "firewall-badbots-create",
            "firewall-badbots-view",
            "firewall-badbots-view-all",
            "firewall-badbots-edit",
            "firewall-badbots-edit-all",
            "firewall-badbots-delete",
            "firewall-badbots-delete-all",
            //[bans]----------------------------------------------------------------------------------------------------
            "firewall-bans-create",
            "firewall-bans-view",
            "firewall-bans-view-all",
            "firewall-bans-edit",
            "firewall-bans-edit-all",
            "firewall-bans-delete",
            "firewall-bans-delete-all",
            //[filters]----------------------------------------------------------------------------------------------------
            "firewall-filters-create",
            "firewall-filters-view",
            "firewall-filters-view-all",
            "firewall-filters-edit",
            "firewall-filters-edit-all",
            "firewall-filters-delete",
            "firewall-filters-delete-all",
            //[Whitelist]----------------------------------------------------------------------------------------
            "firewall-whitelist-access",
            "firewall-whitelist-view",
            "firewall-whitelist-view-all",
            "firewall-whitelist-create",
            "firewall-whitelist-edit",
            "firewall-whitelist-edit-all",
            "firewall-whitelist-delete",
            "firewall-whitelist-delete-all",
        );
        generate_permissions($permissions, "firewall");
    }

}

if (!function_exists("get_firewall_sidebar")) {
    function get_firewall_sidebar($active_url = false): array
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $items = array(
            "home" => array("text" => lang("App.Home"), "href" => "/firewall/", "svg" => "home.svg"),
            "bans" => array("text" => lang("Firewall.bans"), "href" => "/firewall/bans/list/" . lpk(), "icon" => ICON_BAN, "permission" => "firewall-access"),
            "badbots" => array("text" => lang("Firewall.badbots"), "href" => "/firewall/badbots/list/" . lpk(), "icon" => ICON_BOT, "permission" => "firewall-access"),
            "livetraffic" => array("text" => lang("Firewall.livetraffic"), "href" => "/firewall/livetraffic/list/" . lpk(), "icon" => ICON_LIVETRAFFIC, "permission" => "firewall-access"),
            "filters" => array("text" => lang("Firewall.filters"), "href" => "/firewall/filters/list/" . lpk(), "icon" => ICON_FILTERS, "permission" => "firewall-access"),
            "whitelist" => array("text" => lang("Firewall.Whitelist"), "href" => "/firewall/whitelist/list/" . lpk(), "icon" => ICON_WHITELIST, "permission" => "firewall-access"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/firewall/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "firewall-access"),
        );
        $final_items = [];
        foreach ($items as $key => $item) {
            if (isset($item['permission'])) {
                if (safe_has_permission($item['permission'])) {
                    $final_items[$key] = $item;
                }
            } else {
                $final_items[$key] = $item;
            }
        }
        $left = ['sidebar_title' => 'Componentes', 'sidebar_menu_items' => $final_items];
        return ($left);
    }
}


if(!function_exists("get_firewall_widget_myip")){
    function get_firewall_widget_myip(): string
    {
        $server = service('server');
        $ip = $server->get_IPClient();
        $code="<div id=\"card-view-service\" class=\"card  mb-2\">";
        $code.="\t <div class=\"card-body\">";
        $code.="\t\t <div class=\"card-content text-center\">";
        $code.="<b>Ip</b>:$ip";
        $code.="\t\t </div>";
        $code.="\t </div>";
        $code.="</div>";
        return ($code);
    }

}

?>