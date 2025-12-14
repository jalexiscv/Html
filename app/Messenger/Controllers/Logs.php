<?php
/*
 * Copyright (c) 2021-2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace app\Messenger\Controllers;

use App\Controllers\BaseController;

class Logs extends BaseController
{

    public $prefix;
    public $namespace;

    public function __construct()
    {
        helper('App\Modules\Messenger\Helpers\Messenger');
        $this->prefix = 'messenger-logs';
        $this->namespace = 'App\Modules\Messenger';
    }

    public function index($view = "home")
    {
        return ("logs");
    }


    public function ajax($view, $id)
    {
        $data = array("view" => "{$this->prefix}-{$view}", "id" => $id);
        return (view("{$this->namespace}\Views\ajax", $data));
    }


}

?>