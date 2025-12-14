<?php
/**
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                                                    2023-11-26 00:29:34
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules}\Internationalization\Controllers\Internationalization.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                                                                         consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 2.0.0 @since PHP 7, PHP 8
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ Ninguno
 * █ -------------------------------------------------------------------------------------------------------------------
 **/

namespace App\Modules\Internationalization\Controllers;

use App\Controllers\ModuleController;

class Internationalization extends ModuleController
{


    public function __construct()
    {
        parent::__construct();
        $this->module = 'App\Modules\Internationalization';
        helper($this->module . '\Helpers\Internationalization');
        $this->prefix = 'internationalization';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Home';
    }

    public function index()
    {
        $url = base_url('internationalization/home/index.html');
        return (redirect()->to($url));
    }

    public function home(string $rnd = "index")
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-home";
        return (view($this->viewer, $this->get_Array()));
    }


    public function denied(string $rnd = null): string
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-denied";
        return (view($this->viewer, $this->get_Array()));
    }

    public function semantic(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-home";
        return (view($this->viewer, $this->get_Array()));
    }


}

?>
