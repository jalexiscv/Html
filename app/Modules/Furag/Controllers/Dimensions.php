<?php

namespace App\Modules\Furag\Controllers;

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-07-10 02:10:21
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Furag\Controllers\_Dimensions.php]
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

class Dimensions extends ModuleController
{

    //[Furag/Config/Routes]
    //[Dimensions]
    //$subroutes->add('dimensions', 'Dimensions::index');
    //$subroutes->add('dimensions/home/(:any)', 'Dimensions::home/$1');
    //$subroutes->add('dimensions/list/(:any)', 'Dimensions::list/$1');
    //$subroutes->add('dimensions/create/(:any)', 'Dimensions::create/$1');
    //$subroutes->add('dimensions/view/(:any)/', 'Dimensions::view/$1');
    //$subroutes->add('dimensions/edit/(:any)/', 'Dimensions::edit/$1');
    //$subroutes->add('dimensions/delete/(:any)/', 'Dimensions::delete/$1');
    //$subroutes->add('api/dimensions/(:any)/(:any)/(:any)', 'Api::Dimensions/$1/$2/$3');
    //[Furag/Views/index]
    //[Dimensions]
    //"furag-dimensions-home"=>component("{$views}\Dimensions\Home\index",$data),
    //"furag-dimensions-list"=>component("{$views}\Dimensions\List\index",$data),
    //"furag-dimensions-view"=>component("{$views}\Dimensions\View\index",$data),
    //"furag-dimensions-create"=>component("{$views}\Dimensions\Create\index",$data),
    //"furag-dimensions-edit"=>component("{$views}\Dimensions\Edit\index",$data),
    //"furag-dimensions-delete"=>component("{$views}\Dimensions\Delete\index",$data),

    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'furag-dimensions';
        $this->module = 'App\Modules\Furag';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Furag');
    }

    public function index()
    {
        $url = base_url('furag/dimensions/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Dimensions\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Dimensions\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Dimensions\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Dimensions\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Dimensions\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Dimensions\Delete';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>