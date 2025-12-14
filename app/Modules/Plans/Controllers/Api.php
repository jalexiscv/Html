<?php

namespace App\Modules\Plans\Controllers;

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
        helper('App\Helpers\Application');
        helper('App\Modules\Web\Helpers\Web');
        $this->prefix = 'web-api';
        $this->module = 'App\Modules\Web';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Api';
    }

    // all users
    public function index()
    {
        $data = array("message" => "Api Online!");
        return $this->respond($data);
    }

    public function agents(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Plans\Views\Agents\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("App.Api-breaches-no-option")));
        }
    }


    /**
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return void
     */
    public function appointments(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Plans\Views\Appointments\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("App.Api-breaches-no-option")));
        }
    }

    public function tickets(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Plans\Views\Tickets\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("App.Api-breaches-no-option")));
        }
    }

    public function customers(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Plans\Views\Customers\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("App.Api-breaches-no-option")));
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
                echo(view('App\Modules\Plans\Views\Plans\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("App.Api-breaches-no-option")));
        }
    }

    /**
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return void
     */
    public function positions(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                //return ($this->respond(view('App\Modules\Mipg\Views\Api\positions', $data), 200));
                echo(view('App\Modules\Plans\Views\Api\positions', $data));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }

    public function whys(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                //return ($this->respond(view('App\Modules\Mipg\Views\Api\positions', $data), 200));
                echo(view('App\Modules\Plans\Views\Whys\List\json', $data));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }


}
