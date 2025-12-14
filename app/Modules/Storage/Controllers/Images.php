<?php

namespace App\Modules\Storage\Controllers;

use App\Controllers\ModuleController;

class Images extends ModuleController
{

    public string $prefix;

    public function __construct()
    {
        parent::__construct();
        helper('App\Modules\Storage\Helpers\Storage');
        $this->prefix = 'storage-images';
        $this->module = 'App\Modules\Storage';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Home';
    }

    public function index($view = "home")
    {
        $data = array("authentication" => $this->authentication, "view" => "{$this->prefix}-home", "id" => false);
        return (view("{$this->namespace}\Views\index", $data));
    }


    public function croppie($oid = null)
    {
        header('Content-Type: application/json');
        $this->oid = $oid;
        $this->view = "{$this->prefix}-croppie";
        return (view($this->views . "\ajax", $this->get_Array()));
    }


    public function single($id)
    {
        header('Content-Type: application/json');
        $data = array("authentication" => $this->authentication, "view" => "{$this->prefix}-single", "id" => $id);
        return (view("{$this->namespace}\Views\ajax", $data));
    }

    public function dropzone($id)
    {
        header('Content-Type: application/json');
        $data = array("authentication" => $this->authentication, "view" => "{$this->prefix}-dropzone", "id" => $id);
        return (view("{$this->namespace}\Views\ajax", $data));
    }

}

?>