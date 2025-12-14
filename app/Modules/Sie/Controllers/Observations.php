<?php

namespace App\Modules\Sie\Controllers;

use App\Controllers\ModuleController;

class Observations extends ModuleController
{


    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'sie-observations';
        $this->module = 'App\Modules\Sie';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Sie_helper');
    }

    public function index()
    {
        $url = base_url('sie/observations/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Observations\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Observations\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Observations\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Observations\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Observations\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Observations\Delete';
        return (view($this->viewer, $this->get_Array()));
    }

    public function teacher(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-teacher";
        $this->component = $this->views . '\Observations\Teacher';
        return (view($this->viewer, $this->get_Array()));
    }

    public function reports(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-reports";
        $this->component = $this->views . '\Observations\Reports';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>