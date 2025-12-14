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
use App\Libraries\Authentication;
use Psr\Log\LoggerInterface;

class BaseController extends Controller
{

    protected $authentication;
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
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->authentication = service('authentication');
        helper('security');
        helper("form");
        helper('App\Helpers\Application');
        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        // $this->session = \Config\Services::session();
    }

}
