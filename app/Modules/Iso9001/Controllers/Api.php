<?php

namespace App\Modules\Iso9001\Controllers;

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
        $this->module = 'App\Modules\Iso9001';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Api';
        helper($this->module . '\Helpers\Iso9001');
    }

    // all users
    public function index()
    {
        $data = array("message" => "Api Online!");
        return $this->respond($data);
    }

    public function requirements(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Iso9001\Views\Requirements\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Iso9001.Api-breaches-no-option")));
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
                echo(view('App\Modules\Iso9001\Views\Diagnostics\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Iso9001.Api-breaches-no-option")));
        }
    }

    public function components(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Iso9001\Views\Components\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Iso9001.Api-breaches-no-option")));
        }
    }

    public function categories(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Iso9001\Views\Categories\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Iso9001.Api-breaches-no-option")));
        }
    }

    public function activities(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Iso9001\Views\Activities\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Iso9001.Api-breaches-no-option")));
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
                echo(view('App\Modules\Iso9001\Views\test\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Iso9001.Api-breaches-no-option")));
        }
    }
}
