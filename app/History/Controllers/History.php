<?php
/*
 * Copyright (c) 2021-2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Modules\History\Controllers;

use App\Controllers\ModuleController;

class History extends ModuleController
{


    public function __construct()
    {
        parent::__construct();
        helper('App\Modules\History\Helpers\History');
        $this->prefix = 'history';
        $this->module = 'App\Modules\History';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Home';
    }

    public function index()
    {
        generate_history_permissions();
        $url = base_url('history/home/' . lpk());
        return (redirect()->to($url));
    }

    public function home(string $rnd)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-home";
        return (view($this->viewer, $this->get_Array()));
    }

    public function general(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-general";
        $this->component = $this->views . '\General';
        return (view($this->viewer, $this->get_Array()));
    }

}

?>