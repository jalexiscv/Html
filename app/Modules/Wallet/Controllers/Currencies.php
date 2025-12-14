<?php

namespace App\Modules\Wallet\Controllers;

use App\Controllers\BaseController;

class Currencies extends BaseController
{

    public $prefix;
    public $namespace;

    public function __construct()
    {

        helper('App\Modules\Wallet\Helpers\Wallet');
        $this->prefix = 'wallet-currencies';
        $this->namespace = 'App\Modules\Wallet';
    }

    public function index()
    {
        $data = array("authentication" => $this->authentication, "view" => "{$this->prefix}-home", "id" => false);
        return (view("{$this->namespace}\Views\index", $data));
    }

    public function view($id)
    {
        $data = array("authentication" => $this->authentication, "view" => "{$this->prefix}-view", "id" => $id);
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

    public function ajax($view, $id = null)
    {
        $data = array("view" => "{$this->prefix}-ajax-{$view}", "id" => $id);
        return (view("{$this->namespace}\Views\ajax", $data));
    }

}

?>