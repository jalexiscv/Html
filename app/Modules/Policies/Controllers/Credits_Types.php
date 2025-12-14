<?php

namespace App\Modules\Policies\Controllers;

use App\Controllers\BaseController;

class Credits_Types extends BaseController
{

    public $prefix;
    public $namespace;

    public function __construct()
    {

        helper('App\Modules\Policies\Helpers\Policies');
        $this->prefix = 'acredit-credits-types';
        $this->namespace = 'App\Modules\Policies';
    }

    /**
     * Home
     * @param type $view
     * @return type
     */
    public function home($view = "home")
    {
        $data = array("authentication" => $this->authentication, "view" => "acredit-home", "id" => false);
        return (view("{$this->namespace}\Views\index", $data));
    }

    public function index($view = "home")
    {
        $data = array("authentication" => $this->authentication, "view" => "{$this->prefix}-home", "id" => false);
        return (view("{$this->namespace}\Views\index", $data));
    }

    /**
     * Los datos asociados a componentes se relacionan con autodiagnsoticos especificos.
     * @param type $diagnostic
     * @return type
     */
    public function view($category)
    {
        $data = array("authentication" => $this->authentication, "view" => "{$this->prefix}-view", "id" => $category);
        return (view("{$this->namespace}\Views\index", $data));
    }

    public function list($view = "home")
    {
        $data = array("authentication" => $this->authentication, "view" => "{$this->prefix}-list", "id" => false);
        return (view("{$this->namespace}\Views\index", $data));
    }

    public function create()
    {
        $data = array("authentication" => $this->authentication, "view" => "{$this->prefix}-create", "id" => null);
        return (view("{$this->namespace}\Views\index", $data));
    }

    public function edit($id)
    {
        $data = array("authentication" => $this->authentication, "view" => "{$this->prefix}-edit", "id" => $id);
        return (view("{$this->namespace}\Views\index", $data));
    }

    public function delete($id)
    {
        $data = array("authentication" => $this->authentication, "view" => "{$this->prefix}-delete", "id" => $id);
        return (view("{$this->namespace}\Views\index", $data));
    }

    public function ajax($view)
    {
        $data = array("view" => "{$this->prefix}-{$view}", "id" => null);
        return (view("{$this->namespace}\Views\ajax", $data));
    }

}

?>