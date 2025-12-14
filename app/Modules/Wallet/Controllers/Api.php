<?php

namespace App\Modules\Wallet\Controllers;

use Higgs\API\ResponseTrait;
use Higgs\RESTful\ResourceController;

/**
 * Api
 */
class Api extends ResourceController
{

    use ResponseTrait;

    public $prefix;
    public $namespace;
    public $request;
    public $module;
    public $views;
    public $viewer;
    public $component;

    public function __construct()
    {
        header("Content-Type: text/json");
        helper('App\Helpers\Application');
        helper('App\Modules\Wallet\Helpers\Wallet');
        $this->prefix = 'wallet-api';
        $this->module = 'App\Modules\Wallet';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Api';
        $this->request = service("request");
    }

    /**
     * @param string $format
     * @param string $rnd
     * @return \Higgs\HTTP\Response
     */
    public function transactions(string $format, string $option, string $oid)
    {
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Wallet\Views\Transactions\List\json'), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.api-clients-no-option")));
        }
    }


}

?>