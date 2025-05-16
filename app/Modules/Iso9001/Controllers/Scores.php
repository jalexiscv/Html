<?php

namespace App\Modules\Iso9001\Controllers;


use App\Controllers\ModuleController;

class Scores extends ModuleController
{

    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'iso9001-scores';
        $this->module = 'App\Modules\Iso9001';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Iso9001');
    }

    public function index()
    {
        $url = base_url('iso9001/scores/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Scores\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Scores\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Scores\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Scores\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Scores\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Scores\Delete';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>