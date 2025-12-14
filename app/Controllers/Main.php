<?php

namespace App\Controllers;

class Main extends BaseController
{

    public function index()
    {
        $url = $this->authentication->get_ClientDefaultURL();
        if (!empty($url)) {
            return (redirect()->to(base_url($url) . "?session=" . session_id()));
        } else {
            //print_r($this->session);
        }
    }

    public function signin()
    {
        $data = array("session" => $this->authentication, "view" => "signin", "id" => false);
        return (view("index", $data));
    }

    public function robots()
    {
        $this->response->setHeader("Content-Type", "text/plain");
        $str = "\nUser-agent: *";
        $str .= "\nAllow: / ";
        return ($str);
    }

    public function sitemap()
    {
        $server = service('server');
        $dates = service('dates');
        $sn = $server->get_Name();
        $gdate = $dates::get_Date();
        $gtime = $dates::get_Time();
        $date = $dates::getGoogleDateFormat($gdate, $gtime);
        $this->response->setHeader("Content-Type", "application/xml");
        $c = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $c .= "<?xml-stylesheet type=\"text/xsl\" href=\"//wikiverso.com/sitemap.xsl\"?>\n";
        $c .= "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        $c .= "    <sitemap>\n";
        $c .= "        <loc>https://{$sn}/web/sitemaps/index.xml</loc>\n";
        $c .= "        <lastmod>{$date}</lastmod>\n";
        $c .= "    </sitemap>\n";
        $c .= "</sitemapindex>\n";
        return ($c);
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
