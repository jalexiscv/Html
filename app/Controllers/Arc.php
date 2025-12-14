<?php

namespace App\Controllers;

use Higgs\Controller;
use App\Libraries\Server;

class Arc extends Controller
{


    public function index()
    {
        $this->response->setHeader("Content-Type", "application/javascript");
        $body = view("App\Views\Arc\Widget");
        return ($body);
    }

    public function sw()
    {
        $this->response->setHeader("Content-Type", "application/javascript");
        $body = view("App\Views\Arc\SW");
        return ($body);
    }

}

?>