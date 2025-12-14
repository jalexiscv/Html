<?php
/*
 * Copyright (c) 2021-2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Modules\C4isr\Controllers;

use App\Controllers\ModuleController;

class Mongo extends ModuleController
{


    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'c4isr';
        $this->module = 'App\Modules\C4isr';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Home';
        helper($this->module . '\Helpers\C4isr');
    }

    public function index()
    {
        $url = base_url('c4isr/home/' . lpk());
        return (redirect()->to($url));
    }

    public function home(string $rnd)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-home";
        return (view($this->viewer, $this->get_Array()));
    }

    public function denied(string $rnd = null): string
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-denied";
        return (view($this->viewer, $this->get_Array()));
    }


    public function processor(string $rnd = null): string
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-mongo-processor";
        $this->component = $this->views . '\Mongo\Processor';
        return (view($this->viewer, $this->get_Array()));
    }

    public function duplicates(string $rnd = null): string
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-mongo-duplicates";
        $this->component = $this->views . '\Mongo\Duplicates';
        return (view($this->viewer, $this->get_Array()));
    }

}

?>