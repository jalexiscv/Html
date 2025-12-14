<?php
/** @var $authentication */
$server = service("server");
$bootstrap = service("bootstrap");
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Security') / 102400), 6);

//echo __DIR__;
//echo __FILE__;

$card = $bootstrap->get_Card2("card-view-service", array(
    "class" => "mb-3",
    "header-title" => lang('Security.Module') . ": <span class='text-muted'>v{$version}</span>",
    "header-back" => "/",
    "image" => "/themes/assets/images/header/module-security.png",
    "content" => lang("Security.intro-p1")
));
echo($card);

if ($authentication->get_LoggedIn() && $authentication->has_Permission("SECURITY-ACCESS")) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/security/users/list/" . lpk(), "icon" => ICON_USERS, "value" => lang("App.Users"))));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/security/roles/list/" . lpk(), "icon" => ICON_ROLES, "value" => lang("App.Roles"))));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/security/permissions/list/" . lpk(), "icon" => ICON_PERMISSIONS, "value" => lang("App.Permissions"))));
    echo($shortcuts);
}
//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "SECURITY",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "HOME",
    "log" => "El usuario accede a la vista principal del Módulo de Seguridad",
));
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.title = "Seguridad";
    });
</script>
