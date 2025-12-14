<?php

namespace App\Controllers;

use Higgs\Controller;
use App\Libraries\Server;

class Styles extends Controller
{


    public function index($oid)
    {
        $this->response->setHeader("Content-Type", "text/css");
        $body = view("App\Modules\Nexus\Views\Themes\CSS\index.php", array("oid" => $oid));
        return ($body);
    }


    public function hello()
    {
        return "Hello World!";
    }


}

?>