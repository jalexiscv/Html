<?php

namespace App\Modules\Plans\Controllers;

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-04-17 08:54:25
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Plans\Controllers\_Actions.php]
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
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/

use App\Controllers\ModuleController;

class Actions extends ModuleController
{

    //[Plans/Config/Routes]
    //[Actions]----------------------------------------------------------------------------------------
    //"plans-actions-home"=>"$views\Actions\Home\index",
    //"plans-actions-list"=>"$views\Actions\List\index",
    //"plans-actions-view"=>"$views\Actions\View\index",
    //"plans-actions-create"=>"$views\Actions\Create\index",
    //"plans-actions-edit"=>"$views\Actions\Edit\index",
    //"plans-actions-delete"=>"$views\Actions\Delete\index",

    //[Actions]----------------------------------------------------------------------------------------
    //						"plans-actions-access",
    //						"plans-actions-view",
    //						"plans-actions-view-all",
    //						"plans-actions-create",
    //						"plans-actions-edit",
    //						"plans-actions-edit-all",
    //						"plans-actions-delete",
    //						"plans-actions-delete-all",

    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'plans-actions';
        $this->module = 'App\Modules\Plans';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Plans');
    }

    public function index()
    {
        $url = base_url('plans/actions/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Actions\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Actions\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Actions\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Actions\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Actions\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Actions\Delete';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>