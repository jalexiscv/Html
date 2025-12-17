<?php

namespace App\Modules\Facebook\Controllers;

use App\Controllers\BaseController;

class Facebook extends BaseController
{

    public $prefix;
    public $namespace;

    public function __construct()
    {

        helper('App\Modules\Facebook\Helpers\Facebook');
        $this->prefix = 'facebook';
        $this->namespace = 'App\Modules\Facebook';
    }

    public function index()
    {
        $data = array("authentication" => $this->authentication, "view" => "{$this->prefix}-home", "id" => false);
        return (view("{$this->namespace}\Views\index", $data));
    }

    public function signin()
    {
        $data = array("authentication" => $this->authentication, "view" => "{$this->prefix}-signin", "id" => null);
        return (view("{$this->namespace}\Views\index", $data));
    }

    public function ajax($view, $id = null)
    {
        $data = array("view" => "{$this->prefix}-ajax-{$view}", "id" => $id);
        return (view("{$this->namespace}\Views\ajax", $data));
    }

}

?>