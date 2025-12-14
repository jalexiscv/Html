<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Modules\Disa\Controllers;

use App\Controllers\ModuleController;

class Mipg extends ModuleController
{

    public function __construct()
    {
        parent::__construct();
        helper('App\Modules\Disa\Helpers\Disa');
        $this->prefix = 'disa-mipg';
        $this->module = 'App\Modules\Disa';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Mipg';
    }

    public function index()
    {
        $url = base_url('disa/mipg/home/' . lpk());
        return (redirect()->to($url));
    }

    public function home(string $rnd)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-home";
        return (view($this->viewer, $this->get_Array()));
    }

    public function enter(string $rnd)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-enter";
        return (view($this->viewer, $this->get_Array()));
    }

    public function control(string $rnd)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-control";
        return (view($this->viewer, $this->get_Array()));
    }


}

?>