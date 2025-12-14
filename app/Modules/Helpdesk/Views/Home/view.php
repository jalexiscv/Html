<?php
$server = service("server");
$authentication = service('authentication');
$bootstrap = service('bootstrap');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Helpdesk') / 102400), 6);
//[Build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("option-" . lpk(), array(
    "class" => "mb-3",
    'header-back' => "/",
    'image' => "/themes/assets/images/header/helpdesk.png?v3",
    "title" => "Módulo HelpDesk (Mesa de ayuda) <span class='text-muted'>v{$version}</span>",
    "text-class" => "text-center",
    "content" => lang("Sedux.intro-1"),
));
echo($card);

if ($authentication->get_LoggedIn()) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/helpdesk/conversations/create/" . lpk(), "icon" => ICON_QUESTION, "value" => "Crear", "description" => "Solicitud", "target" => "_self")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/helpdesk/conversations/list/" . lpk(), "icon" => ICON_HELPDESK, "value" => "Solicitudes", "description" => "Listado General", "target" => "_self")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/helpdesk/services/list/" . lpk(), "icon" => ICON_CENTERS, "value" => "Centros de Atención", "description" => "Listado General", "target" => "_self")));
    echo($shortcuts);
} else {
    $msg = "¡Hola! Gracias por intentar acceder a nuestro sistema. Sin embargo, es necesario que inicies sesión y seas un usuario autorizado para poder utilizar este sistema y sus componentes."
        . "Para tener acceso, asegúrate de tener una cuenta activa y las credenciales correctas. Si tienes alguna duda o necesitas asistencia, por favor, contacta al administrador del sistema."
        . "Recuerda que el acceso no autorizado a este sistema está prohibido y puede resultar en acciones legales correspondientes. Gracias por tu comprensión y colaboración.";
    $alert = $bootstrap->get_Alert(array(
        "type" => "info",
        "title" => "Acceso limitado",
        "message" => $msg,
        "close" => false,
        "icon" => "fa-regular fa-exclamation-triangle",
        "class" => "mb-3"
    ));
    echo($alert);
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/helpdesk/conversations/create/" . lpk(), "icon" => ICON_QUESTION, "value" => "Crear", "description" => "Solicitud", "target" => "_self")));
    echo($shortcuts);
}
?>