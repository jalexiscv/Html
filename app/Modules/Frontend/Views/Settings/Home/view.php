<?php
$bootstrap = service("bootstrap");

$shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/frontend/shortcuts/list/" . lpk(), "icon" => ICON_TOOLS, "value" => "Accesos", "description" => "Administrador")));
$shortcuts->add($bootstrap->get_Shortcut(array("href" => "/frontend/migrate/home/" . lpk(), "icon" => ICON_TOOLS, "value" => "Actualizar", "description" => "Migraciones", "target" => "_blank")));
echo($shortcuts);


?>