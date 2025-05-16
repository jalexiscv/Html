<?php

namespace App\Modules\Application\Controllers;

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-05-05 16:14:51
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Application\Controllers\_Regions.php]
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
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/

use App\Controllers\ModuleController;

class Regions extends ModuleController
{

    //[Application/Config/Routes]
    //[Regions]----------------------------------------------------------------------------------------
    //"application-regions-home"=>"$views\Regions\Home\index",
    //"application-regions-list"=>"$views\Regions\List\index",
    //"application-regions-view"=>"$views\Regions\View\index",
    //"application-regions-create"=>"$views\Regions\Create\index",
    //"application-regions-edit"=>"$views\Regions\Edit\index",
    //"application-regions-delete"=>"$views\Regions\Delete\index",

    //[Regions]----------------------------------------------------------------------------------------
    //						"application-regions-access",
    //						"application-regions-view",
    //						"application-regions-view-all",
    //						"application-regions-create",
    //						"application-regions-edit",
    //						"application-regions-edit-all",
    //						"application-regions-delete",
    //						"application-regions-delete-all",

    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'application-regions';
        $this->module = 'App\Modules\Application';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Application');
    }

    public function index()
    {
        $url = base_url('application/regions/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Regions\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Regions\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Regions\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Regions\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Regions\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Regions\Delete';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>