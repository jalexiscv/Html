<?php

namespace App\Modules\Security\Controllers;
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Security\Controllers\_Policies.php]
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

class Policies extends ModuleController
{

    /***************************************************************************
     * Rutas a adicionar en Security/Config/Routes
     * $subroutes->add('policies', 'Policies::index');
     * $subroutes->add('policies/home/(:any)', 'Policies::home/$1');
     * $subroutes->add('policies/list/(:any)', 'Policies::list/$1');
     * $subroutes->add('policies/create/(:any)', 'Policies::create/$1');
     * $subroutes->add('policies/view/(:any)/', 'Policies::view/$1');
     * $subroutes->add('policies/edit/(:any)/', 'Policies::edit/$1');
     * $subroutes->add('policies/delete/(:any)/', 'Policies::delete/$1');
     * $subroutes->add('api/roles/(:any)/(:any)/(:any)', 'Api::Policies/$1/$2/$3');
     ***************************************************************************
     * Componentes a adicionar en Security/Views/index
     * "security-policies-home"=>component("{$views}\Policies\Home\index",$data),
     * "security-policies-list"=>component("{$views}\Policies\List\index",$data),
     * "security-policies-view"=>component("{$views}\Policies\View\index",$data),
     * "security-policies-create"=>component("{$views}\Policies\Create\index",$data),
     * "security-policies-edit"=>component("{$views}\Policies\Edit\index",$data),
     * "security-policies-delete"=>component("{$views}\Policies\Delete\index",$data),
     ***************************************************************************/
    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'security-policies';
        $this->module = 'App\Modules\Security';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Security');
    }

    public function index()
    {
        $url = base_url('security/policies/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Home';
        return (view($this->viewer, $this->get_Array()));
    }


    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Policies\Edit';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>