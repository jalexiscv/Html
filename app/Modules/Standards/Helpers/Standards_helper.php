<?php

if (!function_exists("generate_sgd_permissions")) {
    function generate_sgd_permissions(): void
    {
        $permissions = array(
            "standards-access",
            //[standards]-----------------------------------------------------------------------------------------------
            "standards-objects-access",
            "standards-objects-view",
            "standards-objects-view-all",
            "standards-objects-create",
            "standards-objects-edit",
            "standards-objects-edit-all",
            "standards-objects-delete",
            "standards-objects-delete-all",
            //[Categories]----------------------------------------------------------------------------------------------
            "standards-categories-access",
            "standards-categories-view",
            "standards-categories-view-all",
            "standards-categories-create",
            "standards-categories-edit",
            "standards-categories-edit-all",
            "standards-categories-delete",
            "standards-categories-delete-all",
            //[Scores]----------------------------------------------------------------------------------------
            "standards-scores-access",
            "standards-scores-view",
            "standards-scores-view-all",
            "standards-scores-create",
            "standards-scores-edit",
            "standards-scores-edit-all",
            "standards-scores-delete",
            "standards-scores-delete-all",
        );
        generate_permissions($permissions, "standards");
    }
}

if (!function_exists("get_standards_sidebar2")) {
    function get_standards_sidebar2($active_url = false)
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array(
                "text" => lang("App.Home"),
                "href" => "/standards/",
                "svg" => "home.svg"
            ),
            "standards" => array(
                "text" => "Normas",
                "href" => "/standards/objects/list/" . lpk(),
                "icon" => ICON_BOOK,
                "permission" => "standards-access"
            ),
            "categories" => array(
                "text" => "Elementos", "href" => "/standards/categories/list/" . lpk(),
                "icon" => ICON_BOOKMARK,
                "permission" => "standards-access"
            ),
            "settings" => array(
                "text" => "Configuración",
                "href" => "/standards/settings/home/" . lpk(),
                "icon" => ICON_TOOLS,
                "permission" => "standards-access"
            ),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPillsGamma($o, $active_url);
        return ($return);
    }
}




if (!function_exists("get_standards_sidebar")) {
    function get_standards_sidebar($active_url = false): array
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $items = array(
            "home" => array(
                "text" => lang("App.Home"),
                "href" => "/standards/",
                "svg" => "home.svg"
            ),
            "standards" => array(
                "text" => "Normas",
                "href" => "/standards/objects/list/" . lpk(),
                "icon" => ICON_BOOK,
                "permission" => "standards-access"
            ),
            "categories" => array(
                "text" => "Elementos", "href" => "/standards/categories/list/" . lpk(),
                "icon" => ICON_BOOKMARK,
                "permission" => "standards-access"
            ),
            "settings" => array(
                "text" => "Configuración",
                "href" => "/standards/settings/home/" . lpk(),
                "icon" => ICON_TOOLS,
                "permission" => "standards-access"
            ),
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
?>