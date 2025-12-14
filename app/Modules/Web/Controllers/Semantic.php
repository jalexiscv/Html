<?php
/*
 * Copyright (c) 2021-2023. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Modules\Web\Controllers;

use App\Controllers\ModuleController;

class Semantic extends ModuleController
{


    public function __construct()
    {
        parent::__construct();
        helper('App\Modules\Web\Helpers\Web');
        $this->prefix = 'web-semantic';
        $this->module = 'App\Modules\Web';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Semantic';
    }

    public function index(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-post";
        return (view($this->viewer, $this->get_Array()));
    }


}

?>