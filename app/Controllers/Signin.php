<?php

namespace App\Controllers;

class Signin extends BaseController
{

    public function index()
    {
        $data = array("session" => $this->session, "view" => "signin", "id" => false);
        return (view("index", $data));
    }


}
