<?php

namespace App\Modules\Settings\Controllers;

use App\Controllers\ModuleController;

class Countries extends ModuleController
{

    //[Application/Config/Routes]

    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'settings-countries';
        $this->module = 'App\Modules\Settings';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Settings');
    }

    public function index()
    {
        $url = base_url('application/countries/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Countries\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Countries\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Countries\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Countries\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Countries\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Countries\Delete';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>