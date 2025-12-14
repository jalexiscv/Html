<?php

namespace App\Controllers;

class Home extends BaseController
{

    public function index()
    {
        $url = base_url($this->session->get_ClientDefaultURL());
        if (!empty($url)) {
            return (redirect()->to($url . "?session=" . session_id()));
        }
    }

    public function signin()
    {
        $data = array("session" => $this->session, "view" => "signin", "id" => false);
        return (view("index", $data));
    }

    public function hook()
    {
        date_default_timezone_set('America/Bogota');
        $branch["local"] = "origin";
        $branch["remote"] = "2021";
        $repo["repos"] = "/www/wwwroot/Higgs-dominance";
        $repo["local"] = "/www/wwwroot/Higgs-dominance";
        $repo["remote"] = "https://github.com/jalexiscv/Higgs.git";
        if (file_exists($repo["local"])) {
            shell_exec(""
                . "cd " . $repo["local"] . " && git fetch --all && "
                . "git reset --hard " . $branch["local"] . "/" . $branch["remote"]
            );
        } else {
            shell_exec(""
                . "cd " . $repo["repos"] . " "
                . "&& git clone https://jalexiscv:anssible2019x@github.com/jalexiscv/Higgs.git"
            );
        }
    }

}
