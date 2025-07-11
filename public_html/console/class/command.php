<?php

/*
web command developement
user login
*/

class Command
{
    public static $info = "This command have no information.";
    public $data;
    public $root;
    public $header = array("code" => "200");

    protected $folder = "commands/";

    public function __construct()
    {
        $this->root = "/home/" . $_SESSION["user"]["username"] . "/";
        $this->header["prompt"] = "PHPQuery:~$ / ";
        $_SESSION["user"]["prompt"] = $this->header["prompt"];
    }

    static public function help()
    {
        return "This command have no information.";
    }

    protected function syntaxError($params, $n)
    {
        $message = false;
        if (count($params) != $n) {
            $message = 'Error de sintaxis: Utilice el comando help para obtener m�s informaci�n del comando';
            $message = "\n		[[ib;#FFF;]" . $message . "]";
        }
        return utf8_encode($message);
    }
}

?>