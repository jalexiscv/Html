<?php

namespace App\Modules\Sgd\Controllers;

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-03-27 06:56:34
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sgd\Controllers\_Locations.php]
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

class Locations extends ModuleController {

	//[Sgd/Config/Routes]
	//[Locations]----------------------------------------------------------------------------------------
	//"sgd-locations-home"=>"$views\Locations\Home\index",
	//"sgd-locations-list"=>"$views\Locations\List\index",
	//"sgd-locations-view"=>"$views\Locations\View\index",
	//"sgd-locations-create"=>"$views\Locations\Create\index",
	//"sgd-locations-edit"=>"$views\Locations\Edit\index",
	//"sgd-locations-delete"=>"$views\Locations\Delete\index",

	//[Locations]----------------------------------------------------------------------------------------
	//						"sgd-locations-access",
	//						"sgd-locations-view",
	//						"sgd-locations-view-all",
	//						"sgd-locations-create",
	//						"sgd-locations-edit",
	//						"sgd-locations-edit-all",
	//						"sgd-locations-delete",
	//						"sgd-locations-delete-all",

    public function __construct() {
       parent::__construct();
       $this->prefix = 'sgd-locations';
       $this->module = 'App\Modules\Sgd';
       $this->views = $this->module . '\Views';
       $this->viewer = $this->views . '\index';
       helper($this->module.'\Helpers\Sgd');
    }

    public function index() {
        $url = base_url('sgd/locations/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd) {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Locations\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid) {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Locations\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd) {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Locations\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd) {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Locations\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid) {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Locations\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid) {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Locations\Delete';
        return (view($this->viewer, $this->get_Array()));
    }


}
?>