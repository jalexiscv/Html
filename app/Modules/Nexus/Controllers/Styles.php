<?php

namespace App\Modules\Nexus\Controllers;
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Application\Controllers\_Styles.php]
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

class Styles extends ModuleController
{

    /***************************************************************************
     * Rutas a adicionar en Application/Config/Routes
     * $subroutes->add('styles', 'Styles::index');
     * $subroutes->add('styles/home/(:any)', 'Styles::home/$1');
     * $subroutes->add('styles/list/(:any)', 'Styles::list/$1');
     * $subroutes->add('styles/create/(:any)', 'Styles::create/$1');
     * $subroutes->add('styles/view/(:any)/', 'Styles::view/$1');
     * $subroutes->add('styles/edit/(:any)/', 'Styles::edit/$1');
     * $subroutes->add('styles/delete/(:any)/', 'Styles::delete/$1');
     * $subroutes->add('api/roles/(:any)/(:any)/(:any)', 'Api::Styles/$1/$2/$3');
     ***************************************************************************
     * Componentes a adicionar en Application/Views/index
     * "application-styles-home"=>component("{$views}\Styles\Home\index",$data),
     * "application-styles-list"=>component("{$views}\Styles\List\index",$data),
     * "application-styles-view"=>component("{$views}\Styles\View\index",$data),
     * "application-styles-create"=>component("{$views}\Styles\Create\index",$data),
     * "application-styles-edit"=>component("{$views}\Styles\Edit\index",$data),
     * "application-styles-delete"=>component("{$views}\Styles\Delete\index",$data),
     ***************************************************************************/
    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'application-styles';
        $this->module = 'App\Modules\Nexus';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Nexus');
    }

    public function index()
    {
        $url = base_url('application/styles/home/' . lpk());
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
        $this->component = $this->views . '\Styles\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Styles\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Styles\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function importer(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-importer";
        $this->component = $this->views . '\Styles\Importer';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Styles\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Styles\Delete';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>