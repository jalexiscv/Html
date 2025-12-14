<?php

namespace App\Modules\Policies\Controllers;

use App\Controllers\BaseController;

class Conditions extends BaseController
{

    public $prefix;
    public $namespace;

    public function __construct()
    {

        helper('App\Modules\Policies\Helpers\Policies');
        $this->prefix = 'conditions-home';
        $this->namespace = 'App\Modules\Policies';
    }

    public function index($view = "home")
    {
        $this->home();
    }

    /**
     * Home
     * @param type $view
     * @return type
     */
    public function home($view = "home")
    {
        $data = array("authentication" => $this->authentication, "view" => "policies-conditions-home", "id" => false);
        return (view("{$this->namespace}\Views\index", $data));
    }

}

?>