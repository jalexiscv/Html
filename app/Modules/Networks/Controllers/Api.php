<?php

namespace App\Modules\Networks\Controllers;

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
        helper('App\Modules\Networks\Helpers\Networks');
        $this->prefix = 'networks-api';
        $this->module = 'App\Modules\Networks';
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


    public function profiles(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Networks\Views\Profiles\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("App.Api-breaches-no-option")));
        }
    }


}
