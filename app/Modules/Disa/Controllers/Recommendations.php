<?php

namespace App\Modules\Disa\Controllers;
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Controllers\_Recommendations.php]
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

class Recommendations extends ModuleController
{

    /***************************************************************************
     * Rutas a adicionar en Disa/Config/Routes
     * $subroutes->add('recommendations', 'Recommendations::index');
     * $subroutes->add('recommendations/home/(:any)', 'Recommendations::home/$1');
     * $subroutes->add('recommendations/list/(:any)', 'Recommendations::list/$1');
     * $subroutes->add('recommendations/create/(:any)', 'Recommendations::create/$1');
     * $subroutes->add('recommendations/view/(:any)/', 'Recommendations::view/$1');
     * $subroutes->add('recommendations/edit/(:any)/', 'Recommendations::edit/$1');
     * $subroutes->add('recommendations/delete/(:any)/', 'Recommendations::delete/$1');
     * $subroutes->add('api/roles/(:any)/(:any)/(:any)', 'Api::Recommendations/$1/$2/$3');
     ***************************************************************************
     * Componentes a adicionar en Disa/Views/index
     * "disa-recommendations-home"=>component("{$views}\Recommendations\Home\index",$data),
     * "disa-recommendations-list"=>component("{$views}\Recommendations\List\index",$data),
     * "disa-recommendations-view"=>component("{$views}\Recommendations\View\index",$data),
     * "disa-recommendations-create"=>component("{$views}\Recommendations\Create\index",$data),
     * "disa-recommendations-edit"=>component("{$views}\Recommendations\Edit\index",$data),
     * "disa-recommendations-delete"=>component("{$views}\Recommendations\Delete\index",$data),
     ***************************************************************************/
    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'disa-recommendations';
        $this->module = 'App\Modules\Disa';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Disa');
    }

    public function index()
    {
        $url = base_url('disa/recommendations/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Mipg\Recommendations\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Mipg\Recommendations\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $year, string $rnd)
    {
        $this->oid = $year;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Mipg\Recommendations\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Mipg\Recommendations\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Mipg\Recommendations\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function assign(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-assign";
        $this->component = $this->views . '\Mipg\Recommendations\Assign';
        return (view($this->viewer, $this->get_Array()));
    }

    public function unassign(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-unassign";
        $this->component = $this->views . '\Mipg\Recommendations\Unassign';
        return (view($this->viewer, $this->get_Array()));
    }


    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Mipg\Recommendations\Delete';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>