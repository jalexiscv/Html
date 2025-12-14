<?php

namespace App\Modules\Nexus\Controllers;
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Nexus\Controllers\_Modules.php]
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

class Modules extends ModuleController
{

    /***************************************************************************
     * Rutas a adicionar en Nexus/Config/Routes
     * $subroutes->add('modules', 'Modules::index');
     * $subroutes->add('modules/home/(:any)', 'Modules::home/$1');
     * $subroutes->add('modules/list/(:any)', 'Modules::list/$1');
     * $subroutes->add('modules/create/(:any)', 'Modules::create/$1');
     * $subroutes->add('modules/view/(:any)/', 'Modules::view/$1');
     * $subroutes->add('modules/edit/(:any)/', 'Modules::edit/$1');
     * $subroutes->add('modules/delete/(:any)/', 'Modules::delete/$1');
     * $subroutes->add('api/roles/(:any)/(:any)/(:any)', 'Api::Modules/$1/$2/$3');
     ***************************************************************************
     * Componentes a adicionar en Nexus/Views/index
     * "Nexus-modules-home"=>component("{$views}\Modules\Home\index",$data),
     * "Nexus-modules-list"=>component("{$views}\Modules\List\index",$data),
     * "Nexus-modules-view"=>component("{$views}\Modules\View\index",$data),
     * "Nexus-modules-create"=>component("{$views}\Modules\Create\index",$data),
     * "Nexus-modules-edit"=>component("{$views}\Modules\Edit\index",$data),
     * "Nexus-modules-delete"=>component("{$views}\Modules\Delete\index",$data),
     ***************************************************************************/
    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'nexus-modules';
        $this->module = 'App\Modules\Nexus';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Nexus');
    }

    public function index()
    {
        $url = base_url('Nexus/modules/home/' . lpk());
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
        $this->component = $this->views . '\Modules\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Modules\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Modules\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Modules\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Modules\Delete';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>