<?php

namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package Higgs
 */

use Higgs\Controller;
use Higgs\HTTP\RequestInterface;
use Higgs\HTTP\ResponseInterface;
use App\Libraries\Session;
use Psr\Log\LoggerInterface;

class XMLController extends Controller
{

    protected $session;
    protected $helpers = [];

    public function __construct()
    {

    }

    /*     * ************************************************************************
     * *
     * Constructor.
     * *
     * *********************************************************************** */

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = new Session();
        header("Content-Type: text/xml");
        helper("form");
        helper('App\Helpers\Application');
        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        // $this->session = \Config\Services::session();
    }

}
