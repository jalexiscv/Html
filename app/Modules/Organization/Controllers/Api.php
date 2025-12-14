<?php

namespace App\Modules\Organization\Controllers;

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
        $this->module = 'App\Modules\Organization';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Api';
        helper($this->module . '\Helpers\Organization');
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
                echo(view('App\Modules\Organization\Views	est\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Organization.Api-breaches-no-option")));
        }
    }


    public function plans(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Organization\Views\Plans\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Organization.Api-breaches-no-option")));
        }
    }


    public function macroprocesses(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Organization\Views\Macroprocesses\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Organization.Api-breaches-no-option")));
        }
    }


    public function processes(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Organization\Views\Processes\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Organization.Api-breaches-no-option")));
        }
    }

    public function subprocesses(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Organization\Views\Subprocesses\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Organization.Api-breaches-no-option")));
        }
    }

    public function positions(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Organization\Views\Positions\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Organization.Api-breaches-no-option")));
        }
    }


}
