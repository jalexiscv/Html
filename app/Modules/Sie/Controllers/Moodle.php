<?php

namespace App\Modules\Sie\Controllers;

use App\Controllers\ModuleController;

class Moodle extends ModuleController
{

    //[Sie/Config/Routes]


    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'sie-moodle';
        $this->module = 'App\Modules\Sie';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Sie_helper');
    }

    public function index()
    {
        $url = base_url('sie/modules/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Modules\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Modules\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Modules\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Modules\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Modules\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Modules\Delete';
        return (view($this->viewer, $this->get_Array()));
    }


    public function courses($option)
    {
        if ($option == "list") {
            echo(view('App\Modules\Sie\Views\Moodle\Courses\List\index'));
        } elseif ($option == "create") {
            echo(view('App\Modules\Sie\Views\Moodle\Courses\Create\index'));
        } elseif ($option == "clone") {
            echo(view('App\Modules\Sie\Views\Moodle\Courses\Clone\index'));
        } else {
            echo("Opcion de cursos no valida");
        }
    }

    public function synchronization(string $oid)
    {

        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-synchronization";
        $this->component = $this->views . '\Moodle\Users\Synchronization';
        return (view($this->viewer, $this->get_Array()));
    }





}

?>