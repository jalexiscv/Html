<?php

namespace App\Modules\Sogt\Controllers;

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
				  $this->module = 'App\Modules\Sogt';
				  $this->views = $this->module . '\Views';
				  $this->viewer = $this->views . '\index';
				  $this->component = $this->views . '\Api';
			    	helper($this->module . '\Helpers\Sogt');
		}

		// all users
		public function index()
		{
				$data = array("message" => "Api Online!");
				return $this->respond($data);
		}

    /**
     * Telemetry
     * @method telemetry
     * @access public
     * @examples:
     *      1): https://intranet.pynpass.com/api/telemetry/json/create/1234567890
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return void
     */
    public function telemetry(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'create') {
                echo(view('App\Modules\Sogt\Views\Api\Telemetry\Create\index', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sogt.Api-breaches-no-option")));
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
								echo(view('App\Modules\Sogt\Views\test\List\json', $data));
						}
				} else {
						return ($this->failNotFound(lang("Sogt.Api-breaches-no-option")));
				}
		}
}
