<?php

namespace App\Modules\Disa\Controllers;
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Controllers\_Statuses.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* -----------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* -----------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* -----------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* -----------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* -----------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* -----------------------------------------------------------------------------
*/

use App\Controllers\ModuleController;

class Statuses extends ModuleController
{

    /***************************************************************************
     * Rutas a adicionar en Disa/Config/Routes
     * $subroutes->add('statuses', 'Statuses::index');
     * $subroutes->add('statuses/home/(:any)', 'Statuses::home/$1');
     * $subroutes->add('statuses/list/(:any)', 'Statuses::list/$1');
     * $subroutes->add('statuses/create/(:any)', 'Statuses::create/$1');
     * $subroutes->add('statuses/view/(:any)/', 'Statuses::view/$1');
     * $subroutes->add('statuses/edit/(:any)/', 'Statuses::edit/$1');
     * $subroutes->add('statuses/delete/(:any)/', 'Statuses::delete/$1');
     * $subroutes->add('api/roles/(:any)/(:any)/(:any)', 'Api::Statuses/$1/$2/$3');
     ***************************************************************************
     * Componentes a adicionar en Disa/Views/index
     * "disa-statuses-home"=>component("{$views}\Statuses\Home\index",$data),
     * "disa-statuses-list"=>component("{$views}\Statuses\List\index",$data),
     * "disa-statuses-view"=>component("{$views}\Statuses\View\index",$data),
     * "disa-statuses-create"=>component("{$views}\Statuses\Create\index",$data),
     * "disa-statuses-edit"=>component("{$views}\Statuses\Edit\index",$data),
     * "disa-statuses-delete"=>component("{$views}\Statuses\Delete\index",$data),
     ***************************************************************************/
    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'disa-statuses';
        $this->module = 'App\Modules\Disa';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Disa');
    }

    public function index()
    {
        $url = base_url('disa/mipg/plans/statuses/home/' . lpk());
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
        $this->component = $this->views . '\Mipg\Plans\Statuses\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Mipg\Plans\Statuses\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Mipg\Plans\Statuses\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Mipg\Plans\Statuses\Edit';
        return (view($this->viewer, $this->get_Array()));
    }


    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Mipg\Plans\Statuses\Delete';
        return (view($this->viewer, $this->get_Array()));
    }

    public function approval(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-approval";
        $this->component = $this->views . '\Mipg\Plans\Statuses\Approval';
        return (view($this->viewer, $this->get_Array()));
    }


    public function approve(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-approve";
        $this->component = $this->views . '\Mipg\Plans\Statuses\Approve';
        return (view($this->viewer, $this->get_Array()));
    }


    public function evaluate(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-evaluate";
        $this->component = $this->views . '\Mipg\Plans\Statuses\Evaluate';
        return (view($this->viewer, $this->get_Array()));
    }


    public function evaluation(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-evaluation";
        $this->component = $this->views . '\Mipg\Plans\Statuses\Evaluation';
        return (view($this->viewer, $this->get_Array()));
    }

}

?>