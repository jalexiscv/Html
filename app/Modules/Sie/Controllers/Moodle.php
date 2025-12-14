<?php

namespace App\Modules\Sie\Controllers;

use App\Controllers\ModuleController;

class Moodle extends ModuleController
{

    //[Sie/Config/Routes]


    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'sie-moodle';
        $this->module = 'App\Modules\Sie';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Sie_helper');
    }

    public function index()
    {
        $url = base_url('sie/modules/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Moodle\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Moodle\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Moodle\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Moodle\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Moodle\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Moodle\Delete';
        return (view($this->viewer, $this->get_Array()));
    }

    public function courses($option)
    {
        if ($option == "list") {
            echo(view('App\Modules\Sie\Views\Moodle\Courses\List\index'));
        } elseif ($option == "create") {
            echo(view('App\Modules\Sie\Views\Moodle\Courses\Create\index'));
        } elseif ($option == "clone") {
            echo(view('App\Modules\Sie\Views\Moodle\Courses\Clone\index'));
        } elseif ($option == "delete") {
            echo(view('App\Modules\Sie\Views\Moodle\Courses\Delete\index'));
        } elseif ($option == "synchronization") {
            echo(view('App\Modules\Sie\Views\Moodle\Courses\Synchronization\index'));
        } else {
            echo("Opcion de cursos no valida");
        }
    }

    public function students($option)
    {
        if ($option == "list") {
            echo(view('App\Modules\Sie\Views\Moodle\Students\List\index'));
        } elseif ($option == "create") {
            echo(view('App\Modules\Sie\Views\Moodle\Students\Create\index'));
        } elseif ($option == "edit") {
            echo(view('App\Modules\Sie\Views\Moodle\Students\Edit\index'));
        } elseif ($option == "delete") {
            echo(view('App\Modules\Sie\Views\Moodle\Students\Delete\index'));
        } elseif ($option == "asign") {
            echo(view('App\Modules\Sie\Views\Moodle\Students\Asign\index'));
        } elseif ($option == "synchronization") {
            echo(view('App\Modules\Sie\Views\Moodle\Students\Synchronization\index'));
        } else {
            echo("Opcion de cursos no valida");
        }
    }


    public function teachers($option)
    {
        if ($option == "list") {
            echo(view('App\Modules\Sie\Views\Moodle\Teachers\List\index'));
        } elseif ($option == "create") {
            echo(view('App\Modules\Sie\Views\Moodle\Teachers\Create\index'));
        } elseif ($option == "edit") {
            echo(view('App\Modules\Sie\Views\Moodle\Teachers\Edit\index'));
        } elseif ($option == "delete") {
            echo(view('App\Modules\Sie\Views\Moodle\Teachers\Delete\index'));
        } elseif ($option == "asign") {
            echo(view('App\Modules\Sie\Views\Moodle\Teachers\Asign\index'));
        } elseif ($option == "synchronization") {
            echo(view('App\Modules\Sie\Views\Moodle\Teachers\Synchronization\index'));
        } elseif ($option == "assignments") {
            echo(view('App\Modules\Sie\Views\Moodle\Teachers\Assignments\index'));
        } else {
            echo("Opcion de cursos no valida");
        }
    }


    public function passwords($option)
    {
        if ($option == "assignments") {
            echo(view('App\Modules\Sie\Views\Moodle\Passwords\Assignments\index'));
        } else {

        }
    }


    public function synchronization(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-synchronization";
        $this->component = $this->views . '\Moodle\Users\Synchronization';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>