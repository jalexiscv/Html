<?php

namespace App\Modules\Intelligence\Controllers;

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-25 18:52:09
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Application\Controllers\_Ias.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - Tyrell Corporation ., Inc. <admin@tyrell.llc>
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
 * █ @Author Carolina <carolinacarvajal@tyrell.llc>
 * █ @link https://www.tyrell.llc
 * █ @Version 1.6.0 @since PHP 8, PHP 9
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

class Test extends ModuleController
{

    //[Application/Config/Routes]
    //[Ias]----------------------------------------------------------------------------------------
    //"application-ias-home"=>"$views\Ias\Home\index",
    //"application-ias-list"=>"$views\Ias\List\index",
    //"application-ias-view"=>"$views\Ias\View\index",
    //"application-ias-create"=>"$views\Ias\Create\index",
    //"application-ias-edit"=>"$views\Ias\Edit\index",
    //"application-ias-delete"=>"$views\Ias\Delete\index",

    //[Ias]----------------------------------------------------------------------------------------
    //						"application-ias-access",
    //						"application-ias-view",
    //						"application-ias-view-all",
    //						"application-ias-create",
    //						"application-ias-edit",
    //						"application-ias-edit-all",
    //						"application-ias-delete",
    //						"application-ias-delete-all",

    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'application-ias-test';
        $this->module = 'App\Modules\Intelligence';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Intelligence');
    }

    public function index()
    {
        $url = base_url('application/ias/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Ias\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function claude(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-claude";
        $this->component = $this->views . '\Test\Claude';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>