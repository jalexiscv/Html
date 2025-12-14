<?php
/*
 * Copyright (c) 2021-2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Modules\Nexus\Controllers;

use App\Controllers\ModuleController;

class Clients extends ModuleController
{


    public function __construct()
    {
        parent::__construct();
        helper('App\Modules\Nexus\Helpers\Nexus');
        $this->prefix = 'nexus-clients';
        $this->module = 'App\Modules\Nexus';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
    }

    public function index()
    {
        $url = base_url('nexus/clients/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $url = base_url('nexus/clients/list/' . lpk());
        return (redirect()->to($url));
    }

    public function view(string $oid, string $rnd)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Clients\View';
        return (view($this->viewer, $this->get_Array()));
    }


    public function list(string $rnd)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Clients\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Clients\Create';
        return (view($this->viewer, $this->get_Array()));
    }


    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Clients\Delete';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Clients\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

}

?>