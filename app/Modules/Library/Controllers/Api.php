<?php

namespace App\Modules\Library\Controllers;

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
        $this->module = 'App\Modules\Library';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Api';
        helper($this->module . '\Helpers\Library');
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
                echo(view('App\Modules\Library\Views\test\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Library.Api-breaches-no-option")));
        }
    }

    public function Authorizations(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Library\Views\Modules\Authorizations\json', array("oid" => $oid)), 200));
            } elseif ($option == 'edit') {
                return ($this->respond(view('App\Modules\Library\Views\Modules\Authorizations\check', $data), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }

    /**
     * Recepciona todas las transacciones relacionadas con los autorizadores de terceros que se configuren en el sistema
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return \Higgs\HTTP\Response|void
     */
    public function Oauths(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        $data = array("oid" => $oid, "option" => $option);
        if ($format == "json") {
            return ($this->respond(view('App\Modules\Library\Views\Oauths\Api\json', $data), 200));
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }

    public function resources(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Library\Views\Resources\List\json', $data));
                //return ($this->respond(view('App\Modules\Library\Views\Resources\List\json', array("oid" => $oid)), 200));
            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }

    public function networks(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Library\Views\Networks\List\json', array("oid" => $oid)), 200));
            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }

}
