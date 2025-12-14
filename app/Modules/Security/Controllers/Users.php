<?php

namespace App\Modules\Security\Controllers;

use App\Controllers\ModuleController;

class Users extends ModuleController
{


    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'security-users';
        $this->module = 'App\Modules\Security';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Security');
    }

    public function index()
    {
        $url = base_url('security/users/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Users\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function review(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-review";
        $this->component = $this->views . '\Users\Review';
        return (view($this->viewer, $this->get_Array()));
    }



    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Users\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Users\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function importer(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-importer";
        $this->component = $this->views . '\Users\Importer';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Users\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Users\Delete';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>