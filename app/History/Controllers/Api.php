<?php

namespace App\Modules\History\Controllers;

use Higgs\API\ResponseTrait;
use Higgs\RESTful\ResourceController;

/**
 * Api
 */
class Api extends ResourceController
{

    use ResponseTrait;

    use ResponseTrait;

    public $prefix;
    public $namespace;
    public $request;
    public $authentication;
    public $dates;
    public $strings;
    public $module;
    public $view;
    public $views;
    public $viewer;
    public $component;
    public $oid;
    public $option;
    public $libraries;
    public $models;
    public $data;
    protected $helpers = [];

    public function __construct()
    {
        header("Content-Type: text/json");
        helper('App\Helpers\Application');
        helper('App\Modules\Disa\Helpers\Disa');
        $this->prefix = 'disa-api';
        $this->module = 'App\Modules\History';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Api';
        $this->request = service("request");

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
    public function general(string $format, string $option, string $oid)
    {
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\History\Views\General\json', $data), 200));
            } else {

            }
        } else {
            return ($this->failNotFound("Opción no especificada Api/History/" . $format));
        }
    }


}

?>