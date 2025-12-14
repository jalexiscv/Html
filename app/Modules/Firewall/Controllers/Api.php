<?php

namespace App\Modules\Firewall\Controllers;

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
        $this->module = 'App\Modules\Firewall';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Api';
        helper($this->module . '\Helpers\Firewall');
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
                echo(view('App\Modules\Firewall\Views\test\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Firewall.Api-breaches-no-option")));
        }
    }


    public function livetraffic(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Firewall\Views\Livetraffic\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Firewall.Api-breaches-no-option")));
        }
    }


    public function badbots(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Firewall\Views\Badbots\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Firewall.Api-breaches-no-option")));
        }
    }

    public function bans(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Firewall\Views\Bans\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Firewall.Api-breaches-no-option")));
        }
    }

    public function filters(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Firewall\Views\Filters\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Firewall.Api-breaches-no-option")));
        }
    }

}
