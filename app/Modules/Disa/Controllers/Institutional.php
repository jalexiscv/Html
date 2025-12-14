<?php

namespace App\Modules\Disa\Controllers;
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Controllers\_Institutional.php]
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

class Institutional extends ModuleController
{

    /***************************************************************************
     * Rutas a adicionar en Disa/Config/Routes
     * $subroutes->add('institutional', 'Institutional::index');
     * $subroutes->add('institutional/home/(:any)', 'Institutional::home/$1');
     * $subroutes->add('institutional/list/(:any)', 'Institutional::list/$1');
     * $subroutes->add('institutional/create/(:any)', 'Institutional::create/$1');
     * $subroutes->add('institutional/view/(:any)/', 'Institutional::view/$1');
     * $subroutes->add('institutional/edit/(:any)/', 'Institutional::edit/$1');
     * $subroutes->add('institutional/delete/(:any)/', 'Institutional::delete/$1');
     * $subroutes->add('api/roles/(:any)/(:any)/(:any)', 'Api::Institutional/$1/$2/$3');
     ***************************************************************************
     * Componentes a adicionar en Disa/Views/index
     * "disa-institutional-home"=>component("{$views}\Institutional\Home\index",$data),
     * "disa-institutional-list"=>component("{$views}\Institutional\List\index",$data),
     * "disa-institutional-view"=>component("{$views}\Institutional\View\index",$data),
     * "disa-institutional-create"=>component("{$views}\Institutional\Create\index",$data),
     * "disa-institutional-edit"=>component("{$views}\Institutional\Edit\index",$data),
     * "disa-institutional-delete"=>component("{$views}\Institutional\Delete\index",$data),
     ***************************************************************************/
    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'disa-institutional';
        $this->module = 'App\Modules\Disa';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Disa');
    }

    public function index()
    {
        $url = base_url('disa/institutional/home/' . lpk());
        return (redirect()->to($url));
    }

    public function home($rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Institutional\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function plans($option, $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-plans-{$option}";
        $this->component = $this->views . '\Institutional\Plans';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>