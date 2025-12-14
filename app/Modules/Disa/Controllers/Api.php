<?php

namespace App\Modules\Disa\Controllers;

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
        $this->module = 'App\Modules\Disa';
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
    public function countries(string $format, string $option, string $oid)
    {
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Api\countries'), 200));
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
    public function regions(string $format, string $option, string $oid)
    {
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Api\regions'), 200));
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
    public function politics(string $format, string $option, string $oid)
    {
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Mipg\Politics\Api\list'), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }


    /**
     * Retorna el listado de diagnosticos asociados a una politica especifica.
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return \Higgs\HTTP\Response|void
     */
    public function diagnostics(string $format, string $option, string $oid)
    {
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Api\diagnostics'), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }


    /**
     * Retorna el listado de diagnosticos asociados a una politica especifica.
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return \Higgs\HTTP\Response|void
     */
    public function components(string $format, string $option, string $oid)
    {
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Api\components'), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }


    /**
     * Retorna el listado de diagnosticos asociados a una politica especifica.
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return \Higgs\HTTP\Response|void
     */
    public function categories(string $format, string $option, string $oid)
    {
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Api\categories'), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }


    /**
     * Retorna el listado de diagnosticos asociados a una politica especifica.
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return \Higgs\HTTP\Response|void
     */
    public function activities(string $format, string $option, string $oid)
    {
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Api\activities'), 200));
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
    public function recommendations(string $format, string $option, string $oid)
    {
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Mipg\Recommendations\List\json', $data), 200));
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
    public function unassigned(string $format, string $option, string $oid)
    {
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Mipg\Recommendations\Home\json\unassigned', $data), 200));
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
    public function assigned(string $format, string $option, string $oid)
    {
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Mipg\Recommendations\Home\json\assigned', $data), 200));
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
    public function cities(string $format, string $option, string $oid)
    {
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Api\cities'), 200));
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
    public function quotations(string $format, string $option, string $oid)
    {
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Quotations\List\json'), 200));
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
    public function clients(string $format, string $option, string $oid)
    {
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Clients\List\json'), 200));
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
    public function sigep(string $format, string $rnd)
    {
        if ($format == "json") {
            return ($this->respond(view('App\Modules\Disa\Views\Api\furag'), 200));
        } else {
            $response = array(
                "error" => true,
                'message' => 'Formato no especificado: ' . $format,
            );
            return ($this->failNotFound(json_encode($response)));
        }
    }


    /**
     * @param string $format
     * @param string $rnd
     * @return \Higgs\HTTP\Response
     */
    public function macroprocesses(string $format, string $option, string $oid)
    {
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Mipg\Settings\Macroprocesses\List\json', $data), 200));
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
    public function processes(string $format, string $option, string $oid)
    {
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Mipg\Settings\Processes\List\json', $data), 200));
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
    public function subprocesses(string $format, string $option, string $oid)
    {
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Mipg\Settings\Subprocesses\List\json', $data), 200));
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
    public function positions(string $format, string $option, string $oid)
    {
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Mipg\Settings\Positions\List\json', $data), 200));
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
    public function institucionalplans(string $format, string $option, string $oid)
    {
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\Institutional\Plans\List\json', $data), 200));
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
    public function history(string $format, string $option, string $oid)
    {
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Disa\Views\History\List\json', $data), 200));
            } else {

            }
        } else {
            return ($this->failNotFound("Opción no especificada Api/History/" . $format));
        }
    }


}


?>