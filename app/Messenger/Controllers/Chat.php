<?php

namespace app\Messenger\Controllers;
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Messenger\Controllers\_Messages.php]
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

class Chat extends ModuleController
{

    //[Messenger/Config/Routes]
    //[Messages]
    //$subroutes->add('messages', 'Messages::index');
    //$subroutes->add('messages/home/(:any)', 'Messages::home/$1');
    //$subroutes->add('messages/list/(:any)', 'Messages::list/$1');
    //$subroutes->add('messages/create/(:any)', 'Messages::create/$1');
    //$subroutes->add('messages/view/(:any)/', 'Messages::view/$1');
    //$subroutes->add('messages/edit/(:any)/', 'Messages::edit/$1');
    //$subroutes->add('messages/delete/(:any)/', 'Messages::delete/$1');
    //$subroutes->add('api/messages/(:any)/(:any)/(:any)', 'Api::Messages/$1/$2/$3');
    //[Messenger/Views/index]
    //[Messages]
    //"messenger-messages-home"=>component("{$views}\Messages\Home\index",$data),
    //"messenger-messages-list"=>component("{$views}\Messages\List\index",$data),
    //"messenger-messages-view"=>component("{$views}\Messages\View\index",$data),
    //"messenger-messages-create"=>component("{$views}\Messages\Create\index",$data),
    //"messenger-messages-edit"=>component("{$views}\Messages\Edit\index",$data),
    //"messenger-messages-delete"=>component("{$views}\Messages\Delete\index",$data),

    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'messenger-chat';
        $this->module = 'App\Modules\Messenger';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Messenger');
    }

    public function index()
    {
        $url = base_url('messenger/contacts/list/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function conversation(string $user, string $rnd)
    {
        $this->oid = $user;
        $this->prefix = "{$this->prefix}-conversation";
        $this->component = $this->views . '\conversations\View';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>