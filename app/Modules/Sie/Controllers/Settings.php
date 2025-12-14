<?php

namespace App\Modules\Sie\Controllers;

use App\Controllers\ModuleController;

class Settings extends ModuleController
{


    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'sie-settings';
        $this->module = 'App\Modules\Sie';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Sie');
    }

    public function index()
    {
        $url = base_url('sie/settings/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Settings\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Settings\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Settings\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Settings\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Settings\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Settings\Delete';
        return (view($this->viewer, $this->get_Array()));
    }

    public function moodle(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-moodle";
        $this->component = $this->views . '\Settings\Moodle';
        return (view($this->viewer, $this->get_Array()));
    }

    public function formats(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-formats";
        $this->component = $this->views . '\Settings\Formats';
        return (view($this->viewer, $this->get_Array()));
    }

    public function contact(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-contact";
        $this->component = $this->views . '\Settings\Contact';
        return (view($this->viewer, $this->get_Array()));
    }





}

?>