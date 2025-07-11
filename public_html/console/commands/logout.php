<?php

class logout extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    public function init($params)
    {
        session_unset();
        $this->abort("La sesión se ha cerrado correctamente.");
    }

    private function abort($message, $header = array())
    {
        $result = array("data" => "\n		[[ib;#FFF;<BACKGROUND>]" . $message . "]\n",
            "header" => $header);
        echo json_encode($result);
        die();
    }
}

?>