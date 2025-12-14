<?php

namespace App\Modules\Disa\Controllers;
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Controllers\_Plans.php]
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

class Plans extends ModuleController
{

    /***************************************************************************
     * Rutas a adicionar en Disa/Config/Routes
     * $subroutes->add('plans', 'Plans::index');
     * $subroutes->add('plans/home/(:any)', 'Plans::home/$1');
     * $subroutes->add('plans/list/(:any)', 'Plans::list/$1');
     * $subroutes->add('plans/create/(:any)', 'Plans::create/$1');
     * $subroutes->add('plans/view/(:any)/', 'Plans::view/$1');
     * $subroutes->add('plans/edit/(:any)/', 'Plans::edit/$1');
     * $subroutes->add('plans/delete/(:any)/', 'Plans::delete/$1');
     * $subroutes->add('api/roles/(:any)/(:any)/(:any)', 'Api::Plans/$1/$2/$3');
     ***************************************************************************
     * Componentes a adicionar en Disa/Views/index
     * "disa-plans-home"=>component("{$views}\Plans\Home\index",$data),
     * "disa-plans-list"=>component("{$views}\Plans\List\index",$data),
     * "disa-plans-view"=>component("{$views}\Plans\View\index",$data),
     * "disa-plans-create"=>component("{$views}\Plans\Create\index",$data),
     * "disa-plans-edit"=>component("{$views}\Plans\Edit\index",$data),
     * "disa-plans-delete"=>component("{$views}\Plans\Delete\index",$data),
     ***************************************************************************/
    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'disa-plans';
        $this->module = 'App\Modules\Disa';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Disa');
    }

    public function index()
    {
        $url = base_url('disa/mipg/plans/home/' . lpk());
        return (redirect()->to($url));
    }

    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Mipg\Plans\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Mipg\Plans\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Mipg\Plans\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Mipg\Plans\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Mipg\Plans\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Mipg\Plans\Delete';
        return (view($this->viewer, $this->get_Array()));
    }

    public function details(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-details";
        $this->component = $this->views . '\Mipg\Plans\Details';
        return (view($this->viewer, $this->get_Array()));
    }

    public function team(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-team";
        $this->component = $this->views . '\Mipg\Plans\Team';
        return (view($this->viewer, $this->get_Array()));
    }

    public function causes(string $option, string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-causes-{$option}";
        $this->component = $this->views . '\Mipg\Plans\Causes';
        return (view($this->viewer, $this->get_Array()));
    }

    public function formulation(string $option, string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-formulation-{$option}";
        $this->component = $this->views . '\Mipg\Plans\Formulation';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>