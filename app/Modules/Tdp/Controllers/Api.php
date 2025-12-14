<?php

namespace App\Modules\Tdp\Controllers;

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
        $this->module = 'App\Modules\Tdp';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Api';
        helper($this->module . '\Helpers\Tdp');
    }

    // all users
    public function index()
    {
        $data = array("message" => "Api Online!");
        return $this->respond($data);
    }

    public function dimensions(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Tdp\Views\Dimensions\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Tdp.Api-breaches-no-option")));
        }
    }

    public function lines(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Tdp\Views\Lines\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Tdp.Api-breaches-no-option")));
        }
    }


    public function diagnostics(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Tdp\Views\Diagnostics\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Tdp.Api-breaches-no-option")));
        }
    }

    public function sectors(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Tdp\Views\Sectors\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Tdp.Api-breaches-no-option")));
        }
    }


    public function programs(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Tdp\Views\Programs\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Tdp.Api-breaches-no-option")));
        }
    }

    public function products(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Tdp\Views\Products\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Tdp.Api-breaches-no-option")));
        }
    }

    public function indicators(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Tdp\Views\Indicators\Home\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Tdp.Api-breaches-no-option")));
        }
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
                echo(view('App\Modules\Tdp\Views\test\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Tdp.Api-breaches-no-option")));
        }
    }
}
