<?php

namespace App\Modules\Sie\Controllers;

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-05-01 08:14:04
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Controllers\_Registrations.php]
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

class Registrations extends ModuleController
{

    //[Sie/Config/Routes]


    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'sie-registrations';
        $this->module = 'App\Modules\Sie';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Sie_helper');
    }

    public function index()
    {
        $url = base_url('sie/registrations/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Registrations\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Registrations\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Registrations\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Registrations\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function agreements(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-agreements";
        $this->component = $this->views . '\Registrations\Agreements';
        return (view($this->viewer, $this->get_Array()));
    }


    public function documents(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-documents";
        $this->component = $this->views . '\Registrations\Documents';
        return (view($this->viewer, $this->get_Array()));
    }


    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Registrations\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Registrations\Delete';
        return (view($this->viewer, $this->get_Array()));
    }

    public function cancel(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-cancel";
        $this->component = $this->views . '\Registrations\Cancel';
        return (view($this->viewer, $this->get_Array()));
    }

    public function billing(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-billing";
        $this->component = $this->views . '\Registrations\Billing';
        return (view($this->viewer, $this->get_Array()));
    }

    public function notify(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-notify";
        $this->component = $this->views . '\Registrations\Notify';
        return (view($this->viewer, $this->get_Array()));
    }

    public function schedule(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-schedule";
        $this->component = $this->views . '\Registrations\Schedule';
        return (view($this->viewer, $this->get_Array()));
    }

    public function updates(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-updates";
        $this->component = $this->views . '\Registrations\Updates';
        return (view($this->viewer, $this->get_Array()));
    }


    public function settings(string $option, string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-settings-{$option}";
        $this->component = $this->views . "\\Registrations\\Settings\\" . safe_ucfirst($option);
        return (view($this->viewer, $this->get_Array()));
    }


}

?>