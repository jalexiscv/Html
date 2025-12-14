<?php

namespace App\Modules\Disa\Controllers;
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Social\Controllers\_Settings.php]
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

class Settings extends ModuleController
{

    /***************************************************************************
     * Rutas a adicionar en Social/Config/Routes
     * $subroutes->add('settings', 'Settings::index');
     * $subroutes->add('settings/home/(:any)', 'Settings::home/$1');
     * $subroutes->add('settings/list/(:any)', 'Settings::list/$1');
     * $subroutes->add('settings/create/(:any)', 'Settings::create/$1');
     * $subroutes->add('settings/view/(:any)/', 'Settings::view/$1');
     * $subroutes->add('settings/edit/(:any)/', 'Settings::edit/$1');
     * $subroutes->add('settings/delete/(:any)/', 'Settings::delete/$1');
     * $subroutes->add('api/roles/(:any)/(:any)/(:any)', 'Api::Settings/$1/$2/$3');
     ***************************************************************************
     * Componentes a adicionar en Social/Views/index
     * "social-settings-home"=>component("{$views}\Settings\Home\index",$data),
     * "social-settings-list"=>component("{$views}\Settings\List\index",$data),
     * "social-settings-view"=>component("{$views}\Settings\View\index",$data),
     * "social-settings-create"=>component("{$views}\Settings\Create\index",$data),
     * "social-settings-edit"=>component("{$views}\Settings\Edit\index",$data),
     * "social-settings-delete"=>component("{$views}\Settings\Delete\index",$data),
     ***************************************************************************/
    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'disa-settings';
        $this->module = 'App\Modules\Disa';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Disa');
    }

    public function index()
    {
        $url = base_url('disa/settings/home/' . lpk());
        return (redirect()->to($url));
    }

    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Mipg\Settings\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function characterization(string $option, string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-characterization-{$option}";
        $this->component = $this->views . '\Mipg\Settings\Characterization';
        return (view($this->viewer, $this->get_Array()));
    }

    public function macroprocesses(string $option, string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-macroprocesses-{$option}";
        $this->component = $this->views . '\Mipg\Settings\Macroprocesses';
        return (view($this->viewer, $this->get_Array()));
    }

    public function processes(string $option, string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-processes-{$option}";
        $this->component = $this->views . '\Mipg\Settings\Processes';
        return (view($this->viewer, $this->get_Array()));
    }

    public function subprocesses(string $option, string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-subprocesses-{$option}";
        $this->component = $this->views . '\Mipg\Settings\Subprocesses';
        return (view($this->viewer, $this->get_Array()));
    }

    public function positions(string $option, string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-positions-{$option}";
        $this->component = $this->views . '\Mipg\Settings\Positions';
        return (view($this->viewer, $this->get_Array()));
    }

    public function help(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-help";
        $this->component = $this->views . '\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Settings\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Settings\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Settings\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Settings\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Settings\Delete';
        return (view($this->viewer, $this->get_Array()));
    }

}

?>