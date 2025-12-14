<?php


namespace App\Modules\Organization\Controllers;

use App\Controllers\ModuleController;

class Characterization extends ModuleController
{

    public function __construct()
    {
        parent::__construct();
        $this->module = 'App\Modules\Organization';
        helper($this->module . '\Helpers\Organization');
        $this->prefix = 'organization-characterization';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Characterization';
    }


    public function index()
    {

    }

    public function view($oid = "")
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Characterization\View';
        return (view($this->viewer, $this->get_Array()));
    }


    public function edit($oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Characterization\Edit';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>