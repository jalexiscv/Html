<?php

namespace App\Controllers;

require_once(APPPATH . 'ThirdParty/Smarty/libs/Smarty.class.php');


use Higgs\Controller;
use App\Libraries\Server;
use App\Libraries\Session;
use App\Libraries\Images\Resize;

class Debug extends Controller
{

    public function index()
    {
        $session = new Session();
    }


    public function session()
    {
        //echo("<pre>");
        //echo(session_id());
        //print_r($_SESSION);
        //echo("</pre>");

        echo '<pre>';
        var_dump($_SESSION);
        echo '</pre>';
    }

    public function logs()
    {
        $logs=view("App\Views\Themes\Beta\log_viewer");
        echo($logs);
    }


    public function telesign()
    {
        echo("<br>TeleSight");

    }

    function phpinfo()
    {
        phpinfo();
    }

    function rezise()
    {
        $image = new Resize();
        $image->open("https://cdn.computerhoy.com/sites/navi.axelspringer.es/public/styles/1200/public/media/image/2021/10/honor-band-6-analisis-opinion-2496847.jpg?itok=Txp5JCHR");
        $image->resize(200, 200, false);
        $image->display(70);
        $image->save(PUBLICPATH . "/resize/redimensionada3.jpg", "thumbnail", 70);
    }


    function minify()
    {
        $minifier = new \App\Libraries\Minifiers();
        //$minifier->setSource(APPPATH . "ThirdParty/");
        //$minifier->setTarget(APPPATH . "ThirdPartyM/");
        //$minifier->setSource(ROOTPATH . "system/");
        //$minifier->setTarget(ROOTPATH . "systemm/");
        $minifier->run();
    }


}
