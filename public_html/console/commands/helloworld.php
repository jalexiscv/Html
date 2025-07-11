<?php

class helloworld extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    public function init($params)
    {
        $result = "Hello World!";
        if (isset($params[1])) $result .= " " . $params[1];
        $this->data = $result;
    }
}

?>