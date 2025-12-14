<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace app\Messenger\Controllers;

use App\Controllers\BaseController;

class Authentications extends BaseController
{

    public $prefix;
    public $namespace;

    public function __construct()
    {

        helper('App\Modules\Messenger\Helpers\Messenger');
        $this->prefix = 'messenger-Authentications';
        $this->namespace = 'App\Modules\Messenger';
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