<?php

class Template
{
    private $folder = "templates/";

    public function __construct()
    {

    }

    public function init($template)
    {
        include($this->folder . $template . "/index.php");
    }
}

?>