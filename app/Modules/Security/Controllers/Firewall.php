<?php
/*
 * Copyright (c) 2022-2023. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Modules\Security\Controllers;

use App\Controllers\ModuleController;

class Firewall extends ModuleController
{

    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'security-firewall';
        $this->module = 'App\Modules\Security';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Security');
    }

    public function index()
    {
        $url = base_url('disa/history/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Firewall\Home';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>