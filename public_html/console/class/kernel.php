<?php

/*
	Kernel load the essential classes
*/

class Kernel
{
    public function __construct()
    {
        include("commands.php");
        include("user.php");
        $commands = new Commands();
        if ($commands->commandMode) {
            include("command.php");
            $commands->loadCommand();
        } else {
            include("template.php");
            $template = new Template();
            $template->init('terminal');
        }
    }
}

?>