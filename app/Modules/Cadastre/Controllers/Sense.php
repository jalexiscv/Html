<?php

namespace App\Modules\Cadastre\Controllers;

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-06-22 13:47:12
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Cadastre\Controllers\_Sense.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/

use App\Controllers\ModuleController;

class Sense extends ModuleController
{

    //[Cadastre/Config/Routes]
    //[Sense]
    //$subroutes->add('Sense', 'Sense::index');
    //$subroutes->add('Sense/Sense/(:any)', 'Sense::Sense/$1');
    //$subroutes->add('Sense/list/(:any)', 'Sense::list/$1');
    //$subroutes->add('Sense/create/(:any)', 'Sense::create/$1');
    //$subroutes->add('Sense/view/(:any)/', 'Sense::view/$1');
    //$subroutes->add('Sense/edit/(:any)/', 'Sense::edit/$1');
    //$subroutes->add('Sense/delete/(:any)/', 'Sense::delete/$1');
    //$subroutes->add('api/Sense/(:any)/(:any)/(:any)', 'Api::Sense/$1/$2/$3');
    //[Cadastre/Views/index]
    //[Sense]
    //"cadastre-Sense-Sense"=>component("{$views}\Sense\Sense\index",$data),
    //"cadastre-Sense-list"=>component("{$views}\Sense\List\index",$data),
    //"cadastre-Sense-view"=>component("{$views}\Sense\View\index",$data),
    //"cadastre-Sense-create"=>component("{$views}\Sense\Create\index",$data),
    //"cadastre-Sense-edit"=>component("{$views}\Sense\Edit\index",$data),
    //"cadastre-Sense-delete"=>component("{$views}\Sense\Delete\index",$data),

    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'cadastre-sense';
        $this->module = 'App\Modules\Cadastre';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Cadastre');
    }

    public function index()
    {
        $url = base_url('cadastre/Sense/Sense/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Sense\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Sense\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Sense\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Sense\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Sense\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Sense\Delete';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>