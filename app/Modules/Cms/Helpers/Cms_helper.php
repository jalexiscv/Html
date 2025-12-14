<?php

if (!function_exists("generate_cms_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_cms_permissions(): void
    {
        $permissions = array(
            "cms-access",
            //[Asigns]----------------------------------------------------------------------------------------
            "cms-asigns-access",
            "cms-asigns-view",
            "cms-asigns-view-all",
            "cms-asigns-create",
            "cms-asigns-edit",
            "cms-asigns-edit-all",
            "cms-asigns-delete",
            "cms-asigns-delete-all",
            //[Blocks]----------------------------------------------------------------------------------------
            "cms-blocks-access",
            "cms-blocks-view",
            "cms-blocks-view-all",
            "cms-blocks-create",
            "cms-blocks-edit",
            "cms-blocks-edit-all",
            "cms-blocks-delete",
            "cms-blocks-delete-all",
            //[Components]----------------------------------------------------------------------------------------
            "cms-components-access",
            "cms-components-view",
            "cms-components-view-all",
            "cms-components-create",
            "cms-components-edit",
            "cms-components-edit-all",
            "cms-components-delete",
            "cms-components-delete-all",
            //[Files]----------------------------------------------------------------------------------------
            "cms-files-access",
            "cms-files-view",
            "cms-files-view-all",
            "cms-files-create",
            "cms-files-edit",
            "cms-files-edit-all",
            "cms-files-delete",
            "cms-files-delete-all",
            //[Links]----------------------------------------------------------------------------------------
            "cms-links-access",
            "cms-links-view",
            "cms-links-view-all",
            "cms-links-create",
            "cms-links-edit",
            "cms-links-edit-all",
            "cms-links-delete",
            "cms-links-delete-all",
            //[Menus]----------------------------------------------------------------------------------------
            "cms-menus-access",
            "cms-menus-view",
            "cms-menus-view-all",
            "cms-menus-create",
            "cms-menus-edit",
            "cms-menus-edit-all",
            "cms-menus-delete",
            "cms-menus-delete-all",
            //[Metatags]----------------------------------------------------------------------------------------
            "cms-metatags-access",
            "cms-metatags-view",
            "cms-metatags-view-all",
            "cms-metatags-create",
            "cms-metatags-edit",
            "cms-metatags-edit-all",
            "cms-metatags-delete",
            "cms-metatags-delete-all",
            //[Posts]----------------------------------------------------------------------------------------
            "cms-posts-access",
            "cms-posts-view",
            "cms-posts-view-all",
            "cms-posts-create",
            "cms-posts-edit",
            "cms-posts-edit-all",
            "cms-posts-delete",
            "cms-posts-delete-all",
            //[Settings]----------------------------------------------------------------------------------------
            "cms-settings-access",
            "cms-settings-view",
            "cms-settings-view-all",
            "cms-settings-create",
            "cms-settings-edit",
            "cms-settings-edit-all",
            "cms-settings-delete",
            "cms-settings-delete-all",
            //[Typefiles]----------------------------------------------------------------------------------------
            "cms-typefiles-access",
            "cms-typefiles-view",
            "cms-typefiles-view-all",
            "cms-typefiles-create",
            "cms-typefiles-edit",
            "cms-typefiles-edit-all",
            "cms-typefiles-delete",
            "cms-typefiles-delete-all",
        );
        generate_permissions($permissions, "cms");
    }

}

if (!function_exists("get_cms_sidebar")) {

    function get_cms_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/cms/", "svg" => "home.svg"),
            "asigns" => array("text" => lang("Cms.Asigns"), "href" => "/cms/asigns/list/" . lpk(), "icon" => ICON_TOOLS, "permission" => "CMS-ACCESS"),
            "blocks" => array("text" => lang("Cms.Blocks"), "href" => "/cms/blocks/list/" . lpk(), "icon" => ICON_TOOLS, "permission" => "CMS-ACCESS"),
            "components" => array("text" => lang("Cms.Components"), "href" => "/cms/components/list/" . lpk(), "icon" => ICON_TOOLS, "permission" => "CMS-ACCESS"),
            "files" => array("text" => lang("Cms.Files"), "href" => "/cms/files/list/" . lpk(), "icon" => ICON_TOOLS, "permission" => "CMS-ACCESS"),
            "links" => array("text" => lang("Cms.Links"), "href" => "/cms/links/list/" . lpk(), "icon" => ICON_TOOLS, "permission" => "CMS-ACCESS"),
            "menus" => array("text" => lang("Cms.Menus"), "href" => "/cms/menus/list/" . lpk(), "icon" => ICON_TOOLS, "permission" => "CMS-ACCESS"),
            "metatags" => array("text" => lang("Cms.Metatags"), "href" => "/cms/metatags/list/" . lpk(), "icon" => ICON_TOOLS, "permission" => "CMS-ACCESS"),
            "posts" => array("text" => lang("Cms.Posts"), "href" => "/cms/posts/list/" . lpk(), "icon" => ICON_TOOLS, "permission" => "CMS-ACCESS"),
            "typefiles" => array("text" => lang("Cms.Typefiles"), "href" => "/cms/typefiles/list/" . lpk(), "icon" => ICON_TOOLS, "permission" => "CMS-ACCESS"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/cms/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "cms-access"),

        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }

}
?>
