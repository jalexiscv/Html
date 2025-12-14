<?php

namespace App\Modules\Sgd\Controllers;

use Higgs\API\ResponseTrait;
use Higgs\RESTful\ResourceController;

/**
 * Api
 */
class Api extends ResourceController
{
    use ResponseTrait;

    public $namespace;
    protected $prefix;
    protected $module;
    protected $views;
    protected $viewer;
    protected $component;

    public function __construct()
    {
        //header("Content-Type: text/json");
        $this->prefix = 'web-api';
        $this->module = 'App\Modules\Sgd';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Api';
        helper($this->module . '\Helpers\Sgd');
    }

    // all users
    public function index()
    {
        $data = array("message" => "Api Online!");
        return $this->respond($data);
    }


    public function test(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sgd\Views\test\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sgd.Api-breaches-no-option")));
        }
    }

    public function units(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sgd\Views\Api\Units\list', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sgd.Api-breaches-no-option")));
        }
    }

    public function series(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sgd\Views\Api\Series\list', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sgd.Api-breaches-no-option")));
        }
    }

    public function subseries(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sgd\Views\Api\Subseries\list', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sgd.Api-breaches-no-option")));
        }
    }


    public function shelves(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sgd\Views\Api\Shelves\list', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sgd.Api-breaches-no-option")));
        }
    }

    public function boxes(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sgd\Views\Api\Boxes\list', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sgd.Api-breaches-no-option")));
        }
    }

    public function folders(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sgd\Views\Api\Folders\list', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sgd.Api-breaches-no-option")));
        }
    }

    public function locations(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'create') {
                echo(view('App\Modules\Sgd\Views\Api\Locations\create', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sgd.Api-breaches-no-option")));
        }
    }

    public function images(string $format, string $option, string $oid)
    {
        header('Content-Type: image/png');

        if($option=="sticker"){
            echo(view("App\Modules\Sgd\Views\Api\Images\sticker", array()));
        }else if($option=="qr"){
            echo(view("App\Modules\Sgd\Views\Api\Images\qr", array()));
        }else{
            return ($this->failNotFound(lang("Sgd.Api-breaches-no-option")));
        }


    }



}
