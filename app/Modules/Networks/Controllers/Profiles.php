<?php

namespace App\Modules\Networks\Controllers;

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-07-01 13:33:54
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Networks\Controllers\_Profiles.php]
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

class Profiles extends ModuleController
{

    //[Networks/Config/Routes]
    //[Profiles]
    //$subroutes->add('profiles', 'Profiles::index');
    //$subroutes->add('profiles/home/(:any)', 'Profiles::home/$1');
    //$subroutes->add('profiles/list/(:any)', 'Profiles::list/$1');
    //$subroutes->add('profiles/create/(:any)', 'Profiles::create/$1');
    //$subroutes->add('profiles/view/(:any)/', 'Profiles::view/$1');
    //$subroutes->add('profiles/edit/(:any)/', 'Profiles::edit/$1');
    //$subroutes->add('profiles/delete/(:any)/', 'Profiles::delete/$1');
    //$subroutes->add('api/profiles/(:any)/(:any)/(:any)', 'Api::Profiles/$1/$2/$3');
    //[Networks/Views/index]
    //[Profiles]
    //"networks-profiles-home"=>component("{$views}\Profiles\Home\index",$data),
    //"networks-profiles-list"=>component("{$views}\Profiles\List\index",$data),
    //"networks-profiles-view"=>component("{$views}\Profiles\View\index",$data),
    //"networks-profiles-create"=>component("{$views}\Profiles\Create\index",$data),
    //"networks-profiles-edit"=>component("{$views}\Profiles\Edit\index",$data),
    //"networks-profiles-delete"=>component("{$views}\Profiles\Delete\index",$data),

    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'networks-profiles';
        $this->module = 'App\Modules\Networks';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Networks');
    }

    public function index()
    {
        $url = base_url('networks/profiles/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Profiles\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Profiles\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Profiles\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Profiles\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Profiles\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Profiles\Delete';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>