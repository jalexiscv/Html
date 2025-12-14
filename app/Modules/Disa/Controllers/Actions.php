<?php

namespace App\Modules\Disa\Controllers;
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Controllers\_Actions.php]
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

class Actions extends ModuleController
{

    /***************************************************************************
     * Rutas a adicionar en Disa/Config/Routes
     * $subroutes->add('actions', 'Actions::index');
     * $subroutes->add('actions/home/(:any)', 'Actions::home/$1');
     * $subroutes->add('actions/list/(:any)', 'Actions::list/$1');
     * $subroutes->add('actions/create/(:any)', 'Actions::create/$1');
     * $subroutes->add('actions/view/(:any)/', 'Actions::view/$1');
     * $subroutes->add('actions/edit/(:any)/', 'Actions::edit/$1');
     * $subroutes->add('actions/delete/(:any)/', 'Actions::delete/$1');
     * $subroutes->add('api/roles/(:any)/(:any)/(:any)', 'Api::Actions/$1/$2/$3');
     ***************************************************************************
     * Componentes a adicionar en Disa/Views/index
     * "disa-actions-home"=>component("{$views}\Actions\Home\index",$data),
     * "disa-actions-list"=>component("{$views}\Actions\List\index",$data),
     * "disa-actions-view"=>component("{$views}\Actions\View\index",$data),
     * "disa-actions-create"=>component("{$views}\Actions\Create\index",$data),
     * "disa-actions-edit"=>component("{$views}\Actions\Edit\index",$data),
     * "disa-actions-delete"=>component("{$views}\Actions\Delete\index",$data),
     ***************************************************************************/
    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'disa-actions';
        $this->module = 'App\Modules\Disa';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Disa');
    }

    public function index()
    {
        $url = base_url('disa/mipg/actions/home/' . lpk());
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
        $this->component = $this->views . '\Mipg\Plans\Actions\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Mipg\Plans\Actions\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Mipg\Plans\Actions\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Mipg\Plans\Actions\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Mipg\Plans\Actions\Delete';
        return (view($this->viewer, $this->get_Array()));
    }

    public function status(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-status";
        $this->component = $this->views . '\Mipg\Plans\Actions\Status';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>