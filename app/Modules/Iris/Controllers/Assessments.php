<?php

namespace App\Modules\Iris\Controllers;

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-04-10 06:51:02
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Controllers\_Assessments.php]
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

class Assessments extends ModuleController {

	//[Iris/Config/Routes]
	//[Assessments]----------------------------------------------------------------------------------------
	//"iris-assessments-home"=>"$views\Assessments\Home\index",
	//"iris-assessments-list"=>"$views\Assessments\List\index",
	//"iris-assessments-view"=>"$views\Assessments\View\index",
	//"iris-assessments-create"=>"$views\Assessments\Create\index",
	//"iris-assessments-edit"=>"$views\Assessments\Edit\index",
	//"iris-assessments-delete"=>"$views\Assessments\Delete\index",

	//[Assessments]----------------------------------------------------------------------------------------
	//						"iris-assessments-access",
	//						"iris-assessments-view",
	//						"iris-assessments-view-all",
	//						"iris-assessments-create",
	//						"iris-assessments-edit",
	//						"iris-assessments-edit-all",
	//						"iris-assessments-delete",
	//						"iris-assessments-delete-all",

    public function __construct() {
       parent::__construct();
       $this->prefix = 'iris-assessments';
       $this->module = 'App\Modules\Iris';
       $this->views = $this->module . '\Views';
       $this->viewer = $this->views . '\index';
       helper($this->module.'\Helpers\Iris');
    }

    public function index() {
        $url = base_url('iris/assessments/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd) {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Assessments\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid) {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Assessments\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd) {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Assessments\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd) {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Assessments\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid) {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Assessments\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid) {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Assessments\Delete';
        return (view($this->viewer, $this->get_Array()));
    }


}
?>