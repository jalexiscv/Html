<?php

namespace App\Modules\Mipg\Controllers;

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
        $this->module = 'App\Modules\Mipg';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Api';
        helper($this->module . '\Helpers\Mipg');
    }

    // all users

    /**
     * @return mixed
     */
    public function index()
    {
        $data = array("message" => "Api Online!");
        return $this->respond($data);
    }

    /**
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return void
     */
    public function dimensions(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Mipg\Views\Dimensions\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Mipg.Api-breaches-no-option")));
        }
    }


    /**
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return void
     */
    public function politics(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Mipg\Views\Politics\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Mipg.Api-breaches-no-option")));
        }
    }


    /**
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return void
     */
    public function diagnostics(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Mipg\Views\Diagnostics\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Mipg.Api-breaches-no-option")));
        }
    }


    /**
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return void
     */
    public function components(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Mipg\Views\Components\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Mipg.Api-breaches-no-option")));
        }
    }

    /**
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return void
     */
    public function categories(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Mipg\Views\Categories\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Mipg.Api-breaches-no-option")));
        }
    }

    /**
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return void
     */
    public function activities(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Mipg\Views\Activities\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Mipg.Api-breaches-no-option")));
        }
    }

    /**
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return void
     */
    public function plans(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Mipg\Views\Plans\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Mipg.Api-breaches-no-option")));
        }
    }

    /**
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return void
     */
    public function test(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Mipg\Views\test\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Mipg.Api-breaches-no-option")));
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
                echo(view('App\Modules\Mipg\Views\Api\positions', $data));
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
                echo(view('App\Modules\Mipg\Views\Whys\List\json', $data));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }

}
