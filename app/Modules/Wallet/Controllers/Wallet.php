<?php

namespace App\Modules\Wallet\Controllers;

use App\Controllers\ModuleController;

class Wallet extends ModuleController
{

    public $prefix;
    public $namespace;

    public function __construct()
    {
        parent::__construct();
        helper('App\Modules\Wallet\Helpers\Wallet');
        $this->prefix = 'wallet-';
        $this->module = 'App\Modules\Wallet';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Home';
    }

    public function index()
    {
        $url = base_url('wallet/home/' . lpk());
        return (redirect()->to($url));
    }

    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "wallet-home";
        return (view($this->viewer, $this->get_Array()));
    }

}

?>