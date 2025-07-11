<?php

namespace App\Modules\Sie\Controllers;

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-07-03 10:55:50
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Controllers\_Costs.php]
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

class Costs extends ModuleController {

	//[Sie/Config/Routes]
	//[Costs]----------------------------------------------------------------------------------------
	//"sie-costs-home"=>"$views\Costs\Home\index",
	//"sie-costs-list"=>"$views\Costs\List\index",
	//"sie-costs-view"=>"$views\Costs\View\index",
	//"sie-costs-create"=>"$views\Costs\Create\index",
	//"sie-costs-edit"=>"$views\Costs\Edit\index",
	//"sie-costs-delete"=>"$views\Costs\Delete\index",

	//[Costs]----------------------------------------------------------------------------------------
	//						"sie-costs-access",
	//						"sie-costs-view",
	//						"sie-costs-view-all",
	//						"sie-costs-create",
	//						"sie-costs-edit",
	//						"sie-costs-edit-all",
	//						"sie-costs-delete",
	//						"sie-costs-delete-all",

    public function __construct() {
       parent::__construct();
       $this->prefix = 'sie-costs';
       $this->module = 'App\Modules\Sie';
       $this->views = $this->module . '\Views';
       $this->viewer = $this->views . '\index';
       helper($this->module.'\Helpers\Sie');
    }

    public function index() {
        $url = base_url('sie/costs/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd) {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Costs\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid) {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Costs\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd) {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Costs\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd) {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Costs\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid) {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Costs\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid) {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Costs\Delete';
        return (view($this->viewer, $this->get_Array()));
    }


}
?>