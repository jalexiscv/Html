<?php

namespace App\Modules\Security\Controllers;
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Security\Controllers\_Users.php]
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

class Hierarchies extends ModuleController
{

    /***************************************************************************
     * Rutas a adicionar en Security/Config/Routes
     * $subroutes->add('users', 'Users::index');
     * $subroutes->add('users/home/(:any)', 'Users::home/$1');
     * $subroutes->add('users/list/(:any)', 'Users::list/$1');
     * $subroutes->add('users/create/(:any)', 'Users::create/$1');
     * $subroutes->add('users/view/(:any)/', 'Users::view/$1');
     * $subroutes->add('users/edit/(:any)/', 'Users::edit/$1');
     * $subroutes->add('users/delete/(:any)/', 'Users::delete/$1');
     ***************************************************************************
     * Componentes a adicionar en Security/Views/index
     * "security-users-home"=>component("{$views}\Users\Home\index",$data);
     * "security-users-list"=>component("{$views}\Users\List\index",$data);
     * "security-users-view"=>component("{$views}\Users\View\index",$data);
     * "security-users-create"=>component("{$views}\Users\Create\index",$data);
     * "security-users-edit"=>component("{$views}\Users\Edit\index",$data);
     * "security-users-delete"=>component("{$views}\Users\Delete\index",$data);
     ***************************************************************************/
    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'security-hierarchies';
        $this->module = 'App\Modules\Security';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Security');
    }

    public function index()
    {
        $url = base_url('security/users/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Hierarchies';
        return (view($this->viewer, $this->get_Array()));
    }


    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Hierarchies\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function masive(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-masive";
        $this->component = $this->views . '\Hierarchies\Masive';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>