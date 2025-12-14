<?php

namespace App\Modules\Plex\Controllers;

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
        $this->module = 'App\Modules\Plex';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Api';
        helper($this->module . '\Helpers\Plex');
    }

    // all users
    public function index()
    {
        $data = array("message" => "Api Online!");
        return $this->respond($data);
    }


    public function clients(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Plex\Views\Clients\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Plex.Api-breaches-no-option")));
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
                echo(view('App\Modules\Plex\Views\test\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Plex.Api-breaches-no-option")));
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
                return (view('App\Modules\Plex\Views\Authorizations\json', $data));
            } elseif ($option == 'edit') {
                return (view('App\Modules\Plex\Views\Authorizations\check', $data));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }



}
