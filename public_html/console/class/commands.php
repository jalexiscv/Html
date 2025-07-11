<?php

class Commands
{
    public $commandMode = false;
    protected $folder = "commands/";
    private $command;

    public function __construct()
    {
        if (isset($_POST["token"]) && isset($_POST["command"])) {
            $this->commandMode = true;
            //LOGIN NEED TO BE HERE IF YOU WANT TO HAVE IT
            $user = new User();
            if ($user->logged) {
                $this->command = strtolower($_POST["command"]);
            }
        }
    }

    public function loadCommand()
    {
        $result = array("data" => "", "header" => "");
        $part = explode(" ", $this->command);
        $command = $part[0];
        unset($part[0]);
        $params = $part;
        if (file_exists($this->folder . $command . ".php")) {
            include($this->folder . $command . ".php");
            $command = new $command;
            $command->init($params);
            $result["data"] = $command->data;
            $result["header"] = $command->header;
        }
        echo json_encode($result); //RESPUESTA
        die();
    }

}

?>