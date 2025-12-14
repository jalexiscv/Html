<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Modules\Settings\Controllers;

use App\Controllers\ModuleController;

class Emails extends ModuleController
{


    public function __construct()
    {
        parent::__construct();
        $this->module = 'App\Modules\Settings';
        helper($this->module . '\Helpers\Settings');
        $this->prefix = 'settings-emails';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Home';
    }

    public function index()
    {
        $url = base_url('settings/emails/home/' . lpk());
        return (redirect()->to($url));
    }

    public function home(string $rnd = "index")
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Emails\Home';
        return (view($this->viewer, $this->get_Array()));
    }


    public function smtp(string $rnd = "index")
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-smtp";
        $this->component = $this->views . '\Emails\Smtp';
        return (view($this->viewer, $this->get_Array()));
    }

    public function imap(string $rnd = "index")
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-imap";
        $this->component = $this->views . '\Emails\Imap';
        return (view($this->viewer, $this->get_Array()));
    }

    public function test(string $rnd = "index")
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-test";
        $this->component = $this->views . '\Emails\Test';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>