<?php

namespace App\Modules\Disa\Controllers;
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Controllers\_Scores.php]
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

class Scores extends ModuleController
{

    /***************************************************************************
     * Rutas a adicionar en Disa/Config/Routes
     * $subroutes->add('scores', 'Scores::index');
     * $subroutes->add('scores/home/(:any)', 'Scores::home/$1');
     * $subroutes->add('scores/list/(:any)', 'Scores::list/$1');
     * $subroutes->add('scores/create/(:any)', 'Scores::create/$1');
     * $subroutes->add('scores/view/(:any)/', 'Scores::view/$1');
     * $subroutes->add('scores/edit/(:any)/', 'Scores::edit/$1');
     * $subroutes->add('scores/delete/(:any)/', 'Scores::delete/$1');
     * $subroutes->add('api/roles/(:any)/(:any)/(:any)', 'Api::Scores/$1/$2/$3');
     ***************************************************************************
     * Componentes a adicionar en Disa/Views/index
     * "disa-scores-home"=>component("{$views}\Scores\Home\index",$data),
     * "disa-scores-list"=>component("{$views}\Scores\List\index",$data),
     * "disa-scores-view"=>component("{$views}\Scores\View\index",$data),
     * "disa-scores-create"=>component("{$views}\Scores\Create\index",$data),
     * "disa-scores-edit"=>component("{$views}\Scores\Edit\index",$data),
     * "disa-scores-delete"=>component("{$views}\Scores\Delete\index",$data),
     ***************************************************************************/
    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'disa-scores';
        $this->module = 'App\Modules\Disa';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Disa');
    }

    public function index()
    {
        $url = base_url('disa/scores/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Scores\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Scores\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Scores\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Scores\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Scores\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Scores\Delete';
        return (view($this->viewer, $this->get_Array()));
    }

    /**
     * Este método controla todo lo relacionado con el proceso de creación, eliminación de archivos
     * adjuntos como evidencias en las recalificaciones.
     * @param string $option
     * @param string $oid
     * @return array|false|mixed|string
     */
    public function attachment(string $option, string $oid)
    {
        $this->oid = $oid;
        if ($option == 'create') {
            $this->prefix = "{$this->prefix}-attachments-create";
            $this->component = $this->views . '\Scores\Attachments\Create';
        } elseif ($option == 'delete') {
            $this->prefix = "{$this->prefix}-attachments-delete";
            $this->component = $this->views . '\Scores\Attachments\Delete';
        }
        return (view($this->viewer, $this->get_Array()));
    }


}

?>