<?php

namespace App\Modules\Nexus\Controllers;

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
        helper('App\Modules\Nexus\Helpers\Nexus');
        $this->prefix = 'nexus-api';
        $this->module = 'App\Modules\Nexus';
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

    /**
     * @param string $format
     * @param string $rnd
     * @return \Higgs\HTTP\Response
     */
    public function clients(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Nexus\Views\Clients\List\json'), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }


    /**
     * @param string $format
     * @param string $rnd
     * @return \Higgs\HTTP\Response
     */
    public function generators(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Nexus\Views\Generators\List\json'), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }

    /**
     * @param string $format
     * @param string $rnd
     * @return \Higgs\HTTP\Response
     */
    public function themes(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Nexus\Views\Themes\List\json'), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }

    /**
     * @param string $format
     * @param string $rnd
     * @return \Higgs\HTTP\Response
     */
    public function styles(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Nexus\Views\Styles\List\json', array("oid" => $oid)), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }


    public function css(string $oid)
    {
        header("Content-Type: text/json");
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-css";
        $this->component = $this->views . '\Themes\CSS';
        return ($this->respond(view("App\Modules\Nexus\Views\Themes\CSS\index", array("oid" => $oid))));
    }

    public function modules(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Nexus\Views\Modules\List\json'), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }


    public function authorizations(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Nexus\Views\Modules\Authorizations\json', array("oid" => $oid)), 200));
            } elseif ($option == 'edit') {
                return ($this->respond(view('App\Modules\Nexus\Views\Modules\Authorizations\check', $data), 200));
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
            return ($this->respond(view('App\Modules\Nexus\Views\Oauths\Api\json', $data), 200));
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }


}
