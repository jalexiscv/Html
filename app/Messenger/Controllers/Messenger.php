<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace app\Messenger\Controllers;

use App\Controllers\ModuleController;

class Messenger extends ModuleController
{

    public function __construct()
    {
        parent::__construct();
        helper('App\Modules\Messenger\Helpers\Messenger');
        $this->module = 'App\Modules\Messenger';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\home';
    }

    public function index()
    {
        $this->oid = false;
        $this->prefix = "messenger-home";
        return view('App\Modules\Messenger\Views\index', $this->get_Array());
    }


}
